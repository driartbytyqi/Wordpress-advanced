# Auto Dealership Pro - WordPress Theme

A professional WordPress theme for car dealerships with custom car listings, inquiry forms, and complete inventory management through the WordPress admin dashboard.

## Features

- **Custom Post Type**: Dedicated "Cars" post type with full WordPress integration
- **Advanced Filtering**: Filter cars by make, type, price range, and more
- **Detailed Car Pages**: Comprehensive vehicle information with inquiry forms
- **Admin Meta Boxes**: Easy-to-use interface for adding car details (price, year, mileage, etc.)
- **Taxonomies**: Organize cars by Make, Type, and Condition
- **Email Inquiries**: Automatic email notifications for customer inquiries
- **Responsive Design**: Mobile-friendly layout that works on all devices
- **Clean Code**: Well-structured, documented PHP following WordPress standards

## Installation

### Method 1: Upload via WordPress Admin

1. Download the theme as a ZIP file
2. Go to WordPress Admin → Appearance → Themes
3. Click "Add New" → "Upload Theme"
4. Choose the ZIP file and click "Install Now"
5. Activate the theme

### Method 2: Manual Installation

1. Download and extract the theme files
2. Upload the theme folder to `/wp-content/themes/`
3. Go to WordPress Admin → Appearance → Themes
4. Find "Auto Dealership Pro" and click "Activate"

### Post-Installation Setup

1. **Create Navigation Menu**
   - Go to Appearance → Menus
   - Create a new menu and assign it to "Primary Menu"

2. **Add Sample Cars**
   - Go to Cars → Add New Car
   - Fill in the car details using the meta boxes
   - Set featured image, make, type, and condition
   - Publish the car

3. **Configure Permalinks**
   - Go to Settings → Permalinks
   - Choose "Post name" or "Custom Structure"
   - Click "Save Changes" to flush rewrite rules

## Usage

### Adding a New Car

1. Go to **Cars → Add New Car**
2. Enter the car title (e.g., "2023 Toyota Camry LE")
3. Add a description in the content editor
4. Fill in the **Car Details** meta box:
   - Price
   - Year
   - Mileage
   - Transmission (Automatic/Manual/CVT)
   - Fuel Type (Gasoline/Diesel/Electric/Hybrid)
   - Engine (e.g., "2.0L Turbo")
   - Color
   - VIN
5. Set a **Featured Image** (this will be the main car photo)
6. Select **Make**, **Type**, and **Condition** from the taxonomies
7. Click **Publish**

### Managing Taxonomies

- **Car Make**: Go to Cars → Make (e.g., Toyota, Honda, Ford)
- **Car Type**: Go to Cars → Type (e.g., Sedan, SUV, Truck)
- **Car Condition**: Go to Cars → Condition (e.g., New, Used, Certified Pre-Owned)

### Viewing Inquiries

Customer inquiries are automatically sent to the WordPress admin email address. To change this:
- Go to Settings → General
- Update the "Email Address" field

## Theme Structure

\`\`\`
auto-dealership-pro/
├── style.css              # Theme stylesheet and metadata
├── functions.php          # Theme functions and custom post type
├── header.php            # Site header template
├── footer.php            # Site footer template
├── index.php             # Default template (fallback)
├── archive-car.php       # Car listings with filters
├── single-car.php        # Individual car detail page
└── README.md             # This file
\`\`\`

## Customization

### Changing Colors

Edit the CSS variables in `style.css`:

\`\`\`css
:root {
  --primary: #dc2626;        /* Main brand color */
  --primary-dark: #b91c1c;   /* Darker shade */
  --secondary: #1f2937;      /* Secondary color */
  --accent: #f59e0b;         /* Accent color */
}
\`\`\`

### Adding More Car Details

To add custom fields, edit `functions.php`:

1. Add the field to the meta box callback function
2. Add the field to the save function
3. Display it in `single-car.php`

## Requirements

- WordPress 5.0 or higher
- PHP 7.4 or higher
- MySQL 5.6 or higher

## Support

For issues or questions:
1. Check that permalinks are properly configured
2. Ensure the theme is activated
3. Verify that you've added at least one car post

## License

This theme is free to use and modify for your projects.

## Credits

Built with WordPress best practices and modern PHP standards.
