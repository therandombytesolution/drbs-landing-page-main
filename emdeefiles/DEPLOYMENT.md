# 🚀 Secure Docker Deployment Guide

## 📋 Prerequisites

- **Docker Desktop** installed and running
- **Cloudflare Tunnel** token (provided)
- **Git** (optional, for version control)

## 🔒 Security Features Implemented

### Application Security
- ✅ Non-root user execution
- ✅ Read-only filesystem where possible
- ✅ Dropped unnecessary Linux capabilities
- ✅ Security headers (CSP, X-Frame-Options, etc.)
- ✅ Rate limiting on endpoints
- ✅ PHP security hardening (disabled dangerous functions)
- ✅ Session security (httponly, secure, samesite)
- ✅ HTTPS enforcement via Cloudflare

### Container Security
- ✅ No new privileges flag
- ✅ Minimal capability set (CAP_DROP ALL)
- ✅ Health checks for all services
- ✅ Isolated network
- ✅ Resource limits
- ✅ Secure environment variable handling

### Database Security
- ✅ Strong password requirements
- ✅ Limited connections
- ✅ No remote root access
- ✅ Encrypted connections
- ✅ Isolated network access

## 📁 Project Structure

```
drbs-landing-page/
├── docker/
│   ├── nginx/
│   │   └── default.conf          # Nginx with security headers
│   ├── php/
│   │   ├── local.ini              # PHP security configuration
│   │   └── php-fpm.conf           # PHP-FPM settings
│   ├── mysql/
│   │   └── my.cnf                 # MySQL security settings
│   └── supervisor/
│       └── supervisord.conf       # Process manager
├── Dockerfile                      # Secure container build
├── docker-compose.yml              # Orchestration with security
├── .dockerignore                   # Exclude sensitive files
├── .env.docker.example             # Environment template
└── .env.secure                     # Secure credentials template
```

## 🛠️ Deployment Steps

### Step 1: Prepare Environment Variables

1. **Create secure passwords:**
```bash
# Generate strong passwords (use a password manager)
# Example using PowerShell:
Add-Type -AssemblyName System.Web
[System.Web.Security.Membership]::GeneratePassword(32,10)
```

2. **Create `.env` file:**
```bash
# Copy the example file
cp .env.docker.example .env

# Edit .env and set these critical values:
# - APP_KEY (will be generated in step 3)
# - DB_PASSWORD (use a strong password)
# - MYSQL_ROOT_PASSWORD (use a different strong password)
```

3. **Create `.env` file in root with Docker credentials:**
```env
DB_PASSWORD=YOUR_SECURE_DB_PASSWORD_HERE
MYSQL_ROOT_PASSWORD=YOUR_SECURE_ROOT_PASSWORD_HERE
CLOUDFLARE_TUNNEL_TOKEN=eyJhIjoiYmUzYTVmZjhlOGRmZWE0YmE4NzExYTFlYjE2YzgxYTgiLCJ0IjoiM2U2NzVjMjktMzQ0Yi00ZDQzLWIzM2QtZDJmYzE1MWI5M2VhIiwicyI6IlpqTXlOMll4TWpndE0yTXpOaTAwTWpCbExXRTVNVGN0TlRJMFlXRTFaR013TkRGayJ9
```

### Step 2: Build Docker Images

```bash
# Build the application container
docker-compose build --no-cache
```

### Step 3: Generate Application Key

```bash
# Generate Laravel application key
docker-compose run --rm app php artisan key:generate
```

### Step 4: Start Services

```bash
# Start all containers in detached mode
docker-compose up -d

# Check if all services are running
docker-compose ps
```

Expected output:
```
NAME                         STATUS              PORTS
drbs-app                     Up (healthy)        0.0.0.0:8080->80/tcp
drbs-mysql                   Up (healthy)        0.0.0.0:3307->3306/tcp
drbs-cloudflare-tunnel       Up (healthy)
```

### Step 5: Run Database Migrations

```bash
# Run migrations
docker-compose exec app php artisan migrate --force

# (Optional) Seed database if you have seeders
docker-compose exec app php artisan db:seed --force
```

### Step 6: Optimize Application

