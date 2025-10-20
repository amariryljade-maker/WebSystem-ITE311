# Step 5: Navigation Bar Visual Diagram

**Dynamic Role-Based Navigation System**

---

## 🗺️ Complete Navigation Map

```
┌─────────────────────────────────────────────────────────────────┐
│                    NAVIGATION BAR (Fixed Top)                   │
│                  app/Views/template.php (Lines 529-730)         │
└─────────────────────────────────────────────────────────────────┘

┌───────────────────────────────────────────────────────────────────────────┐
│  🎓 ITE311-AMAR  |  [☰]                                                   │
│  ─────────────────────────────────────────────────────────────────────    │
│                                                                            │
│  LEFT SIDE NAVIGATION                       RIGHT SIDE NAVIGATION         │
│  ├─ Home (always)                           ├─ Profile Dropdown (logged)  │
│  ├─ Dashboard (logged)                      └─ Login/Register (guest)     │
│  ├─ Announcements (logged)                                                │
│  │                                                                         │
│  └─ ROLE-SPECIFIC DROPDOWNS:                                              │
│     ├─ Admin Dropdown (admin only)                                        │
│     ├─ Teaching Dropdown (teacher only)                                   │
│     └─ My Learning (student only)                                         │
│                                                                            │
└───────────────────────────────────────────────────────────────────────────┘
```

---

## 📊 Navigation by Role

### 🔴 Admin Navigation

```
┌────────────────────────────────────────────────────────────────┐
│  🎓 ITE311-AMAR                                                │
├────────────────────────────────────────────────────────────────┤
│                                                                │
│  [Home] [Dashboard] [Announcements] [Admin ▼]    [👤 Admin🔴▼]│
│                                      │                         │
│                                      ▼                         │
│                        ┌──────────────────────────┐           │
│                        │ System Management        │           │
│                        ├──────────────────────────┤           │
│                        │ 👥 Manage Users          │           │
│                        │ 📚 Manage Courses        │           │
│                        │ 📢 Manage Announcements  │           │
│                        ├──────────────────────────┤           │
│                        │ 📊 View Reports          │           │
│                        │ ⚙️  System Settings      │           │
│                        └──────────────────────────┘           │
│                                                                │
│  User Profile Dropdown:                                        │
│  ┌──────────────────────────┐                                 │
│  │ Admin User               │                                 │
│  │ admin@lms.com            │                                 │
│  ├──────────────────────────┤                                 │
│  │ 🎯 Dashboard             │                                 │
│  │ 👤 My Profile            │                                 │
│  │ ⚙️  Settings             │                                 │
│  ├──────────────────────────┤                                 │
│  │ 🚪 Logout                │                                 │
│  └──────────────────────────┘                                 │
└────────────────────────────────────────────────────────────────┘
```

### 🟢 Teacher Navigation

```
┌────────────────────────────────────────────────────────────────┐
│  🎓 ITE311-AMAR                                                │
├────────────────────────────────────────────────────────────────┤
│                                                                │
│  [Home] [Dashboard] [Announcements] [Teaching ▼] [👤 Teacher🟢▼]│
│                                      │                         │
│                                      ▼                         │
│                        ┌──────────────────────────┐           │
│                        │ Course Management        │           │
│                        ├──────────────────────────┤           │
│                        │ 📚 My Courses            │           │
│                        │ ➕ Create Course         │           │
│                        ├──────────────────────────┤           │
│                        │ Content                  │           │
│                        ├──────────────────────────┤           │
│                        │ 📝 Lessons               │           │
│                        │ ❓ Quizzes               │           │
│                        ├──────────────────────────┤           │
│                        │ 👥 My Students           │           │
│                        │ 📋 Submissions           │           │
│                        └──────────────────────────┘           │
│                                                                │
│  User Profile Dropdown:                                        │
│  ┌──────────────────────────┐                                 │
│  │ John Smith               │                                 │
│  │ john.smith@lms.com       │                                 │
│  ├──────────────────────────┤                                 │
│  │ 🎯 Dashboard             │                                 │
│  │ 👤 My Profile            │                                 │
│  │ ⚙️  Settings             │                                 │
│  ├──────────────────────────┤                                 │
│  │ 🚪 Logout                │                                 │
│  └──────────────────────────┘                                 │
└────────────────────────────────────────────────────────────────┘
```

### 🟡 Student Navigation

```
┌────────────────────────────────────────────────────────────────┐
│  🎓 ITE311-AMAR                                                │
├────────────────────────────────────────────────────────────────┤
│                                                                │
│  [Home] [Dashboard] [Announcements] [Browse Courses]          │
│  [My Learning ▼]                                [👤 Student🟡▼]│
│        │                                                       │
│        ▼                                                       │
│  ┌──────────────────────────┐                                 │
│  │ Enrolled Courses         │                                 │
│  ├──────────────────────────┤                                 │
│  │ 📚 My Courses            │                                 │
│  │ 📊 My Progress           │                                 │
│  ├──────────────────────────┤                                 │
│  │ ❓ My Quizzes            │                                 │
│  │ 🏆 Achievements          │                                 │
│  └──────────────────────────┘                                 │
│                                                                │
│  User Profile Dropdown:                                        │
│  ┌──────────────────────────┐                                 │
│  │ Alice Wilson             │                                 │
│  │ alice@student.com        │                                 │
│  ├──────────────────────────┤                                 │
│  │ 🎯 Dashboard             │                                 │
│  │ 👤 My Profile            │                                 │
│  │ ⚙️  Settings             │                                 │
│  ├──────────────────────────┤                                 │
│  │ 🚪 Logout                │                                 │
│  └──────────────────────────┘                                 │
└────────────────────────────────────────────────────────────────┘
```

