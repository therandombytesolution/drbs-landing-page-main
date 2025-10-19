# 🔒 Security Implementation Guide

## Overview

This document outlines all security measures implemented in the DRBS Landing Page Docker deployment.

## 🛡️ Security Layers

### 1. Container Security

#### Dockerfile Security
- **Non-root execution**: Application runs as `www-data` user
- **Minimal base image**: Using official PHP-FPM image
- **No unnecessary packages**: Only essential dependencies installed
- **Multi-stage build**: Composer installed from official image
- **Health checks**: Container health monitoring enabled

#### Docker Compose Security
```yaml
security_opt:
  - no-new-privileges:true  # Prevents privilege escalation
cap_drop:
  - ALL                      # Drops all Linux capabilities
cap_add:
  - NET_BIND_SERVICE        # Only necessary capabilities added
  - CHOWN
  - SETGID
  - SETUID
```

#### Read-only Filesystem
- Application code is read-only
- Only `/tmp`, `/storage`, and `/bootstrap/cache` are writable
- Prevents malicious file modifications

### 2. Network Security

#### Isolated Network
- All containers run in isolated bridge network
- No direct external access to database
- Cloudflare tunnel provides secure external access

#### Rate Limiting
```nginx
# General endpoints: 10 requests/second
limit_req_zone $binary_remote_addr zone=general:10m rate=10r/s;

# Authentication endpoints: 5 requests/minute
limit_req_zone $binary_remote_addr zone=login:10m rate=5r/m;
```

#### Cloudflare Protection
- DDoS protection
- WAF (Web Application Firewall)
- SSL/TLS encryption
- Bot protection
- Geographic restrictions (optional)

### 3. Web Server Security (Nginx)

#### Security Headers
```nginx
X-Frame-Options: SAMEORIGIN              # Prevents clickjacking
X-Content-Type-Options: nosniff          # Prevents MIME sniffing
X-XSS-Protection: 1; mode=block          # XSS protection
Referrer-Policy: strict-origin-when-cross-origin
Content-Security-Policy: [strict policy]  # Prevents XSS and injection
```

#### Hidden Server Information
- `server_tokens off` - Hides Nginx version
- `expose_php Off` - Hides PHP version

#### File Access Restrictions
```nginx
# Deny access to:
- .env files
- .git directory
- composer.json/lock
- package.json/lock
- PHP files in storage/
- PHP files in bootstrap/
```

#### Request Limits
- Max body size: 10MB
- Max file uploads: 20
- Connection timeout: 15s
- Request timeout: 300s

### 4. PHP Security

#### Disabled Dangerous Functions
```ini
disable_functions=exec,passthru,shell_exec,system,proc_open,popen,curl_exec,curl_multi_exec,parse_ini_file,show_source
```

#### Session Security
```ini
session.cookie_httponly=1    # Prevents JavaScript access
session.cookie_secure=1      # HTTPS only
session.cookie_samesite=Strict  # CSRF protection
session.use_strict_mode=1    # Prevents session fixation
session.use_only_cookies=1   # No URL-based sessions
```

#### File Upload Security
```ini
upload_max_filesize=10M
max_file_uploads=20
allow_url_fopen=Off          # Prevents remote file inclusion
allow_url_include=Off        # Prevents remote code execution
```

#### Error Handling
```ini
display_errors=Off           # Don't expose errors to users
log_errors=On                # Log errors for debugging
error_reporting=E_ALL & ~E_DEPRECATED
```

### 5. Database Security

#### MySQL Configuration
```ini
local-infile=0               # Prevents local file loading
skip-name-resolve            # Faster, more secure
skip-symbolic-links          # Prevents symlink attacks
```

#### Access Control
- Root access disabled from external connections
- Dedicated application user with limited privileges
- Strong password requirements (20+ characters)
- Connection limits: max 100 concurrent

#### Network Isolation
- Database only accessible from app container
- No external port exposure (port 3307 for local dev only)

### 6. Application Security (Laravel)

#### CSRF Protection
- Enabled by default on all POST/PUT/DELETE requests
- Token validation on form submissions

#### SQL Injection Prevention
- Eloquent ORM with prepared statements
- Query parameter binding

#### XSS Prevention
- Blade template engine auto-escapes output
- `{{ }}` syntax for safe output
- `{!! !!}` only for trusted HTML

#### Password Security
- Bcrypt hashing (default)
- Minimum 8 characters (configurable)
- Password confirmation on sensitive actions

#### Authentication (To be implemented)
```php
// Recommended for admin routes:
Route::middleware(['auth', 'verified'])->group(function () {
    // Admin routes here
});
```

### 7. Environment Security

#### Environment Variables
- Sensitive data in `.env` file
- `.env` excluded from version control
- `.env` excluded from Docker build
- Separate `.env` for different environments

#### Secrets Management
```bash
# Never commit:
- .env
- Database passwords
- API keys
- Cloudflare tokens
- Encryption keys
```

## 🔍 Security Monitoring

