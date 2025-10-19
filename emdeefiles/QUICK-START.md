# 🚀 Quick Start Guide

Get your DRBS Landing Page deployed in 5 minutes!

## Prerequisites

✅ Docker Desktop installed and running  
✅ Cloudflare tunnel token (provided)

## Step 1: Configure Environment

Create `.env` file in the root directory with these values:

```env
# Copy from .env.docker.example and update these:
DB_PASSWORD=YOUR_SECURE_PASSWORD_HERE
MYSQL_ROOT_PASSWORD=YOUR_SECURE_ROOT_PASSWORD_HERE
CLOUDFLARE_TUNNEL_TOKEN=eyJhIjoiYmUzYTVmZjhlOGRmZWE0YmE4NzExYTFlYjE2YzgxYTgiLCJ0IjoiM2U2NzVjMjktMzQ0Yi00ZDQzLWIzM2QtZDJmYzE1MWI5M2VhIiwicyI6IlpqTXlOMll4TWpndE0yTXpOaTAwTWpCbExXRTVNVGN0TlRJMFlXRTFaR013TkRGayJ9
```

**⚠️ IMPORTANT**: Replace `YOUR_SECURE_PASSWORD_HERE` with strong passwords!

## Step 2: Deploy Using PowerShell Script

```powershell
# Build and start all services
.\docker-deploy.ps1 -Build -Start

# Or manually:
docker-compose build
docker-compose up -d
```

## Step 3: Initialize Application

```powershell
# Generate application key
docker-compose exec app php artisan key:generate

# Run database migrations
docker-compose exec app php artisan migrate --force

# Cache configuration
docker-compose exec app php artisan config:cache
docker-compose exec app php artisan route:cache
docker-compose exec app php artisan view:cache
```

## Step 4: Verify Deployment

- **Local**: http://localhost:8080
- **Public**: https://drbs.theonedesk.site
- **Health Check**: http://localhost:8080/health

## Step 5: Check Status

```powershell
# Using script
.\docker-deploy.ps1 -Status

# Or manually
docker-compose ps
```

Expected output:
```
NAME                         STATUS              PORTS
drbs-app                     Up (healthy)        0.0.0.0:8080->80/tcp
drbs-mysql                   Up (healthy)        0.0.0.0:3307->3306/tcp
drbs-cloudflare-tunnel       Up (healthy)
```

## 🎉 Done!

Your application is now live at:
- **https://drbs.theonedesk.site**

## Common Commands

```powershell
# View logs
.\docker-deploy.ps1 -Logs
# or
docker-compose logs -f

# Restart services
.\docker-deploy.ps1 -Restart
# or
docker-compose restart

# Stop services
.\docker-deploy.ps1 -Stop
# or
docker-compose stop

# Backup database
.\docker-deploy.ps1 -Backup

# Check status
.\docker-deploy.ps1 -Status
```

## Troubleshooting

### Services won't start
```powershell
# Check Docker is running
docker ps

# View logs
docker-compose logs
```

### Permission errors
```powershell
docker-compose exec app chown -R www-data:www-data /var/www/html/storage
docker-compose exec app chmod -R 755 /var/www/html/storage
```

### Database connection failed
```powershell
# Verify credentials match in .env and docker-compose.yml
docker-compose exec app cat .env | grep DB_
```

## Next Steps

1. **Secure your deployment**: Review `SECURITY.md`
2. **Set up monitoring**: Configure uptime monitoring
3. **Enable backups**: Set up automated database backups
4. **Configure Cloudflare**: Enable WAF, rate limiting, and SSL settings
5. **Add authentication**: Protect admin routes

## Full Documentation

- **Deployment Guide**: `DEPLOYMENT.md`
- **Security Guide**: `SECURITY.md`
- **Admin Guide**: `ADMIN-GUIDE.md`

## Support

If you encounter issues:
1. Check logs: `docker-compose logs -f`
2. Review `DEPLOYMENT.md` troubleshooting section
3. Check container health: `docker-compose ps`
