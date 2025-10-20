# Step 3: Authorization & Data Flow Diagrams

**Visual Guide to Dashboard Enhancement**

---

## 🔐 Authorization Flow (6 Layers)

```
┌─────────────────────────────────────────────────────────────────┐
│                    USER REQUESTS /dashboard                     │
└─────────────────────────────────────────────────────────────────┘
                           │
                           ▼
┌─────────────────────────────────────────────────────────────────┐
│  LAYER 1: LOGIN CHECK                                           │
│  ┌────────────────────────────────────────────────────────────┐ │
│  │ is_user_logged_in()                                        │ │
│  │ Checks: $_SESSION['logged_in'] === true                   │ │
│  └────────────────────────────────────────────────────────────┘ │
│                                                                 │
│  ✅ Logged In → Continue                                        │
│  ❌ Not Logged In → Redirect to /login                          │
└─────────────────────────────────────────────────────────────────┘
                           │
                           ▼
┌─────────────────────────────────────────────────────────────────┐
│  LAYER 2: SESSION TIMEOUT                                       │
│  ┌────────────────────────────────────────────────────────────┐ │
│  │ check_session_timeout()                                    │ │
│  │ Checks: session_timeout > current_time                     │ │
│  └────────────────────────────────────────────────────────────┘ │
│                                                                 │
│  ✅ Valid → Continue                                            │
│  ❌ Expired → Logout & Redirect                                 │
└─────────────────────────────────────────────────────────────────┘
                           │
                           ▼
┌─────────────────────────────────────────────────────────────────┐
│  LAYER 3: USER ID VERIFICATION                                  │
│  ┌────────────────────────────────────────────────────────────┐ │
│  │ get_user_id()                                              │ │
│  │ Gets: $_SESSION['user_id']                                 │ │
│  └────────────────────────────────────────────────────────────┘ │
│                                                                 │
│  ✅ ID Exists → Continue                                        │
│  ❌ No ID → Redirect to /login                                  │
└─────────────────────────────────────────────────────────────────┘
                           │
                           ▼
┌─────────────────────────────────────────────────────────────────┐
│  LAYER 4: DATABASE VERIFICATION                                 │
│  ┌────────────────────────────────────────────────────────────┐ │
│  │ $user = UserModel::find($userId)                           │ │
│  │ Query: SELECT * FROM users WHERE id = ?                    │ │
│  └────────────────────────────────────────────────────────────┘ │
│                                                                 │
│  ✅ User Found → Continue                                       │
│  ❌ Not Found → Logout & Redirect                               │
└─────────────────────────────────────────────────────────────────┘
                           │
                           ▼
┌─────────────────────────────────────────────────────────────────┐
│  LAYER 5: ROLE VALIDATION                                       │
│  ┌────────────────────────────────────────────────────────────┐ │
│  │ in_array($user['role'], $validRoles)                       │ │
│  │ Valid: ['admin', 'teacher', 'instructor', 'student']       │ │
│  └────────────────────────────────────────────────────────────┘ │
│                                                                 │
│  ✅ Valid Role → Continue                                       │
│  ❌ Invalid Role → Logout & Redirect                            │
└─────────────────────────────────────────────────────────────────┘
                           │
                           ▼
┌─────────────────────────────────────────────────────────────────┐
│  LAYER 6: SECURITY UPDATES                                      │
│  ┌────────────────────────────────────────────────────────────┐ │
│  │ set_session_timeout(30)                                    │ │
│  │ log_message('info', 'User X accessed dashboard')           │ │
│  └────────────────────────────────────────────────────────────┘ │
│                                                                 │
│  ✅ Timeout Updated                                             │
│  ✅ Access Logged                                               │
└─────────────────────────────────────────────────────────────────┘
                           │
                           ▼
        ┌──────────────────────────────────────┐
        │   ✅ AUTHORIZATION COMPLETE          │
        │   Proceed to data fetching           │
        └──────────────────────────────────────┘
```

---

## 📊 Data Fetching Flow by Role

