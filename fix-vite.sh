#!/bin/bash
# Fix Vite issue by commenting out @vite directive

echo "Fixing Vite directive in welcome.blade.php..."

# Create a temporary file with the fix
cat > /tmp/welcome_fixed.blade.php << 'EOF'
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DRBS Internet - Reliable Internet Provider</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/drbs-logo-small.png') }}">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Custom CSS -->
    {{-- Vite disabled for Docker deployment --}}
EOF

# Copy the rest of the file from line 21 onwards
tail -n +21 /var/www/html/resources/views/welcome.blade.php >> /tmp/welcome_fixed.blade.php

# Replace the original file
cp /tmp/welcome_fixed.blade.php /var/www/html/resources/views/welcome.blade.php

# Clear view cache
php /var/www/html/artisan view:clear

echo "Vite directive fixed!"
