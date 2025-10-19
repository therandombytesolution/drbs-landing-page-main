# 🚀 Cloudflare-Only Deployment Guide (No Port Exposure)

## Overview

This deployment configuration is designed for servers with multiple containers where port conflicts are common. The application is **only accessible through Cloudflare Tunnel** - no local ports are exposed on the host machine.

## ✅ Benefits of This Approach

- **No Port Conflicts**: Application runs without exposing any host ports
- **Automatic HTTPS**: Cloudflare provides SSL/TLS termination
- **DDoS Protection**: Built-in Cloudflare protection
- **Zero Trust Access**: Secure tunnel without opening firewall ports
- **Multi-Container Friendly**: Perfect for servers running many containers

## 🔧 Architecture

```
Internet → Cloudflare Tunnel → Docker Network → App Container (port 80 internal only)
                                              → MySQL Container (port 3306 internal only)
```

**No ports are exposed to the host machine!**

## 📋 Prerequisites

1. **Cloudflare Account** with domain configured
2. **Cloudflare Tunnel Token** from Zero Trust dashboard
3. **Docker & Docker Compose** installed
4. **No port requirements** on host machine

## 🚀 Deployment Steps

### Step 1: Configure Environment Variables

Create a `.env` file in the project root:

```bash
# Copy from the secure template
cp .env.secure .env.production.example

# Or create manually with these required variables:
```

**Required `.env` contents:**
```env
# Docker Database Credentials
DB_PASSWORD=YOUR_STRONG_PASSWORD_HERE
MYSQL_ROOT_PASSWORD=YOUR_STRONG_ROOT_PASSWORD_HERE

# Cloudflare Tunnel Token (from https://one.dash.cloudflare.com/)
CLOUDFLARE_TUNNEL_TOKEN=your_actual_tunnel_token_here
```

**⚠️ IMPORTANT**: 
- Replace `YOUR_STRONG_PASSWORD_HERE` with a secure password (32+ characters)
- Get your Cloudflare token from: https://one.dash.cloudflare.com/
- Never commit the `.env` file to git

### Step 2: Build Docker Images

```bash
# Build all containers
docker-compose build --no-cache
```

This will:
- Build the Laravel application container
- Pull MySQL 8.0 image
- Pull Cloudflare Tunnel image

### Step 3: Start Services

```bash
# Start all services in detached mode
docker-compose up -d
```

**Expected Output:**
```
✔ Container drbs-mysql              Started
✔ Container drbs-app                Started
✔ Container drbs-cloudflare-tunnel  Started
```

### Step 4: Initialize Application

```bash
# 1. Generate Laravel application key
docker-compose exec app php artisan key:generate

# 2. Run database migrations
docker-compose exec app php artisan migrate --force

# 3. Cache configuration for performance
docker-compose exec app php artisan config:cache
docker-compose exec app php artisan route:cache
docker-compose exec app php artisan view:cache

# 4. Set proper permissions
docker-compose exec app chown -R www-data:www-data /var/www/html/storage
docker-compose exec app chmod -R 755 /var/www/html/storage
```

### Step 5: Verify Deployment

Check that all containers are healthy:

```bash
docker-compose ps
```

**Expected Output:**
```
NAME                         STATUS
drbs-app                     Up (healthy)
drbs-mysql                   Up (healthy)
drbs-cloudflare-tunnel       Up (healthy)
```

**Access your application:**
- **Public URL**: https://drbs.theonedesk.site
- **Health Check**: https://drbs.theonedesk.site/health

**Note**: There is NO local access (no localhost URL) - this is by design!

## 🔍 Verification & Testing

### Check Cloudflare Tunnel Status

```bash
# View tunnel logs
docker-compose logs cloudflared

# Should show: "Connection established" or "Registered tunnel connection"
```

### Test Application Health

```bash
# From inside the tunnel container
docker-compose exec cloudflared wget -O- http://app:80/health

# Should return: "healthy"
```

### Check Application Logs

```bash
# Real-time logs from all services
docker-compose logs -f

# Application logs only
docker-compose logs -f app

# Database logs only
docker-compose logs -f db
```

## 🎯 Container Network Communication

All containers communicate through the internal Docker network (`drbs-network`):

- **App Container**: Accessible as `app:80` (internal only)
- **MySQL Container**: Accessible as `db:3306` (internal only)
- **Cloudflare Tunnel**: Routes external traffic to `app:80`

