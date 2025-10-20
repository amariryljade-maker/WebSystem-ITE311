# Routes Configuration - Step 6
**File**: `app/Config/Routes.php`  
**Purpose**: Configure enrollment route for AJAX requests  
**Completed**: October 20, 2025

---

## 📋 Lab Activity Requirement

### **✅ Step 6: Configure Routes**

**Requirement**: Update `app/Config/Routes.php` to include enrollment route

**Specified Route**:
```php
$routes->post('/course/enroll', 'Course::enroll');
```

**Status**: ✅ **COMPLETED**

---

## 🎯 Implementation

### **Route Added** (Line 82):

```php
// Lab specification route (singular 'course')
$routes->post('/course/enroll', 'Course::enroll');
```

---

## 📊 Route Details

| Property | Value |
|----------|-------|
| **HTTP Method** | POST |
| **URL** | `/course/enroll` |
| **Controller** | `Course` |
| **Method** | `enroll` |
| **Full Handler** | `\App\Controllers\Course::enroll` |

---

## 🔐 Route Security

### **Filters Applied Automatically**:

| Filter | Purpose | Status |
|--------|---------|--------|
| **honeypot** | Bot protection | ✅ Active |
| **csrf** | CSRF token validation | ✅ Active |
| **invalidchars** | Invalid character filtering | ✅ Active |
| **secureheaders** | Security HTTP headers | ✅ Active |
| **toolbar** | Debug toolbar (development) | ✅ Active |

**Security Level**: 🛡️ **High**

---

## 📡 Route Verification

### **Command**:
```bash
php spark routes | findstr "course/enroll"
```

### **Output**:
```
| POST   | course/enroll  | »  | \App\Controllers\Course::enroll | honeypot csrf invalidchars | honeypot secureheaders toolbar |
```

**Status**: ✅ **Route registered and active**

---

## 🔄 Alternative Routes (Compatibility)

### **Additional Routes Configured**:

```php
// Alternative routes (plural 'courses') for compatibility
$routes->post('courses/enroll', 'Course::enroll');      // Same handler
$routes->post('courses/unenroll', 'Course::unenroll');
$routes->get('courses/enrollment-status', 'Course::getEnrollmentStatus');
```

**Why Both?**
- `/course/enroll` - Lab specification (singular)
- `/courses/enroll` - Already used in AJAX code (plural)
- Both work and point to the same controller method

---

## 📝 Complete Routes Configuration

### **File Location**: `app/Config/Routes.php`

### **Enrollment Routes Section** (Lines 78-87):

```php
// ============================================
// Course Enrollment (AJAX)
// ============================================
// Lab specification route (singular 'course')
$routes->post('/course/enroll', 'Course::enroll');

// Alternative routes (plural 'courses') for compatibility
$routes->post('courses/enroll', 'Course::enroll');
$routes->post('courses/unenroll', 'Course::unenroll');
$routes->get('courses/enrollment-status', 'Course::getEnrollmentStatus');
```

---

## 🧪 Testing the Route

### **Method 1: Using cURL**

```bash
curl -X POST http://localhost:8080/course/enroll \
  -H "Content-Type: application/x-www-form-urlencoded" \
  -d "course_id=1"
```

**Expected**: 401 Unauthorized (not logged in)

---

### **Method 2: Using jQuery (in browser console)**

```javascript
// After logging in as student
$.post('/course/enroll', {
    course_id: 1,
    csrf_test_name: $('[name="csrf_test_name"]').val()
}, function(response) {
    console.log(response);
});
```

**Expected**: JSON success or error response

---

### **Method 3: Using Dashboard Enroll Button**

1. Login as student
2. Go to dashboard
3. Click "Enroll Now" on any available course
4. Observe AJAX request to `/course/enroll` in Network tab

**Expected**: 201 Created with enrollment details

---

## 📊 All Course-Related Routes

| Method | Route | Handler | Purpose |
|--------|-------|---------|---------|
| GET | `/courses` | Course::index | List all courses |
| GET | `/courses/view/:id` | Course::view | View course details |
| **POST** | **`/course/enroll`** | **Course::enroll** | **Enroll in course** ✅ |
| POST | `/courses/enroll` | Course::enroll | (Alternative) Enroll |
| POST | `/courses/unenroll` | Course::unenroll | Withdraw from course |
| GET | `/courses/enrollment-status` | Course::getEnrollmentStatus | Check enrollment |

**Total Course Routes**: 6

---

## 🎯 Route Usage in Code

### **In Dashboard View** (dashboard.php Line 890):

**Currently Uses** (plural):
```javascript
$.post({
    url: '<?= base_url('courses/enroll') ?>',
    // ...
});
```

**Lab Specification** (singular):
```javascript
$.post({
    url: '<?= base_url('course/enroll') ?>',
    // ...
});
```

**Both work!** They both route to `Course::enroll()`

---

## 🔧 Route Configuration Details

### **Route Definition Syntax**:

```php
$routes->{method}({uri}, {handler});
```

**Example**:
```php
$routes->post('/course/enroll', 'Course::enroll');
         ↑        ↑                 ↑         ↑
      Method    URI              Controller  Method
```

---

### **HTTP Method**: `POST`

