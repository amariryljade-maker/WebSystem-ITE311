# Logging Guide

## Log Files Location
All application logs are stored in: `writable/logs/`

Log files are named: `log-YYYY-MM-DD.log` (e.g., `log-2025-12-04.log`)

## Viewing Logs

### On Windows (PowerShell):
```powershell
Get-Content writable/logs/log-2025-12-04.log -Tail 50
```

### On Linux/Mac:
```bash
tail -f writable/logs/log-2025-12-04.log
```

## What's Being Logged

### User Seeder Logs
- Database connection status
- Table structure verification
- User insertion results
- Any errors during seeding

### Login Process Logs
- Login attempts with email and IP
- User lookup results
- Password verification results
- Successful/failed login events

## Log Levels

- **INFO**: General information (login attempts, successful operations)
- **DEBUG**: Detailed debugging information
- **WARNING**: Warning messages (failed logins, missing data)
- **ERROR**: Error messages (database errors, exceptions)
- **CRITICAL**: Critical errors (system failures)

## Testing Logging

1. **Check Admin Account:**
   ```bash
   php spark check:admin
   ```

2. **Run User Seeder:**
   ```bash
   php spark db:seed UserSeeder
   ```

3. **Try to Login:**
   - Go to `/login` page
   - Try logging in with admin credentials
   - Check the log file for login attempt details

## Log File Format

Each log entry follows this format:
```
LEVEL - YYYY-MM-DD HH:MM:SS --> Message
```

Example:
```
INFO - 2025-12-04 03:42:04 --> Login attempt: Email = admin@lms.com, IP = 127.0.0.1
DEBUG - 2025-12-04 03:42:04 --> User lookup result: Found user ID 1
INFO - 2025-12-04 03:42:04 --> Login successful: User ID 1 (admin@lms.com)
```

## Troubleshooting

If you don't see logs:
1. Check that `writable/logs/` directory exists and is writable
2. Check `app/Config/Logger.php` - threshold should be 9 for development
3. Verify ENVIRONMENT is set to 'development' in `.env` file

