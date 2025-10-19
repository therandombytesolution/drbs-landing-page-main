# DRBS Internet Landing Page - Setup Guide

## 🚀 Quick Start

Follow these steps to get the improved DRBS Internet landing page up and running.

## Prerequisites

Before you begin, ensure you have the following installed:

- **PHP** >= 8.1
- **Composer** (PHP dependency manager)
- **Node.js** >= 16.x and npm
- **XAMPP** (or any other local server)

## Installation Steps

### 1. Navigate to Project Directory

```bash
cd C:\xampp\htdocs\drbs-landing-page
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Install Node Dependencies

```bash
npm install
```

### 4. Environment Configuration

Copy the example environment file:

```bash
copy .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

### 5. Build Assets

For development (with hot reload):

```bash
npm run dev
```

For production (optimized build):

```bash
npm run build
```

### 6. Start the Development Server

Open a new terminal and run:

```bash
php artisan serve
```

The application will be available at: `http://localhost:8000`

## Alternative: Using XAMPP

If you prefer to use XAMPP instead of `php artisan serve`:

1. Make sure Apache is running in XAMPP Control Panel
2. Access the site at: `http://localhost/drbs-landing-page/public`

## 📄 Available Pages

Once the server is running, you can access:

- **Landing Page**: `http://localhost:8000/`
- **Registration**: `http://localhost:8000/register`
- **Support**: `http://localhost:8000/support`

## 🎨 New Features

### Landing Page Improvements
- Modern hero section with animations
- Service status banner
- Enhanced pricing cards with popular badge
- Testimonials with avatars
- Interactive coverage checker
- Professional contact section
- Call-to-action section
- Enhanced footer

### Registration Page (`/register`)
- Multi-step form (4 steps)
- Progress indicator
- Form validation
- Interactive plan selection
- Date picker with minimum date constraint
- File upload support
- Terms & conditions

### Support Page (`/support`)
- Quick contact options (Phone, Email, Live Chat, WhatsApp)
- Ticket submission form with priority levels
- Ticket tracking system
- FAQ accordion section
- Emergency support highlight
- Support hours display

## 🛠️ Development

### File Structure

```
drbs-landing-page/
├── resources/
│   ├── views/
│   │   ├── welcome.blade.php    # Landing page
│   │   ├── register.blade.php   # Registration page
│   │   └── support.blade.php    # Support page
│   ├── css/
│   │   └── app.css              # Custom styles
│   └── js/
│       └── app.js               # JavaScript
├── routes/
│   └── web.php                  # Route definitions
└── public/
    └── build/                   # Compiled assets
```

### Modifying Styles

1. Edit `resources/css/app.css`
2. Run `npm run dev` to see changes in real-time
3. Or run `npm run build` for production

### Adding New Routes

Edit `routes/web.php` to add new pages:

```php
Route::get('/new-page', function () {
    return view('new-page');
});
```

## 🎯 Key Technologies

- **Laravel 10.x** - PHP Framework
- **Bootstrap 5.3.3** - CSS Framework
- **Bootstrap Icons 1.11.3** - Icon Library
- **Inter Font** - Modern Typography
- **Vite** - Asset Bundler

## 📱 Responsive Design

The site is fully responsive and optimized for:

- Mobile devices (< 576px)
- Tablets (576px - 991px)
- Desktops (992px+)
- Large displays (1200px+)

## 🎨 Customization

### Colors

Edit CSS variables in `resources/css/app.css`:

```css
:root {
    --primary-color: #0d6efd;
    --primary-dark: #0a58ca;
    --primary-light: #6ea8fe;
    /* Add more custom colors */
}
```

### Fonts

Change font family in `resources/css/app.css`:

```css
body {
    font-family: 'Your Font', sans-serif;
}
```

### Hero Background

Update the hero background image in `resources/css/app.css`:

```css
.hero-section::before {
    background: url("your-image-url") no-repeat center center;
}
```

## 🔧 Troubleshooting

### Assets not loading

Run:
```bash
npm run build
php artisan optimize:clear
```

### Page not found errors

Make sure Apache's `mod_rewrite` is enabled if using XAMPP.

### Styles not updating

Clear browser cache or use incognito mode. Also run:
```bash
npm run build
```

### Port already in use

If port 8000 is busy, specify a different port:
```bash
php artisan serve --port=8080
```

## 📊 Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers (iOS Safari, Chrome Mobile)

## 🔒 Security Notes

For production deployment:

1. Set `APP_ENV=production` in `.env`
2. Set `APP_DEBUG=false` in `.env`
3. Run `php artisan config:cache`
4. Run `php artisan route:cache`
5. Ensure proper file permissions
6. Use HTTPS
7. Implement CSRF protection on forms

## 📝 Next Steps

### Backend Integration

To make forms functional:

1. **Create Database Tables**
   ```bash
   php artisan make:migration create_registrations_table
   php artisan make:migration create_tickets_table
   ```

2. **Create Models**
   ```bash
   php artisan make:model Registration
   php artisan make:model Ticket
   ```

3. **Create Controllers**
   ```bash
   php artisan make:controller RegistrationController
   php artisan make:controller TicketController
   ```

4. **Update Routes**
   ```php
   Route::post('/register', [RegistrationController::class, 'store']);
   Route::post('/support/ticket', [TicketController::class, 'store']);
   ```

### Email Notifications

Configure email in `.env`:
```
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-password
```

## 📚 Documentation

- [Laravel Documentation](https://laravel.com/docs)
- [Bootstrap Documentation](https://getbootstrap.com/docs/)
- [Vite Documentation](https://vitejs.dev/)

## 🤝 Support

For issues or questions:

1. Check the `IMPROVEMENTS.md` file for feature details
2. Review Laravel documentation
3. Check browser console for errors
4. Verify all dependencies are installed

## 🎉 Enjoy!

Your modern DRBS Internet landing page is now ready! The improved design includes:

✅ Modern, professional UI/UX
✅ Separate registration page with multi-step form
✅ Dedicated support/ticketing page
✅ Mobile-responsive design
✅ Smooth animations and transitions
✅ Accessible and user-friendly
✅ Ready for backend integration

Happy coding! 🚀