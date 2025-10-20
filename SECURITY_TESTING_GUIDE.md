# 🔐 Security Testing Guide - Step 9

## Testing the ITE311-AMAR Enrollment System

---

## 📋 Pre-Testing Checklist

### **Required Tools**:
- ✅ Web Browser (Chrome, Firefox, or Edge)
- ✅ Browser Developer Tools (F12)
- ✅ Postman (Optional, for API testing)
- ✅ Server running at `http://localhost:8080`

### **Test Accounts**:
You'll need a student account for some tests:

**Test Student Account**:
- **Email**: `alice@test.com`
- **Password**: `Student@123`

---

## 🧪 Testing Methods

### **Method 1: Interactive HTML Test Suite** ⭐ RECOMMENDED

1. **Open the Test Suite**:
   ```
   http://localhost:8080/security_test.html
   ```

2. **Run Individual Tests**:
   - Click each test button to run specific vulnerability checks
   - View detailed results for each test
   - See security score in real-time

3. **Run All Tests at Once**:
   - Click the **"🚀 Run All Tests"** button at the bottom
   - All tests will execute sequentially
   - Final security score will be displayed

**Advantages**:
- ✅ User-friendly interface
- ✅ Visual feedback
- ✅ Automatic scoring
- ✅ No manual commands needed

---

### **Method 2: Browser Console Testing**

For manual testing via browser console:

#### **Open Console**:
1. Press `F12` to open Developer Tools
2. Go to the **Console** tab
3. Copy and paste test commands

---

## 🧪 Detailed Test Cases

---

## **Test 1: Authorization Bypass Prevention** 🚫

### **Objective**: 
Verify that unauthenticated users cannot enroll in courses.

### **Steps**:

#### **Step 1.1: Logout** (if logged in)
```
Navigate to: http://localhost:8080/logout
```

#### **Step 1.2: Test via Security Suite**
```
1. Open: http://localhost:8080/security_test.html
2. Click: "🚫 Test Unauthorized Enrollment"
3. Expected Result: ✅ SECURE - Request rejected with 401
```

#### **Step 1.3: Test via Browser Console**
```javascript
// Paste in Console (when logged out):
fetch('http://localhost:8080/course/enroll', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
    },
    body: new URLSearchParams({
        course_id: 1
    }),
    credentials: 'omit'
})
.then(r => r.json())
.then(data => console.log(data))
.catch(e => console.error(e));
```

#### **Step 1.4: Test via Postman**

**Request**:
```
POST http://localhost:8080/course/enroll
Content-Type: application/x-www-form-urlencoded

Body (x-www-form-urlencoded):
course_id: 1
```

**Important**: Don't include cookies or authentication headers.

### **Expected Results**:

✅ **PASS Criteria**:
```json
{
    "success": false,
    "message": "You must be logged in to enroll in a course.",
    "redirect": "http://localhost:8080/login"
}
```
- Status Code: `401 Unauthorized`
- No enrollment created in database

❌ **FAIL Criteria**:
- Request succeeds without authentication
- Enrollment is created
- Status code is 200 or 201

### **Verification**:

Check database (optional):
```sql
SELECT * FROM enrollments ORDER BY id DESC LIMIT 1;
-- Should NOT show a new enrollment
```

---

## **Test 2: SQL Injection Prevention** 💉

### **Objective**: 
Verify that SQL injection attacks are blocked.

### **Prerequisites**: 
✅ **You must be logged in as a student**

**Login**:
```
URL: http://localhost:8080/login
Email: alice@test.com
Password: Student@123
```

### **Attack Vectors**:

#### **Attack 2.1: OR 1=1 Injection**

**Via Security Suite**:
```
Click: "💉 Test: 1 OR 1=1"
```

**Via Browser Console**:
```javascript
// Paste in Console (when logged in):
fetch('http://localhost:8080/course/enroll', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
    },
    body: new URLSearchParams({
        course_id: "1 OR 1=1"
    }),
    credentials: 'include'
})
.then(r => r.json())
.then(data => {
    console.log('Status:', r.status);
    console.log('Response:', data);
});
```

#### **Attack 2.2: DROP TABLE Injection**

**Via Browser Console**:
```javascript
fetch('http://localhost:8080/course/enroll', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
    },
    body: new URLSearchParams({
        course_id: "1; DROP TABLE enrollments--"
    }),
    credentials: 'include'
})
.then(r => r.json())
.then(data => console.log(data));
```

