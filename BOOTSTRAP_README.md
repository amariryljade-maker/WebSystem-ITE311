# Bootstrap Integration with CodeIgniter

This project has been configured with Bootstrap 5.3.2 (latest version) for easy integration with CodeIgniter.

## What's Included

- **Bootstrap Helper** (`application/helpers/bootstrap_helper.php`) - Provides easy-to-use functions for including Bootstrap assets
- **Assets Directory** (`application/assets/`) - Organized structure for CSS, JS, and images
- **Demo Controller** (`application/controllers/Bootstrap.php`) - Example controller showing Bootstrap usage
- **Demo Views** - Sample pages demonstrating Bootstrap components

## Quick Start

### 1. Using the Bootstrap Helper (Recommended)

The Bootstrap helper provides convenient functions to include Bootstrap assets:

```php
// In your view files:

// Include Bootstrap CSS
<?php echo bootstrap_css(); ?>

// Include Bootstrap JavaScript
<?php echo bootstrap_js(); ?>

// Include Bootstrap Icons
<?php echo bootstrap_icons_css(); ?>

// Or include everything at once
<?php echo bootstrap_assets(); ?>
```

### 2. View the Demo

To see Bootstrap in action, visit:
- `http://your-domain/bootstrap` - Main demo page
- `http://your-domain/bootstrap/manual` - Alternative loading method

### 3. Helper Functions Available

#### `bootstrap_css($version = '5.3.2', $use_cdn = true)`
Includes Bootstrap CSS. By default uses CDN, but you can set `$use_cdn = false` to use local files.

#### `bootstrap_js($version = '5.3.2', $use_cdn = true)`
Includes Bootstrap JavaScript bundle (includes Popper.js).

#### `bootstrap_icons_css($version = '1.11.1', $use_cdn = true)`
Includes Bootstrap Icons CSS.

#### `bootstrap_assets($bootstrap_version = '5.3.2', $icons_version = '1.11.1', $use_cdn = true)`
Includes all Bootstrap assets (CSS, JS, and Icons) at once.

## File Structure

```
application/
├── assets/
│   ├── css/
│   │   └── bootstrap.min.css (placeholder for local files)
│   ├── js/
│   │   └── bootstrap.bundle.min.js (placeholder for local files)
│   └── images/
├── helpers/
│   └── bootstrap_helper.php
├── controllers/
│   └── Bootstrap.php
└── views/
    └── bootstrap_demo.php
```

## Using Local Files vs CDN

### CDN (Default)
- Faster loading (files served from CDN)
- Automatic updates
- No local storage required
- Requires internet connection

### Local Files
- Works offline
- Better for production environments
- More control over versions
- Requires downloading files manually

To use local files:
1. Download Bootstrap files from https://getbootstrap.com/
2. Place them in the appropriate directories under `application/assets/`
3. Use the helper functions with `$use_cdn = false`

## Bootstrap Components Demonstrated

The demo page includes examples of:
- Navigation bar
- Grid system
- Cards
- Forms
- Buttons
- Alerts
- Progress bars
- Icons
- Responsive design

## Customization

You can customize Bootstrap by:
1. Creating custom CSS files in `application/assets/css/`
2. Modifying the helper functions to include your custom styles
3. Using Bootstrap's SASS source files for advanced customization

## Browser Support

Bootstrap 5.3.2 supports:
- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Internet Explorer 11+ (with polyfills)

## Additional Resources

- [Bootstrap Documentation](https://getbootstrap.com/docs/)
- [Bootstrap Icons](https://icons.getbootstrap.com/)
- [CodeIgniter Documentation](https://codeigniter.com/user_guide/)

## Troubleshooting

If Bootstrap doesn't load:
1. Check that the helper is autoloaded in `application/config/autoload.php`
2. Verify your internet connection (if using CDN)
3. Check browser console for any JavaScript errors
4. Ensure your CodeIgniter base URL is configured correctly
