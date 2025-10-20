# Step 4: Dashboard View Structure Diagram

**Visual Guide to the Unified Dashboard View**

---

## 📁 File Structure

```
app/Views/auth/dashboard.php (1,199 lines)
│
├── Header (Lines 1-30) - Common to ALL roles
│   ├── Template extension
│   ├── Welcome message with user name
│   ├── Role badge display
│   └── Logout button
│
├── Flash Messages (Lines 35-49) - Common to ALL roles
│   ├── Success alerts
│   └── Error alerts
│
├── Session Status (Lines 52-57) - Common to ALL roles
│   └── Session timer display
│
├── Welcome Card (Lines 61-72) - Common to ALL roles
│   ├── Dynamic dashboard_message
│   └── Dynamic dashboard_description
│
├── ┌─────────────────────────────────────────┐
│   │  CONDITIONAL CONTENT STARTS HERE       │
│   └─────────────────────────────────────────┘
│
├── ADMIN SECTION (Lines 74-246) ✅
│   │   <?php if ($user['role'] === 'admin'): ?>
│   │
│   ├── System Statistics (Lines 76-142)
│   │   ├── Total Users card
│   │   ├── Students card
│   │   ├── Instructors card
│   │   └── Teachers card
│   │
│   ├── Additional Stats (Lines 145-188)
│   │   ├── Admins card
│   │   ├── Courses card
│   │   └── Announcements card
│   │
│   ├── System Management (Lines 191-211)
│   │   ├── Manage Users button
│   │   ├── Manage Courses button
│   │   └── View Reports button
│   │
│   └── Recent Activity (Lines 212-244)
│       └── Recent user registrations
│
├── TEACHER SECTION (Lines 247-416) ✅
│   │   <?php elseif ($user['role'] === 'instructor' || $user['role'] === 'teacher'): ?>
│   │
│   ├── Course Management Header (Lines 249-255)
│   │
│   ├── Teacher Statistics (Lines 258-315)
│   │   ├── My Courses card
│   │   ├── Total Students card
│   │   ├── Lessons card
│   │   └── Pending card
│   │
│   ├── My Courses List (Lines 318-370)
│   │   ├── Empty state (no courses)
│   │   └── Course list with edit/view buttons
│   │
│   ├── Quick Actions (Lines 371-392)
│   │   ├── Create Course
│   │   ├── Add Lesson
│   │   ├── Create Quiz
│   │   └── Post Announcement
│   │
│   └── Tips Section (Lines 393-413)
│       └── Teaching best practices
│
├── STUDENT SECTION (Lines 417-767) ✅
│   │   <?php else: ?>  (Default)
│   │
│   ├── Learning Journey Header (Lines 419-425)
│   │
│   ├── Student Statistics (Lines 428-485)
│   │   ├── Enrolled card
│   │   ├── Completed card
│   │   ├── Progress card
│   │   └── Quizzes card
│   │
│   ├── Enrolled Courses Section (Lines 488-599)
│   │   ├── Empty state (no enrollments)
│   │   └── Course cards with:
│   │       ├── Thumbnails
│   │       ├── Progress bars
│   │       ├── Continue buttons
│   │       └── Unenroll options
│   │
│   ├── Available Courses Section (Lines 604-693)
│   │   ├── Browse not-enrolled courses
│   │   └── Enroll Now buttons (AJAX)
│   │
│   ├── Recent Announcements (Lines 696-718)
│   │   └── Last 3 active announcements
│   │
│   ├── Quick Actions Sidebar (Lines 722-742)
│   │   ├── Browse Courses
│   │   ├── View Announcements
│   │   ├── My Achievements
│   │   └── View Progress
│   │
│   └── Learning Tips (Lines 744-765)
│       └── Study recommendations
│
├── ┌─────────────────────────────────────────┐
│   │  CONDITIONAL CONTENT ENDS HERE          │
│   │  <?php endif; ?> (Line 767)             │
│   └─────────────────────────────────────────┘
│
├── Profile Section (Lines 770-801) - Common to ALL roles
│   ├── Name display
│   ├── Email display
│   ├── Role display
│   ├── Member since date
│   ├── Edit Profile button
│   └── Change Password button
│
├── CSS Styles (Lines 803-829) - Common to ALL roles
│   ├── Hover effects
│   ├── Shadow animations
│   └── List item styles
│
└── JavaScript (Lines 831-1196) - Common to ALL roles
    ├── Session Timer (Lines 832-871)
    ├── AJAX Enrollment (Lines 886-1123)
    └── Unenrollment Function (Lines 1128-1196)
```

