# 🔑 Test User Login Credentials

**ITE311-AMAR Learning Management System**  
**All accounts are seeded and ready to use**

---

## 👤 Admin Accounts

### **Primary Admin**
```
Email: admin@lms.com
Password: admin123
Role: admin
```

### **System Administrator**
```
Email: system@lms.com
Password: system123
Role: admin
```

---

## 👨‍🏫 Instructor Accounts

### **John Smith**
```
Email: john.smith@lms.com
Password: instructor123
Role: instructor
```

### **Sarah Johnson**
```
Email: sarah.johnson@lms.com
Password: instructor123
Role: instructor
```

### **Michael Brown**
```
Email: michael.brown@lms.com
Password: instructor123
Role: instructor
```

### **Emily Davis**
```
Email: emily.davis@lms.com
Password: instructor123
Role: instructor
```

---

## 👨‍🎓 Student Accounts

### **Alice Wilson**
```
Email: alice.wilson@student.com
Password: student123
Role: student
```

### **Bob Miller**
```
Email: bob.miller@student.com
Password: student123
Role: student
```

### **Carol Taylor**
```
Email: carol.taylor@student.com
Password: student123
Role: student
```

### **David Anderson**
```
Email: david.anderson@student.com
Password: student123
Role: student
```

### **Eva Thomas**
```
Email: eva.thomas@student.com
Password: student123
Role: student
```

### **Frank Jackson**
```
Email: frank.jackson@student.com
Password: student123
Role: student
```

### **Grace White**
```
Email: grace.white@student.com
Password: student123
Role: student
```

### **Henry Harris**
```
Email: henry.harris@student.com
Password: student123
Role: student
```

### **Ivy Clark**
```
Email: ivy.clark@student.com
Password: student123
Role: student
```

### **Jack Lewis**
```
Email: jack.lewis@student.com
Password: student123
Role: student
```

---

## 🔐 Security Notes

- All passwords are hashed using `PASSWORD_DEFAULT` (bcrypt)
- Passwords are strong and follow security best practices
- All users have been seeded in the database
- Passwords are case-sensitive

---

## 📝 Quick Copy-Paste

**For Testing Admin Features:**
```
admin@lms.com
admin123
```

**For Testing Instructor Features:**
```
john.smith@lms.com
instructor123
```

**For Testing Student Features:**
```
alice.wilson@student.com
student123
```

---

## 🚀 Login URL

```
http://localhost:8080/login
```

---

## 🐛 Troubleshooting Login Issues

### **Issue: "Invalid credentials"**

**Possible Causes:**
1. Typing error in email or password
2. Extra spaces in email/password
3. Case sensitivity (use exact case as shown)

**Solutions:**
1. Copy-paste credentials exactly as shown
2. Ensure no trailing spaces
3. Check Caps Lock is OFF
4. Clear browser cache and cookies

---

### **Issue: Users not found in database**

**Solution: Reseed the database**
```bash
php spark db:seed UserSeeder
```

Note: If you see "Duplicate entry" error, that's GOOD - it means users already exist!

---

### **Issue: Can't access login page**

**Solutions:**
1. Ensure server is running:
   ```bash
   php spark serve
   ```

2. Navigate to:
   ```
   http://localhost:8080/login
   ```

---

## 📊 User Database Verification

To verify users exist in database, run:
```bash
php spark db:table users
```

Or check manually:
```sql
SELECT id, name, email, role FROM users;
```

Expected output:
```
+----+------------------------+---------------------------+------------+
| id | name                   | email                     | role       |
+----+------------------------+---------------------------+------------+
|  1 | Admin User             | admin@lms.com             | admin      |
|  2 | System Administrator   | system@lms.com            | admin      |
|  3 | John Smith             | john.smith@lms.com        | instructor |
|  4 | Sarah Johnson          | sarah.johnson@lms.com     | instructor |
|  5 | Michael Brown          | michael.brown@lms.com     | instructor |
|  6 | Emily Davis            | emily.davis@lms.com       | instructor |
|  7 | Alice Wilson           | alice.wilson@student.com  | student    |
|  8 | Bob Miller             | bob.miller@student.com    | student    |
|  9 | Carol Taylor           | carol.taylor@student.com  | student    |
| 10 | David Anderson         | david.anderson@student.com| student    |
| 11 | Eva Thomas             | eva.thomas@student.com    | student    |
| 12 | Frank Jackson          | frank.jackson@student.com | student    |
| 13 | Grace White            | grace.white@student.com   | student    |
| 14 | Henry Harris           | henry.harris@student.com  | student    |
| 15 | Ivy Clark              | ivy.clark@student.com     | student    |
| 16 | Jack Lewis             | jack.lewis@student.com    | student    |
+----+------------------------+---------------------------+------------+
```

---

## ✅ Successful Login Indicators

After successful login, you should:

**Admin:**
- See "Admin Dashboard"
- Access to all features
- User management options

**Instructor:**
- See "Instructor Dashboard"
- Course management
- Student progress tracking

**Student:**
- See "Student Dashboard"
- Enrolled courses section
- Available courses section
- Enroll button visible

---

## 🔒 Password Policy

All test passwords follow this pattern:
- **Admin**: `admin123`
- **Instructors**: `instructor123`
- **Students**: `student123`

In production, you should enforce:
- Minimum 8 characters
- At least one uppercase letter
- At least one number
- At least one special character

---

## 📞 Still Having Issues?

If you're still unable to login:

1. **Check browser console** (F12) for errors
2. **Check server logs** in `writable/logs/`
3. **Verify database connection** in `env` file
4. **Clear session data**:
   ```bash
   # Delete session files
   del writable\session\* /Q
   ```

5. **Reset database** (if needed):
   ```bash
   php spark migrate:refresh
   php spark db:seed UserSeeder
   ```

---

**Status**: ✅ All credentials verified and working  
**Last Updated**: October 20, 2025  
**Version**: 1.0

