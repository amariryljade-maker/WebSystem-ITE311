# EnrollmentModel Documentation
**File**: `app/Models/EnrollmentModel.php`  
**Purpose**: Manage student course enrollments  
**Created**: October 20, 2025

---

## 📋 Lab Activity Requirements

### **✅ Step 2: Create Enrollment Model**

**Location**: `app/Models/EnrollmentModel.php`  
**Status**: ✅ **COMPLETED**

---

## 🎯 Required Methods (Lab Specification)

### **1. enrollUser($data)** ✅

**Purpose**: Insert a new enrollment record

**Parameters**:
```php
$data = [
    'user_id' => 7,                          // Required: User ID
    'course_id' => 1,                        // Required: Course ID
    'enrollment_date' => '2025-10-20 12:00:00', // Optional: Defaults to now
    'payment_status' => 'paid',              // Optional: Defaults to 'pending'
    'amount_paid' => 99.99                   // Optional
];
```

**Returns**: 
- `int` - Enrollment ID on success
- `false` - On failure (duplicate enrollment, validation error)

**Usage Example**:
```php
$enrollmentModel = new EnrollmentModel();

$result = $enrollmentModel->enrollUser([
    'user_id' => 7,
    'course_id' => 1
]);

if ($result) {
    echo "Enrolled successfully! Enrollment ID: {$result}";
} else {
    echo "Enrollment failed (duplicate or error)";
}
```

**Features**:
- ✅ Prevents duplicate enrollments
- ✅ Sets default values automatically
- ✅ Validates user and course existence
- ✅ Logs enrollment events
- ✅ Returns enrollment ID on success

---

### **2. getUserEnrollments($user_id)** ✅

**Purpose**: Fetch all courses a user is enrolled in

**Parameters**:
```php
$user_id = 7; // User ID to fetch enrollments for
```

**Returns**: 
- `array` - Array of enrollment records with course details
- Empty array if no enrollments

**Usage Example**:
```php
$enrollmentModel = new EnrollmentModel();

$enrollments = $enrollmentModel->getUserEnrollments(7);

foreach ($enrollments as $enrollment) {
    echo "Course: {$enrollment['course_title']}\n";
    echo "Progress: {$enrollment['progress']}%\n";
    echo "Status: {$enrollment['status']}\n";
}
```

**Returned Data Structure**:
```php
[
    [
        'id' => 1,
        'user_id' => 7,
        'course_id' => 1,
        'enrollment_date' => '2025-10-20 12:00:00',
        'progress' => 45.50,
        'status' => 'active',
        'course_title' => 'Web Development',
        'course_description' => '...',
        'level' => 'beginner',
        'duration' => 120,
        'thumbnail' => 'course.jpg'
    ],
    // ... more enrollments
]
```

**Features**:
- ✅ Joins with courses table
- ✅ Returns course details
- ✅ Ordered by enrollment date (newest first)
- ✅ Handles empty results gracefully

---

### **3. isAlreadyEnrolled($user_id, $course_id)** ✅

**Purpose**: Check if user is already enrolled to prevent duplicates

**Parameters**:
```php
$user_id = 7;     // User ID to check
$course_id = 1;   // Course ID to check
```

**Returns**: 
- `true` - User is already enrolled
- `false` - User is not enrolled

**Usage Example**:
```php
$enrollmentModel = new EnrollmentModel();

if ($enrollmentModel->isAlreadyEnrolled(7, 1)) {
    echo "Already enrolled in this course!";
} else {
    echo "Can enroll in this course";
    $enrollmentModel->enrollUser([
        'user_id' => 7,
        'course_id' => 1
    ]);
}
```

**Features**:
- ✅ Prevents duplicate enrollments
- ✅ Fast lookup (indexed query)
- ✅ Error handling included
- ✅ Used automatically in `enrollUser()`

---

## 🎁 Bonus Methods (Additional Features)

### **4. getActiveEnrollments($user_id)**

Get only active (in-progress) enrollments

```php
$activeEnrollments = $enrollmentModel->getActiveEnrollments(7);
// Returns only enrollments with status = 'active'
```

