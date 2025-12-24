# Setup Guide - Creative Portfolio & Booking System

## Quick Start

### Step 1: Database Setup

1. Open phpMyAdmin (http://localhost/phpmyadmin)
2. Create a new database or use existing MySQL
3. Import the SQL file:
   - Go to "Import" tab
   - Choose file: `data/schema.sql`
   - Click "Go"

Alternatively, run the SQL file directly:
```sql
-- The schema.sql file contains all necessary CREATE TABLE statements
-- and sample data inserts
```

### Step 2: Configure Database Connection

Edit `includes/config.php` and update if needed:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');        // Your MySQL username
define('DB_PASS', '');            // Your MySQL password (empty for XAMPP default)
define('DB_NAME', 'portfolio_booking');
```

### Step 3: Access the Application

1. Start XAMPP Control Panel
2. Start Apache and MySQL services
3. Open browser: `http://localhost/`
4. Navigate to:
   - Home: `http://localhost/index.php`
   - About: `http://localhost/about.php`
   - Portfolio: `http://localhost/portfolio.php`

## Testing the Features

### 1. Portfolio Filtering & Sorting
- Go to Portfolio page
- Click category buttons (Cakes, Desserts, Bread)
- Use sort dropdown to change order

### 2. Booking Form (AJAX)
- Scroll to booking section on Portfolio page
- Fill out the form
- Submit (no page reload - AJAX submission)
- Check database for new booking entry

### 3. Theme Toggle
- Click theme toggle button (moon/sun icon) in header
- Theme preference saved in cookie
- Refresh page to see theme persists

### 4. Web Services
- Test GET endpoint: `http://localhost/api/portfolio.php`
- Should return JSON with portfolio items
- Test POST endpoint via booking form submission

## Troubleshooting

### Database Connection Error
- Ensure MySQL is running in XAMPP
- Check database credentials in `includes/config.php`
- Verify database `portfolio_booking` exists

### API Not Working
- Check Apache is running
- Verify `.htaccess` file is present
- Check browser console for CORS errors

### JavaScript Not Loading
- Check browser console for errors
- Verify file paths in `includes/footer.php`
- Ensure files are in correct directories

### Styles Not Applied
- Check CSS file paths in `includes/header.php`
- Verify theme CSS files exist (`dark.css`, `light.css`)
- Clear browser cache

## File Structure Verification

Ensure these directories exist:
```
/
├── index.php
├── about.php
├── portfolio.php
├── assets/
│   ├── css/
│   │   ├── style.css
│   │   ├── dark.css
│   │   └── light.css
│   └── js/
│       ├── data.js
│       ├── ui.js
│       └── events.js
├── includes/
│   ├── config.php
│   ├── header.php
│   └── footer.php
├── api/
│   ├── portfolio.php
│   ├── booking.php
│   └── theme.php
└── data/
    └── schema.sql
```

## Requirements Checklist

✅ HTML5 semantic structure (header, nav, main, section, footer)
✅ Responsive CSS with Flexbox
✅ External CSS files only
✅ 3+ pages (index, about, portfolio)
✅ JavaScript modules (data.js, ui.js, events.js)
✅ map, filter, reduce methods used
✅ Arrow functions
✅ 5+ DOM elements created dynamically
✅ Style modification via JavaScript
✅ 5+ event handlers (click, mouseover, submit, keydown, blur)
✅ PHP form processing with validation
✅ $_POST, if/else, PHP functions
✅ MySQL database with 2+ tables
✅ SELECT and INSERT queries
✅ $_SESSION usage
✅ Cookies for theme
✅ AJAX with fetch API
✅ Web Service v1 (GET) - JSON response
✅ Web Service v2 (POST) - Database update
✅ Forms submitted via JavaScript (no reload)
✅ Interactive filtering/sorting system

## Notes

- Default database password for XAMPP is empty (blank)
- All forms use AJAX - no page reloads
- Theme preference persists via cookies
- Portfolio items loaded dynamically from database
- Booking submissions saved to database