```
┌─────────────────────────────────────────────────────────────────┐
│              ROLE-SPECIFIC DATA FETCHING                        │
└─────────────────────────────────────────────────────────────────┘
                           │
                           ▼
                switch ($user['role'])
                           │
          ┌────────────────┼────────────────┐
          │                │                │
          ▼                ▼                ▼
    ┌─────────┐      ┌──────────┐     ┌─────────┐
    │  admin  │      │ teacher/ │     │ student │
    │         │      │instructor│     │         │
    └────┬────┘      └────┬─────┘     └────┬────┘
         │                │                │
         ▼                ▼                ▼

┌──────────────────┐  ┌──────────────────┐  ┌──────────────────┐
│  ADMIN QUERIES   │  │  TEACHER QUERIES │  │  STUDENT QUERIES │
├──────────────────┤  ├──────────────────┤  ├──────────────────┤
│                  │  │                  │  │                  │
│ 1. Count Users   │  │ 1. My Courses    │  │ 1. Enrollments   │
│    SELECT COUNT  │  │    SELECT *      │  │    SELECT * JOIN │
│    FROM users    │  │    FROM courses  │  │    courses       │
│                  │  │    WHERE         │  │                  │
│ 2. Count Student │  │    instructor_id │  │ 2. Available     │
│    WHERE role    │  │                  │  │    SELECT *      │
│                  │  │ 2. Count Students│  │    FROM courses  │
│ 3. Count Teacher │  │    SELECT COUNT  │  │    WHERE NOT IN  │
│    WHERE role    │  │    FROM enrolls  │  │                  │
│                  │  │    WHERE course  │  │ 3. Announcements │
│ 4. Count Instru  │  │                  │  │    SELECT *      │
│    WHERE role    │  │ 3. Count Lessons │  │    WHERE active  │
│                  │  │    SELECT COUNT  │  │    LIMIT 3       │
│ 5. Count Admin   │  │    FROM lessons  │  │                  │
│    WHERE role    │  │    WHERE course  │  │ + Calculate:     │
│                  │  │                  │  │   - Progress %   │
│ 6. Recent Users  │  │                  │  │   - Completed    │
│    SELECT *      │  │                  │  │                  │
│    ORDER BY      │  │                  │  │                  │
│    LIMIT 5       │  │                  │  │                  │
│                  │  │                  │  │                  │
│ 7. Count Announc │  │                  │  │                  │
│    WHERE active  │  │                  │  │                  │
│                  │  │                  │  │                  │
│ 8. Count Courses │  │                  │  │                  │
│    SELECT COUNT  │  │                  │  │                  │
│                  │  │                  │  │                  │
└────────┬─────────┘  └────────┬─────────┘  └────────┬─────────┘
         │                     │                     │
         │  8 Queries          │  3 Queries          │  3 Queries
         │                     │                     │  + Calcs
         └─────────────────────┼─────────────────────┘
                               │
                               ▼
                   ┌───────────────────────┐
                   │  MERGE WITH BASE DATA │
                   └───────────┬───────────┘
                               │
                               ▼
                ┌──────────────────────────────┐
                │  PASS TO VIEW                │
                │  view('auth/dashboard', ...) │
                └──────────────────────────────┘
```

---

## 🗄️ Database Tables Used

```
┌─────────────────────────────────────────────────────────────────┐
│                    DATABASE INTERACTION MAP                     │
└─────────────────────────────────────────────────────────────────┘

ADMIN ROLE:
┌────────────┐
│   users    │ ← Count all, count by role, fetch recent
└────────────┘
┌────────────┐
│ announcements │ ← Count active
└────────────┘
┌────────────┐
│  courses   │ ← Count all
└────────────┘

TEACHER ROLE:
┌────────────┐
│  courses   │ ← WHERE instructor_id = userId
└─────┬──────┘
      │ course_ids
      ├─────────────────────────┐
      │                         │
      ▼                         ▼
┌────────────┐            ┌────────────┐
│enrollments │            │  lessons   │
└────────────┘            └────────────┘
← COUNT WHERE             ← COUNT WHERE
  course_id IN              course_id IN
  (course_ids)              (course_ids)

STUDENT ROLE:
┌────────────┐
│enrollments │ ← WHERE student_id = userId
└─────┬──────┘  (WITH course data via JOIN)
      │ enrolled_course_ids
      │
      ├─────────────────────────┐
      │                         │
      ▼                         ▼
┌────────────┐            ┌────────────┐
│  courses   │            │ announcements │
└────────────┘            └────────────┘
← SELECT WHERE            ← SELECT active
  id NOT IN                 LIMIT 3
  (enrolled_ids)
```

---

## 🔄 Complete Method Flow

