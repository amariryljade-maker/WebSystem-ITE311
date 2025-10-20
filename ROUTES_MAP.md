# ITE311-AMAR Routes Map
**Last Updated**: October 20, 2025  
**Total Routes**: 33

## 🎯 Main Dashboard Route

### **Unified Dashboard** ✅
```
GET /dashboard → Auth::dashboard
```
**Description**: Single endpoint for all authenticated users. Displays role-specific content based on user's role in session.

**Access**: All authenticated users (admin, teacher, instructor, student)

---

## 📚 Route Categories

### 1. Authentication Routes (8 routes)

| Method | Route | Controller::Method | Description |
|--------|-------|-------------------|-------------|
| GET | `/register` | Auth::register | Registration form |
| POST | `/register` | Auth::register | Process registration |
| GET | `/login` | Auth::login | Login form |
| POST | `/login` | Auth::login | Process login |
| GET | `/logout` | Auth::logout | Logout user |
| **GET** | **`/dashboard`** | **Auth::dashboard** | **Main dashboard** ✅ |
| GET | `/profile` | Auth::profile | User profile |
| GET | `/settings` | Auth::settings | Account settings |

---

### 2. Public Routes (6 routes)

| Route | Controller::Method | Description |
|-------|-------------------|-------------|
| `/` | Home::index | Homepage |
| `/about` | Home::about | About page |
| `/contact` | Home::contact | Contact page |
| `/test` | Home::test | Test page |
| `/announcements` | Announcement::index | View announcements |
| `/courses` | Course::index | Browse courses |
| `/courses/view/:id` | Course::view | View course details |

---

### 3. Admin Routes (5 routes)

**Base URL**: `/admin/*`  
**Access**: Admin role only

| Route | Controller::Method | Description |
|-------|-------------------|-------------|
| `/admin/users` | Admin::users | Manage all users |
| `/admin/courses` | Admin::courses | Manage all courses |
| `/admin/announcements` | Admin::announcements | Manage announcements |
| `/admin/reports` | Admin::reports | View system reports |
| `/admin/settings` | Admin::settings | System settings |

---

### 4. Teacher/Instructor Routes (9 routes)

**Base URL**: `/teacher/*`  
**Access**: Teacher and Instructor roles

#### Course Management
| Route | Method | Controller::Method | Description |
|-------|--------|-------------------|-------------|
| `/teacher/courses` | GET | Teacher::courses | View my courses |
| `/teacher/courses/create` | GET/POST | Teacher::createCourse | Create new course |
| `/teacher/courses/edit/:id` | GET/POST | Teacher::editCourse | Edit course |

#### Content Management
| Route | Method | Controller::Method | Description |
|-------|--------|-------------------|-------------|
| `/teacher/lessons` | GET | Teacher::lessons | Manage lessons |
| `/teacher/quizzes` | GET | Teacher::quizzes | Manage quizzes |

#### Student Management
| Route | Method | Controller::Method | Description |
|-------|--------|-------------------|-------------|
| `/teacher/students` | GET | Teacher::students | View enrolled students |
| `/teacher/submissions` | GET | Teacher::submissions | Grade submissions |

---

### 5. Student Routes (4 routes)

**Base URL**: `/student/*`  
**Access**: Student role only

| Route | Controller::Method | Description |
|-------|-------------------|-------------|
| `/student/courses` | Student::courses | My enrolled courses |
| `/student/progress` | Student::progress | Track my progress |
| `/student/quizzes` | Student::quizzes | My quizzes |
| `/student/achievements` | Student::achievements | View achievements |

---

## 🔄 Route Flow Diagram

```
User Request
     ↓
┌────┴────┐
│  Route  │
└────┬────┘
     ↓
Is Authenticated?
     ├─ No → Public Routes (/, /about, /contact, /login, /register)
     └─ Yes → Check Role
              ├─ Admin → /dashboard, /admin/*
              ├─ Teacher → /dashboard, /teacher/*
              └─ Student → /dashboard, /student/*, /courses
```

---

## 🎨 Route Group Benefits

### What is Route Grouping?
```php
$routes->group('admin', function($routes) {
    $routes->get('users', 'Admin::users');  // Creates /admin/users
    $routes->get('courses', 'Admin::courses'); // Creates /admin/courses
});
```

### Advantages:
- ✅ Clean URL structure
- ✅ Organized by functionality
- ✅ Easy to add middleware/filters
- ✅ Clear role separation
- ✅ Maintainable codebase

---

## 🔐 Security Considerations

### Current Implementation:
- Routes are defined but **not filtered** at route level
- Security handled **in controllers** via:
  - `is_user_logged_in()` checks
  - `has_role()` checks
  - Session validation

### Future Enhancement:
Can add route filters:
```php
$routes->group('admin', ['filter' => 'admin'], function($routes) {
    // Only admin users can access
});
```

---

## 📍 URL Examples

### Dashboard Access:
```
✅ http://localhost:8080/dashboard
```

### Role-Specific URLs:

#### Admin:
```
http://localhost:8080/admin/users
http://localhost:8080/admin/courses
http://localhost:8080/admin/reports
```

#### Teacher:
```
http://localhost:8080/teacher/courses
http://localhost:8080/teacher/courses/create
http://localhost:8080/teacher/students
```

#### Student:
```
http://localhost:8080/student/courses
http://localhost:8080/student/progress
http://localhost:8080/student/achievements
```

---

## 🧪 Testing Routes

### Test Dashboard Route:
```bash
# Check if route exists
php spark routes | findstr dashboard

# Test with curl
curl http://localhost:8080/dashboard

# Or open in browser
start http://localhost:8080/dashboard
```

### Expected Result:
- **Not logged in**: Redirect to `/login`
- **Logged in**: Display role-based dashboard

---

## 📝 Route Naming Convention

### Pattern:
```
/{role}/{resource}/{action}
```

### Examples:
- `/admin/users` - Admin managing users
- `/teacher/courses/create` - Teacher creating course
- `/student/progress` - Student viewing progress

### Common Actions:
- List: `/{role}/{resource}`
- Create: `/{role}/{resource}/create`
- Edit: `/{role}/{resource}/edit/:id`
- View: `/{role}/{resource}/view/:id`
- Delete: `/{role}/{resource}/delete/:id`

---

## 🚀 Quick Reference

### Must-Have Routes for Lab:
✅ `/dashboard` - Main requirement  
✅ `/login` - Authentication  
✅ `/announcements` - Feature requirement  

### Navigation Integration:
✅ All routes match navigation menu items  
✅ Role-specific routes match role menus  
✅ Dynamic navigation displays correct links  

---

## 📊 Routes Status

| Route Category | Status | Routes Count |
|---------------|--------|--------------|
| Authentication | ✅ Working | 8 |
| Dashboard | ✅ Working | 1 |
| Public | ✅ Working | 6 |
| Admin | ✅ Configured | 5 |
| Teacher | ✅ Configured | 9 |
| Student | ✅ Configured | 4 |

**Total**: 33 routes configured and verified

---

**The dashboard route is properly configured and all role-specific routes are ready for implementation!** 🎉

**Access the dashboard at**: `http://localhost:8080/dashboard`

