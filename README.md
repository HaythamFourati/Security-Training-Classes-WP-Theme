# Security Training Classes - WordPress Theme

A professional WordPress theme developed for Security Training Academy, featuring dynamic class management, Bookeo API integration, and a comprehensive training platform.

## 🚀 Features

### Core Functionality
- **Bookeo API Integration**: Real-time class scheduling and availability
- **Dynamic Class Management**: Automated class display and filtering
- **Professional Blog System**: SEO-optimized blog with custom pagination
- **Contact Form Integration**: Contact Form 7 with custom styling
- **Responsive Design**: Mobile-first approach with Tailwind CSS
- **Category-Specific Pages**: Dedicated pages for each training type

### Training Categories
- Security Guard Training
- Firearms Certifications
- Special Police Training (SPO)
- NRA Classes
- USCCA Classes
- Life Saving Courses (CPR, ACLS, PALS)

### Page Templates
- **Homepage**: Hero section, class grid, testimonials, FAQ, contact
- **Blog Pages**: Professional blog index and single post templates
- **Category Pages**: Filtered class displays for each training type
- **Default Page**: Standard page template with FAQ and contact sections
- **404 Page**: Professional error page with navigation recovery

## 🛠 Technical Stack

- **Backend**: WordPress 6.0+, PHP 8.0+
- **Frontend**: JavaScript (ES6+), Tailwind CSS v4.1
- **Build Tools**: @wordpress/scripts, npm-run-all
- **APIs**: Bookeo API v2
- **Forms**: Contact Form 7 integration
- **Icons**: Font Awesome, Heroicons

## 📦 Installation

### 1. Clone Repository
```bash
git clone https://github.com/HaythamFourati/Security-Training-Classes-WP-Theme.git security-training-classes-wp-theme
cd security-training-classes-wp-theme
```

### 2. Install Dependencies
```bash
npm install
```

### 3. Build Assets
```bash
npm run build
```

### 4. WordPress Setup
1. Upload theme to `/wp-content/themes/`
2. Activate theme in WordPress admin
3. Configure APIs and plugins (see configuration section)

## ⚙️ Configuration

### Bookeo API Setup
1. Navigate to **Settings > Bookeo API** in WordPress admin
2. Enter your Bookeo API credentials:
   - **API Key**: Your Bookeo API key
   - **Secret Key**: Your Bookeo secret key
3. Save settings

**API Endpoints Used:**
- `GET /products` - Fetch available classes
- Authentication: API Key + Secret Key (Base64 encoded)

### Contact Form 7 Setup
1. Install Contact Form 7 plugin
2. Use the form code from `contact-form-7-config.txt`
3. Update form ID in `template-parts/contact-section.php`
4. Configure email settings as documented

### Global Variables
Update in `functions.php`:
```php
$phone_number = '(443) 702-7891';
$email = 'info@securitytrainingclasses.com';
```

## 🎨 Design System

### Color Palette
```css
:root {
  --color-navy: #1a2a45;
  --color-steel-gray: #6c757d;
  --color-safety-orange: #ff6600;
  --color-deep-red: #cc0000;
}
```

### Typography
- **Headings**: Instrument Serif
- **Body**: System fonts (ui-sans-serif, system-ui)
- **Responsive**: Mobile-first scaling

### Components
- **Buttons**: Safety orange primary, navy secondary
- **Cards**: Shadow-based elevation, hover effects
- **Forms**: Custom styled with focus states
- **Navigation**: Responsive dropdown menus

## 🔧 Development

### Build Commands
```bash
# Development mode with watch
npm run start

# Production build
npm run build

# Individual builds
npm run buildwp      # WordPress scripts
npm run tailwindbuild # Tailwind CSS
```

### File Structure
```
security-training-classes-wp-theme/
├── build/                          # Compiled assets
│   ├── index.js                   # Compiled JavaScript
│   ├── index.css                  # Compiled CSS
│   └── index.asset.php            # Asset dependencies
├── src/                           # Source files
│   ├── index.js                   # Main JavaScript entry
│   ├── index.css                  # Main CSS with Tailwind
│   └── scripts/                   # JavaScript modules
├── template-parts/                # Reusable components
│   ├── class-all-products-card.php
│   ├── contact-section.php
│   ├── faq-section.php
│   ├── render-all-classes.php
│   └── render-filtered-classes.php
├── page-*.php                     # Category page templates
├── functions.php                  # Theme functions
├── header.php                     # Site header
├── footer.php                     # Site footer
├── index.php                      # Blog index
├── single.php                     # Single post template
├── page.php                       # Default page template
├── 404.php                        # Error page template
├── contact-form-7-config.txt      # CF7 setup guide
└── style.css                      # WordPress theme info
```

