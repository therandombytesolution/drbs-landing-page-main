# DRBS Landing Page - Docker Deployment Script
# This script automates the secure deployment process

param(
    [switch]$Build,
    [switch]$Start,
    [switch]$Stop,
    [switch]$Restart,
    [switch]$Logs,
    [switch]$Status,
    [switch]$Clean,
    [switch]$Backup,
    [switch]$Help
)

$ErrorActionPreference = "Stop"

function Write-ColorOutput($ForegroundColor) {
    $fc = $host.UI.RawUI.ForegroundColor
    $host.UI.RawUI.ForegroundColor = $ForegroundColor
    if ($args) {
        Write-Output $args
    }
    $host.UI.RawUI.ForegroundColor = $fc
}

function Show-Help {
    Write-ColorOutput Green "=== DRBS Docker Deployment Script ==="
    Write-Output ""
    Write-Output "Usage: .\docker-deploy.ps1 [OPTIONS]"
    Write-Output ""
    Write-Output "Options:"
    Write-Output "  -Build      Build Docker images"
    Write-Output "  -Start      Start all services"
    Write-Output "  -Stop       Stop all services"
    Write-Output "  -Restart    Restart all services"
    Write-Output "  -Logs       View logs (real-time)"
    Write-Output "  -Status     Check service status"
    Write-Output "  -Clean      Stop and remove all containers and volumes (DANGER)"
    Write-Output "  -Backup     Backup database"
    Write-Output "  -Help       Show this help message"
    Write-Output ""
    Write-Output "Examples:"
    Write-Output "  .\docker-deploy.ps1 -Build -Start    # Build and start services"
    Write-Output "  .\docker-deploy.ps1 -Status           # Check status"
    Write-Output "  .\docker-deploy.ps1 -Logs             # View logs"
    Write-Output "  .\docker-deploy.ps1 -Backup           # Backup database"
}

function Test-Prerequisites {
    Write-ColorOutput Cyan "Checking prerequisites..."
    
    # Check Docker
    try {
        $dockerVersion = docker --version
        Write-ColorOutput Green "✓ Docker found: $dockerVersion"
    } catch {
        Write-ColorOutput Red "✗ Docker not found. Please install Docker Desktop."
        exit 1
    }
    
    # Check Docker Compose
    try {
        $composeVersion = docker-compose --version
        Write-ColorOutput Green "✓ Docker Compose found: $composeVersion"
    } catch {
        Write-ColorOutput Red "✗ Docker Compose not found."
        exit 1
    }
    
    # Check if Docker is running
    try {
        docker ps | Out-Null
        Write-ColorOutput Green "✓ Docker daemon is running"
    } catch {
        Write-ColorOutput Red "✗ Docker daemon is not running. Please start Docker Desktop."
        exit 1
    }
    
    # Check .env file
    if (Test-Path ".env") {
        Write-ColorOutput Green "✓ .env file found"
    } else {
        Write-ColorOutput Yellow "⚠ .env file not found. Creating from example..."
        if (Test-Path ".env.docker.example") {
            Copy-Item ".env.docker.example" ".env"
            Write-ColorOutput Yellow "⚠ Please edit .env file and set secure passwords!"
            Write-ColorOutput Yellow "⚠ Run: notepad .env"
            exit 1
        } else {
            Write-ColorOutput Red "✗ .env.docker.example not found."
            exit 1
        }
    }
    
    Write-Output ""
}

function Build-Images {
    Write-ColorOutput Cyan "Building Docker images..."
    docker-compose build --no-cache
    if ($LASTEXITCODE -eq 0) {
        Write-ColorOutput Green "✓ Images built successfully"
    } else {
        Write-ColorOutput Red "✗ Build failed"
        exit 1
    }
}

