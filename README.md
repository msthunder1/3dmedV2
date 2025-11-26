# 3D Med Theme V2

Modern WordPress theme for 3D printing and CNC business management. Refactored with OOP principles, WordPress coding standards, and best practices.

## Features

- Custom Post Types for Orders, Invoices, Customers, Materials
- User authentication and role management
- Order submission forms (3D printing & CNC)
- Invoice generation with PDF export
- Email notification system
- STL file viewer
- Customer dashboard

## Requirements

- PHP 7.4 or higher
- WordPress 6.0 or higher
- Composer

## Installation

1. Clone repository into `wp-content/themes/`
2. Run `composer install`
3. Activate theme in WordPress admin
4. Configure settings under "3DMed Settings"

## Development

### Code Standards

Follow WordPress coding standards:

```bash
composer phpcs    # Check code
composer phpcbf   # Auto-fix code
```

### Structure

```
src/              # OOP classes (PSR-4 autoloaded)
templates/        # View templates
assets/           # CSS, JS, images
libs/             # Third-party libraries
tests/            # PHPUnit tests
```

## Credits

Refactored for 10up Engineering Best Practices.

## License

GPL-2.0-or-later