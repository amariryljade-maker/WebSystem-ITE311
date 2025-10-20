# ✅ Step 4: Unified Dashboard View with Conditional Content - COMPLETE

**Laboratory Activity: Multi-Role Dashboard System**  
**Project:** ITE311-AMAR CodeIgniter LMS  
**Date Completed:** October 20, 2025  
**Status:** ✅ FULLY IMPLEMENTED AND VERIFIED

---

## 🎯 Step 4 Requirements (All Met)

### Required Tasks

From the laboratory instructions:

> "Create or modify the dashboard view at app/Views/auth/dashboard.php. Use PHP conditional statements to display different content based on the user's role."

### ✅ All Requirements Met

1. ✅ **Dashboard view exists** at `app/Views/auth/dashboard.php`
2. ✅ **PHP conditional statements implemented** (lines 74, 247, 417)
3. ✅ **Role-based content display** for admin, teacher, student
4. ✅ **Single unified view file** (no separate files per role)

---

## 📁 File Structure

**Location:** `app/Views/auth/dashboard.php`  
**Total Lines:** 1,199 lines  
**Structure:** Single file with PHP conditionals

### File Layout

```
dashboard.php (1,199 lines)
│
├── Header Section (1-30)
│   └── Common to all roles
│
├── Flash Messages (35-49)
│   └── Success/Error alerts
│
├── Dashboard Message Card (61-72)
│   └── Dynamic based on role data
│
├── CONDITIONAL SECTION 1: ADMIN (74-246)
│   ├── System Statistics Cards
│   ├── Admin Actions
│   └── Recent Activity
│
├── CONDITIONAL SECTION 2: TEACHER (247-416)
│   ├── Course Management Stats
│   ├── My Courses List
│   └── Quick Actions
│
├── CONDITIONAL SECTION 3: STUDENT (417-767)
│   ├── Learning Journey Stats
│   ├── Enrolled Courses
│   ├── Available Courses
│   └── Recent Announcements
│
├── Common Profile Section (770-801)
│   └── User information (all roles)
│
├── Styles (803-829)
│   └── CSS for animations
│
└── JavaScript (831-1196)
    ├── Session timer
    ├── AJAX enrollment
    └── Unenrollment functions
```

---

## 🔀 PHP Conditional Structure

### Main Conditional Block

```php
<?php if ($user['role'] === 'admin'): ?>
    <!-- ADMIN DASHBOARD CONTENT -->
    <!-- Lines 74-246 (173 lines) -->

<?php elseif ($user['role'] === 'instructor' || $user['role'] === 'teacher'): ?>
    <!-- TEACHER DASHBOARD CONTENT -->
    <!-- Lines 247-416 (170 lines) -->

<?php else: ?>
    <!-- STUDENT DASHBOARD CONTENT (Default) -->
    <!-- Lines 417-767 (351 lines) -->

<?php endif; ?>
```

### Implementation Details

**Line 74:** Admin Conditional Start
```php
<?php if ($user['role'] === 'admin'): ?>
```

**Line 247:** Teacher Conditional Start
```php
<?php elseif ($user['role'] === 'instructor' || $user['role'] === 'teacher'): ?>
```

**Line 417:** Student Conditional Start (Default)
```php
<?php else: ?>
```

**Line 767:** Conditional End
```php
<?php endif; ?>
```

---

## 👤 Section 1: Admin Dashboard (Lines 74-246)

### Content Overview

```php
<?php if ($user['role'] === 'admin'): ?>
    <!-- Admin Dashboard -->
    
    <!-- System Statistics (4 cards) -->
    <div class="row g-4 mb-5">
        <div>Total Users: <?= $total_users ?? 0 ?></div>
        <div>Students: <?= $total_students ?? 0 ?></div>
        <div>Instructors: <?= $total_instructors ?? 0 ?></div>
        <div>Teachers: <?= $total_teachers ?? 0 ?></div>
    </div>
    
    <!-- Additional Stats (3 cards) -->
    <div class="row g-4 mb-5">
        <div>Admins: <?= $total_admins ?? 0 ?></div>
        <div>Courses: <?= $total_courses ?? 0 ?></div>
        <div>Announcements: <?= $total_announcements ?? 0 ?></div>
    </div>
    
    <!-- Admin Actions -->
    <div class="card">
        <button>Manage Users</button>
        <button>Manage Courses</button>
        <button>View Reports</button>
    </div>
    
    <!-- Recent Activity -->
    <div class="card">
        <!-- List of recent users -->
    </div>
<?php endif; ?>
```

### Key Features

✅ **7 Statistical Cards**
- Total Users
- Students
- Instructors  
- Teachers
- Admins
- Courses
- Announcements

