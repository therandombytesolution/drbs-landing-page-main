# DRBS Internet - Admin Guide

## 🎯 Overview

This guide explains how administrators can view and manage support tickets and customer registrations submitted through the DRBS Internet website.

## 🔐 Accessing the Admin Panel

### Admin Dashboard URL
```
http://localhost:8000/admin
```

Or if using XAMPP:
```
http://localhost/drbs-landing-page/public/admin
```

**Note:** Currently, the admin panel has no authentication. For production, you should add authentication middleware to protect these routes.

## 📊 Admin Dashboard Features

### 1. Dashboard Overview (`/admin`)

The main dashboard displays:

#### Support Tickets Statistics:
- **Total Tickets** - All submitted support tickets
- **Open** - New tickets awaiting response
- **In Progress** - Tickets being worked on
- **Resolved** - Completed tickets
- **High Priority** - Urgent tickets requiring immediate attention

#### Registration Statistics:
- **Total Registrations** - All service registration requests
- **Pending** - New registrations awaiting review
- **Contacted** - Registrations that have been contacted
- **Scheduled** - Installations that have been scheduled
- **Active** - Active subscribers

#### Recent Activity:
- Last 5 support tickets submitted
- Last 5 registration requests
- Today's submissions count
- This week's submissions count

## 🎫 Managing Support Tickets

### View All Tickets (`/admin/tickets`)

Features:
- **Search** - Search by ticket number, name, email, or subject
- **Filter by Status** - open, in_progress, resolved, closed
- **Filter by Priority** - low, medium, high
- **Pagination** - 20 tickets per page
- **Export to CSV** - Download tickets data

### View Ticket Details (`/admin/tickets/{id}`)

Displays:
- Ticket number (e.g., TKT-123456)
- Customer information (name, email, phone)
- Account number (if provided)
- Category (connection issues, billing, etc.)
- Priority level
- Subject and description
- Attachments (if any)
- Current status
- Admin notes
- Creation and update dates

### Update Ticket Status

Available status options:
- **Open** - New ticket, not yet addressed
- **In Progress** - Currently being worked on
- **Resolved** - Issue has been fixed
- **Closed** - Ticket is completed

Actions you can perform:
1. Change status
2. Add admin notes
3. Assign to team member
4. View/download attachments
5. Delete ticket (if necessary)

### Ticket Priority Levels

- **Low** (Green badge) - Non-urgent issues
- **Medium** (Yellow badge) - Standard issues
- **High** (Red badge) - Urgent issues requiring immediate attention

### Ticket Categories

- No Internet Connection
- Slow/Intermittent Connection
- Billing & Payment Inquiry
- Installation Request
- Equipment Issue
- Plan Upgrade/Downgrade
- Service Cancellation
- Other Technical Issues

## 👥 Managing Registrations

### View All Registrations (`/admin/registrations`)

Features:
- **Search** - Search by registration number, name, email, or phone
- **Filter by Status** - pending, contacted, scheduled, installed, active, cancelled
- **Filter by Plan** - 10mbps, 25mbps, 50mbps
- **Pagination** - 20 registrations per page
- **Export to CSV** - Download registrations data

### View Registration Details (`/admin/registrations/{id}`)

Displays:
- Registration number (e.g., REG-123456)
- Personal information (name, email, phone)
- Location details (building, floor, unit, full address)
- Selected plan (10 Mbps, 25 Mbps, or 50 Mbps)
- Plan pricing
- Preferred installation date
- Referral code (if used)
- Customer notes
- Uploaded documents (if any)
- Terms agreement status
- Current status
- Admin notes
- Important dates (contacted, scheduled, installed)

### Update Registration Status

Available status options:
- **Pending** - New registration, awaiting review
- **Contacted** - Customer has been contacted
- **Scheduled** - Installation date has been set
- **Installed** - Service has been installed
- **Active** - Customer is now an active subscriber
- **Cancelled** - Registration was cancelled

Actions you can perform:
1. Change status (automatically updates timestamps)
2. Set scheduled installation date
3. Add admin notes
4. View/download documents
5. Delete registration (if necessary)

### Registration Status Workflow

Typical workflow:
1. **Pending** → New registration received
2. **Contacted** → Admin calls/emails customer
3. **Scheduled** → Installation date confirmed
4. **Installed** → Technician completes installation
5. **Active** → Customer becomes subscriber

## 📥 How Customers Submit Information

### Support Tickets

Customers submit tickets via: `/support`