---

### **5. getCompletedEnrollments($user_id)**

Get completed courses

```php
$completed = $enrollmentModel->getCompletedEnrollments(7);
// Returns only enrollments with status = 'completed'
```

---

### **6. getCourseEnrollments($course_id)**

Get all students enrolled in a specific course

```php
$students = $enrollmentModel->getCourseEnrollments(1);
// Returns all enrollments for course ID 1 with student details
```

---

### **7. updateProgress($enrollment_id, $progress)**

Update course completion progress

```php
$enrollmentModel->updateProgress(1, 75.50);
// Updates progress to 75.5%
// Auto-marks as 'completed' when progress reaches 100%
```

---

### **8. issueCertificate($enrollment_id)**

Issue completion certificate

```php
$enrollmentModel->issueCertificate(1);
// Marks certificate as issued with timestamp
```

---

### **9. updatePaymentStatus($enrollment_id, $status, $amount)**

Update payment information

```php
$enrollmentModel->updatePaymentStatus(1, 'paid', 99.99);
// Updates payment status and amount
```

---

### **10. getUserEnrollmentStats($user_id)**

Get enrollment statistics for a user

```php
$stats = $enrollmentModel->getUserEnrollmentStats(7);
/*
Returns:
[
    'total_enrolled' => 5,
    'active' => 3,
    'completed' => 2,
    'average_progress' => 65.50
]
*/
```

---

### **11. dropEnrollment($user_id, $course_id)**

Withdraw from a course

```php
$enrollmentModel->dropEnrollment(7, 1);
// Changes status to 'dropped'
```

---

### **12. getCourseEnrollmentCount($course_id)**

Count students enrolled in a course

```php
$count = $enrollmentModel->getCourseEnrollmentCount(1);
// Returns number of enrolled students
```

---

### **13. bulkEnroll($user_ids, $course_id)**

Enroll multiple users at once

```php
$result = $enrollmentModel->bulkEnroll([7, 8, 9], 1);
/*
Returns:
[
    'success' => 3,
    'failed' => 0,
    'errors' => []
]
*/
```

---

## 🔧 Model Configuration

### **Table**: `enrollments`

### **Allowed Fields**:
```php
[
    'user_id', 'course_id', 'enrollment_date',
    'completion_date', 'progress', 'status', 'grade',
    'certificate_issued', 'certificate_issued_at',
    'payment_status', 'amount_paid'
]
```

### **Validation Rules**:
```php
'user_id'         => 'required|integer|is_not_unique[users.id]'
'course_id'       => 'required|integer|is_not_unique[courses.id]'
'enrollment_date' => 'required|valid_date'
'status'          => 'in_list[active,completed,dropped,suspended]'
'payment_status'  => 'in_list[pending,paid,failed,refunded]'
```

### **Timestamps**: ✅ Enabled (`created_at`, `updated_at`)

### **Callbacks**:
- `beforeInsert`: Prevents duplicate enrollments

---

## 📝 Usage Examples

### **Example 1: Simple Enrollment**
```php
use App\Models\EnrollmentModel;

$enrollmentModel = new EnrollmentModel();

// Enroll student in course
$enrollmentId = $enrollmentModel->enrollUser([
    'user_id' => 7,
    'course_id' => 1
]);

if ($enrollmentId) {
    echo "Successfully enrolled! ID: {$enrollmentId}";
}
```

---

### **Example 2: Check Before Enrolling**
```php
$enrollmentModel = new EnrollmentModel();

if (!$enrollmentModel->isAlreadyEnrolled(7, 1)) {
    $enrollmentModel->enrollUser([
        'user_id' => 7,
        'course_id' => 1,
        'payment_status' => 'paid',
        'amount_paid' => 99.99
    ]);
    echo "Enrollment successful!";
} else {
    echo "Already enrolled in this course!";
}
```

---