**No ports are exposed to the host!**

## 🔒 Security Features

### Network Isolation
- ✅ All containers on isolated bridge network
- ✅ No host port exposure
- ✅ Database only accessible from app container
- ✅ Cloudflare Tunnel provides secure ingress

### Container Security
- ✅ Non-root user execution
- ✅ Dropped all capabilities (CAP_DROP ALL)
- ✅ No-new-privileges flag
- ✅ Read-only filesystem where possible
- ✅ Security headers (CSP, X-Frame-Options, etc.)

### Application Security
- ✅ PHP dangerous functions disabled
- ✅ Session security (httponly, secure, samesite)
- ✅ HTTPS enforced via Cloudflare
- ✅ Rate limiting configured
- ✅ CSRF protection enabled

## 📊 Monitoring & Maintenance

### Check Service Health

```bash
# Quick status check
docker-compose ps

# Detailed health status
docker inspect drbs-app | grep -A 10 Health
docker inspect drbs-mysql | grep -A 10 Health
docker inspect drbs-cloudflare-tunnel | grep -A 10 Health
```

### View Application Logs

```bash
# Laravel application logs
docker-compose exec app tail -f storage/logs/laravel.log

# PHP error logs
docker-compose exec app tail -f storage/logs/php-error.log

# Apache access logs
docker-compose exec app tail -f /var/log/apache2/access.log

# Apache error logs
docker-compose exec app tail -f /var/log/apache2/error.log
```

### Database Management

```bash
# Access MySQL CLI
docker-compose exec db mysql -u drbs_user -p drbs_db
# Enter password when prompted

# Create database backup
docker-compose exec db mysqldump -u drbs_user -p drbs_db > backup_$(date +%Y%m%d_%H%M%S).sql

# Restore database
docker-compose exec -T db mysql -u drbs_user -p drbs_db < backup_file.sql
```

### Resource Monitoring

```bash
# Real-time resource usage
docker stats

# Disk usage
docker system df

# Container details
docker-compose top
```

## 🔄 Common Operations

### Restart Services

```bash
# Restart all services
docker-compose restart

# Restart specific service
docker-compose restart app
docker-compose restart db
docker-compose restart cloudflared
```

### Update Application Code

```bash
# Pull latest code (if using git)
git pull origin main

# Rebuild and restart
docker-compose up -d --build

# Clear Laravel caches
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan route:clear
docker-compose exec app php artisan view:clear

# Re-cache for performance
docker-compose exec app php artisan config:cache
docker-compose exec app php artisan route:cache
docker-compose exec app php artisan view:cache
```

### Stop Services

```bash
# Stop all services (keeps containers)
docker-compose stop

# Stop and remove containers (keeps volumes/data)
docker-compose down

# Stop and remove everything including data (⚠️ DANGER)
docker-compose down -v
```

## 🆘 Troubleshooting

### Issue: Cloudflare Tunnel Not Connecting

**Symptoms**: Cannot access https://drbs.theonedesk.site

**Solutions**:
```bash
# 1. Check tunnel logs
docker-compose logs cloudflared

# 2. Verify token is correct
docker-compose exec cloudflared env | grep CLOUDFLARE

# 3. Restart tunnel
docker-compose restart cloudflared

# 4. Test internal connectivity
docker-compose exec cloudflared wget -O- http://app:80/health
```

### Issue: Database Connection Failed

**Symptoms**: Application shows database connection errors

**Solutions**:
```bash
# 1. Check MySQL is running and healthy
docker-compose ps db

# 2. View MySQL logs
docker-compose logs db

# 3. Verify credentials match
docker-compose exec app cat .env | grep DB_

# 4. Test connection from app container
docker-compose exec app php artisan tinker
>>> DB::connection()->getPdo();
```

### Issue: Application Returns 500 Error

**Symptoms**: White screen or 500 error on website

**Solutions**:
```bash
# 1. Check Laravel logs
docker-compose exec app tail -50 storage/logs/laravel.log

# 2. Check permissions
docker-compose exec app ls -la storage/

# 3. Fix permissions if needed
docker-compose exec app chown -R www-data:www-data /var/www/html/storage
docker-compose exec app chmod -R 755 /var/www/html/storage

# 4. Clear all caches
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan view:clear
```

### Issue: Container Keeps Restarting

**Symptoms**: Container status shows "Restarting"