### Health Checks
```yaml
healthcheck:
  test: ["CMD", "curl", "-f", "http://localhost/health"]
  interval: 30s
  timeout: 10s
  retries: 3
```

### Logging
- Application logs: `/storage/logs/laravel.log`
- PHP-FPM logs: `/storage/logs/php-fpm-error.log`
- Nginx access logs: `/var/log/nginx/access.log`
- Nginx error logs: `/var/log/nginx/error.log`
- MySQL slow query log: `/var/lib/mysql/slow-query.log`

### Log Monitoring Commands
```bash
# Watch Laravel logs
docker-compose exec app tail -f storage/logs/laravel.log

# Watch Nginx access logs
docker-compose exec app tail -f /var/log/nginx/access.log

# Watch for errors
docker-compose logs -f | grep -i error
```

## 🚨 Incident Response

### Suspicious Activity Detection
```bash
# Check for failed login attempts
docker-compose exec app grep "Failed login" storage/logs/laravel.log

# Check for 404 errors (potential scanning)
docker-compose exec app grep "404" /var/log/nginx/access.log

# Check for unusual traffic patterns
docker-compose exec app tail -100 /var/log/nginx/access.log
```

### Emergency Response
```bash
# 1. Enable Cloudflare "Under Attack Mode"
# 2. Block suspicious IPs in Cloudflare
# 3. Review logs for attack patterns
# 4. Rotate credentials if compromised
# 5. Take snapshot/backup before changes

# Stop all services immediately
docker-compose down

# Review logs
docker-compose logs > incident_$(date +%Y%m%d_%H%M%S).log

# Restart with clean state
docker-compose up -d
```

## 🔐 Security Checklist

### Pre-Deployment
- [ ] Strong passwords generated (20+ characters)
- [ ] `.env` file configured with production values
- [ ] `APP_DEBUG=false`
- [ ] `APP_ENV=production`
- [ ] Database credentials secured
- [ ] Cloudflare tunnel token secured
- [ ] SSL/TLS certificate valid

### Post-Deployment
- [ ] Health checks passing
- [ ] HTTPS enforced
- [ ] Security headers verified
- [ ] Rate limiting tested
- [ ] File upload restrictions tested
- [ ] Admin routes protected
- [ ] Backup system configured
- [ ] Monitoring alerts set up
- [ ] Logs reviewed for errors
- [ ] Penetration testing completed

### Ongoing Maintenance
- [ ] Review logs weekly
- [ ] Update dependencies monthly
- [ ] Rotate passwords quarterly
- [ ] Test backups monthly
- [ ] Security audit quarterly
- [ ] Update Docker images monthly
- [ ] Review Cloudflare WAF rules monthly

## 🛠️ Security Testing

### Manual Tests
```bash
# 1. Test rate limiting
for i in {1..20}; do curl https://drbs.theonedesk.site/; done

# 2. Test security headers
curl -I https://drbs.theonedesk.site/

# 3. Test file upload limits
# Upload file > 10MB (should fail)

# 4. Test SQL injection (should be blocked)
curl "https://drbs.theonedesk.site/test?id=1' OR '1'='1"

# 5. Test XSS (should be escaped)
# Submit form with: <script>alert('XSS')</script>
```

### Automated Security Scanning
```bash
# Using OWASP ZAP (install separately)
docker run -t owasp/zap2docker-stable zap-baseline.py -t https://drbs.theonedesk.site

# Using Nikto (install separately)
nikto -h https://drbs.theonedesk.site
```

## 📋 Compliance

### Data Protection
- HTTPS encryption for data in transit
- Database encryption at rest (optional)
- Secure session management
- CSRF protection
- XSS protection

### Privacy
- No unnecessary data collection
- Secure password storage (bcrypt)
- Session timeout (120 minutes)
- Secure cookie flags

## 🔄 Security Updates

### Update Process
```bash
# 1. Backup current state
docker-compose exec db mysqldump -u drbs_user -p drbs_db > backup.sql

# 2. Update dependencies
docker-compose exec app composer update

# 3. Rebuild containers
docker-compose build --no-cache

# 4. Test in staging (if available)

# 5. Deploy to production
docker-compose up -d

# 6. Verify functionality
curl https://drbs.theonedesk.site/health

# 7. Monitor logs
docker-compose logs -f
```

### Security Patch Priority
1. **Critical**: Apply immediately (within 24 hours)
2. **High**: Apply within 1 week
3. **Medium**: Apply within 1 month
4. **Low**: Apply during regular maintenance

## 📞 Security Contacts

### Reporting Security Issues
- **Internal**: Review logs and incident response procedures
- **Cloudflare**: https://www.cloudflare.com/trust-hub/reporting-security-issues/
- **Laravel**: https://laravel.com/docs/contributions#security-vulnerabilities

### Security Resources
- OWASP Top 10: https://owasp.org/www-project-top-ten/
- Laravel Security: https://laravel.com/docs/security
- Docker Security: https://docs.docker.com/engine/security/
- Cloudflare Security: https://www.cloudflare.com/learning/security/

---

**Last Updated**: October 18, 2025
**Next Review**: January 18, 2026