### **Example 3: Display User's Courses**
```php
$enrollmentModel = new EnrollmentModel();

$enrollments = $enrollmentModel->getUserEnrollments(7);

foreach ($enrollments as $enrollment) {
    echo "<div class='course-card'>";
    echo "  <h3>{$enrollment['course_title']}</h3>";
    echo "  <p>Progress: {$enrollment['progress']}%</p>";
    echo "  <p>Status: {$enrollment['status']}</p>";
    echo "</div>";
}
```

---

### **Example 4: Update Progress**
```php
$enrollmentModel = new EnrollmentModel();

// Update to 80% progress
$enrollmentModel->updateProgress(1, 80.00);

// Update to 100% (auto-marks as completed)
$enrollmentModel->updateProgress(1, 100.00);
```

---

### **Example 5: Teacher View Enrolled Students**
```php
$enrollmentModel = new EnrollmentModel();

$students = $enrollmentModel->getCourseEnrollments(1);

echo "Students enrolled in this course: " . count($students);

foreach ($students as $student) {
    echo "{$student['student_name']} - Progress: {$student['progress']}%";
}
```

---

## 🛡️ Security Features

### **1. Duplicate Prevention**:
- Database constraint: UNIQUE (user_id, course_id)
- Model validation in `beforeInsert` callback
- Manual check in `isAlreadyEnrolled()`

### **2. Data Validation**:
- User ID must exist in users table
- Course ID must exist in courses table
- Status must be valid enum value
- Progress must be 0-100

### **3. SQL Injection Prevention**:
- Uses Query Builder (parameterized queries)
- No raw SQL with user input
- Model-based database access

### **4. Error Handling**:
- Try-catch blocks on all methods
- Logging of errors and warnings
- Graceful fallback values

---

## 🎯 Method Summary Table

| Method | Required | Purpose | Returns |
|--------|----------|---------|---------|
| `enrollUser($data)` | ✅ Yes | Enroll user in course | int\|false |
| `getUserEnrollments($user_id)` | ✅ Yes | Get user's enrollments | array |
| `isAlreadyEnrolled($user_id, $course_id)` | ✅ Yes | Check duplicate | bool |
| `getActiveEnrollments($user_id)` | Bonus | Active enrollments | array |
| `getCompletedEnrollments($user_id)` | Bonus | Completed courses | array |
| `getCourseEnrollments($course_id)` | Bonus | Course students | array |
| `updateProgress($enrollment_id, $progress)` | Bonus | Update progress | bool |
| `issueCertificate($enrollment_id)` | Bonus | Issue certificate | bool |
| `updatePaymentStatus($enrollment_id, $status, $amount)` | Bonus | Update payment | bool |
| `getUserEnrollmentStats($user_id)` | Bonus | Get statistics | array |
| `dropEnrollment($user_id, $course_id)` | Bonus | Withdraw | bool |
| `getCourseEnrollmentCount($course_id)` | Bonus | Count students | int |
| `bulkEnroll($user_ids, $course_id)` | Bonus | Bulk enroll | array |

**Total Methods**: 13 (3 required + 10 bonus)

---

## ✅ Verification Checklist

- [x] ✅ File created at `app/Models/EnrollmentModel.php`
- [x] ✅ Extends CodeIgniter Model class
- [x] ✅ `enrollUser($data)` method implemented
- [x] ✅ `getUserEnrollments($user_id)` method implemented
- [x] ✅ `isAlreadyEnrolled($user_id, $course_id)` method implemented
- [x] ✅ Validation rules defined
- [x] ✅ Error handling implemented
- [x] ✅ Security measures included
- [x] ✅ Logging implemented
- [x] ✅ Tested and verified

---

## 🎉 Summary

The **EnrollmentModel** has been successfully created with:

- ✅ All 3 required methods from lab specification
- ✅ 10 bonus methods for enhanced functionality
- ✅ Complete validation rules
- ✅ Security measures (duplicate prevention, SQL injection protection)
- ✅ Error handling and logging
- ✅ Join operations for related data
- ✅ Comprehensive documentation

**Model Status**: ✅ **PRODUCTION READY**

---

**Next Steps**: Create Enrollment controller to handle enrollment operations via web interface.

