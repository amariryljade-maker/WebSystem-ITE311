# Step 2: Visual Implementation Guide 📊

**Unified Dashboard with Role-Based Conditionals**

---

## 🔄 Complete Login to Dashboard Flow

```
┌─────────────────────────────────────────────────────────────────┐
│                         USER INTERACTION                        │
└─────────────────────────────────────────────────────────────────┘

Step 1: User visits login page
┌──────────────────────────────────┐
│  http://localhost/.../login      │
│                                  │
│  ┌────────────────────────┐     │
│  │ Email:    [         ]  │     │
│  │ Password: [         ]  │     │
│  │ [Login Button]         │     │
│  └────────────────────────┘     │
└──────────────────────────────────┘
           │
           │ POST /login
           ▼
┌──────────────────────────────────────────────────────────────────┐
│                    AUTH CONTROLLER - LOGIN()                     │
│                   app/Controllers/Auth.php                       │
└──────────────────────────────────────────────────────────────────┘

Step 2: Validate credentials
┌──────────────────────────────────┐
│  1. Validate input               │
│  2. Query database               │
│  3. Verify password              │
└──────────────┬───────────────────┘
               │
               ▼
┌──────────────────────────────────────────────────────────────────┐
│  CREATE SESSION WITH ROLE                                        │
│  ┌────────────────────────────────────────────────────────────┐ │
│  │ 'user_id'    => 7                                          │ │
│  │ 'user_name'  => "Alice Wilson"                             │ │
│  │ 'user_email' => "alice@student.com"                        │ │
│  │ 'user_role'  => "student"  ← ✅ STORED IN SESSION         │ │
│  │ 'logged_in'  => true                                       │ │
│  └────────────────────────────────────────────────────────────┘ │
└──────────────────────────────────────────────────────────────────┘
               │
               │ STEP 2 REQUIREMENT: UNIFIED REDIRECT ✅
               ▼
┌──────────────────────────────────────────────────────────────────┐
│           return redirect()->to('/dashboard');                   │
│                                                                  │
│  ⚠️ NOTE: SAME REDIRECT FOR ALL ROLES                           │
│  • Admin → /dashboard                                            │
│  • Teacher → /dashboard                                          │
│  • Student → /dashboard                                          │
└──────────────────────────────────────────────────────────────────┘
               │
               │ GET /dashboard
               ▼
┌──────────────────────────────────────────────────────────────────┐
│               AUTH CONTROLLER - DASHBOARD()                      │
│               app/Controllers/Auth.php                           │
└──────────────────────────────────────────────────────────────────┘

Step 3: Get role from session
┌──────────────────────────────────┐
│  $userId = get_user_id();        │
│  $user = $this->userModel        │
│           ->find($userId);       │
│                                  │
│  $role = $user['role'];  ✅      │
└──────────────┬───────────────────┘
               │
               │ STEP 2 REQUIREMENT: ROLE-BASED CONDITIONALS ✅
               ▼
┌──────────────────────────────────────────────────────────────────┐
│                   SWITCH ON USER ROLE                            │
│                                                                  │
│  switch ($user['role']) {                                        │
│      case 'admin':                                               │
│          $data = getAdminDashboardData();                        │
│          break;                                                  │
│      case 'instructor':                                          │
│      case 'teacher':                                             │
│          $data = getTeacherDashboardData();                      │
│          break;                                                  │
│      case 'student':                                             │
│          $data = getStudentDashboardData();                      │
│          break;                                                  │
│  }                                                               │
└──────────────────────────────────────────────────────────────────┘
       │                    │                    │
       │ Admin              │ Teacher            │ Student
       ▼                    ▼                    ▼
┌─────────────┐     ┌─────────────┐     ┌─────────────┐
│ Admin Data  │     │Teacher Data │     │Student Data │
├─────────────┤     ├─────────────┤     ├─────────────┤
│• Total users│     │• My courses │     │• Enrolled   │
│• Students   │     │• Students   │     │• Available  │
│• Teachers   │     │• Lessons    │     │• Progress   │
│• Courses    │     │• Pending    │     │• Quizzes    │
└─────────────┘     └─────────────┘     └─────────────┘
       │                    │                    │
       └────────────────────┼────────────────────┘
                            │
                            ▼
┌──────────────────────────────────────────────────────────────────┐
│         return view('auth/dashboard', $dashboardData);           │
│                                                                  │
│         ⚠️ NOTE: SAME VIEW FILE FOR ALL ROLES                   │
└──────────────────────────────────────────────────────────────────┘
                            │
                            ▼
┌──────────────────────────────────────────────────────────────────┐
│                    VIEW - auth/dashboard.php                     │
│                  app/Views/auth/dashboard.php                    │
└──────────────────────────────────────────────────────────────────┘

Step 4: Render role-based content
┌──────────────────────────────────────────────────────────────────┐
│  <?php if ($user['role'] === 'admin'): ?>                        │
│      <!-- Admin Dashboard -->                                    │
│      <h3>System Statistics</h3>                                  │
│      <div>Total Users: <?= $total_users ?></div>                 │
│      <button>Manage Users</button>                               │
│                                                                  │
│  <?php elseif ($user['role'] === 'instructor' ||                │
│                $user['role'] === 'teacher'): ?>                  │
│      <!-- Teacher Dashboard -->                                  │
│      <h3>Course Management</h3>                                  │
│      <div>My Courses: <?= $total_courses ?></div>                │
│      <button>Create Course</button>                              │
│                                                                  │
│  <?php else: ?>                                                  │
│      <!-- Student Dashboard -->                                  │
│      <h3>My Learning Journey</h3>                                │
│      <div>Enrolled: <?= $total_enrolled ?></div>                 │
│      <button>Browse Courses</button>                             │
│                                                                  │
│  <?php endif; ?>                                                 │
└──────────────────────────────────────────────────────────────────┘
       │                    │                    │
       ▼                    ▼                    ▼
┌─────────────┐     ┌─────────────┐     ┌─────────────┐
│   ADMIN     │     │   TEACHER   │     │   STUDENT   │
│  DASHBOARD  │     │  DASHBOARD  │     │  DASHBOARD  │
└─────────────┘     └─────────────┘     └─────────────┘
```