```
dashboard()
│
├─ SECTION 1: AUTHORIZATION (Lines 404-445)
│  ├─ Check 1: Login status       ✅
│  ├─ Check 2: Session timeout    ✅
│  ├─ Check 3: User ID exists     ✅
│  ├─ Check 4: User in DB         ✅
│  ├─ Check 5: Valid role         ✅
│  └─ Check 6: Update & log       ✅
│
├─ SECTION 2: BASE DATA (Lines 451-457)
│  └─ Prepare common data for all roles
│
├─ SECTION 3: ROLE-SPECIFIC DATA (Lines 463-657)
│  │
│  ├─ switch($user['role'])
│  │
│  ├─ case 'admin':
│  │  └─ getAdminDashboardData($userId)
│  │     ├─ Query users table (5 queries)
│  │     ├─ Query announcements (1 query)
│  │     ├─ Query courses (1 query)
│  │     └─ Return array with 9 keys
│  │
│  ├─ case 'instructor':
│  ├─ case 'teacher':
│  │  └─ getTeacherDashboardData($userId)
│  │     ├─ Query courses WHERE instructor_id
│  │     ├─ Query enrollments for student count
│  │     ├─ Query lessons for lesson count
│  │     └─ Return array with 5 keys
│  │
│  └─ case 'student':
│     └─ getStudentDashboardData($userId)
│        ├─ Query enrollments with JOINs
│        ├─ Calculate progress statistics
│        ├─ Query available courses
│        ├─ Query announcements
│        └─ Return array with 6 keys
│
└─ SECTION 4: RENDER VIEW (Line 491)
   └─ return view('auth/dashboard', $dashboardData)
```

---

## 📦 Data Structure Passed to View

```
COMMON TO ALL ROLES:
┌──────────────────────────────────────┐
│ $dashboardData                       │
├──────────────────────────────────────┤
│ 'title'          => 'Dashboard - X'  │
│ 'user'           => [...]  (object)  │
│ 'user_role'      => 'admin/teacher/  │
│                      student'        │
│ 'session_start'  => 1729443600       │
│ 'current_time'   => 1729445400       │
└──────────────────────────────────────┘

+

ADMIN-SPECIFIC:
┌──────────────────────────────────────┐
│ 'dashboard_message'     => 'Welcome' │
│ 'dashboard_description' => '...'     │
│ 'total_users'           => 10        │
│ 'total_students'        => 4         │
│ 'total_instructors'     => 4         │
│ 'total_teachers'        => 0         │
│ 'total_admins'          => 2         │
│ 'recent_users'          => [...]     │
│ 'total_announcements'   => 3         │
│ 'total_courses'         => 5         │
│ 'active_users'          => 10        │
└──────────────────────────────────────┘

OR TEACHER-SPECIFIC:
┌──────────────────────────────────────┐
│ 'dashboard_message'     => 'Welcome' │
│ 'dashboard_description' => '...'     │
│ 'my_courses'            => [...]     │
│ 'total_courses'         => 3         │
│ 'total_students'        => 25        │
│ 'total_lessons'         => 12        │
│ 'pending_submissions'   => 0         │
└──────────────────────────────────────┘

OR STUDENT-SPECIFIC:
┌──────────────────────────────────────┐
│ 'dashboard_message'     => 'Welcome' │
│ 'dashboard_description' => '...'     │
│ 'enrolled_courses'      => [...]     │
│ 'available_courses'     => [...]     │
│ 'total_enrolled'        => 2         │
│ 'completed_courses'     => 0         │
│ 'overall_progress'      => 15.5      │
│ 'recent_announcements'  => [...]     │
│ 'pending_quizzes'       => 0         │
└──────────────────────────────────────┘
```

---

## 🎯 Summary Metrics

```
┌─────────────────────────────────────────────────────────┐
│              STEP 3 IMPLEMENTATION METRICS              │
├─────────────────────────────────────────────────────────┤
│                                                         │
│  Authorization Layers:          6                       │
│  Role-Specific Methods:         3                       │
│  Total Database Queries:        8-14 (per request)      │
│  Security Checks:               Multiple                │
│  Data Points Passed:            10-15 (per role)        │
│  Code Lines (dashboard):        ~300                    │
│  Performance:                   Optimized               │
│  Security:                      Enterprise-grade        │
│                                                         │
└─────────────────────────────────────────────────────────┘
```

---

**Created:** October 20, 2025  
**Project:** ITE311-AMAR  
**Step 3:** COMPLETE ✅