---

## 🔀 Conditional Logic Flow

```
┌─────────────────────────────────────────────────────────────┐
│                    DASHBOARD VIEW RENDER                    │
└─────────────────────────────────────────────────────────────┘
                           │
                           ▼
┌─────────────────────────────────────────────────────────────┐
│  COMMON HEADER (All Roles)                                  │
│  • Welcome back, {User Name}!                               │
│  • Role: {Badge}                                            │
│  • Logout button                                            │
└───────────────────────┬─────────────────────────────────────┘
                        │
                        ▼
┌─────────────────────────────────────────────────────────────┐
│  FLASH MESSAGES (All Roles)                                 │
│  • Success alerts                                           │
│  • Error alerts                                             │
└───────────────────────┬─────────────────────────────────────┘
                        │
                        ▼
┌─────────────────────────────────────────────────────────────┐
│  WELCOME CARD (All Roles)                                   │
│  • {dashboard_message}                                      │
│  • {dashboard_description}                                  │
└───────────────────────┬─────────────────────────────────────┘
                        │
                        ▼
                    CHECK $user['role']
                        │
          ┌─────────────┼─────────────┐
          │             │             │
          ▼             ▼             ▼
    ┌─────────┐   ┌──────────┐   ┌─────────┐
    │  admin  │   │ teacher/ │   │ student │
    │         │   │instructor│   │ (else)  │
    └────┬────┘   └────┬─────┘   └────┬────┘
         │             │             │
         ▼             ▼             ▼

┌──────────────┐  ┌──────────────┐  ┌──────────────┐
│ ADMIN VIEW   │  │ TEACHER VIEW │  │ STUDENT VIEW │
│ (173 lines)  │  │ (170 lines)  │  │ (351 lines)  │
├──────────────┤  ├──────────────┤  ├──────────────┤
│ • Statistics │  │ • Statistics │  │ • Statistics │
│   7 cards    │  │   4 cards    │  │   4 cards    │
│              │  │              │  │              │
│ • Management │  │ • My Courses │  │ • Enrolled   │
│   Actions    │  │   List       │  │   Courses    │
│              │  │              │  │              │
│ • Recent     │  │ • Quick      │  │ • Available  │
│   Activity   │  │   Actions    │  │   Courses    │
│              │  │              │  │              │
│              │  │ • Tips       │  │ • Recent     │
│              │  │              │  │   Announce   │
│              │  │              │  │              │
│              │  │              │  │ • Actions    │
│              │  │              │  │              │
│              │  │              │  │ • Tips       │
└──────────────┘  └──────────────┘  └──────────────┘
         │             │             │
         └─────────────┼─────────────┘
                       │
                       ▼
┌─────────────────────────────────────────────────────────────┐
│  PROFILE SECTION (All Roles)                                │
│  • Name, Email, Role                                        │
│  • Member Since, Last Updated                               │
│  • Edit Profile, Change Password buttons                    │
└───────────────────────┬─────────────────────────────────────┘
                        │
                        ▼
┌─────────────────────────────────────────────────────────────┐
│  CSS & JAVASCRIPT (All Roles)                               │
│  • Hover effects                                            │
│  • Session timer                                            │
│  • AJAX enrollment                                          │
└─────────────────────────────────────────────────────────────┘
```

---

## 📊 Content Distribution

```
┌────────────────────────────────────────────────────┐
│         DASHBOARD VIEW LINE DISTRIBUTION           │
├────────────────────────────────────────────────────┤
│                                                    │
│  Common Header:        30 lines    (2.5%)         │
│  Flash Messages:       15 lines    (1.3%)         │
│  Welcome Card:         12 lines    (1.0%)         │
│                                                    │
│  Admin Section:       173 lines   (14.4%) ✅      │
│  Teacher Section:     170 lines   (14.2%) ✅      │
│  Student Section:     351 lines   (29.3%) ✅      │
│                                                    │
│  Profile Section:      32 lines    (2.7%)         │
│  CSS Styles:           27 lines    (2.3%)         │
│  JavaScript:          366 lines   (30.5%)         │
│  Miscellaneous:        23 lines    (1.9%)         │
│                                                    │
│  Total:             1,199 lines  (100.0%)         │
│                                                    │
└────────────────────────────────────────────────────┘

Role-Specific Content: 694 lines (57.9%)
Common Content:        505 lines (42.1%)
```