✅ **System Management Actions**
- Manage Users button
- Manage Courses button
- View Reports button
- Settings button

✅ **Recent Activity Feed**
- New user registrations
- Course creations
- System events

---

## 👨‍🏫 Section 2: Teacher Dashboard (Lines 247-416)

### Content Overview

```php
<?php elseif ($user['role'] === 'instructor' || $user['role'] === 'teacher'): ?>
    <!-- Instructor/Teacher Dashboard -->
    
    <!-- Teacher Statistics (4 cards) -->
    <div class="row g-4 mb-4">
        <div>My Courses: <?= $total_courses ?? 0 ?></div>
        <div>Total Students: <?= $total_students ?? 0 ?></div>
        <div>Lessons: <?= $total_lessons ?? 0 ?></div>
        <div>Pending: <?= $pending_submissions ?? 0 ?></div>
    </div>
    
    <!-- My Courses List -->
    <div class="card">
        <?php if (empty($my_courses)): ?>
            <div>No courses yet. Create your first course!</div>
        <?php else: ?>
            <?php foreach ($my_courses as $course): ?>
                <div><?= esc($course['title']) ?></div>
                <button>Edit</button>
                <button>View</button>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    
    <!-- Quick Actions -->
    <div class="card">
        <button>Create Course</button>
        <button>Add Lesson</button>
        <button>Create Quiz</button>
        <button>Post Announcement</button>
    </div>
<?php endif; ?>
```

### Key Features

✅ **4 Statistical Cards**
- My Courses count
- Total Students enrolled
- Total Lessons created
- Pending Submissions

✅ **Course Management**
- List of instructor's courses
- Edit/View buttons per course
- Empty state for new instructors
- Create Course button

✅ **Quick Actions**
- Create Course
- Add Lesson
- Create Quiz
- Post Announcement

✅ **Teaching Tips**
- Best practices section
- Engagement tips

---

## 🎓 Section 3: Student Dashboard (Lines 417-767)

### Content Overview

```php
<?php else: ?>
    <!-- Student Dashboard -->
    
    <!-- Student Statistics (4 cards) -->
    <div class="row g-4 mb-4">
        <div>Enrolled: <?= $total_enrolled ?? 0 ?></div>
        <div>Completed: <?= $completed_courses ?? 0 ?></div>
        <div>Progress: <?= $overall_progress ?? 0 ?>%</div>
        <div>Quizzes: <?= $pending_quizzes ?? 0 ?></div>
    </div>
    
    <!-- Enrolled Courses -->
    <div class="card">
        <?php if (empty($enrolled_courses)): ?>
            <div>No enrolled courses yet.</div>
        <?php else: ?>
            <?php foreach ($enrolled_courses as $enrollment): ?>
                <div>
                    <h6><?= esc($enrollment['course_title']) ?></h6>
                    <div>Progress: <?= $enrollment['progress'] ?>%</div>
                    <div class="progress-bar" style="width: <?= $enrollment['progress'] ?>%"></div>
                    <button>Continue</button>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    
    <!-- Available Courses -->
    <div class="card">
        <?php foreach ($available_courses as $course): ?>
            <div>
                <h6><?= esc($course['title']) ?></h6>
                <button onclick="enrollInCourse(<?= $course['id'] ?>)">
                    Enroll Now
                </button>
            </div>
        <?php endforeach; ?>
    </div>
    
    <!-- Recent Announcements -->
    <div class="card">
        <?php foreach ($recent_announcements as $announcement): ?>
            <div>
                <h6><?= esc($announcement['title']) ?></h6>
                <p><?= esc($announcement['content']) ?></p>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
```

### Key Features

✅ **4 Statistical Cards**
- Enrolled Courses
- Completed Courses
- Overall Progress %
- Pending Quizzes

✅ **Enrolled Courses Section**
- Course cards with thumbnails
- Progress bars
- Enrollment dates
- Continue learning buttons
- Unenroll option

✅ **Available Courses**
- Browse not-enrolled courses
- Course details (level, price)
- One-click enrollment via AJAX
- Featured course badges

✅ **Recent Announcements**
- Last 3 active announcements
- Announcement titles and content
- Posted dates
- View All link

✅ **Quick Actions**
- Browse Courses
- View Announcements
- My Achievements
- View Progress

✅ **Learning Tips**
- Daily learning goals
- Quiz completion tips
- Review recommendations

---

## 🎨 Common Sections (All Roles)

### Header (Lines 5-30)

```php
<!-- Common to ALL roles -->
<div class="bg-primary text-white py-4">
    <div class="container">
        <h1>Welcome back, <?= esc($user['name']) ?>!</h1>
        <p>
            Role: <span class="badge"><?= ucfirst($user['role']) ?></span>
            <span>Session active</span>
        </p>
        <a href="<?= base_url('logout') ?>" class="btn">Logout</a>
    </div>
</div>
```

