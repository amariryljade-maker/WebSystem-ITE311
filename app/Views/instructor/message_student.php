<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Page Header -->
            <div class="d-sm-flex align-items-center justify-content-between mb-5">
                <div>
                    <h1 class="h2 page-title mb-2">
                        <i class="bi bi-chat-dots-fill me-3"></i>Send Message
                    </h1>
                    <p class="text-muted mb-0">Compose and send message to student</p>
                </div>
                <div>
                    <a href="<?= site_url('instructor/students') ?>" class="btn btn-modern btn-secondary btn-lg">
                        <i class="bi bi-arrow-left me-2"></i>Back to Students
                    </a>
                </div>
            </div>

            <!-- Student Info Card -->
            <div class="card card-modern mb-4">
                <div class="card-header" style="background: var(--primary-gradient); border: none; color: white;">
                    <h6 class="m-0 fw-bold">
                        <i class="bi bi-person-badge me-2"></i>
                        Student Information
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-3 text-center">
                            <div class="avatar bg-primary text-white rounded-circle mx-auto mb-2" style="width: 80px; height: 80px; display: flex; align-items: center; justify-content-center; font-size: 2rem; font-weight: bold;">
                                <?= strtoupper(substr($student['first_name'], 0, 1) . substr($student['last_name'], 0, 1)) ?>
                            </div>
                            <h6 class="fw-bold mb-1"><?= esc($student['first_name'] . ' ' . $student['last_name']) ?></h6>
                            <small class="text-muted">ID: <?= esc($student['student_id'] ?? 'N/A') ?></small>
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-muted">Email Address</label>
                                    <p class="form-control-plaintext">
                                        <i class="bi bi-envelope text-muted me-2"></i><?= esc($student['email']) ?>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-muted">Phone Number</label>
                                    <p class="form-control-plaintext">
                                        <i class="bi bi-telephone text-muted me-2"></i><?= esc($student['phone'] ?? 'Not provided') ?>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-muted">Status</label>
                                    <p class="form-control-plaintext">
                                        <span class="badge badge-modern <?= ($student['status'] ?? 'active') === 'active' ? 'bg-success' : 'bg-warning' ?>">
                                            <i class="bi bi-<?= ($student['status'] ?? 'active') === 'active' ? 'person-check-fill' : 'person-dash-fill' ?> me-1"></i>
                                            <?= ucfirst($student['status'] ?? 'active') ?>
                                        </span>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-muted">Enrolled Courses</label>
                                    <p class="form-control-plaintext">
                                        <i class="bi bi-book text-muted me-2"></i><?= $student['enrolled_courses'] ?? 0 ?> courses
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Message Statistics -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stats-card text-white shadow-lg" style="background: gray;">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1 opacity-75">
                                        Messages Sent
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= $messageStats['total_sent'] ?? 0 ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-send-fill fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stats-card text-white shadow-lg" style="background: var(--success-gradient);">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1 opacity-75">
                                        Response Rate
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= $messageStats['response_rate'] ?? 0 ?>%
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-reply-fill fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stats-card text-white shadow-lg" style="background: var(--warning-gradient);">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1 opacity-75">
                                        Last Contact
                                    </div>
                                    <div class="h4 mb-0 font-weight-bold">
                                        <?= $messageStats['last_contact'] ?? 'Never' ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-clock-history fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stats-card text-white shadow-lg" style="background: var(--info-gradient);">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1 opacity-75">
                                        Unread Count
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= $messageStats['unread_count'] ?? 0 ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-envelope-fill fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Compose Message -->
            <div class="card card-modern mb-4">
                <div class="card-header" style="background: var(--primary-gradient); border: none; color: white;">
                    <h6 class="m-0 fw-bold">
                        <i class="bi bi-pencil-square me-2"></i>
                        Compose Message
                    </h6>
                </div>
                <div class="card-body">
                    <form method="post" action="<?= site_url('instructor/students/message/' . $student['id']) ?>">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="recipient" class="form-label fw-bold">To</label>
                                <input type="text" class="form-control" id="recipient" value="<?= esc($student['first_name'] . ' ' . $student['last_name']) ?>" readonly>
                                <small class="text-muted"><?= esc($student['email']) ?></small>
                            </div>
                            <div class="col-md-6">
                                <label for="priority" class="form-label fw-bold">Priority</label>
                                <select class="form-select" id="priority" name="priority">
                                    <option value="normal">Normal</option>
                                    <option value="high">High</option>
                                    <option value="urgent">Urgent</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="subject" class="form-label fw-bold">Subject</label>
                                <input type="text" class="form-control" id="subject" name="subject" placeholder="Enter message subject..." required>
                            </div>
                            <div class="col-md-6">
                                <label for="category" class="form-label fw-bold">Category</label>
                                <select class="form-select" id="category" name="category">
                                    <option value="general">General</option>
                                    <option value="academic">Academic</option>
                                    <option value="attendance">Attendance</option>
                                    <option value="behavior">Behavior</option>
                                    <option value="assignment">Assignment</option>
                                    <option value="grade">Grade</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="message" class="form-label fw-bold">Message</label>
                            <textarea class="form-control" id="message" name="message" rows="8" 
                                      placeholder="Type your message here..." required></textarea>
                            <div class="form-text">Be clear and specific in your communication</div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Quick Templates</label>
                                <div class="d-flex flex-wrap gap-2">
                                    <button type="button" class="btn btn-modern btn-outline-primary btn-sm template-btn" 
                                            data-template="progress">Progress Update</button>
                                    <button type="button" class="btn btn-modern btn-outline-primary btn-sm template-btn" 
                                            data-template="assignment">Assignment Reminder</button>
                                    <button type="button" class="btn btn-modern btn-outline-primary btn-sm template-btn" 
                                            data-template="concern">Academic Concern</button>
                                    <button type="button" class="btn btn-modern btn-outline-primary btn-sm template-btn" 
                                            data-template="praise">Praise</button>
                                    <button type="button" class="btn btn-modern btn-outline-primary btn-sm template-btn" 
                                            data-template="meeting">Meeting Request</button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Attachments</label>
                                <div class="border rounded p-3">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-paperclip text-muted me-2"></i>
                                        <input type="file" class="form-control" id="attachment" name="attachment" multiple>
                                    </div>
                                    <small class="text-muted">You can attach multiple files (PDF, DOC, IMG)</small>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Delivery Options</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="email_copy" name="email_copy" checked>
                                    <label class="form-check-label" for="email_copy">
                                        Send email copy to student
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="sms_notification" name="sms_notification">
                                    <label class="form-check-label" for="sms_notification">
                                        Send SMS notification
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="parent_copy" name="parent_copy">
                                    <label class="form-check-label" for="parent_copy">
                                        Send copy to parent/guardian
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Schedule</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="schedule" id="send_now" value="now" checked>
                                    <label class="form-check-label" for="send_now">
                                        Send immediately
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="schedule" id="schedule_later" value="later">
                                    <label class="form-check-label" for="schedule_later">
                                        Schedule for later
                                    </label>
                                </div>
                                <div class="mt-2" id="schedule_options" style="display: none;">
                                    <input type="datetime-local" class="form-control" name="scheduled_time">
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <div>
                                <button type="submit" class="btn btn-modern btn-success btn-lg">
                                    <i class="bi bi-send me-2"></i>Send Message
                                </button>
                                <button type="submit" name="save_draft" value="1" class="btn btn-modern btn-primary btn-lg ms-2">
                                    <i class="bi bi-save me-2"></i>Save as Draft
                                </button>
                            </div>
                            <a href="<?= site_url('instructor/students') ?>" class="btn btn-modern btn-secondary btn-lg">
                                <i class="bi bi-x-circle me-2"></i>Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Recent Messages -->
            <div class="card card-modern">
                <div class="card-header" style="background: var(--primary-gradient); border: none; color: white;">
                    <h6 class="m-0 fw-bold">
                        <i class="bi bi-clock-history me-2"></i>
                        Recent Messages
                    </h6>
                </div>
                <div class="card-body">
                    <?php if (!empty($recentMessages)): ?>
                        <div class="timeline">
                            <?php foreach ($recentMessages as $message): ?>
                                <div class="d-flex align-items-start mb-3">
                                    <div class="me-3">
                                        <i class="bi bi-<?= $message['direction'] === 'sent' ? 'send-fill text-primary' : 'reply-fill text-success' ?>"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <div class="fw-bold"><?= esc($message['subject']) ?></div>
                                                <small class="text-muted"><?= substr(esc($message['message']), 0, 100) ?>...</small>
                                            </div>
                                            <div class="text-end">
                                                <small class="text-muted"><?= date('M d, Y H:i', strtotime($message['date'])) ?></small>
                                                <div>
                                                    <span class="badge badge-modern <?= $message['status'] === 'read' ? 'bg-success' : 'bg-warning' ?>">
                                                        <?= ucfirst($message['status']) ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <i class="bi bi-chat-dots text-muted" style="font-size: 3rem;"></i>
                            <p class="text-muted mt-3">No previous messages with this student.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Enhanced hover effects for cards
    const cards = document.querySelectorAll('.card-modern');
    cards.forEach(function(card) {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });

    // Stats card hover effects
    const statsCards = document.querySelectorAll('.stats-card');
    statsCards.forEach(function(card) {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });

    // Message templates
    const templates = {
        progress: "I wanted to check in on your progress in the course. You're doing well overall, but I'd like to discuss your current standing and any challenges you might be facing.",
        assignment: "This is a reminder that you have an upcoming assignment due. Please make sure to submit it on time and don't hesitate to ask if you have any questions.",
        concern: "I'm concerned about your recent performance in class. I'd like to schedule a meeting to discuss how we can work together to improve your understanding of the material.",
        praise: "I wanted to commend you on your excellent work recently. Your participation and effort have been outstanding, and I'm very pleased with your progress.",
        meeting: "I would like to schedule a meeting with you to discuss your progress in the course. Please let me know what times work best for you this week."
    };

    // Template button functionality
    const templateButtons = document.querySelectorAll('.template-btn');
    const messageTextarea = document.getElementById('message');
    
    templateButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            const templateKey = this.getAttribute('data-template');
            if (messageTextarea && templates[templateKey]) {
                const currentText = messageTextarea.value;
                const newTemplate = templates[templateKey];
                messageTextarea.value = currentText ? currentText + '\n\n' + newTemplate : newTemplate;
            }
        });
    });

    // Schedule options toggle
    const scheduleRadio = document.querySelectorAll('input[name="schedule"]');
    const scheduleOptions = document.getElementById('schedule_options');
    
    scheduleRadio.forEach(function(radio) {
        radio.addEventListener('change', function() {
            if (this.value === 'later' && scheduleOptions) {
                scheduleOptions.style.display = 'block';
            } else if (scheduleOptions) {
                scheduleOptions.style.display = 'none';
            }
        });
    });
});
</script>
<?= $this->endSection() ?>