---

## 🎨 Visual Hierarchy

```
┌─────────────────────────────────────────────────────────┐
│                    ADMIN DASHBOARD                      │
├─────────────────────────────────────────────────────────┤
│  👤 Welcome back, Admin User!                          │
│  Role: Admin  🔒  [Logout]                             │
├─────────────────────────────────────────────────────────┤
│  ✅ Success message (if any)                           │
│  ❌ Error message (if any)                             │
├─────────────────────────────────────────────────────────┤
│  📊 Welcome to Admin Dashboard                         │
│  Manage users, courses, and system settings            │
├─────────────────────────────────────────────────────────┤
│  System Statistics                                     │
│  ┌───────┐ ┌───────┐ ┌───────┐ ┌───────┐            │
│  │Users  │ │Student│ │Instru │ │Teacher│            │
│  │  10   │ │   4   │ │   4   │ │   0   │            │
│  └───────┘ └───────┘ └───────┘ └───────┘            │
│                                                         │
│  ┌───────┐ ┌───────┐ ┌───────┐                       │
│  │Admins │ │Courses│ │Announc│                       │
│  │   2   │ │   5   │ │   3   │                       │
│  └───────┘ └───────┘ └───────┘                       │
├─────────────────────────────────────────────────────────┤
│  System Management     │  Recent Activity              │
│  [Manage Users]        │  • New user registered        │
│  [Manage Courses]      │  • Course created             │
│  [View Reports]        │                               │
├─────────────────────────────────────────────────────────┤
│  Profile Information                                   │
│  Name: Admin User  |  Email: admin@lms.com            │
│  [Edit Profile]  [Change Password]                     │
└─────────────────────────────────────────────────────────┘
```

```
┌─────────────────────────────────────────────────────────┐
│                   TEACHER DASHBOARD                     │
├─────────────────────────────────────────────────────────┤
│  👨‍🏫 Welcome back, John Smith!                         │
│  Role: Instructor  🔒  [Logout]                        │
├─────────────────────────────────────────────────────────┤
│  📚 Welcome to Teacher Dashboard                       │
│  Manage your courses, lessons, and assessments         │
├─────────────────────────────────────────────────────────┤
│  Course Management                                     │
│  ┌───────┐ ┌───────┐ ┌───────┐ ┌───────┐            │
│  │Courses│ │Student│ │Lessons│ │Pending│            │
│  │   3   │ │  25   │ │  12   │ │   0   │            │
│  └───────┘ └───────┘ └───────┘ └───────┘            │
├─────────────────────────────────────────────────────────┤
│  My Courses                │  Quick Actions            │
│  📖 Web Development 101    │  [Create Course]          │
│     [Edit] [View]          │  [Add Lesson]             │
│  📖 PHP Advanced           │  [Create Quiz]            │
│     [Edit] [View]          │  [Post Announcement]      │
│  📖 JavaScript Mastery     │                           │
│     [Edit] [View]          │  💡 Tips                  │
│                            │  • Engage students        │
│                            │  • Provide feedback       │
└─────────────────────────────────────────────────────────┘
```