---

## 📊 Three Role Views Side-by-Side

```
┌─────────────────────┬─────────────────────┬─────────────────────┐
│   ADMIN DASHBOARD   │  TEACHER DASHBOARD  │  STUDENT DASHBOARD  │
├─────────────────────┼─────────────────────┼─────────────────────┤
│                     │                     │                     │
│ 👤 Welcome Admin!   │ 👨‍🏫 Welcome Teacher! │ 🎓 Welcome Student! │
│                     │                     │                     │
│ ┌─────────────────┐ │ ┌─────────────────┐ │ ┌─────────────────┐ │
│ │ 📊 STATISTICS   │ │ │ 📚 MY COURSES   │ │ │ 📖 ENROLLED     │ │
│ ├─────────────────┤ │ ├─────────────────┤ │ ├─────────────────┤ │
│ │ Users:       10 │ │ │ Courses:      3 │ │ │ Courses:      2 │ │
│ │ Students:     4 │ │ │ Students:    25 │ │ │ Completed:    0 │ │
│ │ Teachers:     4 │ │ │ Lessons:     12 │ │ │ Progress:   15% │ │
│ │ Courses:      5 │ │ │ Pending:      5 │ │ │ Quizzes:      0 │ │
│ └─────────────────┘ │ └─────────────────┘ │ └─────────────────┘ │
│                     │                     │                     │
│ ┌─────────────────┐ │ ┌─────────────────┐ │ ┌─────────────────┐ │
│ │ 🛠️ ACTIONS      │ │ │ ⚡ ACTIONS       │ │ │ 🔍 AVAILABLE    │ │
│ ├─────────────────┤ │ ├─────────────────┤ │ ├─────────────────┤ │
│ │ [Manage Users]  │ │ │ [Create Course] │ │ │ [Browse Courses]│ │
│ │ [Manage Courses]│ │ │ [Add Lesson]    │ │ │ [Announcements] │ │
│ │ [View Reports]  │ │ │ [Create Quiz]   │ │ │ [My Progress]   │ │
│ │ [Settings]      │ │ │ [Announcement]  │ │ │ [Achievements]  │ │
│ └─────────────────┘ │ └─────────────────┘ │ └─────────────────┘ │
│                     │                     │                     │
│ ┌─────────────────┐ │ ┌─────────────────┐ │ ┌─────────────────┐ │
│ │ 📋 RECENT       │ │ │ 📝 COURSE LIST  │ │ │ 📚 MY COURSES   │ │
│ ├─────────────────┤ │ ├─────────────────┤ │ ├─────────────────┤ │
│ │ • New user      │ │ │ • Web Dev 101   │ │ │ • Python Basics │ │
│ │ • Course added  │ │ │ • PHP Advanced  │ │ │   Progress: 20% │ │
│ │ • Announcement  │ │ │ • JavaScript    │ │ │                 │ │
│ │                 │ │ │                 │ │ │ • Data Science  │ │
│ │                 │ │ │                 │ │ │   Progress: 10% │ │
│ └─────────────────┘ │ └─────────────────┘ │ └─────────────────┘ │
│                     │                     │                     │
└─────────────────────┴─────────────────────┴─────────────────────┘

 URL: /dashboard       URL: /dashboard       URL: /dashboard
 (SAME FOR ALL)        (SAME FOR ALL)        (SAME FOR ALL)
```

