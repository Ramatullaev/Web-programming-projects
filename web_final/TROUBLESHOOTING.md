# Troubleshooting: "No items found" Issue

## Quick Fix Steps

### Step 1: Check Database Connection
1. Open phpMyAdmin: `http://localhost/phpmyadmin`
2. Check if database `portfolio_booking` exists
3. If not, create it or import `data/schema.sql`

### Step 2: Import Database Schema
1. In phpMyAdmin, select database `portfolio_booking`
2. Go to "Import" tab
3. Choose file: `data/schema.sql`
4. Click "Go"

OR execute SQL directly:
```sql
-- Copy and paste the entire content of data/schema.sql into SQL tab
```

### Step 3: Verify Data Exists
Run this SQL query in phpMyAdmin:
```sql
SELECT COUNT(*) as total FROM portfolio_items;
SELECT COUNT(*) as featured FROM portfolio_items WHERE featured = 1;
```

You should see:
- Total items: 17
- Featured items: 8

### Step 4: Check API Endpoint
1. Open in browser: `http://localhost/api/portfolio.php`
2. You should see JSON data with dishes
3. If you see an error, check:
   - MySQL is running in XAMPP
   - Database credentials in `includes/config.php` are correct

### Step 5: Check Browser Console
1. Open browser Developer Tools (F12)
2. Go to "Console" tab
3. Refresh the page
4. Look for error messages or debug logs
5. Check "Network" tab for API calls

### Step 6: Verify Featured Items
Run this SQL to check featured items:
```sql
SELECT id, title, featured FROM portfolio_items WHERE featured = 1;
```

Expected featured dishes:
- Beshbarmak
- Kazy
- Baursak
- Shashlik
- Plov
- Kuyrdak
- Zhent
- Kymyz

### Common Issues

**Issue: Database not found**
- Solution: Create database `portfolio_booking` in phpMyAdmin

**Issue: Table doesn't exist**
- Solution: Run `data/schema.sql` to create tables

**Issue: Table is empty**
- Solution: Run INSERT statements from `data/schema.sql` or use `quick_add_items.sql`

**Issue: API returns error**
- Solution: Check `includes/config.php` - verify DB credentials
- Default XAMPP: user=`root`, password=`` (empty)

**Issue: Featured filter not working**
- Solution: Check that `featured` column values are 1 (not '1' or 'TRUE')
- Run: `UPDATE portfolio_items SET featured = 1 WHERE title IN ('Beshbarmak', 'Kazy', 'Baursak', 'Shashlik', 'Plov', 'Kuyrdak', 'Zhent', 'Kymyz');`

### Quick SQL Fix
If featured items are not showing, run this:
```sql
UPDATE portfolio_items SET featured = 1 WHERE title IN ('Beshbarmak', 'Kazy', 'Baursak', 'Shashlik', 'Plov', 'Kuyrdak', 'Zhent', 'Kymyz');
UPDATE portfolio_items SET featured = 0 WHERE title NOT IN ('Beshbarmak', 'Kazy', 'Baursak', 'Shashlik', 'Plov', 'Kuyrdak', 'Zhent', 'Kymyz');
```

### Test API Directly
Open in browser: `http://localhost/api/portfolio.php`

Expected response:
```json
{
  "success": true,
  "data": [...array of dishes...],
  "count": 17
}
```

If you see this, the API is working correctly!