**Why POST?**
- ✅ Creates new resource (enrollment)
- ✅ Sends data in request body
- ✅ Not cacheable
- ✅ Not idempotent (each call creates new record if allowed)
- ✅ More secure than GET for sensitive operations

---

### **URI**: `/course/enroll`

**Format**: Singular noun + action verb  
**RESTful**: Represents an action on a resource  
**Clean**: Easy to understand and remember

---

### **Handler**: `Course::enroll`

**Full Namespace**: `\App\Controllers\Course::enroll`  
**Method Location**: `app/Controllers/Course.php` lines 107-221  
**Return Type**: JSON Response

---

## ✅ Route Verification Checklist

- [x] ✅ Route added to `app/Config/Routes.php`
- [x] ✅ HTTP method is POST
- [x] ✅ URI is `/course/enroll` (as specified)
- [x] ✅ Handler points to `Course::enroll`
- [x] ✅ Route registered successfully
- [x] ✅ Route visible in `php spark routes`
- [x] ✅ Security filters applied
- [x] ✅ CSRF protection active
- [x] ✅ Route tested and working

---

## 🎨 Route Flow Diagram

```
HTTP POST Request
       ↓
/course/enroll
       ↓
┌──────────────────┐
│ Security Filters │
│ • Honeypot      │
│ • CSRF          │
│ • InvalidChars  │
└────────┬─────────┘
         ↓
┌──────────────────┐
│ Course Controller│
│ enroll() Method  │
└────────┬─────────┘
         ↓
    ┌────┴────┐
    ↓         ↓
Validation  Database
  Check     Operation
    ↓         ↓
    └────┬────┘
         ↓
   JSON Response
   (201/400/401/409/500)
```

---

## 📝 Route Examples

### **Success Request**:

**Request**:
```http
POST /course/enroll HTTP/1.1
Host: localhost:8080
Content-Type: application/x-www-form-urlencoded

course_id=1&csrf_test_name=token_value
```

**Response** (201 Created):
```json
{
    "success": true,
    "message": "Successfully enrolled in the course!",
    "enrollment_id": 1,
    "course_title": "Web Development",
    "enrollment_date": "October 20, 2025 at 1:00 PM"
}
```

---

### **Error Request (Not Logged In)**:

**Request**:
```http
POST /course/enroll HTTP/1.1
Host: localhost:8080
Content-Type: application/x-www-form-urlencoded

course_id=1
```

**Response** (401 Unauthorized):
```json
{
    "success": false,
    "message": "You must be logged in to enroll in a course.",
    "redirect": "http://localhost:8080/login"
}
```

---

## 🎯 Route Best Practices

### **✅ What We Did Right**:

1. **Specific HTTP Method** - POST only, not GET
2. **Clear URI** - `/course/enroll` is descriptive
3. **RESTful Design** - Action-based endpoint
4. **Security Filters** - Automatic CSRF, honeypot
5. **Documented** - Clear comments in routes file
6. **Tested** - Verified route is registered

---

## 🔍 Routes File Structure

### **Complete Routes.php Organization**:

```php
<?php

use CodeIgniter\Router\RouteCollection;

// ============================================
// Public Routes
// ============================================
$routes->get('/', 'Home::index');
$routes->get('about', 'Home::about');
$routes->get('contact', 'Home::contact');

// ============================================
// Authentication Routes
// ============================================
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::login');
$routes->get('dashboard', 'Auth::dashboard');

// ============================================
// Course Enrollment (AJAX) ← STEP 6
// ============================================
$routes->post('/course/enroll', 'Course::enroll');  // ✅ Lab specification
$routes->post('courses/enroll', 'Course::enroll');   // Alternative
```

---

## ✅ Step 6 Completion Checklist

- [x] ✅ Opened `app/Config/Routes.php`
- [x] ✅ Added POST route `/course/enroll`
- [x] ✅ Route points to `Course::enroll`
- [x] ✅ Route follows lab specification exactly
- [x] ✅ Route verified with `php spark routes`
- [x] ✅ Security filters automatically applied
- [x] ✅ Route tested and working
- [x] ✅ Documentation created

---

## 📖 Quick Reference

### **Lab Specification Route**:
```php
$routes->post('/course/enroll', 'Course::enroll');
```

**Location**: `app/Config/Routes.php` Line 82  
**Status**: ✅ **ACTIVE**

### **Test Route**:
```bash
php spark routes | findstr "course/enroll"
```

**Output**:
```
| POST | course/enroll | » | \App\Controllers\Course::enroll | honeypot csrf invalidchars | honeypot secureheaders toolbar |
```

---

## 🎉 Summary

The enrollment route has been successfully configured:

- ✅ **Route Added**: `POST /course/enroll` → `Course::enroll`
- ✅ **Lab Specification**: Exactly as required
- ✅ **Security**: All filters active
- ✅ **Compatibility**: Additional plural route also available
- ✅ **Verified**: Route is registered and working
- ✅ **Documented**: Complete documentation provided

**File**: `app/Config/Routes.php` Line 82 ✅  
**Route**: `POST /course/enroll` ✅  
**Handler**: `Course::enroll` ✅  
**Status**: Production Ready 🚀

---

**Laboratory Activity Step 6: ✅ COMPLETE**

The enrollment route is properly configured and ready to handle AJAX enrollment requests!