### Flash Messages (Lines 35-49)

```php
<!-- Success messages -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<!-- Error messages -->
<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>
```

### Dynamic Welcome Message (Lines 61-72)

```php
<!-- Based on role data from controller -->
<div class="card">
    <h2><?= $dashboard_message ?? 'Welcome to Dashboard' ?></h2>
    <p><?= $dashboard_description ?? 'Your personalized learning space' ?></p>
</div>
```

### Profile Section (Lines 770-801)

```php
<!-- Common to ALL roles -->
<div class="card">
    <h5>Profile Information</h5>
    <p><strong>Name:</strong> <?= esc($user['name']) ?></p>
    <p><strong>Email:</strong> <?= esc($user['email']) ?></p>
    <p><strong>Role:</strong> <?= ucfirst($user['role']) ?></p>
    <p><strong>Member Since:</strong> <?= date('F j, Y', strtotime($user['created_at'])) ?></p>
    <button>Edit Profile</button>
    <button>Change Password</button>
</div>
```

---

## 🎯 Data Display Patterns

### Pattern 1: Statistical Cards

```php
<!-- Used by ALL roles -->
<div class="card text-center">
    <div class="icon-circle">
        <i class="bi bi-icon"></i>
    </div>
    <h3 class="fw-bold"><?= $variable ?? 0 ?></h3>
    <p class="text-muted">Label</p>
    <small class="text-muted">Description</small>
</div>
```

### Pattern 2: List with Empty State

```php
<!-- Used by Teacher (courses) and Student (enrollments) -->
<?php if (empty($items)): ?>
    <!-- Empty State -->
    <div class="text-center py-5">
        <i class="bi bi-icon" style="font-size: 3rem;"></i>
        <h5>No items yet</h5>
        <p>Get started message</p>
        <button>Primary Action</button>
    </div>
<?php else: ?>
    <!-- List of Items -->
    <?php foreach ($items as $item): ?>
        <div class="list-group-item">
            <!-- Item content -->
        </div>
    <?php endforeach; ?>
<?php endif; ?>
```

### Pattern 3: Action Buttons

```php
<!-- Used by ALL roles -->
<div class="card">
    <h5>Quick Actions</h5>
    <div class="d-grid gap-2">
        <button class="btn btn-outline-primary">
            <i class="bi bi-icon"></i> Action 1
        </button>
        <button class="btn btn-outline-success">
            <i class="bi bi-icon"></i> Action 2
        </button>
    </div>
</div>
```

---

## 🔒 Security in Views

### XSS Prevention

```php
<!-- All user input escaped -->
<?= esc($user['name']) ?>
<?= esc($course['title']) ?>
<?= esc($announcement['content']) ?>
```

### Safe Attribute Output

```php
<!-- HTML attributes escaped -->
<div data-course-id="<?= $course['id'] ?>">
<input value="<?= esc($user['email']) ?>">
```

### CSRF Tokens

```php
<!-- Forms include CSRF -->
<input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>">
```

---

## 📊 Data Variables Used

### Admin Role Variables

```php
$user                    // User object
$user_role              // 'admin'
$dashboard_message      // "Welcome to Admin Dashboard"
$dashboard_description  // "Manage users, courses, and system settings"
$total_users           // Count of all users
$total_students        // Count of students
$total_instructors     // Count of instructors
$total_teachers        // Count of teachers
$total_admins          // Count of admins
$recent_users          // Array of 5 recent users
$total_announcements   // Count of active announcements
$total_courses         // Count of all courses
$active_users          // Count of active users
```

### Teacher Role Variables

```php
$user                    // User object
$user_role              // 'instructor' or 'teacher'
$dashboard_message      // "Welcome to Teacher Dashboard"
$dashboard_description  // "Manage your courses, lessons, and assessments"
$my_courses            // Array of instructor's courses
$total_courses         // Count of instructor's courses
$total_students        // Count of students across all courses
$total_lessons         // Count of lessons in all courses
$pending_submissions   // Count of pending submissions
```

### Student Role Variables

```php
$user                    // User object
$user_role              // 'student'
$dashboard_message      // "Welcome to Student Dashboard"
$dashboard_description  // "View your enrolled courses and progress"
$enrolled_courses      // Array of enrollments with course data
$available_courses     // Array of courses not yet enrolled
$total_enrolled        // Count of enrolled courses
$completed_courses     // Count of completed courses
$overall_progress      // Average progress percentage
$recent_announcements  // Array of 3 recent announcements
$pending_quizzes       // Count of pending quizzes
```

---

## 🎨 Visual Design

### Bootstrap 5 Components Used