**Solutions**:
```bash
# 1. Check container logs
docker-compose logs app

# 2. Check health check status
docker inspect drbs-app | grep -A 20 Health

# 3. Test health endpoint manually
docker-compose exec app curl -f http://localhost/health

# 4. Restart with fresh state
docker-compose down
docker-compose up -d
```

## 🔐 Security Recommendations

### Cloudflare Configuration

1. **SSL/TLS Mode**: Set to "Full (strict)" in Cloudflare dashboard
2. **Always Use HTTPS**: Enable in SSL/TLS settings
3. **HSTS**: Enable with max-age of 31536000
4. **WAF Rules**: Configure Web Application Firewall
5. **Rate Limiting**: Set up rate limits for sensitive endpoints
6. **Bot Fight Mode**: Enable to block malicious bots

### Password Management

1. **Generate Strong Passwords**:
   ```powershell
   # PowerShell method
   Add-Type -AssemblyName System.Web
   [System.Web.Security.Membership]::GeneratePassword(32,10)
   ```

2. **Store Securely**: Use a password manager (1Password, Bitwarden, etc.)

3. **Rotate Regularly**: Change passwords every 90 days

### Backup Strategy

```bash
# Create automated backup script
cat > backup.sh << 'EOF'
#!/bin/bash
BACKUP_DIR="./backups"
DATE=$(date +%Y%m%d_%H%M%S)

mkdir -p $BACKUP_DIR

# Backup database
docker-compose exec -T db mysqldump -u drbs_user -p$DB_PASSWORD drbs_db | gzip > $BACKUP_DIR/db_$DATE.sql.gz

# Backup storage directory
tar -czf $BACKUP_DIR/storage_$DATE.tar.gz storage/

# Keep only last 7 days of backups
find $BACKUP_DIR -name "*.gz" -mtime +7 -delete

echo "Backup completed: $DATE"
EOF

chmod +x backup.sh

# Add to cron (Linux) or Task Scheduler (Windows)
```

## 📈 Performance Optimization

### OPcache (Already Enabled)
- Configured in `docker/php/local.ini`
- Validates timestamps disabled for production
- 128MB memory allocation

### Database Optimization

```bash
# Optimize tables
docker-compose exec db mysql -u drbs_user -p -e "OPTIMIZE TABLE registrations, tickets;" drbs_db

# Analyze tables
docker-compose exec db mysql -u drbs_user -p -e "ANALYZE TABLE registrations, tickets;" drbs_db
```

### Laravel Optimization

```bash
# Run all optimization commands
docker-compose exec app php artisan optimize
docker-compose exec app php artisan config:cache
docker-compose exec app php artisan route:cache
docker-compose exec app php artisan view:cache
```

## 📞 Quick Reference

### Essential Commands

```bash
# Start everything
docker-compose up -d

# Check status
docker-compose ps

# View logs
docker-compose logs -f

# Access app shell
docker-compose exec app bash

# Access database
docker-compose exec db mysql -u drbs_user -p drbs_db

# Restart all
docker-compose restart

# Stop all
docker-compose down

# Update and restart
git pull && docker-compose up -d --build
```

### Important URLs

- **Public Access**: https://drbs.theonedesk.site
- **Health Check**: https://drbs.theonedesk.site/health
- **Cloudflare Dashboard**: https://one.dash.cloudflare.com/
- **Admin Panel**: https://drbs.theonedesk.site/admin (add authentication!)

## ✅ Deployment Checklist

- [ ] `.env` file created with secure passwords
- [ ] Cloudflare Tunnel token configured
- [ ] Docker images built successfully
- [ ] All containers started and healthy
- [ ] APP_KEY generated
- [ ] Database migrations run
- [ ] Laravel caches optimized
- [ ] Storage permissions set correctly
- [ ] Public URL accessible (https://drbs.theonedesk.site)
- [ ] Health check passing
- [ ] Cloudflare SSL/TLS configured
- [ ] WAF rules enabled
- [ ] Backup strategy implemented
- [ ] Monitoring configured

---

## 🎉 Success!

Your application is now deployed and accessible **only through Cloudflare Tunnel** with:
- ✅ No port conflicts
- ✅ Automatic HTTPS
- ✅ DDoS protection
- ✅ Zero Trust security
- ✅ Production-ready configuration

**Access your application at**: https://drbs.theonedesk.site
