# DRBS Internet Landing Page - Quick Reference Guide

## 🚀 Quick Start Commands

```bash
# Install dependencies
composer install
npm install

# Build assets
npm run dev          # Development with hot reload
npm run build        # Production build

# Start server
php artisan serve    # Access at http://localhost:8000
```

## 📄 Page URLs

| Page | URL | Description |
|------|-----|-------------|
| Landing | `/` | Main homepage with plans and features |
| Registration | `/register` | Multi-step registration form |
| Support | `/support` | Ticket system and FAQ |

## 🎨 Design System

### Colors
```css
--primary-color: #0d6efd      /* Primary blue */
--primary-dark: #0a58ca       /* Dark blue */
--primary-light: #6ea8fe      /* Light blue */
--gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%)
```

### Breakpoints
- Mobile: `< 576px`
- Tablet: `576px - 991px`
- Desktop: `992px - 1199px`
- Large: `≥ 1200px`

### Spacing Scale
- `0.25rem` (4px) - xs
- `0.5rem` (8px) - sm
- `1rem` (16px) - md
- `2rem` (32px) - lg
- `3rem` (48px) - xl

## 🧩 Key Components

### Navbar
- **Class:** `.navbar`
- **Behavior:** Fixed on scroll with blur effect
- **State:** `.navbar-scrolled` adds background

### Hero Section
- **Class:** `.hero-section`
- **Height:** `100vh`
- **Background:** Gradient overlay on image
- **Animations:** Staggered fade-in

### Cards
```html
<!-- Feature Card -->
<div class="feature-card">
  <div class="feature-icon">
    <i class="bi bi-icon"></i>
  </div>
  <h4>Title</h4>
  <p>Description</p>
</div>

<!-- Pricing Card -->
<div class="pricing-card">
  <div class="card-body">
    <!-- Content -->
  </div>
</div>

<!-- Popular Pricing Card -->
<div class="pricing-card pricing-card-popular">
  <div class="popular-badge">Most Popular</div>
  <!-- Content -->
</div>
```

### Buttons
```html
<!-- Primary -->
<button class="btn btn-primary">Action</button>

<!-- Rounded Pills -->
<button class="btn btn-primary rounded-pill">Get Started</button>

<!-- Outline -->
<button class="btn btn-outline-light">Learn More</button>
```

## 📝 Form Elements

### Multi-Step Form (Registration)
```javascript
// Navigate to next step
function nextStep(currentStep) {
  // Validates current step
  // Moves to next step
}

// Navigate to previous step
function prevStep(currentStep) {
  // Returns to previous step
}
```

### Form Validation
```javascript
// Automatic validation on submit
// Adds .is-invalid class to invalid fields
// Shows error messages
```

## 🎭 Animations

### Fade In Up
```css
animation: fadeInUp 1s ease;
```

### Hover Effects
```css
transform: translateY(-10px);  /* Lift effect */
transform: scale(1.1);         /* Scale up */
transform: rotate(360deg);     /* Rotate */
```

### Transitions
```css
transition: all 0.3s ease;
```

## 🎯 Common Patterns

### Section Structure
```html
<section class="py-5 [bg-light]">
  <div class="container py-5">
    <!-- Header -->
    <div class="text-center mb-5">
      <span class="badge bg-primary-soft">SECTION LABEL</span>
      <h2 class="display-5 fw-bold">Section Title</h2>
      <p class="lead text-muted">Description</p>
    </div>
    <!-- Content -->
    <div class="row g-4">
      <!-- Cards/Content -->
    </div>
  </div>
</section>
```

### Card with Hover Effect
```html
<div class="feature-card">
  <div class="feature-icon">
    <i class="bi bi-star-fill"></i>
  </div>
  <h5 class="fw-bold">Title</h5>
  <p class="text-muted">Description</p>
</div>
```

### Input Group with Icon
```html
<div class="input-group">
  <span class="input-group-text bg-light border-end-0">
    <i class="bi bi-person"></i>
  </span>
  <input type="text" class="form-control border-start-0">
</div>
```

## 📱 Responsive Utilities

### Display Classes
```html
<div class="d-none d-md-block">Desktop only</div>
<div class="d-md-none">Mobile only</div>
```

### Text Alignment
```html
<p class="text-center text-md-start">Responsive align</p>
```

### Spacing
```html
<div class="mb-3 mb-md-4 mb-lg-5">Responsive margin</div>
```

## 🔧 JavaScript Helpers

### Smooth Scroll
```javascript
document.querySelector('a[href^="#"]').addEventListener('click', function(e) {
  e.preventDefault();
  document.querySelector(this.getAttribute('href'))
    .scrollIntoView({ behavior: 'smooth' });
});
```