#### **Attack 2.3: UNION SELECT Injection**

**Via Browser Console**:
```javascript
fetch('http://localhost:8080/course/enroll', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
    },
    body: new URLSearchParams({
        course_id: "1 UNION SELECT * FROM users--"
    }),
    credentials: 'include'
})
.then(r => r.json())
.then(data => console.log(data));
```

### **Expected Results**:

✅ **PASS Criteria** (All attacks):
```json
{
    "success": false,
    "message": "Invalid course ID provided."
}
```
- Status Code: `400 Bad Request`
- Input validation rejects non-numeric values
- No SQL executed
- Database tables remain intact

### **Verification**:

Check that tables still exist:
```sql
SHOW TABLES;
-- enrollments table should still exist

SELECT COUNT(*) FROM enrollments;
-- Should return normal count, not drop table
```

---

## **Test 3: CSRF Protection** 🛡️

### **Objective**: 
Verify that requests without valid CSRF tokens are rejected.

### **Step 3.1: Check Configuration**

**File: `app/Config/Security.php`**
```php
public string $csrfProtection = 'cookie';  // Should be enabled
```

**File: `app/Config/Filters.php`**
```php
public array $globals = [
    'before' => [
        'csrf',  // Should be present
    ],
];
```

### **Step 3.2: Test Request Without Token**

**Via Security Suite**:
```
Click: "🛡️ Test Request Without CSRF Token"
```

**Via Browser Console**:
```javascript
// This will fail CSRF validation
fetch('http://localhost:8080/course/enroll', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
    },
    body: new URLSearchParams({
        course_id: 1
        // Notice: No CSRF token included
    }),
    credentials: 'include'
})
.then(r => {
    console.log('Status:', r.status);
    return r.text();
})
.then(data => console.log(data));
```

### **Step 3.3: Test with Invalid Token**

**Via Browser Console**:
```javascript
fetch('http://localhost:8080/course/enroll', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
    },
    body: new URLSearchParams({
        course_id: 1,
        csrf_test_name: 'invalid_token_12345'  // Invalid token
    }),
    credentials: 'include'
})
.then(r => r.json())
.then(data => console.log(data));
```

### **Expected Results**:

✅ **PASS Criteria**:
- Status Code: `403 Forbidden`
- Error message: "The action you requested is not allowed"
- Or CodeIgniter CSRF error page
- Request is blocked before reaching controller

### **Step 3.4: Verify Token in Forms**

**Inspect Login Form**:
```
1. Go to: http://localhost:8080/login
2. Right-click → Inspect Element
3. Look for: <input type="hidden" name="csrf_test_name">
4. Should have a token value
```

**Inspect AJAX Requests**:
```
1. Log in as student
2. Go to dashboard
3. Open DevTools → Network tab
4. Click an "Enroll" button
5. Check request payload
6. Should include: csrf_test_name: [token]
```

---

## **Test 4: Data Tampering Prevention** 🔧

### **Objective**: 
Verify that users cannot enroll others by manipulating the `user_id`.

### **Prerequisites**: 
✅ **You must be logged in as a student**

### **Attack Scenario**:
Student Alice (user_id=7) tries to enroll Bob (user_id=8) instead of herself.

### **Step 4.1: Via Security Suite**

```
Click: "🔧 Test User ID Manipulation"
```

### **Step 4.2: Via Browser Console**

```javascript
// Try to add user_id parameter
fetch('http://localhost:8080/course/enroll', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
    },
    body: new URLSearchParams({
        course_id: 1,
        user_id: 999  // ← Attempting to enroll user 999
    }),
    credentials: 'include'
})
.then(r => r.json())
.then(data => {
    console.log('Response:', data);
    console.log('Now check database to verify enrollment used session user_id, not 999');
});
```

### **Step 4.3: Via Browser DevTools - Edit and Resend**

**Advanced Method**:
```
1. Log in as a student
2. Go to student dashboard
3. Open DevTools (F12)
4. Go to Network tab
5. Click "Enroll Now" on a course
6. In Network tab, right-click the request
7. Select "Edit and Resend" (Chrome) or "Edit and Resend" (Firefox)
8. Add parameter: user_id=999
9. Click "Send"
10. Check database
```

### **Expected Results**:

✅ **PASS Criteria**:
- Server ignores client-supplied `user_id`
- Enrollment is created with **session user_id** only
- Response may succeed, but with correct user
- Cannot enroll other users

### **Verification** (REQUIRED):

**Check Database**:
```sql
-- After attempting to enroll with user_id=999
SELECT * FROM enrollments ORDER BY id DESC LIMIT 1;

-- Expected result:
-- user_id should be YOUR session user_id (e.g., 7)
-- NOT 999
```

**Check Code** (app/Controllers/Course.php):
```php
// Line 148: Should use session, not request
$userId = get_user_id();  // ✅ From session

// Should NEVER do:
// $userId = $this->request->getPost('user_id');  // ❌ Vulnerable
```

---

## **Test 5: Input Validation** ❌

### **Objective**: 
Verify that invalid inputs are properly validated and rejected.

### **Prerequisites**: 
✅ **You must be logged in as a student**

### **Test Cases**:

#### **Test 5.1: String Input**

**Via Security Suite**:
```
Click: "❌ Test: String Input"
```

**Via Console**:
```javascript
fetch('http://localhost:8080/course/enroll', {
    method: 'POST',
    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    body: new URLSearchParams({course_id: 'abc'}),
    credentials: 'include'
})
.then(r => r.json())
.then(data => console.log(data));
```

**Expected**:
```json
{"success": false, "message": "Invalid course ID provided."}
Status: 400
```

---

#### **Test 5.2: Empty Input**

**Via Console**:
```javascript
fetch('http://localhost:8080/course/enroll', {
    method: 'POST',
    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    body: new URLSearchParams({course_id: ''}),
    credentials: 'include'
})
.then(r => r.json())
.then(data => console.log(data));
```

**Expected**:
```json
{"success": false, "message": "Invalid course ID provided."}
Status: 400
```

---

#### **Test 5.3: Negative ID**

**Via Console**:
```javascript
fetch('http://localhost:8080/course/enroll', {
    method: 'POST',
    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    body: new URLSearchParams({course_id: -1}),
    credentials: 'include'
})
.then(r => r.json())
.then(data => console.log(data));
```

**Expected**:
```json
{"success": false, "message": "Course not found."}
Status: 404
```

---

#### **Test 5.4: Non-Existent Course**

**Via Console**:
```javascript
fetch('http://localhost:8080/course/enroll', {
    method: 'POST',
    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    body: new URLSearchParams({course_id: 999999}),
    credentials: 'include'
})
.then(r => r.json())
.then(data => console.log(data));
```

**Expected**:
```json
{"success": false, "message": "Course not found."}
Status: 404
```

---

#### **Test 5.5: SQL Injection Attempt**

**Via Console**:
```javascript
fetch('http://localhost:8080/course/enroll', {
    method: 'POST',
    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    body: new URLSearchParams({course_id: "1' OR '1'='1"}),
    credentials: 'include'
})
.then(r => r.json())
.then(data => console.log(data));
```

**Expected**:
```json
{"success": false, "message": "Invalid course ID provided."}
Status: 400
```

---

#### **Test 5.6: Very Large Number**

**Via Console**:
```javascript
fetch('http://localhost:8080/course/enroll', {
    method: 'POST',
    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    body: new URLSearchParams({course_id: 999999999999}),
    credentials: 'include'
})
.then(r => r.json())
.then(data => console.log(data));
```

**Expected**:
```json
{"success": false, "message": "Course not found."}
Status: 404
```

---

### **Input Validation Summary**:

| Input | Expected Status | Expected Message |
|-------|----------------|------------------|
| `"abc"` | 400 | Invalid course ID provided |
| `""` | 400 | Invalid course ID provided |
| `null` | 400 | Invalid course ID provided |
| `-1` | 404 | Course not found |
| `999999` | 404 | Course not found |
| `"1 OR 1=1"` | 400 | Invalid course ID provided |
| `1.5` | Numeric validation | May be accepted as integer |

---

## 📊 Test Results Checklist

Use this checklist to track your testing:

### **Test 1: Authorization Bypass**
- [ ] Logged out successfully
- [ ] Request rejected with 401
- [ ] Error message: "You must be logged in"
- [ ] No enrollment created
- **Result**: ✅ PASS / ❌ FAIL

