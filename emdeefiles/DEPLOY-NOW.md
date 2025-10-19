# 🚀 Ready to Deploy - All Configured!

Your password has been set: `Pa$$w*rd@DanDrev029`

## ⚠️ IMPORTANT: Before Building

### Set Environment Variables

Create a `.env` file in the project root:

```bash
# Copy the template
cp .env.docker .env

# Edit the file and set your Cloudflare Tunnel Token
# Get your token from: https://one.dash.cloudflare.com/
```

Or set it directly in your shell:

```powershell
# PowerShell
$env:CLOUDFLARE_TUNNEL_TOKEN="your_token_here"

# Or add to .env file
echo "CLOUDFLARE_TUNNEL_TOKEN=your_token_here" > .env
```

## ⚡ Deploy in 3 Steps

### Step 1: Build and Start Services

```powershell
# Option A: Using the deployment script (Recommended)
.\docker-deploy.ps1 -Build -Start

# Option B: Manual commands
docker-compose build
docker-compose up -d
```

### Step 2: Initialize Application

```powershell
# Generate application key
docker-compose exec app php artisan key:generate

# Run database migrations
docker-compose exec app php artisan migrate --force

# Cache configuration for performance
docker-compose exec app php artisan config:cache
docker-compose exec app php artisan route:cache
docker-compose exec app php artisan view:cache

# Set proper permissions
docker-compose exec app chown -R www-data:www-data /var/www/html/storage
docker-compose exec app chmod -R 755 /var/www/html/storage
```

### Step 3: Verify Deployment

Open your browser:
- **Local**: http://localhost:8080
- **Public**: https://drbs.theonedesk.site
- **Health Check**: http://localhost:8080/health

Check status:
```powershell
docker-compose ps
```

Expected output:
```
NAME                         STATUS              PORTS
drbs-app                     Up (healthy)        0.0.0.0:8080->80/tcp
drbs-mysql                   Up (healthy)        0.0.0.0:3307->3306/tcp
drbs-cloudflare-tunnel       Up (healthy)
```

## 📋 Configuration Summary

✅ **Database Password**: Pa$$w*rd@DanDrev029  
✅ **MySQL Root Password**: Pa$$w*rd@DanDrev029  
✅ **Cloudflare Tunnel**: Configured  
✅ **Domain**: drbs.theonedesk.site  
✅ **Security**: All best practices implemented  

## 🎯 Quick Commands

```powershell
# View logs
docker-compose logs -f

# Check status
docker-compose ps

# Restart services
docker-compose restart

# Stop services
docker-compose stop

# Access app shell
docker-compose exec app bash

# Access database
docker-compose exec db mysql -u drbs_user -pPa\$\$w\*rd@DanDrev029 drbs_db
```

## 🔒 Security Notes

- Password is configured in `docker-compose.yml` with environment variable fallback
- All security headers are active (CSP, X-Frame-Options, etc.)
- Rate limiting is enabled (10 req/s general, 5 req/min for auth)
- PHP dangerous functions are disabled
- Container capabilities are minimized
- HTTPS enforced via Cloudflare

## 📊 Monitoring

```powershell
# Real-time logs
docker-compose logs -f

# Application logs
docker-compose exec app tail -f storage/logs/laravel.log

# Resource usage
docker stats

# Health check
curl http://localhost:8080/health
```

## 🆘 Troubleshooting

### If containers fail to start:
```powershell
docker-compose down
docker-compose up -d
docker-compose logs
```

### If you get permission errors:
```powershell
docker-compose exec app chown -R www-data:www-data /var/www/html/storage
docker-compose exec app chmod -R 755 /var/www/html/storage
```

### If database connection fails:
```powershell
# Check MySQL is running
docker-compose ps db

# View MySQL logs
docker-compose logs db
```

## 🎉 You're All Set!

Everything is configured and ready to deploy. Just run the commands in Step 1 above!

For detailed documentation, see:
- `DEPLOYMENT.md` - Full deployment guide
- `SECURITY.md` - Security details
- `QUICK-START.md` - Quick reference
