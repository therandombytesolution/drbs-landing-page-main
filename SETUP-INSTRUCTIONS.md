# 🚀 Quick Setup Instructions - Cloudflare-Only Deployment

## ⚡ Fast Track (5 Minutes)

This setup uses **Cloudflare Tunnel only** - no local ports are exposed, perfect for servers with multiple containers.

### Step 1: Create Environment File

```powershell
# Copy the template
Copy-Item .env.secure .env.production.example

# Edit and set your values
notepad .env.production.example
```

**Required values to change:**
```env
DB_PASSWORD=YOUR_STRONG_PASSWORD_32_CHARS_MIN
MYSQL_ROOT_PASSWORD=YOUR_DIFFERENT_STRONG_PASSWORD
CLOUDFLARE_TUNNEL_TOKEN=your_cloudflare_token_from_dashboard
```

**Get Cloudflare Token**: https://one.dash.cloudflare.com/

### Step 2: Deploy Using Script

```powershell
# Build and start everything
.\docker-deploy.ps1 -Build -Start
```

### Step 3: Initialize Application

```powershell
# Generate app key
docker-compose exec app php artisan key:generate

# Run migrations
docker-compose exec app php artisan migrate --force

# Optimize for production
docker-compose exec app php artisan config:cache
docker-compose exec app php artisan route:cache
docker-compose exec app php artisan view:cache

# Set permissions
docker-compose exec app chown -R www-data:www-data /var/www/html/storage
docker-compose exec app chmod -R 755 /var/www/html/storage
```

### Step 4: Verify

Visit: **https://drbs.theonedesk.site**

Check health: **https://drbs.theonedesk.site/health**

---

## ✅ What You Get

- ✅ **No Port Conflicts**: No ports exposed on host
- ✅ **Automatic HTTPS**: Cloudflare SSL/TLS
- ✅ **DDoS Protection**: Built-in Cloudflare security
- ✅ **Zero Trust**: Secure tunnel access
- ✅ **Production Ready**: All security hardening applied

---

## 📋 Manual Deployment (Alternative)

If you prefer manual commands:

```powershell
# 1. Create .env file (copy from template and edit)
Copy-Item .env.secure .env.production.example

# 2. Build images
docker-compose build --no-cache

# 3. Start services
docker-compose up -d

# 4. Initialize app
docker-compose exec app php artisan key:generate
docker-compose exec app php artisan migrate --force
docker-compose exec app php artisan config:cache
docker-compose exec app php artisan route:cache
docker-compose exec app php artisan view:cache

# 5. Fix permissions
docker-compose exec app chown -R www-data:www-data /var/www/html/storage
docker-compose exec app chmod -R 755 /var/www/html/storage

# 6. Check status
docker-compose ps
```

---

## 🔍 Verify Deployment

```powershell
# Check all containers are healthy
docker-compose ps

# Expected output:
# NAME                         STATUS
# drbs-app                     Up (healthy)
# drbs-mysql                   Up (healthy)
# drbs-cloudflare-tunnel       Up (healthy)

# View logs
docker-compose logs -f
```

---

## 🆘 Troubleshooting

### Container won't start?
```powershell
docker-compose logs app
docker-compose down
docker-compose up -d
```

### Can't access website?
```powershell
# Check Cloudflare tunnel
docker-compose logs cloudflared

# Restart tunnel
docker-compose restart cloudflared
```

### Database connection error?
```powershell
# Check MySQL is running
docker-compose ps db

# View MySQL logs
docker-compose logs db
```

---

## 📚 Full Documentation

- **CLOUDFLARE-ONLY-DEPLOYMENT.md** - Complete deployment guide
- **TROUBLESHOOTING.md** - Detailed troubleshooting
- **FIXES-APPLIED.md** - Technical details

---

## 🎯 Important Notes

1. **No Local Access**: Application is only accessible via Cloudflare Tunnel
2. **No Port Exposure**: Perfect for multi-container servers
3. **HTTPS Only**: All traffic goes through Cloudflare SSL
4. **Zero Configuration**: No port mapping needed

---

## 🔐 Security Checklist

- [ ] Strong passwords set (32+ characters)
- [ ] Cloudflare Tunnel token configured
- [ ] APP_KEY generated
- [ ] Cloudflare SSL/TLS set to "Full (strict)"
- [ ] WAF rules enabled in Cloudflare
- [ ] Admin routes protected (add authentication!)

---

**🎉 You're ready to deploy!**

Run: `.\docker-deploy.ps1 -Build -Start`