---

## 🔑 Key Implementation Points

### 1️⃣ Single Redirect
```php
// ✅ CORRECT (Step 2)
return redirect()->to('/dashboard');

// ❌ WRONG (Old way)
if ($user['role'] === 'admin') {
    return redirect()->to('/admin');
} elseif ($user['role'] === 'teacher') {
    return redirect()->to('/teacher');
} else {
    return redirect()->to('/student');
}
```

### 2️⃣ Session Role Storage
```php
// Stored at login
$sessionData = [
    'user_role' => $user['role']  // ✅ CRITICAL
];
session()->set($sessionData);

// Retrieved in dashboard
$role = $user['role'];  // From database verification
$sessionRole = session()->get('user_role');  // From session
```

### 3️⃣ Controller Conditionals
```php
// ✅ CORRECT (Switch statement)
switch ($user['role']) {
    case 'admin':
        $data = $this->getAdminDashboardData($userId);
        break;
    case 'teacher':
        $data = $this->getTeacherDashboardData($userId);
        break;
    case 'student':
        $data = $this->getStudentDashboardData($userId);
        break;
}

return view('auth/dashboard', $data);
```

### 4️⃣ View Conditionals
```php
<!-- ✅ CORRECT (PHP conditionals in view) -->
<?php if ($user['role'] === 'admin'): ?>
    <div class="admin-content">
        <!-- Admin-specific HTML -->
    </div>
<?php elseif ($user['role'] === 'teacher'): ?>
    <div class="teacher-content">
        <!-- Teacher-specific HTML -->
    </div>
<?php else: ?>
    <div class="student-content">
        <!-- Student-specific HTML -->
    </div>
<?php endif; ?>
```

---

## 🎯 Data Flow Comparison

### Before Step 2 (Multiple Endpoints)
```
Login → Check Role → Redirect
                 ↓
        ┌────────┼────────┐
        ▼        ▼        ▼
    /admin  /teacher  /student
        ↓        ↓        ↓
  admin.php teacher.php student.php
  (separate files)
```