function Start-Services {
    Write-ColorOutput Cyan "Starting services..."
    docker-compose up -d
    
    if ($LASTEXITCODE -eq 0) {
        Write-ColorOutput Green "✓ Services started successfully"
        Write-Output ""
        Write-ColorOutput Cyan "Waiting for services to be healthy..."
        Start-Sleep -Seconds 10
        
        # Check health
        docker-compose ps
        
        Write-Output ""
        Write-ColorOutput Green "=== Deployment Information ==="
        Write-ColorOutput Yellow "Note: No local ports exposed - Cloudflare Tunnel only"
        Write-Output "Public URL: https://drbs.theonedesk.site"
        Write-Output "Health:     https://drbs.theonedesk.site/health"
        Write-Output ""
        Write-ColorOutput Yellow "Next steps:"
        Write-Output "1. Generate app key: docker-compose exec app php artisan key:generate"
        Write-Output "2. Run migrations: docker-compose exec app php artisan migrate --force"
        Write-Output "3. Cache config: docker-compose exec app php artisan config:cache"
        Write-Output "4. Verify access: https://drbs.theonedesk.site"
    } else {
        Write-ColorOutput Red "✗ Failed to start services"
        exit 1
    }
}

function Stop-Services {
    Write-ColorOutput Cyan "Stopping services..."
    docker-compose stop
    if ($LASTEXITCODE -eq 0) {
        Write-ColorOutput Green "✓ Services stopped"
    } else {
        Write-ColorOutput Red "✗ Failed to stop services"
    }
}

function Restart-Services {
    Write-ColorOutput Cyan "Restarting services..."
    docker-compose restart
    if ($LASTEXITCODE -eq 0) {
        Write-ColorOutput Green "✓ Services restarted"
    } else {
        Write-ColorOutput Red "✗ Failed to restart services"
    }
}

function Show-Logs {
    Write-ColorOutput Cyan "Showing logs (Ctrl+C to exit)..."
    docker-compose logs -f
}

function Show-Status {
    Write-ColorOutput Cyan "Service Status:"
    docker-compose ps
    Write-Output ""
    
    Write-ColorOutput Cyan "Resource Usage:"
    docker stats --no-stream
}

function Clean-All {
    Write-ColorOutput Red "⚠ WARNING: This will remove all containers and volumes (including database)!"
    $confirmation = Read-Host "Are you sure? Type 'yes' to confirm"
    
    if ($confirmation -eq "yes") {
        Write-ColorOutput Cyan "Cleaning up..."
        docker-compose down -v
        Write-ColorOutput Green "✓ Cleanup complete"
    } else {
        Write-ColorOutput Yellow "Cleanup cancelled"
    }
}

function Backup-Database {
    Write-ColorOutput Cyan "Creating database backup..."
    
    $timestamp = Get-Date -Format "yyyyMMdd_HHmmss"
    $backupDir = "backups"
    $backupFile = "$backupDir/db_backup_$timestamp.sql"
    
    # Create backup directory if it doesn't exist
    if (!(Test-Path $backupDir)) {
        New-Item -ItemType Directory -Path $backupDir | Out-Null
    }
    
    # Create backup
    docker-compose exec -T db mysqldump -u drbs_user -p drbs_db > $backupFile
    
    if ($LASTEXITCODE -eq 0) {
        Write-ColorOutput Green "✓ Backup created: $backupFile"
        
        # Compress backup
        Compress-Archive -Path $backupFile -DestinationPath "$backupFile.zip"
        Remove-Item $backupFile
        Write-ColorOutput Green "✓ Backup compressed: $backupFile.zip"
    } else {
        Write-ColorOutput Red "✗ Backup failed"
    }
}

# Main script logic
if ($Help) {
    Show-Help
    exit 0
}

if (!($Build -or $Start -or $Stop -or $Restart -or $Logs -or $Status -or $Clean -or $Backup)) {
    Show-Help
    exit 0
}

Test-Prerequisites

if ($Build) { Build-Images }
if ($Start) { Start-Services }
if ($Stop) { Stop-Services }
if ($Restart) { Restart-Services }
if ($Logs) { Show-Logs }
if ($Status) { Show-Status }
if ($Clean) { Clean-All }
if ($Backup) { Backup-Database }

Write-Output ""
Write-ColorOutput Green "=== Script completed ==="