## 🔌 API Integration

### Bookeo API
**Base URL**: `https://api.bookeo.com/v2/`

**Authentication**:
```php
$auth = base64_encode($apiKey . ':' . $secretKey);
$headers = ['Authorization: Basic ' . $auth];
```

**Key Endpoints**:
- `GET /products` - Retrieve class products
- `GET /availability` - Check class availability

**Response Format**:
```json
{
  "data": [
    {
      "productId": "string",
      "name": "string",
      "description": "string",
      "category": "string",
      "price": "number"
    }
  ]
}
```

### External Services
- **Bookeo Booking**: `https://bookeo.com/securitytrainingacademy`
- **Police Protection Services**: `https://www.policeprotectionservicesllc.com/`

## 📱 Responsive Breakpoints

```css
/* Tailwind CSS Breakpoints */
sm: 640px   /* Small devices */
md: 768px   /* Medium devices */
lg: 1024px  /* Large devices */
xl: 1280px  /* Extra large devices */
2xl: 1536px /* 2X Extra large devices */
```

## 🎯 Page Templates

### Homepage (`front-page.php`)
- Hero section with CTA
- Upcoming classes grid
- FAQ accordion
- Contact form

### Category Pages
- `page-security-guard-training.php`
- `page-firearms-certifications.php`
- `page-special-police-training.php`
- `page-nra-classes.php`
- `page-uscca-classes.php`
- `page-life-saving-courses.php`

### Blog Templates
- `index.php` - Blog index with pagination
- `single.php` - Single post with related posts

### Utility Templates
- `page.php` - Default page template
- `404.php` - Error page with recovery options

## 🔍 SEO Features

- Semantic HTML structure
- Proper heading hierarchy
- Meta descriptions support
- Schema markup ready
- Fast loading performance
- Mobile-first responsive design

## 🚀 Performance

- Minified CSS and JavaScript
- Optimized images with lazy loading
- Efficient API caching
- Minimal external dependencies
- Fast Tailwind CSS compilation

## 🔒 Security

- API keys stored securely in WordPress options
- CSRF protection on forms
- Sanitized user inputs
- Secure file permissions
- No hardcoded credentials

## 🧪 Testing

### Browser Support
- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+
- Mobile browsers (iOS Safari, Chrome Mobile)

### Device Testing
- Desktop (1920x1080, 1366x768)
- Tablet (768x1024, 1024x768)
- Mobile (375x667, 414x896)

## 📝 Customization Guide

### Adding New Training Categories
1. Create new page template: `page-{category-name}.php`
2. Update navigation menus in `header.php`
3. Add category filter in JavaScript
4. Update footer quick links

### Styling Modifications
1. Edit `src/index.css` for custom styles
2. Use Tailwind utilities in templates
3. Run `npm run build` to compile

### Contact Form Customization
1. Modify form in Contact Form 7 admin
2. Update styling in `src/index.css`
3. Adjust layout in `contact-section.php`

## 🐛 Troubleshooting

### Common Issues

**Classes not displaying:**
- Check Bookeo API credentials
- Verify API endpoint accessibility
- Check browser console for errors

**Styling not applied:**
- Run `npm run build`
- Clear WordPress cache
- Check file permissions

**Contact form not working:**
- Install Contact Form 7 plugin
- Update form ID in template
- Configure SMTP settings

## 📞 Support

For technical support or customization:
- **Developer**: Haytham Fourati
- **Repository**: [GitHub](https://github.com/HaythamFourati/Security-Training-Classes-WP-Theme)
- **Issues**: Use GitHub Issues for bug reports

## 📄 License

This theme is proprietary software developed for Security Training Academy.

---

**Last Updated**: January 2025
**Version**: 1.0.0
**WordPress Compatibility**: 6.0+
**PHP Compatibility**: 8.0+
