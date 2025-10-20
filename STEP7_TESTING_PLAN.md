# Step 7: Comprehensive Testing Plan

**Laboratory Activity: Multi-Role Dashboard System**  
**Project:** ITE311-AMAR CodeIgniter LMS  
**Date:** October 20, 2025

---

## 🎯 Step 7 Requirements

From the laboratory instructions:

1. ✅ Register or manually create users with different roles
2. ✅ Log in with each user and verify:
   - All users redirect to same dashboard
   - Dashboard displays different content per role
   - Navigation shows appropriate menu items
   - Users can only access role-appropriate functionality
3. ✅ Test logout functionality
4. ✅ Test access control

---

## 📋 Testing Checklist

### Pre-Test Verification

- [x] ✅ Database has users with all roles
- [x] ✅ 10 test users available (2 admin, 4 teachers, 4 students)
- [x] ✅ Development server running (http://localhost:8080)
- [x] ✅ All code implemented (Steps 1-6 complete)

---

## 🧪 Test Cases

### Test Suite 1: Admin Role Testing

**Test User:** admin@lms.com

#### TC1.1: Admin Login & Redirect
```
Steps:
1. Navigate to /login
2. Enter: admin@lms.com
3. Enter password
4. Click Login

Expected:
✅ Login successful
✅ Redirect to /dashboard (not /admin/dashboard)
✅ Success message displayed
```

#### TC1.2: Admin Dashboard Content
```
Steps:
1. View dashboard page after login

Expected:
✅ Title: "Dashboard - Admin"
✅ Welcome message: "Welcome to Admin Dashboard"
✅ System Statistics section visible
✅ 7 statistical cards displayed:
   • Total Users
   • Students
   • Instructors
   • Teachers
   • Admins
   • Courses
   • Announcements
✅ "Manage Users" button visible
✅ "Manage Courses" button visible
✅ "View Reports" button visible
✅ Recent Activity section visible
✅ Profile section visible
```

#### TC1.3: Admin Navigation Bar
```
Steps:
1. Check navigation bar items

Expected:
✅ Brand: "ITE311-AMAR" visible
✅ "Home" link visible
✅ "Dashboard" link visible
✅ "Announcements" link visible
✅ "Admin" dropdown visible with icon
✅ Admin dropdown contains:
   • Manage Users
   • Manage Courses
   • Manage Announcements
   • View Reports
   • System Settings
✅ Profile dropdown visible
✅ Role badge shows "Admin" with RED color
✅ User name displayed
```

#### TC1.4: Admin Access Control
```
Steps:
1. Try to access admin routes
2. Try to access teacher routes
3. Try to access student routes

Expected:
✅ Can access: /admin/users
✅ Can access: /admin/courses
✅ Can access: /admin/reports
✅ Teacher dropdown NOT visible in navigation
✅ Student dropdown NOT visible in navigation
```

---

### Test Suite 2: Teacher Role Testing

**Test User:** john.smith@lms.com

#### TC2.1: Teacher Login & Redirect
```
Steps:
1. Logout from admin
2. Navigate to /login
3. Enter: john.smith@lms.com
4. Enter password
5. Click Login

Expected:
✅ Login successful
✅ Redirect to /dashboard (not /teacher/dashboard)
✅ Success message displayed
```

#### TC2.2: Teacher Dashboard Content
```
Steps:
1. View dashboard page after login

Expected:
✅ Title: "Dashboard - Instructor"
✅ Welcome message: "Welcome to Teacher Dashboard"
✅ Course Management section visible
✅ 4 statistical cards displayed:
   • My Courses
   • Total Students
   • Lessons
   • Pending Submissions
✅ "My Courses" section visible
✅ "Create Course" button visible
✅ Quick Actions sidebar with:
   • Create Course
   • Add Lesson
   • Create Quiz
   • Post Announcement
✅ Teaching Tips section visible
✅ Profile section visible
```

#### TC2.3: Teacher Navigation Bar
```
Steps:
1. Check navigation bar items

Expected:
✅ "Home" link visible
✅ "Dashboard" link visible
✅ "Announcements" link visible
✅ "Teaching" dropdown visible with icon
✅ Teaching dropdown contains:
   • My Courses
   • Create Course
   • Lessons
   • Quizzes
   • My Students
   • Submissions
✅ Profile dropdown visible
✅ Role badge shows "Instructor" with GREEN color
✅ Admin dropdown NOT visible
✅ Student links NOT visible
```

#### TC2.4: Teacher Access Control
```
Steps:
1. Try to access teacher routes
2. Try to access admin routes (via URL)
3. Try to access student routes (via URL)

Expected:
✅ Can access: /teacher/courses
✅ Can access: /teacher/lessons
✅ Cannot access: /admin/users (should be blocked)
✅ Only sees own courses (instructor_id filter)
```

---

### Test Suite 3: Student Role Testing

**Test User:** alice.wilson@student.com

#### TC3.1: Student Login & Redirect
```
Steps:
1. Logout from teacher
2. Navigate to /login
3. Enter: alice.wilson@student.com
4. Enter password
5. Click Login

Expected:
✅ Login successful
✅ Redirect to /dashboard (not /student/dashboard)
✅ Success message displayed
```

#### TC3.2: Student Dashboard Content
```
Steps:
1. View dashboard page after login

Expected:
✅ Title: "Dashboard - Student"
✅ Welcome message: "Welcome to Student Dashboard"
✅ My Learning Journey section visible
✅ 4 statistical cards displayed:
   • Enrolled Courses
   • Completed Courses
   • Overall Progress %
   • Pending Quizzes
✅ "My Enrolled Courses" section visible
✅ Progress bars for each course
✅ "Available Courses" section visible
✅ "Enroll Now" buttons visible
✅ Recent Announcements section visible
✅ Profile section visible
```

#### TC3.3: Student Navigation Bar
```
Steps:
1. Check navigation bar items

Expected:
✅ "Home" link visible
✅ "Dashboard" link visible
✅ "Announcements" link visible
✅ "Browse Courses" direct link visible
✅ "My Learning" dropdown visible
✅ My Learning dropdown contains:
   • My Courses
   • My Progress
   • My Quizzes
   • Achievements
✅ Profile dropdown visible
✅ Role badge shows "Student" with YELLOW color
✅ Admin dropdown NOT visible
✅ Teaching dropdown NOT visible
```

#### TC3.4: Student Access Control
```
Steps:
1. Try to access student routes
2. Try to access admin routes (via URL)
3. Try to access teacher routes (via URL)

Expected:
✅ Can access: /student/courses
✅ Can access: /student/progress
✅ Cannot access: /admin/users (should be blocked)
✅ Cannot access: /teacher/courses (should be blocked)
✅ Only sees own enrollments
```

---

### Test Suite 4: AJAX Enrollment Testing (Student)

#### TC4.1: AJAX Course Enrollment
```
Steps:
1. Login as student
2. Go to dashboard
3. Find "Available Courses" section
4. Click "Enroll Now" on a course

Expected:
✅ AJAX request sent to /courses/enroll
✅ Button shows loading state
✅ Success alert displayed
✅ Button changes to "Enrolled"
✅ Course added to "Enrolled Courses" section
✅ Statistics updated (Enrolled count +1)
✅ No page reload
```

#### TC4.2: AJAX Course Unenrollment
```
Steps:
1. In "Enrolled Courses" section
2. Click unenroll button (X)
3. Confirm dialog

Expected:
✅ Confirmation dialog appears
✅ AJAX request sent to /courses/unenroll
✅ Success message displayed
✅ Page reloads
✅ Course removed from enrolled list
✅ Statistics updated (Enrolled count -1)
```

---

### Test Suite 5: Logout Functionality

#### TC5.1: Admin Logout
```
Steps:
1. Login as admin
2. Click profile dropdown
3. Click "Logout"
4. Confirm logout

Expected:
✅ Confirmation dialog appears
✅ Session destroyed
✅ Redirect to /login
✅ Success message: "You have been successfully logged out"
✅ Cannot access /dashboard without logging in again
```

#### TC5.2: Teacher Logout
```
Steps:
1. Login as teacher
2. Click "Logout" in navigation
3. Confirm

Expected:
✅ Session destroyed
✅ Redirect to /login
✅ Success flash message
✅ Teaching dropdown no longer visible
```

#### TC5.3: Student Logout
```
Steps:
1. Login as student
2. Logout via profile dropdown

Expected:
✅ Session cleared
✅ Redirect to /login
✅ Cannot access student routes after logout
```

---

### Test Suite 6: Access Control Testing

#### TC6.1: Unauthorized Dashboard Access
```
Steps:
1. Logout completely
2. Try to access /dashboard directly

Expected:
✅ Redirect to /login
✅ Error message: "Please log in to access the dashboard"
```

#### TC6.2: Unauthorized Admin Access
```
Steps:
1. Login as student
2. Try to access /admin/users via URL

Expected:
✅ Access denied (should be blocked)
✅ Admin dropdown not visible in navigation
```

#### TC6.3: Unauthorized Teacher Access
```
Steps:
1. Login as student
2. Try to access /teacher/courses via URL

Expected:
✅ Access denied (should be blocked)
✅ Teaching dropdown not visible in navigation
```

#### TC6.4: Cross-Role Data Access
```
Steps:
1. Login as teacher (ID: 3)
2. Check dashboard courses

Expected:
✅ Only sees courses with instructor_id = 3
✅ Cannot see other teachers' courses
✅ Data filtered by role
```

---

### Test Suite 7: Session Timeout Testing

#### TC7.1: Session Expiration
```
Steps:
1. Login as any user
2. Wait 30+ minutes (or manually expire session)
3. Try to access /dashboard

Expected:
✅ Session expired
✅ Auto-logout triggered
✅ Redirect to /login
✅ Must login again
```

#### TC7.2: Session Timer Display
```
Steps:
1. Login as any user
2. View dashboard
3. Check session timer

Expected:
✅ Timer visible in alert box
✅ Counts down from 30:00
✅ Updates every second
✅ Shows "Session expires in: MM:SS"
```

---

### Test Suite 8: Navigation Testing

#### TC8.1: Active Link Highlighting
```
Steps:
1. Login as any user
2. Click "Dashboard"
3. Click "Announcements"
4. Click "Dashboard" again

Expected:
✅ Current page highlighted in navigation
✅ Active class applied to current link
✅ Visual feedback for current location
```

#### TC8.2: Mobile Navigation
```
Steps:
1. Resize browser to mobile width (<768px)
2. Check navigation

Expected:
✅ Hamburger menu icon appears
✅ Clicking hamburger opens full menu
✅ All menu items accessible
✅ Dropdowns work on mobile
✅ Touch-friendly spacing
```

#### TC8.3: Role Badge Colors
```
Steps:
1. Login as admin
2. Check badge color (should be RED)
3. Logout, login as teacher
4. Check badge color (should be GREEN)
5. Logout, login as student
6. Check badge color (should be YELLOW)

Expected:
✅ Admin: Red badge
✅ Teacher: Green badge
✅ Student: Yellow badge
✅ Badge shows correct role name
```

---

### Test Suite 9: Security Testing

#### TC9.1: CSRF Protection
```
Steps:
1. View page source on login form
2. Check for CSRF token
3. Submit form without token

Expected:
✅ CSRF token present in form
✅ Form submission without token rejected
✅ Security error displayed
```

#### TC9.2: XSS Prevention
```
Steps:
1. Try to inject script in form fields
2. Submit data
3. View displayed content

Expected:
✅ Script tags escaped
✅ No JavaScript execution
✅ Content displayed safely
```

#### TC9.3: SQL Injection Prevention
```
Steps:
1. Try SQL injection in login email field
2. Example: admin' OR '1'='1
3. Submit

Expected:
✅ Query safely escaped
✅ Login fails (invalid credentials)
✅ No database error
✅ Security logging active
```

---

### Test Suite 10: Responsive Design Testing

#### TC10.1: Desktop View (>992px)
```
Expected:
✅ Full navigation visible
✅ User name displayed
✅ All dropdowns work
✅ Dashboard shows all columns
✅ Cards in grid layout
```

#### TC10.2: Tablet View (768-992px)
```
Expected:
✅ Navigation condensed
✅ User name hidden on smaller tablets
✅ Dashboard cards stack appropriately
✅ Touch-friendly interactions
```

#### TC10.3: Mobile View (<768px)
```
Expected:
✅ Hamburger menu appears
✅ Full menu in collapse
✅ Dashboard single column
✅ Touch-optimized buttons
✅ Scrollable content
```

---

## 🗂️ Test Data Reference

### Test Accounts (from LOGIN_CREDENTIALS.md)

**Admins (2):**
1. admin@lms.com (ID: 1)
2. system@lms.com (ID: 2)

**Teachers/Instructors (4):**
1. john.smith@lms.com (ID: 3)
2. sarah.johnson@lms.com (ID: 4)
3. michael.brown@lms.com (ID: 5)
4. emily.davis@lms.com (ID: 6)

**Students (4):**
1. alice.wilson@student.com (ID: 7)
2. bob.miller@student.com (ID: 8)
3. carol.taylor@student.com (ID: 9)
4. david.anderson@student.com (ID: 10)

---

## ✅ Expected Results Summary

### Unified Dashboard Redirect

| Role | Login Email | Expected URL | Expected Content |
|------|------------|--------------|------------------|
| Admin | admin@lms.com | /dashboard | System Statistics |
| Teacher | john.smith@lms.com | /dashboard | Course Management |
| Student | alice.wilson@student.com | /dashboard | Learning Journey |

**Key Point:** ALL redirect to `/dashboard` (not role-specific URLs)

### Navigation Visibility

| Navigation Item | Admin | Teacher | Student | Guest |
|----------------|-------|---------|---------|-------|
| Home | ✅ | ✅ | ✅ | ✅ |
| Dashboard | ✅ | ✅ | ✅ | ❌ |
| Announcements | ✅ | ✅ | ✅ | ❌ |
| Admin Dropdown | ✅ | ❌ | ❌ | ❌ |
| Teaching Dropdown | ❌ | ✅ | ❌ | ❌ |
| Browse Courses | ❌ | ❌ | ✅ | ❌ |
| My Learning Dropdown | ❌ | ❌ | ✅ | ❌ |
| Profile Dropdown | ✅ | ✅ | ✅ | ❌ |
| About | ❌ | ❌ | ❌ | ✅ |
| Contact | ❌ | ❌ | ❌ | ✅ |
| Login | ❌ | ❌ | ❌ | ✅ |
| Register | ❌ | ❌ | ❌ | ✅ |

### Dashboard Content by Role

**Admin Dashboard Should Show:**
- ✅ System statistics (7 cards)
- ✅ User counts by role
- ✅ Recent users list
- ✅ Management action buttons
- ✅ Recent activity feed

**Teacher Dashboard Should Show:**
- ✅ Course statistics (4 cards)
- ✅ My courses list
- ✅ Create course button
- ✅ Quick actions sidebar
- ✅ Teaching tips

**Student Dashboard Should Show:**
- ✅ Learning statistics (4 cards)
- ✅ Enrolled courses with progress bars
- ✅ Available courses to enroll
- ✅ Enroll Now buttons (AJAX)
- ✅ Recent announcements
- ✅ Learning tips

---

## 🔐 Security Testing Checklist

### Authorization Tests

- [ ] Guest cannot access /dashboard
- [ ] Student cannot access /admin routes
- [ ] Student cannot access /teacher routes
- [ ] Teacher cannot access /admin routes
- [ ] Session timeout works (30 min)
- [ ] Invalid session redirects to login
- [ ] Role validation prevents access

### Input Security Tests

- [ ] CSRF tokens required
- [ ] XSS attempts escaped
- [ ] SQL injection prevented
- [ ] Invalid characters filtered
- [ ] Password properly hashed

### Session Security Tests

- [ ] Session regenerated on login
- [ ] Session timeout after 30 minutes
- [ ] Session cleared on logout
- [ ] Multiple sessions handled
- [ ] Session hijacking prevented

---

## 📊 Testing Progress Tracker

### Test Suites

| Suite | Description | Total Tests | Status |
|-------|-------------|-------------|--------|
| 1 | Admin Role | 4 test cases | Pending |
| 2 | Teacher Role | 4 test cases | Pending |
| 3 | Student Role | 4 test cases | Pending |
| 4 | AJAX Features | 2 test cases | Pending |
| 5 | Logout | 3 test cases | Pending |
| 6 | Access Control | 4 test cases | Pending |
| 7 | Session Timeout | 2 test cases | Pending |
| 8 | Navigation | 3 test cases | Pending |
| 9 | Security | 3 test cases | Pending |
| 10 | Responsive | 3 test cases | Pending |

**Total Test Cases:** 32

---

## 🎯 Success Criteria

### Must Pass

✅ All users redirect to `/dashboard`  
✅ Dashboard shows different content per role  
✅ Navigation shows correct items per role  
✅ Access control blocks unauthorized access  
✅ Logout clears session  
✅ Security features active  

### Should Pass

✅ AJAX enrollment works  
✅ Session timer functional  
✅ Active link highlighting  
✅ Responsive design works  
✅ All buttons functional  

---

## 📝 Test Execution Notes

### How to Execute Tests

1. **Automated Testing** (Preferred)
   - Use browser developer tools
   - Check console for errors
   - Verify network requests
   - Inspect HTML elements

2. **Manual Testing**
   - Follow test case steps
   - Check expected results
   - Document any issues
   - Take screenshots

3. **Command Line Verification**
   ```bash
   php spark routes          # Verify routes
   php spark db:table users  # Check test data
   php spark migrate:status  # Verify migrations
   ```

---

## 🐛 Issue Tracking Template

If any test fails, document:

```
Test Case: TC#.#
Description: [Test description]
Steps: [Steps taken]
Expected: [Expected result]
Actual: [What happened]
Status: FAIL
Priority: High/Medium/Low
Notes: [Additional information]
```

---

## ✅ Test Completion Criteria

All test suites must achieve:
- ✅ 100% pass rate for critical tests
- ✅ All roles tested successfully
- ✅ Security tests passed
- ✅ No console errors
- ✅ No PHP errors in logs
- ✅ Documentation complete

---

**Testing Plan Created:** October 20, 2025  
**Ready to Execute:** YES  
**Next:** Begin testing execution

---

*This testing plan ensures comprehensive verification of all laboratory requirements.*

