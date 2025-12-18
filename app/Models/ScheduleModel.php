<?php

namespace App\Models;

use CodeIgniter\Model;

class ScheduleModel extends Model
{
    protected $table = 'schedules';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'title', 'description', 'course_id', 'instructor_id', 'start_date', 
        'end_date', 'start_time', 'end_time', 'type', 'status', 'location',
        'created_at', 'updated_at'
    ];
    protected $useTimestamps = false;
    protected $returnType = 'array';

    /**
     * Get schedules for instructor
     */
    public function getInstructorSchedules($instructorId, $limit = null, $offset = 0)
    {
        // Get schedules from session storage (temporary solution until database table exists)
        $session = \Config\Services::session();
        $schedules = $session->get('instructor_schedules_' . $instructorId) ?? [];
        
        // Filter schedules by instructor ID
        $instructorSchedules = array_filter($schedules, function($schedule) use ($instructorId) {
            return $schedule['instructor_id'] == $instructorId;
        });

        // Add course information to each schedule
        $courseModel = new \App\Models\CourseModel();
        foreach ($instructorSchedules as &$schedule) {
            $course = $courseModel->find($schedule['course_id']);
            if ($course) {
                $schedule['course_title'] = $course['title'];
                $schedule['course_code'] = $course['category'] ?? 'N/A';
            } else {
                $schedule['course_title'] = 'Unknown Course';
                $schedule['course_code'] = 'N/A';
            }
        }
        unset($schedule);

        // Reindex array for easier processing
        $instructorSchedules = array_values($instructorSchedules);

        // Detect time conflicts between schedules for this instructor
        $count = count($instructorSchedules);
        for ($i = 0; $i < $count; $i++) {
            $startA = isset($instructorSchedules[$i]['start_time']) ? strtotime($instructorSchedules[$i]['start_time']) : null;
            $endA = isset($instructorSchedules[$i]['end_time']) ? strtotime($instructorSchedules[$i]['end_time']) : null;

            if (!$startA || !$endA) {
                continue;
            }

            for ($j = $i + 1; $j < $count; $j++) {
                $startB = isset($instructorSchedules[$j]['start_time']) ? strtotime($instructorSchedules[$j]['start_time']) : null;
                $endB = isset($instructorSchedules[$j]['end_time']) ? strtotime($instructorSchedules[$j]['end_time']) : null;

                if (!$startB || !$endB) {
                    continue;
                }

                if ($startA < $endB && $endA > $startB) {
                    $instructorSchedules[$i]['has_conflict'] = true;
                    $instructorSchedules[$j]['has_conflict'] = true;
                }
            }
        }

        // Mark conflicting schedules with a conflict status so the UI can highlight them
        foreach ($instructorSchedules as &$schedule) {
            if (!empty($schedule['has_conflict'])) {
                $schedule['status'] = 'conflict';
            }
        }
        unset($schedule);

        // Sort by creation time (newest first)
        usort($instructorSchedules, function($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });

        if ($limit) {
            return array_slice($instructorSchedules, $offset, $limit);
        }

        return array_values($instructorSchedules);
    }

    /**
     * Get schedule by ID
     */
    public function getSchedule($id)
    {
        // Since schedules are stored per instructor in session, search all
        // instructor_schedules_* keys for the matching schedule ID.
        $session = \Config\Services::session();
        $allData = $session->get();

        foreach ($allData as $key => $value) {
            if (strpos($key, 'instructor_schedules_') === 0 && is_array($value)) {
                foreach ($value as $schedule) {
                    if (isset($schedule['id']) && (string)$schedule['id'] === (string)$id) {
                        return $schedule;
                    }
                }
            }
        }

        return null;
    }

    /**
     * Delete schedule by ID
     */
    public function deleteSchedule($id)
    {
        // In a real implementation, this would delete from database:
        // return $this->delete($id);

        // Mock implementation: remove from session storage
        $session = \Config\Services::session();
        $allData = $session->get();

        foreach ($allData as $key => $value) {
            if (strpos($key, 'instructor_schedules_') === 0 && is_array($value)) {
                $updated = [];
                $found = false;

                foreach ($value as $schedule) {
                    if (isset($schedule['id']) && (string)$schedule['id'] === (string)$id) {
                        $found = true;
                        continue; // Skip this one to "delete" it
                    }
                    $updated[] = $schedule;
                }

                if ($found) {
                    $session->set($key, $updated);
                    log_message('info', "Schedule {$id} deleted successfully from {$key}");
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Get schedule count for instructor
     */
    public function getInstructorScheduleCount($instructorId)
    {
        $schedules = $this->getInstructorSchedules($instructorId);
        return count($schedules);
    }

    /**
     * Get schedules by status
     */
    public function getSchedulesByStatus($instructorId, $status, $limit = null)
    {
        $schedules = $this->getInstructorSchedules($instructorId);
        $filteredSchedules = array_filter($schedules, function($schedule) use ($status) {
            return $schedule['status'] === $status;
        });

        if ($limit) {
            return array_slice($filteredSchedules, 0, $limit);
        }

        return array_values($filteredSchedules);
    }

    /**
     * Create new schedule
     */
    public function createSchedule($data)
    {
        try {
            // Add default values if not provided
            $scheduleData = [
                'id' => rand(1000, 9999),
                'title' => $data['title'],
                'description' => $data['description'] ?? '',
                'course_id' => $data['course_id'],
                'instructor_id' => $data['instructor_id'],
                'start_date' => $data['start_date'] ?? date('Y-m-d'),
                'end_date' => $data['end_date'] ?? ($data['start_date'] ?? date('Y-m-d')),
                'start_time' => $data['start_time'],
                'end_time' => $data['end_time'],
                'type' => $data['type'] ?? 'lecture',
                'location' => $data['location'] ?? 'TBD',
                'status' => $data['status'] ?? 'upcoming',
                'created_at' => $data['created_at'] ?? date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            // Save to session storage (temporary solution until database table exists)
            $session = \Config\Services::session();
            $existingSchedules = $session->get('instructor_schedules_' . $data['instructor_id']) ?? [];
            $existingSchedules[] = $scheduleData;
            $session->set('instructor_schedules_' . $data['instructor_id'], $existingSchedules);
            
            log_message('info', "Schedule created: " . json_encode($scheduleData));
            
            return $scheduleData;
            
        } catch (\Exception $e) {
            log_message('error', 'Error creating schedule: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Update schedule
     */
    public function updateSchedule($id, $data)
    {
        // In a real implementation, this would update database:
        // return $this->update($id, $data);

        // Mock implementation: update schedule in session storage
        $session = \Config\Services::session();
        $allData = $session->get();

        foreach ($allData as $key => $value) {
            if (strpos($key, 'instructor_schedules_') === 0 && is_array($value)) {
                $updated = [];
                $found = false;

                foreach ($value as $schedule) {
                    if (isset($schedule['id']) && (string)$schedule['id'] === (string)$id) {
                        // Merge provided data into existing schedule
                        foreach ($data as $field => $val) {
                            $schedule[$field] = $val;
                        }

                        $schedule['updated_at'] = date('Y-m-d H:i:s');
                        $found = true;
                    }

                    $updated[] = $schedule;
                }

                if ($found) {
                    $session->set($key, $updated);
                    log_message('info', "Schedule {$id} updated in {$key} with data: " . json_encode($data));
                    return true;
                }
            }
        }

        return false;
    }
}
