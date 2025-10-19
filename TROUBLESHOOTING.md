# 🔧 Docker Build & Deployment Troubleshooting

## Common Build Errors and Solutions

### 1. ❌ Error: `proc_open` is not available

**Error Message:**
```
The Process class relies on proc_open, which is not available on your PHP installation.
```

**Cause:** PHP security settings disabled `proc_open` before Composer scripts ran.

**Solution:** ✅ **FIXED** - The Dockerfile has been reordered to apply security settings AFTER Composer operations.

**Verification:**
```bash
docker-compose build
```

---

### 2. ⚠️ Warning: CLOUDFLARE_TUNNEL_TOKEN variable not set

**Error Message:**
```
The "CLOUDFLARE_TUNNEL_TOKEN" variable is not set. Defaulting to a blank string.
```

**Cause:** Environment variable not configured.

**Solution:**

**Option A: Create .env file (Recommended)**
```bash
# Copy template
cp .env.docker .env

# Edit and add your token
# CLOUDFLARE_TUNNEL_TOKEN=your_actual_token_here
```

**Option B: Set in shell**
```powershell
# PowerShell
$env:CLOUDFLARE_TUNNEL_TOKEN="your_token_here"
docker-compose build
```

**Option C: Inline with command**
```bash
CLOUDFLARE_TUNNEL_TOKEN=your_token docker-compose up -d
```

**Get your token from:** https://one.dash.cloudflare.com/

---

### 3. ⚠️ Warning: `version` attribute is obsolete

**Error Message:**
```
the attribute `version` is obsolete, it will be ignored
```

**Solution:** ✅ **FIXED** - Removed `version: '3.8'` from `docker-compose.yml`.

---

### 4. ❌ Error: Port already in use

**Error Message:**
```
Bind for 0.0.0.0:8080 failed: port is already allocated
```

**Solution:**

**Check what's using the port:**
```powershell
# Windows
netstat -ano | findstr :8080

# Find and kill the process
taskkill /PID <process_id> /F
```

**Or change the port in docker-compose.yml:**
```yaml
ports:
  - "8081:80"  # Change 8080 to 8081
```

---

### 5. ❌ Error: Permission denied on storage

**Error Message:**
```
failed to open stream: Permission denied
```

**Solution:**
```bash
# Fix permissions
docker-compose exec app chown -R www-data:www-data /var/www/html/storage
docker-compose exec app chmod -R 755 /var/www/html/storage
docker-compose exec app chmod -R 755 /var/www/html/bootstrap/cache
```

---

### 6. ❌ Error: Database connection refused

**Error Message:**
```
SQLSTATE[HY000] [2002] Connection refused
```

**Solution:**

**Wait for MySQL to be ready:**
```bash
# Check MySQL health
docker-compose ps db

# View MySQL logs
docker-compose logs db

# Restart if needed
docker-compose restart db

# Wait 30 seconds, then retry
```

---

### 7. ❌ Error: Composer install fails

**Error Message:**
```
Failed to download package from dist
```

**Solution:**

**Clear Docker cache and rebuild:**
```bash
# Remove old images
docker-compose down
docker system prune -a

# Rebuild without cache
docker-compose build --no-cache
```

---

### 8. ❌ Error: Out of disk space

**Error Message:**
```
no space left on device
```

**Solution:**
```bash
# Clean up Docker
docker system prune -a --volumes

# Remove unused images
docker image prune -a

# Check disk space
docker system df
```

---

## 🚀 Clean Rebuild Process

If you encounter persistent issues, follow this clean rebuild:

```bash
# 1. Stop and remove everything
docker-compose down -v

# 2. Remove all related images
docker rmi $(docker images | grep drbs | awk '{print $3}')

# 3. Clean Docker system
docker system prune -f

# 4. Rebuild from scratch
docker-compose build --no-cache

# 5. Start services
docker-compose up -d

# 6. Check logs
docker-compose logs -f
```

---

## 🔍 Debugging Commands

### Check Container Status
```bash
docker-compose ps
docker-compose logs app
docker-compose logs db
```

### Access Container Shell
```bash
# App container
docker-compose exec app bash

# Check PHP configuration
docker-compose exec app php -i | grep disable_functions

# Check Composer
docker-compose exec app composer --version
```

### Test Database Connection
```bash
# From app container
docker-compose exec app php artisan tinker
>>> DB::connection()->getPdo();
```

### Monitor Resources
```bash
# Real-time stats
docker stats

# Disk usage
docker system df
```

---

## 📝 Pre-Build Checklist

Before running `docker-compose build`, ensure:

- [ ] `.env` file exists with `CLOUDFLARE_TUNNEL_TOKEN`
- [ ] Port 8080 is available (or changed in docker-compose.yml)
- [ ] Docker Desktop is running
- [ ] You have sufficient disk space (at least 5GB free)
- [ ] No other DRBS containers are running
- [ ] `composer.json` and `composer.lock` exist

---

## 🆘 Still Having Issues?

### Check Build Context
```bash
# Verify files are present
ls -la composer.json composer.lock
ls -la docker/php/
ls -la docker/nginx/
```

### Verify Docker Installation
```bash
docker --version
docker-compose --version
docker info
```

### Review Dockerfile Changes
The Dockerfile has been optimized to:
1. ✅ Use `composer.ini` during build (allows `proc_open`)
2. ✅ Run all Composer operations with permissive settings
3. ✅ Apply `local.ini` security settings AFTER Composer
4. ✅ Ensure proper file ordering

---

## 📞 Support Resources

- **Docker Logs:** `docker-compose logs -f`
- **Laravel Logs:** `docker-compose exec app tail -f storage/logs/laravel.log`
- **PHP Errors:** `docker-compose exec app tail -f storage/logs/php-error.log`

---

## ✅ Success Indicators

After successful build and deployment:

```bash
$ docker-compose ps
NAME                         STATUS              PORTS
drbs-app                     Up (healthy)        0.0.0.0:8080->80/tcp
drbs-mysql                   Up (healthy)        0.0.0.0:3307->3306/tcp
drbs-cloudflare-tunnel       Up (healthy)
```

Test endpoints:
- http://localhost:8080 - Should show landing page
- http://localhost:8080/health - Should return 200 OK
