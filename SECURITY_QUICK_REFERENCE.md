# 🔒 Security Quick Reference Guide
**ITE311-AMAR LMS - Login & Registration Security**

---

## 🚀 Quick Start - Testing Security Features

### **1. Test Rate Limiting:**
```
1. Go to: http://localhost:8080/login
2. Enter wrong password 5 times
3. Expected: Account locked for 15 minutes
4. Result: ✅ Brute force attack prevented
```

### **2. Test Password Strength:**
```
1. Go to: http://localhost:8080/register
2. Try password: "password" (weak)
3. Expected: Error - must have uppercase, number, special char
4. Try password: "MyP@ss123" (strong)
5. Expected: ✅ Accepted
```

### **3. Test CSRF Protection:**
```
1. Open login form
2. Check page source
3. Look for: <input type="hidden" name="csrf_test_name">
4. Expected: ✅ CSRF token present
```

---

## 🎯 Password Requirements

### **Minimum Requirements:**
- ✅ At least **8 characters**
- ✅ At least **1 uppercase** letter (A-Z)
- ✅ At least **1 lowercase** letter (a-z)
- ✅ At least **1 number** (0-9)
- ✅ At least **1 special** character (!@#$%^&*)

### **Examples:**

| Password | Valid? | Reason |
|----------|--------|--------|
| `password` | ❌ No | No uppercase, number, special char |
| `Password` | ❌ No | No number, special char |
| `Password123` | ❌ No | No special char |
| `Pass@123` | ❌ No | Less than 8 characters |
| `MyP@ss123` | ✅ Yes | Meets all requirements |
| `SecureP@ssw0rd!` | ✅ Yes | Meets all requirements |

---

## 🔐 Security Features Active

### **Filters Enabled:**
```php
✅ CSRF Protection (Cross-Site Request Forgery)
✅ Honeypot (Bot Protection)
✅ InvalidChars (Character Filtering)
✅ SecureHeaders (HTTP Security Headers)
```

### **Rate Limiting:**
```php
✅ Maximum Attempts: 5
✅ Lockout Duration: 15 minutes
✅ Tracked By: IP Address
✅ Applies To: Login & Registration
```

### **Password Security:**
```php
✅ Hashing Algorithm: Argon2ID
✅ Minimum Length: 8 characters
✅ Complexity: Required
✅ Strength Validation: Active
✅ Automatic Rehashing: Enabled
```

---

## 🛡️ Security Layers

### **Layer 1: Input Validation**
```
User Input → Validation Rules → Accept/Reject
```

### **Layer 2: Input Sanitization**
```
Valid Input → Strip Tags → HTML Entities → Clean Input
```

### **Layer 3: Database Protection**
```
Clean Input → Query Builder → Parameterized Query → Safe Database Access
```

### **Layer 4: Output Protection**
```
Database Data → esc() Helper → HTML Encoding → Safe Output
```

### **Layer 5: Session Security**
```
Login → Regenerate Session → Set Timeout → Track IP/Agent
```

---

## 🚨 Security Alerts

### **When Account is Locked:**
```
Message: "Too many failed attempts. Account locked for 15 minutes."
Action: Wait 15 minutes or contact administrator
Logged: Yes (in writable/logs/)
```

### **When Invalid Input Detected:**
```
Message: Specific validation error
Action: Correct input and retry
Logged: Yes (failed validation attempts)
```

### **When CSRF Token Invalid:**
```
Message: "The action you requested is not allowed."
Action: Refresh page and try again
Logged: Yes (by CodeIgniter)
```

---

## 📊 Login Attempt Tracking

### **How It Works:**
1. Each failed login increments counter
2. Counter stored in session by IP
3. After 5 attempts, account locks
4. Lockout lasts 15 minutes
5. Successful login clears counter

### **Example:**
```
Attempt 1: Failed → Counter = 1
Attempt 2: Failed → Counter = 2
Attempt 3: Failed → Counter = 3
Attempt 4: Failed → Counter = 4
Attempt 5: Failed → Counter = 5
Attempt 6: LOCKED → "Please wait 15 minutes"
```

---

## 🔍 Security Logging

### **What Gets Logged:**
- ✅ Failed login attempts
- ✅ Successful logins (with IP)
- ✅ Registration events
- ✅ Rate limit violations
- ✅ Validation failures
- ✅ Security errors

### **Log Location:**
```
writable/logs/log-YYYY-MM-DD.log
```

### **Log Example:**
```
[2025-10-20 12:00:00] WARNING → Failed login attempt for: user@example.com
[2025-10-20 12:05:00] INFO → Successful login: admin@lms.com from IP: 127.0.0.1
[2025-10-20 12:10:00] WARNING → Login blocked due to rate limiting from IP: 192.168.1.100
```

---

## 🎨 User Experience

### **Security Messages:**

#### **Success Messages:**
- ✅ "Registration successful! Please log in."
- ✅ "Welcome back, [Name]!"

#### **Error Messages:**
- ❌ "Invalid email or password." (generic)
- ❌ "Too many failed attempts. Please try again in X minutes."
- ❌ "Password must contain at least one uppercase letter..."

---

## 🔧 Configuration Quick Check

### **Verify Security Is Active:**

```bash
# Check CSRF is enabled
php spark config:check

# Check logs directory is writable
ls -la writable/logs/

# View recent security logs
tail -n 50 writable/logs/log-YYYY-MM-DD.log
```

---

## 🆘 Troubleshooting

### **Problem: "Account locked" message**
**Solution**: Wait 15 minutes or clear session:
```php
session()->remove('login_attempts_' . md5('login_' . $ipAddress));
session()->remove('lockout_until_' . md5('login_' . $ipAddress));
```

### **Problem: CSRF token error**
**Solution**: Refresh page to get new token

### **Problem: "Password too weak" error**
**Solution**: Use password with:
- 8+ characters
- Uppercase + lowercase
- Numbers
- Special characters

---

## ✅ Security Status

**Current Status**: 🟢 **SECURE**

All critical security measures are active and functioning correctly.

**Last Audit**: October 20, 2025  
**Next Review**: January 20, 2026 (3 months)

---

## 📞 Support

For security concerns or questions, refer to:
- Full audit: `SECURITY_AUDIT_REPORT.md`
- Code: `app/Controllers/Auth.php`
- Config: `app/Config/Security.php`
- Logs: `writable/logs/`