They provide:
- Full name
- Email address
- Phone number
- Account number (optional)
- Issue category
- Priority level
- Subject line
- Detailed description
- Attachments (screenshots, files)

### Service Registrations

Customers register via: `/register`

Four-step process:
1. **Personal Info** - Name, email, phone
2. **Location** - Building, unit, address
3. **Plan Selection** - Choose internet plan
4. **Confirmation** - Terms, documents, notes

## 🔍 Tracking Features

### For Customers

#### Track Support Ticket:
- URL: `/support` → "Track Ticket" tab
- Enter: Ticket ID or email address
- View: Current status and updates

#### Track Registration:
- URL: `/registration/{number}`
- Enter: Registration number or email
- View: Current status and progress

## 📊 Exporting Data

### Export Tickets to CSV
1. Go to `/admin/tickets`
2. Apply filters (optional)
3. Click "Export to CSV"
4. File downloads with name: `tickets_YYYY-MM-DD_HHMMSS.csv`

### Export Registrations to CSV
1. Go to `/admin/registrations`
2. Apply filters (optional)
3. Click "Export to CSV"
4. File downloads with name: `registrations_YYYY-MM-DD_HHMMSS.csv`

## 📧 Email Notifications (Coming Soon)

Currently, email notifications are not configured. To enable:

1. Configure email in `.env`:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="DRBS Internet"
```

2. Uncomment email notification code in:
   - `app/Http/Controllers/TicketController.php`
   - `app/Http/Controllers/RegistrationController.php`

## 🔒 Adding Authentication (Recommended)

For production, protect admin routes with authentication:

### Option 1: Laravel Breeze (Simple)
```bash
composer require laravel/breeze --dev
php artisan breeze:install
npm install && npm run build
php artisan migrate
```

Then add middleware to `routes/web.php`:
```php
Route::prefix('admin')->middleware(['auth'])->name('admin.')->group(function () {
    // ... admin routes
});
```

### Option 2: Simple Password Protection

Create middleware:
```bash
php artisan make:middleware AdminAuth
```

Add basic authentication check in the middleware.

## 📱 Mobile Access

The admin dashboard is responsive and works on:
- Desktop computers
- Tablets
- Mobile phones

## 🎨 Admin Dashboard Navigation

Sidebar menu includes:
- **Dashboard** - Overview and statistics
- **Tickets** - View and manage support tickets
- **Registrations** - View and manage registrations
- **View Website** - Opens public website in new tab

## 📝 Best Practices

### For Ticket Management:
1. Respond to high-priority tickets first
2. Update status as work progresses
3. Add clear admin notes for team communication
4. Resolve and close tickets promptly
5. Monitor open ticket count daily

### For Registration Management:
1. Review pending registrations daily
2. Contact new registrations within 24 hours
3. Schedule installations based on preferred dates
4. Update status at each stage
5. Convert installed to active status after confirmation

## 🐛 Troubleshooting

### Can't Access Admin Panel
- Check URL is correct
- Ensure Laravel server is running: `php artisan serve`
- Clear cache: `php artisan optimize:clear`

### No Data Showing
- Check database connection in `.env`
- Verify tables exist: `php artisan migrate`
- Submit test ticket from `/support` page

### Attachments Not Uploading
- Check storage permissions
- Create storage link: `php artisan storage:link`
- Verify max upload size in `php.ini`

## 📞 Support

For technical issues or questions:
- Check Laravel logs: `storage/logs/laravel.log`
- Review documentation files:
  - `IMPROVEMENTS.md` - Feature details
  - `SETUP.md` - Installation guide
  - `QUICK-REFERENCE.md` - Developer reference

## 🚀 Quick Start Checklist

- [ ] Access admin dashboard: `/admin`
- [ ] Review pending tickets
- [ ] Review pending registrations
- [ ] Update ticket statuses
- [ ] Update registration statuses
- [ ] Add admin notes where needed
- [ ] Export data for reports (optional)
- [ ] Respond to high-priority items first

## 📈 Reports & Analytics

Current statistics available:
- Total submissions (tickets and registrations)
- Status breakdown
- Daily, weekly, and monthly counts
- Priority distribution (tickets)
- Plan distribution (registrations)

For advanced analytics, consider integrating:
- Google Analytics
- Custom reporting tools
- Data visualization dashboards

---

**Version:** 1.0  
**Last Updated:** October 2025  
**System:** DRBS Internet Landing Page with Admin Panel

For developers: See `IMPROVEMENTS.md` for technical implementation details.