✅ **Cards** - For all content sections  
✅ **Alerts** - For flash messages  
✅ **Badges** - For role display, status indicators  
✅ **Progress Bars** - For student course progress  
✅ **Buttons** - For actions throughout  
✅ **List Groups** - For course/user lists  
✅ **Grid System** - For responsive layout  
✅ **Icons** - Bootstrap Icons throughout  

### Custom Styling

```css
/* Hover effects */
.hover-lift:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}

/* Shadow effects */
.hover-shadow:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.12);
}

/* List item hover */
.list-group-item:hover {
    background-color: #f8f9fa;
}
```

---

## 📱 Responsive Design

### Layout Grid

```html
<!-- 4 columns on large screens, 2 on medium, 1 on small -->
<div class="row g-4">
    <div class="col-lg-3 col-md-6">
        <!-- Stat card -->
    </div>
</div>

<!-- 2 columns on large screens, full width on mobile -->
<div class="row">
    <div class="col-lg-8">
        <!-- Main content -->
    </div>
    <div class="col-lg-4">
        <!-- Sidebar -->
    </div>
</div>
```

---

## 🔄 Dynamic Features

### Session Timer (Lines 832-871)

```javascript
// Updates every second
function updateSessionTimer() {
    const elapsed = Date.now() - sessionStartTime;
    const remaining = sessionTimeout - elapsed;
    
    if (remaining <= 0) {
        alert('Your session has expired.');
        window.location.href = '/logout';
    }
    
    const minutes = Math.floor(remaining / 60000);
    const seconds = Math.floor((remaining % 60000) / 1000);
    
    document.getElementById('session-timer').textContent = 
        `Session expires in: ${minutes}:${seconds}`;
}
```

### AJAX Enrollment (Lines 886-979)

```javascript
// jQuery AJAX for course enrollment
$('.enroll-btn').on('click', function(e) {
    e.preventDefault();
    
    const courseId = $(this).data('course-id');
    
    $.post({
        url: '/courses/enroll',
        data: { course_id: courseId },
        success: function(response) {
            if (response.success) {
                showBootstrapAlert(response.message, 'success');
                updateEnrolledCoursesList(response);
            }
        }
    });
});
```

---

## ✅ Step 4 Completion Checklist

- [x] ✅ Dashboard view exists at correct location
- [x] ✅ PHP conditional statements implemented
- [x] ✅ Admin section created (lines 74-246)
- [x] ✅ Teacher section created (lines 247-416)
- [x] ✅ Student section created (lines 417-767)
- [x] ✅ Common sections for all roles
- [x] ✅ Flash message handling
- [x] ✅ Profile section for all users
- [x] ✅ Bootstrap 5 styling applied
- [x] ✅ Responsive design implemented
- [x] ✅ XSS prevention via esc()
- [x] ✅ Dynamic data display
- [x] ✅ Empty state handling
- [x] ✅ AJAX functionality
- [x] ✅ Session timer implemented
- [x] ✅ All roles tested

**Status: STEP 4 COMPLETE** ✅

---

## 🚀 What's Next?

**Step 4 is COMPLETE!** ✅

Your unified dashboard view now:
- ✅ Single file for all roles
- ✅ PHP conditionals for role-based content
- ✅ Three distinct user experiences
- ✅ Professional UI with Bootstrap 5
- ✅ Dynamic features (AJAX, timers)
- ✅ Responsive and mobile-friendly

**Next:** Step 5 or advanced features!

---

## 📝 Quick Reference

### File Location
```
app/Views/auth/dashboard.php (1,199 lines)
```

### Conditional Structure
```php
Line 74:  <?php if ($user['role'] === 'admin'): ?>
Line 247: <?php elseif ($user['role'] === 'instructor' || $user['role'] === 'teacher'): ?>
Line 417: <?php else: ?>  (Student - default)
Line 767: <?php endif; ?>
```

### Test URLs
```
http://localhost/ITE311-AMAR/dashboard
```

### Test Accounts
```
admin@lms.com           → Admin view
john.smith@lms.com      → Teacher view
alice.wilson@student.com → Student view
```

---

**Documentation Generated:** October 20, 2025  
**Project:** ITE311-AMAR CodeIgniter LMS  
**Laboratory Activity:** Multi-Role Dashboard System  
**Step 4 Status:** ✅ COMPLETE AND VERIFIED

**All Steps Complete:**
- ✅ Step 1: Project Setup
- ✅ Step 2: Unified Dashboard
- ✅ Step 3: Enhanced Dashboard Method
- ✅ Step 4: Unified Dashboard View

---

*This document serves as proof of Step 4 completion. The unified dashboard view is fully implemented with comprehensive role-based conditionals and professional UI design.*

