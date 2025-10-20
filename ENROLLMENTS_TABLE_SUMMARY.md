# Enrollments Table - Laboratory Activity
**Created**: August 24, 2025  
**Migration File**: `app/Database/Migrations/2025-08-24-050702_CreateEnrollmentsTable.php`  
**Status**: ✅ **MIGRATED AND ACTIVE**

---

## 📋 Lab Requirements

### **✅ Step 1: Create Database Migration**

#### **Command Used:**
```bash
php spark make:migration CreateEnrollmentsTable
```

**Status**: ✅ **Already Created**  
**Migration File**: `2025-08-24-050702_CreateEnrollmentsTable.php`

---

## 🗂️ Table Schema

### **Required Fields (Lab Specification):**

| Field | Type | Constraints | Description |
|-------|------|-------------|-------------|
| **id** | INT | PRIMARY KEY, AUTO_INCREMENT | ✅ Unique identifier |
| **user_id** | INT | FOREIGN KEY → users.id | ✅ Student/User reference |
| **course_id** | INT | FOREIGN KEY → courses.id | ✅ Course reference |
| **enrollment_date** | DATETIME | NOT NULL | ✅ When enrolled |

**Status**: ✅ **All Required Fields Present**

---

### **Additional Fields (Enhanced Implementation):**

| Field | Type | Default | Description |
|-------|------|---------|-------------|
| completion_date | DATETIME | NULL | When course completed |
| progress | DECIMAL(5,2) | 0.00 | Progress percentage (0-100) |
| status | ENUM | 'active' | Status: active, completed, dropped, suspended |
| grade | DECIMAL(5,2) | NULL | Final grade (0-100) |
| certificate_issued | BOOLEAN | false | Certificate issued flag |
| certificate_issued_at | DATETIME | NULL | Certificate issue date |
| payment_status | ENUM | 'pending' | Payment status tracking |
| amount_paid | DECIMAL(10,2) | 0.00 | Amount paid for course |
| created_at | DATETIME | NULL | Record creation timestamp |
| updated_at | DATETIME | NULL | Record update timestamp |

---

## 🔑 Indexes and Constraints

### **Primary Key:**
```sql
PRIMARY KEY (id)
```

### **Foreign Keys:**
```sql
FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE ON UPDATE CASCADE
```

### **Unique Constraint:**
```sql
UNIQUE KEY (user_id, course_id)  -- Prevents duplicate enrollments
```

### **Additional Indexes:**
```sql
INDEX (user_id)
INDEX (course_id)
INDEX (status)
```

---

## 📝 Migration Code

### **up() Method:**
```php
public function up()
{
    $this->forge->addField([
        'id' => [
            'type' => 'INT',
            'constraint' => 11,
            'unsigned' => true,
            'auto_increment' => true,
        ],
        'user_id' => [
            'type' => 'INT',
            'constraint' => 11,
            'unsigned' => true,
            'null' => false,
        ],
        'course_id' => [
            'type' => 'INT',
            'constraint' => 11,
            'unsigned' => true,
            'null' => false,
        ],
        'enrollment_date' => [
            'type' => 'DATETIME',
            'null' => false,
        ],
        // ... additional fields ...
    ]);
    
    $this->forge->addKey('id', true);
    $this->forge->addKey('user_id');
    $this->forge->addKey('course_id');
    $this->forge->addKey('status');
    $this->forge->addUniqueKey(['user_id', 'course_id']);
    $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
    $this->forge->addForeignKey('course_id', 'courses', 'id', 'CASCADE', 'CASCADE');
    $this->forge->createTable('enrollments');
}
```

### **down() Method:**
```php
public function down()
{
    $this->forge->dropTable('enrollments');
}
```

---

## ✅ Migration Status

### **Migration Execution:**
```bash
php spark migrate
```

**Result**: ✅ **Successfully Migrated**

### **Verification:**
```bash
php spark migrate:status
```

**Output:**
```
| App | 2025-08-24-050702 | CreateEnrollmentsTable | default | 2025-08-24 06:23:09 | 2 |
```

**Status**: ✅ **Table exists in database**

---

## 🔗 Table Relationships

```
users (1) ←→ (many) enrollments (many) ←→ (1) courses
```