### After Step 2 (Unified Endpoint) ✅
```
Login → Unified Redirect → /dashboard
                              ↓
                    Check role in controller
                              ↓
                    Load role-specific data
                              ↓
                    Pass to single view
                              ↓
                    dashboard.php
                    (conditionals inside)
```

---

## 🔄 Session Role Flow

```
┌─────────────────────────────────────────────────────────┐
│                    SESSION LIFECYCLE                    │
└─────────────────────────────────────────────────────────┘

1. USER LOGS IN
   ↓
   [Database Query] → SELECT * FROM users WHERE email = ?
   ↓
   [Password Verify] → password_verify($input, $hash)
   ↓
   [Create Session]
   ┌──────────────────────────────────────┐
   │ $_SESSION = [                        │
   │   'user_id' => 7,                    │
   │   'user_role' => 'student'  ← SAVED  │
   │ ]                                    │
   └──────────────────────────────────────┘
   ↓
   [Redirect] → /dashboard

2. USER ACCESSES DASHBOARD
   ↓
   [Get Session] → $role = session()->get('user_role')
   ↓
   [Verify DB] → $user = UserModel::find(user_id)
   ↓
   [Compare] → session role === database role?
   ↓
   [Load Data] → Based on $user['role']
   ↓
   [Render View] → dashboard.php

3. USER PERFORMS ACTION
   ↓
   [Check Role] → get_user_role()
   ↓
   [Authorize] → has_role('admin') ?
   ↓
   [Execute] → If authorized

4. USER LOGS OUT
   ↓
   [Destroy Session] → session()->destroy()
   ↓
   [Redirect] → /login
```

---

## 📁 File Structure

```
app/
├── Controllers/
│   └── Auth.php  ← ✅ UNIFIED DASHBOARD METHOD
│       ├── login()           (line 245)
│       ├── dashboard()       (line 397) ✅ ONE METHOD FOR ALL
│       ├── getAdminDashboardData()    (line 497)
│       ├── getTeacherDashboardData()  (line 542)
│       └── getStudentDashboardData()  (line 589)
│
├── Views/
│   └── auth/
│       └── dashboard.php  ← ✅ ONE VIEW FILE
│           ├── Admin section    (lines 74-246)
│           ├── Teacher section  (lines 247-416)
│           └── Student section  (lines 417-767)
│
└── Helpers/
    └── session_helper.php  ← ✅ ROLE FUNCTIONS
        ├── get_user_role()
        ├── has_role($role)
        ├── is_admin()
        ├── is_instructor()
        └── is_student()
```

---

## ✅ Step 2 Checklist

- [x] ✅ Login redirects to `/dashboard` (unified)
- [x] ✅ No role-based redirect logic
- [x] ✅ Role stored in session
- [x] ✅ Dashboard checks role from session
- [x] ✅ Switch statement for conditionals
- [x] ✅ Single view file
- [x] ✅ View has PHP conditionals
- [x] ✅ Admin content displays for admin
- [x] ✅ Teacher content displays for teacher
- [x] ✅ Student content displays for student

**STEP 2: COMPLETE** ✅

---

## 🧪 Quick Test

```bash
# 1. Visit login page
http://localhost/ITE311-AMAR/login

# 2. Login as admin
Email: admin@lms.com
Password: [from LOGIN_CREDENTIALS.md]

# 3. Check URL after login
Expected: http://localhost/ITE311-AMAR/dashboard  ✅
NOT:      http://localhost/ITE311-AMAR/admin      ❌

# 4. Check page content
Expected: "Welcome to Admin Dashboard"
Expected: System statistics visible
Expected: "Manage Users" button visible

# 5. Check session
In browser console:
<?php var_dump(session()->get('user_role')); ?>
Expected: string(5) "admin"
```

---

**Created:** October 20, 2025  
**Project:** ITE311-AMAR  
**Step 2:** COMPLETE ✅

