# Bookeo API WordPress Plugin

A WordPress plugin that displays upcoming classes from the Bookeo API using customizable shortcodes. Based on the functionality from the Security Training Classes theme.

## 🚀 Features

- **Shortcode Integration**: Display classes anywhere with `[bookeo_classes]`
- **Bookeo API Integration**: Real-time class data from Bookeo platform
- **Category Filtering**: Filter classes by training type
- **Responsive Design**: Mobile-first responsive layout
- **Pagination Support**: Handle large numbers of classes
- **Admin Dashboard**: Easy API configuration and testing
- **Customizable Display**: Control columns, filters, and pagination
- **Professional Styling**: Matches Security Training Academy branding

## 📦 Installation

### Manual Installation

1. **Upload Plugin Files**:
   ```
   wp-content/plugins/bookeo-api/
   ├── bookeo-api.php
   ├── assets/
   │   ├── bookeo-api.css
   │   └── bookeo-api.js
   └── README.md
   ```

2. **Activate Plugin**:
   - Go to WordPress Admin > Plugins
   - Find "Bookeo API" and click "Activate"

3. **Configure API Settings**:
   - Go to Settings > Bookeo API
   - Enter your Bookeo API Key and Secret Key
   - Test the connection
   - Save settings

## ⚙️ Configuration

### API Setup

1. **Get Bookeo Credentials**:
   - Log into your Bookeo account
   - Go to Settings > API
   - Generate API Key and Secret Key

2. **WordPress Configuration**:
   - Navigate to **Settings > Bookeo API**
   - Enter your API credentials
   - Configure default settings:
     - Classes per page (default: 12)
     - Show category filters (default: enabled)
     - Show pagination (default: enabled)
   - Click "Test Connection" to verify setup

## 🎯 Usage

### Basic Shortcode

```
[bookeo_classes]
```

Displays all upcoming classes with default settings.

### Advanced Shortcode Options

```
[bookeo_classes limit="6" category="security-guard" show_filters="false" columns="2"]
```

### Shortcode Parameters

| Parameter | Description | Options | Default |
|-----------|-------------|---------|---------|
| `limit` | Number of classes to show | 1-50 | 12 |
| `category` | Filter by specific category | `security-guard`, `firearms`, `spo`, `nra`, `uscca`, `life-saving`, `all` | `all` |
| `show_filters` | Display category filter buttons | `true`, `false` | `true` |
| `show_pagination` | Display pagination controls | `true`, `false` | `true` |
| `columns` | Number of columns in grid | `1`, `2`, `3`, `4` | `3` |

### Usage Examples

**Security Guard Classes Only**:
```
[bookeo_classes category="security-guard" limit="8"]
```

**Simple List View**:
```
[bookeo_classes columns="1" show_filters="false" limit="5"]
```

**Compact Grid**:
```
[bookeo_classes columns="4" limit="16" show_pagination="true"]
```

## 🎨 Styling

### CSS Classes

The plugin uses these main CSS classes for styling:

- `.bookeo-classes-container` - Main container
- `.bookeo-filters` - Filter buttons container
- `.bookeo-classes-grid` - Classes grid layout
- `.bookeo-class-card` - Individual class card
- `.bookeo-pagination` - Pagination controls

### Custom Styling

Add custom CSS to your theme or use WordPress Customizer:

```css
.bookeo-class-card {
    border-radius: 15px;
    box-shadow: 0 5px 25px rgba(0,0,0,0.1);
}

.bookeo-filter-btn {
    background: #your-color;
    border-color: #your-color;
}
```

### Color Variables

The plugin uses CSS custom properties:

```css
:root {
    --bookeo-navy: #1a2a45;
    --bookeo-orange: #ff6600;
    --bookeo-gray: #6c757d;
    --bookeo-light-gray: #f8f9fa;
    --bookeo-white: #ffffff;
}
```

## 🔧 Development

### File Structure

```
bookeo-api-plugin/
├── bookeo-api.php          # Main plugin file
├── assets/
│   ├── bookeo-api.css      # Plugin styles
│   └── bookeo-api.js       # Plugin JavaScript
└── README.md               # Documentation
```

### Hooks and Filters

**Actions**:
- `bookeo_api_before_classes` - Before classes display
- `bookeo_api_after_classes` - After classes display

**Filters**:
- `bookeo_api_class_categories` - Modify available categories
- `bookeo_api_class_card_html` - Customize class card HTML
- `bookeo_api_booking_url` - Modify booking URL

### AJAX Endpoints

- `bookeo_get_classes` - Fetch classes data
- `bookeo_test_connection` - Test API connection

## 🐛 Troubleshooting

### Common Issues

**Classes not displaying**:
1. Check API credentials in Settings > Bookeo API
2. Test API connection using the "Test Connection" button
3. Verify Bookeo account has active products
4. Check browser console for JavaScript errors

**Styling issues**:
1. Clear any caching plugins
2. Check for theme CSS conflicts
3. Verify plugin CSS is loading (view page source)

**Shortcode not working**:
1. Ensure plugin is activated
2. Check shortcode syntax
3. Verify you're using the correct parameter names

### Debug Mode

Add this to your `wp-config.php` for debugging:

```php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
```

Check `/wp-content/debug.log` for error messages.

## 📊 Performance

### Optimization Tips

1. **Limit Classes**: Use reasonable `limit` values (6-12 per page)
2. **Enable Caching**: Use caching plugins for better performance
3. **Optimize Images**: Ensure Bookeo images are optimized
4. **Use CDN**: Consider CDN for faster asset loading

### Caching

The plugin respects WordPress caching. For custom caching:

```php
// Cache classes for 15 minutes
$classes = get_transient('bookeo_classes_' . $category);
if (false === $classes) {
    $classes = fetch_bookeo_classes($category);
    set_transient('bookeo_classes_' . $category, $classes, 15 * MINUTE_IN_SECONDS);
}
```

## 🔒 Security

- API credentials stored securely in WordPress options
- AJAX requests use WordPress nonces
- All user inputs sanitized and escaped
- No direct file access allowed

## 📱 Browser Support

- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+
- Mobile browsers (iOS Safari, Chrome Mobile)

## 📄 License

This plugin is proprietary software developed for Security Training Academy.

## 📞 Support

For technical support:
- **Developer**: Haytham Fourati
- **Email**: support@securitytrainingclasses.com
- **Documentation**: See plugin admin page

---

**Version**: 1.0.0  
**WordPress Compatibility**: 5.0+  
**PHP Compatibility**: 7.4+  
**Last Updated**: January 2025