### **Relationship Diagram:**
```
┌─────────────┐
│   users     │
│ id (PK)     │
└──────┬──────┘
       │ 1
       │
       │ many
┌──────┴──────────┐
│  enrollments    │
│ id (PK)         │
│ user_id (FK)    │
│ course_id (FK)  │
│ enrollment_date │
└──────┬──────────┘
       │ many
       │
       │ 1
┌──────┴──────┐
│   courses   │
│ id (PK)     │
└─────────────┘
```

---

## 🎯 Business Rules Enforced

### **1. No Duplicate Enrollments:**
```sql
UNIQUE KEY (user_id, course_id)
```
A user can only enroll in a course once.

### **2. Referential Integrity:**
```sql
FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
```
- If user deleted → enrollments deleted
- If course deleted → enrollments deleted

### **3. Progress Tracking:**
```sql
progress DECIMAL(5,2) DEFAULT 0.00  -- 0% to 100%
```
Percentage-based progress tracking.

### **4. Status Management:**
```sql
status ENUM('active', 'completed', 'dropped', 'suspended')
```
Clear enrollment lifecycle states.

---

## 📊 Sample Data Structure

### **Example Enrollment Record:**
```json
{
    "id": 1,
    "user_id": 7,
    "course_id": 1,
    "enrollment_date": "2025-10-20 12:00:00",
    "completion_date": null,
    "progress": 45.50,
    "status": "active",
    "grade": null,
    "certificate_issued": false,
    "certificate_issued_at": null,
    "payment_status": "paid",
    "amount_paid": 99.99,
    "created_at": "2025-10-20 12:00:00",
    "updated_at": "2025-10-20 12:30:00"
}
```

---

## 🚀 Usage Examples

### **Create Enrollment:**
```php
$enrollmentData = [
    'user_id' => 7,
    'course_id' => 1,
    'enrollment_date' => date('Y-m-d H:i:s'),
    'status' => 'active',
    'payment_status' => 'paid'
];

$db->table('enrollments')->insert($enrollmentData);
```

### **Get User's Enrollments:**
```php
$enrollments = $db->table('enrollments')
    ->where('user_id', $userId)
    ->join('courses', 'courses.id = enrollments.course_id')
    ->get()
    ->getResultArray();
```

### **Update Progress:**
```php
$db->table('enrollments')
    ->where('user_id', $userId)
    ->where('course_id', $courseId)
    ->update(['progress' => 75.00]);
```

---

## ✅ Verification Checklist

- [x] ✅ Migration file created
- [x] ✅ up() method defined with all required fields
- [x] ✅ down() method defined to drop table
- [x] ✅ Migration executed successfully
- [x] ✅ Table exists in database
- [x] ✅ Foreign keys configured
- [x] ✅ Indexes created
- [x] ✅ Constraints applied

---

## 📖 Migration Commands Reference

### **Create Migration:**
```bash
php spark make:migration CreateEnrollmentsTable
```

### **Run Migration:**
```bash
php spark migrate
```

### **Check Status:**
```bash
php spark migrate:status
```

### **Rollback (if needed):**
```bash
php spark migrate:rollback
```

### **Refresh (drop and recreate):**
```bash
php spark migrate:refresh
```

---

## 🎯 Lab Activity Status

### **Step 1: Create Migration** ✅
- **Status**: Completed
- **File**: `2025-08-24-050702_CreateEnrollmentsTable.php`
- **Location**: `app/Database/Migrations/`

### **Required Fields** ✅
- **id**: Primary key, auto-increment ✅
- **user_id**: Foreign key to users ✅
- **course_id**: Foreign key to courses ✅
- **enrollment_date**: Datetime field ✅

### **Migration Execution** ✅
- **Command**: `php spark migrate`
- **Result**: Successfully migrated
- **Batch**: 2
- **Date**: 2025-08-24 06:23:09

---

## 🎉 Summary

The **enrollments table** has been successfully created and migrated with:
- ✅ All required fields from lab specification
- ✅ Additional fields for enhanced functionality
- ✅ Proper foreign key relationships
- ✅ Indexes for performance optimization
- ✅ Business rule constraints

**Table is ready for use in the enrollment system!**

---

**Next Steps**: Create Enrollment controller and views for managing student course enrollments.