### ⚪ Guest Navigation

```
┌────────────────────────────────────────────────────────────────┐
│  🎓 ITE311-AMAR                                                │
├────────────────────────────────────────────────────────────────┤
│                                                                │
│  [Home] [About] [Contact]             [Login] [Register]      │
│                                                                │
│  Simple navigation for non-authenticated users                │
│                                                                │
└────────────────────────────────────────────────────────────────┘
```

---

## 🔄 Navigation State Flow

```
┌────────────────────────────────────────────────────────┐
│              NAVIGATION RENDERING FLOW                 │
└────────────────────────────────────────────────────────┘

Template Loaded
     │
     ▼
Check: is_user_logged_in()
     │
     ├─ NO (Guest)
     │  └─> Show: Home, About, Contact, Login, Register
     │
     └─ YES (Logged In)
        │
        ├─> Show: Home, Dashboard, Announcements
        │
        ├─> Get: $userRole = session()->get('user_role')
        │
        ├─> Check Role:
        │   │
        │   ├─ if ($userRole === 'admin')
        │   │  └─> Show: Admin Dropdown (6 items)
        │   │
        │   ├─ if ($userRole === 'teacher' || $userRole === 'instructor')
        │   │  └─> Show: Teaching Dropdown (8 items)
        │   │
        │   └─ if ($userRole === 'student')
        │      └─> Show: Browse Courses + My Learning Dropdown (4 items)
        │
        └─> Show: User Profile Dropdown
            ├─> Display: get_user_name()
            ├─> Display: Role Badge (colored)
            └─> Menu: Dashboard, Profile, Settings, Logout
```

---

## 🎨 Badge Color System

```
┌────────────────────────────────────────────────────────┐
│              DYNAMIC ROLE BADGE COLORS                 │
└────────────────────────────────────────────────────────┘

Role Assignment (Lines 683-689):

$roleColors = [
    'admin'      => 'danger',     // 🔴 Red
    'teacher'    => 'success',    // 🟢 Green
    'instructor' => 'info',       // 🔵 Blue
    'student'    => 'warning'     // 🟡 Yellow
];

Visual Result:
┌──────────────┬────────────┬──────────────┐
│ Role         │ Color      │ Badge Class  │
├──────────────┼────────────┼──────────────┤
│ Admin        │ Red        │ bg-danger    │
│ Teacher      │ Green      │ bg-success   │
│ Instructor   │ Blue       │ bg-info      │
│ Student      │ Yellow     │ bg-warning   │
└──────────────┴────────────┴──────────────┘

Display:
[👤 Admin User | Admin🔴]
[👤 John Smith | Teacher🟢]
[👤 Alice Wilson | Student🟡]
```

---

## 📱 Responsive Behavior

```
Desktop View (> 992px):
┌───────────────────────────────────────────────────────┐
│ 🎓 ITE311-AMAR  [Home] [Dashboard] [Admin▼]  [👤▼]   │
└───────────────────────────────────────────────────────┘

Tablet View (768px - 992px):
┌───────────────────────────────────────────────────────┐
│ 🎓 ITE311-AMAR  [Home] [Dashboard] [Admin▼]  [👤▼]   │
└───────────────────────────────────────────────────────┘

Mobile View (< 768px):
┌───────────────────────────────────────────────────────┐
│ 🎓 ITE311-AMAR                              [☰]      │
└───────────────────────────────────────────────────────┘
                                               │
                                               ▼
                                    ┌──────────────────┐
                                    │ Home             │
                                    │ Dashboard        │
                                    │ Announcements    │
                                    │ Admin ▼          │
                                    │ 👤 Profile ▼     │
                                    └──────────────────┘
```

---

## 🔧 JavaScript Enhancements

### Active Link Highlighting (Lines 768-777)

```javascript
// Automatically highlights current page
const currentLocation = window.location.pathname;
const navLinks = document.querySelectorAll('.nav-link');

navLinks.forEach(link => {
    if (link.getAttribute('href') === currentLocation) {
        link.classList.add('active');
    }
});
```

### Scroll Effects (Lines 812-822)

```javascript
// Changes navbar background on scroll
window.addEventListener('scroll', function() {
    const navbar = document.querySelector('.navbar');
    if (window.scrollY > 50) {
        navbar.style.boxShadow = '0 2px 20px rgba(0, 0, 0, 0.1)';
    }
});
```

---

**Created:** October 20, 2025  
**Project:** ITE311-AMAR  
**Step 5:** COMPLETE ✅