### Navbar Scroll Effect
```javascript
window.addEventListener('scroll', function() {
  const navbar = document.querySelector('.navbar');
  if (window.scrollY > 50) {
    navbar.classList.add('navbar-scrolled');
  } else {
    navbar.classList.remove('navbar-scrolled');
  }
});
```

## 🎨 Icon Usage (Bootstrap Icons)

### Common Icons
```html
<i class="bi bi-wifi"></i>           <!-- WiFi -->
<i class="bi bi-telephone-fill"></i> <!-- Phone -->
<i class="bi bi-envelope-fill"></i>  <!-- Email -->
<i class="bi bi-chat-dots-fill"></i> <!-- Chat -->
<i class="bi bi-check-circle-fill"></i> <!-- Check -->
<i class="bi bi-star-fill"></i>      <!-- Star -->
<i class="bi bi-speedometer2"></i>   <!-- Speed -->
<i class="bi bi-shield-check"></i>   <!-- Security -->
<i class="bi bi-headset"></i>        <!-- Support -->
```

## 📊 Badge Usage

### Gradient Badge
```html
<span class="badge bg-primary-gradient">Featured</span>
```

### Soft Background Badge
```html
<span class="badge bg-primary-soft text-primary">New</span>
```

### Rounded Pill Badge
```html
<span class="badge bg-primary rounded-pill">Beta</span>
```

## 🎯 Call-to-Action Patterns

### Primary CTA
```html
<a href="/register" class="btn btn-primary btn-lg px-5 py-3 rounded-pill">
  <i class="bi bi-rocket-takeoff me-2"></i>Start Free Trial
</a>
```

### Secondary CTA
```html
<a href="#plans" class="btn btn-outline-light btn-lg px-5 py-3 rounded-pill">
  <i class="bi bi-grid-3x3-gap me-2"></i>View Plans
</a>
```

## 🔍 Debugging Tips

### Check Asset Compilation
```bash
npm run build
php artisan optimize:clear
```

### Clear Browser Cache
- Hard refresh: `Ctrl + Shift + R` (Windows/Linux)
- Hard refresh: `Cmd + Shift + R` (Mac)

### View in Incognito
- Bypasses cache
- Fresh state testing

### Check Console
- `F12` to open Developer Tools
- Look for JavaScript errors
- Check network requests

## 📦 File Locations

### Views
- Landing: `resources/views/welcome.blade.php`
- Registration: `resources/views/register.blade.php`
- Support: `resources/views/support.blade.php`

### Styles
- Main CSS: `resources/css/app.css`

### Scripts
- Main JS: `resources/js/app.js`

### Routes
- Web routes: `routes/web.php`

## 🎨 Customization Quick Tips

### Change Primary Color
Edit in `resources/css/app.css`:
```css
:root {
  --primary-color: #YOUR_COLOR;
}
```

### Update Hero Image
Edit in `resources/css/app.css`:
```css
.hero-section::before {
  background: url("YOUR_IMAGE_URL") no-repeat center center;
}
```

### Add New Section
```html
<section id="new-section" class="py-5">
  <div class="container py-5">
    <!-- Your content -->
  </div>
</section>
```

### Add New Route
Edit `routes/web.php`:
```php
Route::get('/new-page', function () {
    return view('new-page');
});
```

## ⚡ Performance Tips

1. **Optimize Images**: Use WebP format, compress
2. **Lazy Load**: Add `loading="lazy"` to images
3. **Minify Assets**: Run `npm run build` for production
4. **Cache Routes**: Run `php artisan route:cache`
5. **Enable Gzip**: Configure server compression

## 🔒 Security Checklist

- [ ] Set `APP_ENV=production` in `.env`
- [ ] Set `APP_DEBUG=false` in `.env`
- [ ] Add CSRF tokens to forms: `@csrf`
- [ ] Validate all inputs server-side
- [ ] Sanitize user content
- [ ] Use HTTPS in production
- [ ] Set proper file permissions

## 📚 Resources

- [Laravel Docs](https://laravel.com/docs)
- [Bootstrap Docs](https://getbootstrap.com/docs/)
- [Bootstrap Icons](https://icons.getbootstrap.com/)
- [Vite Docs](https://vitejs.dev/)

## 🚀 Deployment Checklist

- [ ] Run `composer install --optimize-autoloader --no-dev`
- [ ] Run `npm run build`
- [ ] Set environment variables
- [ ] Run `php artisan config:cache`
- [ ] Run `php artisan route:cache`
- [ ] Run `php artisan view:cache`
- [ ] Set up database
- [ ] Configure email settings
- [ ] Set up SSL certificate
- [ ] Test all functionality

---

**Need Help?** Check the detailed documentation:
- `IMPROVEMENTS.md` - Feature details
- `SETUP.md` - Installation guide
- `SUMMARY.md` - Transformation overview