```bash
# Cache configuration
docker-compose exec app php artisan config:cache

# Cache routes
docker-compose exec app php artisan route:cache

# Cache views
docker-compose exec app php artisan view:cache

# Optimize autoloader
docker-compose exec app php artisan optimize
```

### Step 7: Set Proper Permissions

```bash
# Ensure storage and cache directories are writable
docker-compose exec app chown -R www-data:www-data /var/www/html/storage
docker-compose exec app chown -R www-data:www-data /var/www/html/bootstrap/cache
docker-compose exec app chmod -R 755 /var/www/html/storage
docker-compose exec app chmod -R 755 /var/www/html/bootstrap/cache
```

### Step 8: Verify Deployment

1. **Local Access:**
   - Open browser: http://localhost:8080
   - Check health: http://localhost:8080/health

2. **Public Access:**
   - Open browser: https://drbs.theonedesk.site
   - Verify SSL certificate (Cloudflare)

3. **Check Logs:**
```bash
# View all logs
docker-compose logs -f

# View specific service
docker-compose logs -f app
docker-compose logs -f cloudflared
```

## 🔍 Monitoring & Maintenance

### Health Checks

```bash
# Check container health status
docker-compose ps

# Manual health check
curl http://localhost:8080/health
```

### View Logs

```bash
# Real-time logs (all services)
docker-compose logs -f

# Application logs
docker-compose exec app tail -f storage/logs/laravel.log

# Nginx access logs
docker-compose exec app tail -f /var/log/nginx/access.log

# Nginx error logs
docker-compose exec app tail -f /var/log/nginx/error.log

# PHP-FPM logs
docker-compose exec app tail -f storage/logs/php-fpm-error.log
```

### Database Access

```bash
# Access MySQL CLI
docker-compose exec db mysql -u drbs_user -p drbs_db

# Backup database
docker-compose exec db mysqldump -u drbs_user -p drbs_db > backup_$(date +%Y%m%d_%H%M%S).sql

# Restore database
docker-compose exec -T db mysql -u drbs_user -p drbs_db < backup_file.sql
```

### Container Management

```bash
# Restart all services
docker-compose restart

# Restart specific service
docker-compose restart app

# Stop all services
docker-compose stop

# Stop and remove containers (keeps volumes)
docker-compose down

# Stop and remove everything including volumes (⚠️ DANGER: Deletes database)
docker-compose down -v

# View resource usage
docker stats
```

## 🔄 Updates & Maintenance

### Update Application Code

```bash
# Pull latest code (if using git)
git pull origin main

# Rebuild and restart
docker-compose up -d --build

# Clear caches
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan route:clear
docker-compose exec app php artisan view:clear

# Re-cache
docker-compose exec app php artisan config:cache
docker-compose exec app php artisan route:cache
docker-compose exec app php artisan view:cache
```

### Update Docker Images

```bash
# Pull latest base images
docker-compose pull

# Rebuild containers
docker-compose up -d --build
```

## 🛡️ Security Best Practices

### 1. Password Management
- ✅ Use strong, unique passwords (minimum 20 characters)
- ✅ Store passwords in a password manager
- ✅ Never commit `.env` file to version control
- ✅ Rotate passwords regularly (every 90 days)

### 2. SSL/TLS
- ✅ Always use HTTPS (handled by Cloudflare)
- ✅ Enable Cloudflare SSL/TLS mode: "Full (strict)"
- ✅ Enable HSTS in Cloudflare dashboard

### 3. Cloudflare Security Settings
- ✅ Enable "Under Attack Mode" if experiencing DDoS
- ✅ Configure WAF (Web Application Firewall) rules
- ✅ Enable Bot Fight Mode
- ✅ Set up rate limiting rules
- ✅ Enable "Always Use HTTPS"

### 4. Regular Updates
```bash
# Update composer dependencies (monthly)
docker-compose exec app composer update

# Update system packages in container (rebuild required)
docker-compose build --no-cache
docker-compose up -d
```

### 5. Backup Strategy
```bash
# Daily database backup (add to cron/Task Scheduler)
docker-compose exec db mysqldump -u drbs_user -p drbs_db | gzip > backups/db_$(date +%Y%m%d).sql.gz

# Weekly full backup (database + uploads)
tar -czf backups/full_$(date +%Y%m%d).tar.gz storage/ backups/db_$(date +%Y%m%d).sql.gz
```

