<?php

namespace App\Controllers;

use App\Models\AnnouncementModel;

class Announcement extends BaseController
{
    protected $announcementModel;

    public function __construct()
    {
        $this->announcementModel = new AnnouncementModel();
    }

    /**
     * Display all announcements
     */
    public function index()
    {
        // Fetch all announcements from the database
        $announcements = $this->announcementModel->getActiveAnnouncements();

        // Prepare data for the view
        $data = [
            'title' => 'Announcements',
            'announcements' => $announcements,
            'content' => view('announcements', ['announcements' => $announcements])
        ];

        // Load the template with announcements
        return view('template', $data);
    }
}