```
┌─────────────────────────────────────────────────────────┐
│                   STUDENT DASHBOARD                     │
├─────────────────────────────────────────────────────────┤
│  🎓 Welcome back, Alice Wilson!                        │
│  Role: Student  🔒  [Logout]                           │
├─────────────────────────────────────────────────────────┤
│  📚 Welcome to Student Dashboard                       │
│  View your enrolled courses and progress               │
├─────────────────────────────────────────────────────────┤
│  My Learning Journey                                   │
│  ┌───────┐ ┌───────┐ ┌───────┐ ┌───────┐            │
│  │Enroll │ │Complet│ │Progres│ │Quizzes│            │
│  │   2   │ │   0   │ │ 15.5% │ │   0   │            │
│  └───────┘ └───────┘ └───────┘ └───────┘            │
├─────────────────────────────────────────────────────────┤
│  My Enrolled Courses                                   │
│  ┌──────────────────────────────────┐                 │
│  │ 📖 Python Basics                 │                 │
│  │ Progress: 20%  [████░░░░░░] │                 │
│  │ Enrolled: Oct 15, 2025           │                 │
│  │ [Continue] [Unenroll]            │                 │
│  └──────────────────────────────────┘                 │
│                                                         │
│  ┌──────────────────────────────────┐                 │
│  │ 📖 Data Science Intro            │                 │
│  │ Progress: 10%  [██░░░░░░░░]      │                 │
│  │ Enrolled: Oct 18, 2025           │                 │
│  │ [Continue] [Unenroll]            │                 │
│  └──────────────────────────────────┘                 │
├─────────────────────────────────────────────────────────┤
│  Available Courses                                     │
│  ┌─────────────┐ ┌─────────────┐                     │
│  │Web Dev 101  │ │JavaScript   │                     │
│  │Level: Beginn│ │Level: Inter │                     │
│  │[Enroll Now] │ │[Enroll Now] │                     │
│  └─────────────┘ └─────────────┘                     │
├─────────────────────────────────────────────────────────┤
│  📢 Recent Announcements                               │
│  • New course available in CS department               │
│  • Registration deadline extended                      │
│  • Holiday schedule announced                          │
└─────────────────────────────────────────────────────────┘
```

---

## 🔧 Code Examples

### Admin Conditional

```php
<?php if ($user['role'] === 'admin'): ?>
    <div class="row mb-4">
        <div class="col-12">
            <h3 class="h5 mb-3">
                <i class="bi bi-graph-up me-2 text-primary"></i>
                System Statistics
            </h3>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <h3 class="fw-bold text-primary mb-1">
                        <?= $total_users ?? 0 ?>
                    </h3>
                    <p class="text-muted mb-2">Total Users</p>
                </div>
            </div>
        </div>
        <!-- More cards... -->
    </div>
<?php endif; ?>
```

### Teacher Conditional

```php
<?php elseif ($user['role'] === 'instructor' || $user['role'] === 'teacher'): ?>
    <div class="row mb-4">
        <div class="col-12">
            <h3 class="h5 mb-3">
                <i class="bi bi-person-workspace me-2 text-success"></i>
                Course Management
            </h3>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <?php if (empty($my_courses)): ?>
            <div class="text-center py-5">
                <h5 class="text-muted mb-3">No Courses Yet</h5>
                <button class="btn btn-success">
                    <i class="bi bi-plus-circle me-2"></i>
                    Create Your First Course
                </button>
            </div>
        <?php else: ?>
            <?php foreach ($my_courses as $course): ?>
                <div class="list-group-item">
                    <h6 class="mb-1"><?= esc($course['title']) ?></h6>
                    <button class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-pencil"></i> Edit
                    </button>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
<?php endif; ?>
```

### Student Conditional (Default)

```php
<?php else: ?>
    <div class="row mb-4">
        <div class="col-12">
            <h3 class="h5 mb-3">
                <i class="bi bi-mortarboard me-2 text-warning"></i>
                My Learning Journey
            </h3>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <?php if (empty($enrolled_courses)): ?>
            <div class="text-center py-5">
                <h5 class="text-muted mb-3">No Enrolled Courses</h5>
                <p class="text-muted mb-4">
                    Browse available courses to start your learning journey!
                </p>
                <a href="#available-courses" class="btn btn-warning">
                    <i class="bi bi-arrow-down-circle me-2"></i>
                    See Available Courses
                </a>
            </div>
        <?php else: ?>
            <?php foreach ($enrolled_courses as $enrollment): ?>
                <div class="list-group-item">
                    <h6><?= esc($enrollment['course_title']) ?></h6>
                    <div class="progress">
                        <div class="progress-bar bg-warning" 
                             style="width: <?= $enrollment['progress'] ?>%">
                        </div>
                    </div>
                    <button class="btn btn-warning">
                        <i class="bi bi-play-circle"></i> Continue
                    </button>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
<?php endif; ?>
```

---

**Created:** October 20, 2025  
**Project:** ITE311-AMAR  
**Step 4:** COMPLETE ✅