### 6. Monitoring
- ✅ Set up uptime monitoring (UptimeRobot, Pingdom)
- ✅ Monitor disk space: `docker system df`
- ✅ Monitor container resources: `docker stats`
- ✅ Review logs regularly for suspicious activity

## 🚨 Troubleshooting

### Issue: Containers won't start

```bash
# Check logs
docker-compose logs

# Check Docker Desktop is running
docker ps

# Remove and recreate containers
docker-compose down
docker-compose up -d
```

### Issue: Permission Denied Errors

```bash
# Fix storage permissions
docker-compose exec app chown -R www-data:www-data /var/www/html/storage
docker-compose exec app chmod -R 755 /var/www/html/storage
```

### Issue: Database Connection Failed

```bash
# Check if MySQL is running
docker-compose ps db

# Check MySQL logs
docker-compose logs db

# Verify credentials in .env match docker-compose.yml
docker-compose exec app cat .env | grep DB_
```

### Issue: 500 Internal Server Error

```bash
# Check Laravel logs
docker-compose exec app tail -50 storage/logs/laravel.log

# Check PHP-FPM logs
docker-compose exec app tail -50 storage/logs/php-fpm-error.log

# Clear all caches
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan route:clear
docker-compose exec app php artisan view:clear
```

### Issue: Cloudflare Tunnel Not Working

```bash
# Check cloudflared logs
docker-compose logs cloudflared

# Verify token is correct in docker-compose.yml
# Restart tunnel
docker-compose restart cloudflared

# Check if app is accessible from tunnel container
docker-compose exec cloudflared wget -O- http://app:80/health
```

### Issue: High Memory Usage

```bash
# Check resource usage
docker stats

# Restart services to clear memory
docker-compose restart

# Adjust PHP-FPM settings in docker/php/php-fpm.conf
# Reduce pm.max_children if needed
```

## 📊 Performance Optimization

### Enable OPcache (Already configured)
- OPcache is enabled in `docker/php/local.ini`
- Validates timestamps disabled for production

### Database Optimization
```bash
# Optimize tables
docker-compose exec db mysql -u drbs_user -p -e "OPTIMIZE TABLE registrations, tickets;"

# Analyze tables
docker-compose exec db mysql -u drbs_user -p -e "ANALYZE TABLE registrations, tickets;"
```

### Nginx Caching
- Static assets cached for 30 days
- Gzip compression enabled

## 🔐 Security Checklist

Before going live, verify:

- [ ] Strong passwords set for DB_PASSWORD and MYSQL_ROOT_PASSWORD
- [ ] APP_DEBUG=false in .env
- [ ] APP_ENV=production in .env
- [ ] APP_KEY generated
- [ ] SSL/TLS enabled in Cloudflare (Full strict mode)
- [ ] Cloudflare WAF rules configured
- [ ] Rate limiting tested
- [ ] Health checks passing
- [ ] Backups configured
- [ ] Monitoring set up
- [ ] Logs reviewed for errors
- [ ] Admin routes protected (add authentication)
- [ ] CSRF protection enabled (Laravel default)
- [ ] XSS protection headers active
- [ ] File upload limits configured
- [ ] Database backups automated

## 📞 Support

For issues or questions:
1. Check logs: `docker-compose logs -f`
2. Review Laravel logs: `docker-compose exec app tail -f storage/logs/laravel.log`
3. Check container health: `docker-compose ps`

## 🎯 Quick Reference Commands

```bash
# Start
docker-compose up -d

# Stop
docker-compose down

# Restart
docker-compose restart

# Logs
docker-compose logs -f

# Shell access
docker-compose exec app bash

# Run artisan commands
docker-compose exec app php artisan [command]

# Database backup
docker-compose exec db mysqldump -u drbs_user -p drbs_db > backup.sql

# Update code and restart
git pull && docker-compose up -d --build
```

---

**🎉 Deployment Complete!**

Your application is now securely deployed and accessible at:
- **Local**: http://localhost:8080
- **Public**: https://drbs.theonedesk.site