### **Test 2: SQL Injection**
- [ ] "1 OR 1=1" rejected
- [ ] "DROP TABLE" rejected
- [ ] "UNION SELECT" rejected
- [ ] All return 400 Bad Request
- [ ] Database tables intact
- **Result**: ✅ PASS / ❌ FAIL

### **Test 3: CSRF Protection**
- [ ] CSRF enabled in config
- [ ] CSRF filter in globals
- [ ] Request without token rejected
- [ ] Request with invalid token rejected
- [ ] Forms include CSRF token
- **Result**: ✅ PASS / ❌ FAIL

### **Test 4: Data Tampering**
- [ ] Attempted to add user_id parameter
- [ ] Database shows session user_id (not client-supplied)
- [ ] Code uses get_user_id() from session
- [ ] Cannot enroll other users
- **Result**: ✅ PASS / ❌ FAIL

### **Test 5: Input Validation**
- [ ] String input rejected (400)
- [ ] Empty input rejected (400)
- [ ] Negative ID rejected (404)
- [ ] Non-existent course rejected (404)
- [ ] SQL injection strings rejected (400)
- **Result**: ✅ PASS / ❌ FAIL

---

## 🎯 Security Score Calculation

**Total Tests**: 15  
**Tests Passed**: _____  
**Security Score**: _____ %

**Formula**: (Passed / Total) × 100

**Rating Scale**:
- 100% = 🏆 Excellent (A+)
- 90-99% = 🎖️ Very Good (A)
- 80-89% = ✅ Good (B)
- 70-79% = ⚠️ Needs Improvement (C)
- < 70% = ❌ Vulnerable (F)

---

## 🔍 Advanced Testing (Optional)

### **Postman Collection**

Create a Postman collection with these requests:

1. **Test Authorization**:
   - POST `/course/enroll`
   - No cookies/auth
   - Expect: 401

2. **Test SQL Injection**:
   - POST `/course/enroll`
   - Body: `course_id=1 OR 1=1`
   - With auth
   - Expect: 400

3. **Test Valid Enrollment**:
   - POST `/course/enroll`
   - Body: `course_id=1`
   - With auth + CSRF token
   - Expect: 201 (if not already enrolled) or 409

### **Automated Testing Script**

Create `test_security.sh`:
```bash
#!/bin/bash

echo "Running Security Tests..."

# Test 1: Authorization
echo "Test 1: Authorization Bypass"
curl -X POST http://localhost:8080/course/enroll \
  -d "course_id=1" \
  -w "\nStatus: %{http_code}\n"

# Test 2: SQL Injection
echo "\nTest 2: SQL Injection"
curl -X POST http://localhost:8080/course/enroll \
  -d "course_id=1 OR 1=1" \
  -w "\nStatus: %{http_code}\n"

echo "\nTests Complete"
```

---

## 📝 Reporting

Document your findings:

### **Test Report Template**:

```
SECURITY TEST REPORT
Date: [Date]
Tester: [Your Name]

TEST 1: Authorization Bypass
Result: ✅ PASS / ❌ FAIL
Details: [Notes]

TEST 2: SQL Injection
Result: ✅ PASS / ❌ FAIL
Details: [Notes]

TEST 3: CSRF Protection
Result: ✅ PASS / ❌ FAIL
Details: [Notes]

TEST 4: Data Tampering
Result: ✅ PASS / ❌ FAIL
Details: [Notes]

TEST 5: Input Validation
Result: ✅ PASS / ❌ FAIL
Details: [Notes]

OVERALL SECURITY SCORE: [X]%
RECOMMENDATION: [Production Ready / Needs Fixes]
```

---

## ✅ Success Criteria

The enrollment system is considered **SECURE** if:

- ✅ All 5 test categories pass
- ✅ Security score ≥ 90%
- ✅ No critical vulnerabilities found
- ✅ OWASP Top 10 compliance
- ✅ Proper error handling
- ✅ Comprehensive input validation

---

## 🎉 Conclusion

After completing all tests, your enrollment system should demonstrate:

1. **Strong Authentication**: No bypass possible
2. **SQL Injection Prevention**: All attacks blocked
3. **CSRF Protection**: Enabled and working
4. **Data Integrity**: User ID from session only
5. **Input Validation**: Comprehensive checks

**Ready for deployment!** 🚀🔐

---

**Testing Guide Version**: 1.0  
**Last Updated**: October 20, 2025  
**Application**: ITE311-AMAR LMS

