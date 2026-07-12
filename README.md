# 3D Med Theme (V2)

A complete rebuild of the 3D Med reservation platform theme, using modern WordPress development standards.

---

## About

3D Med is a reservation platform for a 3D dental printing service. This theme powers the customer-facing platform where dental clinics register, submit orders for 3D prints, manage invoices, and track their reservations.

The original theme (still in production) was built as a functional-style WordPress theme with mixed concerns, jQuery reliance, and limited documentation. This V2 is a ground-up rebuild focused on maintainability, testability, and modern WordPress standards.

---

## Architecture

- **Object-Oriented PHP** with PSR-4 autoloading via Composer
- **Dependency Injection Container** for service management
- **Repository Pattern** for data access
- **Service Layer** for business logic
- **Abstract base classes** for shared behavior (CPTs, Repositories, AJAX handlers, Shortcodes)
- **Vanilla JavaScript** (no jQuery)
- **SCSS** with **ITCSS** architecture
- **ACF Pro** with JSON sync for version-controlled field structure
- **WordPress Coding Standards** (PHPCS/PHPCBF)

---

## Features

### Foundation

- Composer autoloading (PSR-4)
- Dependency Injection Container
- 10 Custom Post Types with an abstract base class (Customers, Orders, Invoices, Materials, etc.)
- Custom user role (`3dmed_stranka`)
- ACF field groups with JSON sync
- Widget areas (footer columns) with Gutenberg block support
- i18n throughout
- Full security (nonces, input sanitization, output escaping)

### Templates

- Base templates (`header.php`, `footer.php`, `page.php`, `front-page.php`, `404.php`)
- Template parts for reusable pieces
- Shortcode system

### Customer Registration

- Registration form template with company + representative sections
- Generic `Validator` class with fluent chaining
- `CustomerRepository` for data access
- `CustomerService` for business logic
- `RegistrationHandler` (AJAX) with server-side validation
- Per-field error display in the UI
- Vanilla JS submission with `fetch` API
- Choices.js integration for enhanced select fields

### Styling

- SCSS with ITCSS folder structure
- `@forward`/`@use` for scoped modules
- Site header, footer, and forms styled

---

## Project Structure

```
3dmedV2/
├── src/                              # PSR-4 autoloaded PHP classes
│   ├── Container.php                 # DI container
│   ├── CustomPostTypes/              # CPT registration classes
│   │   ├── AbstractPostType.php
│   │   ├── CustomerPostType.php
│   │   ├── OrderPostType.php
│   │   └── ...
│   ├── Repositories/                 # Data access layer
│   │   ├── AbstractRepository.php
│   │   └── CustomerRepository.php
│   ├── Services/                     # Business logic
│   │   └── CustomerService.php
│   ├── Ajax/                         # AJAX request handlers
│   │   ├── AbstractAjaxHandler.php
│   │   └── RegistrationHandler.php
│   ├── Shortcodes/                   # Shortcode handlers
│   │   ├── AbstractShortcode.php
│   │   └── RegistrationShortcode.php
│   ├── Validators/                   # Input validation
│   │   └── Validator.php
│   ├── Roles/                        # Custom user roles
│   │   └── RoleManager.php
│   ├── Widgets/                      # Widget areas
│   │   └── Sidebars.php
│   ├── Assets/                       # Script/style enqueuing
│   │   ├── ScriptEnqueuer.php
│   │   └── StyleEnqueuer.php
│   └── Strings/                      # Translatable strings for JS
│       └── RegistrationStrings.php
│
├── templates/                        # View files (pure PHP)
│   ├── forms/
│   │   └── registration.php
│   └── parts/
│       └── logged-in-bar.php
│
├── assets/
│   ├── scss/                         # SCSS source (ITCSS)
│   │   ├── main.scss
│   │   ├── 1-settings/
│   │   ├── 2-tools/
│   │   ├── 3-generic/
│   │   ├── 4-elements/
│   │   ├── 5-objects/
│   │   ├── 6-components/
│   │   └── 7-utilities/
│   ├── css/                          # Compiled CSS
│   ├── js/
│   │   └── frontend/
│   └── fonts/
│
├── acf-json/                         # ACF field definitions (version-controlled)
├── libs/                             # Third-party libraries (PDF engines)
├── vendor/                           # Composer dependencies (gitignored)
├── node_modules/                     # npm dependencies (gitignored)
│
├── functions.php                     # Theme bootstrap
├── header.php
├── footer.php
├── index.php
├── page.php
├── front-page.php
├── 404.php
├── style.css                         # Theme metadata
├── composer.json
├── package.json
└── phpcs.xml                         # Code standards config
```

---

## Installation

**Requirements:**

- WordPress 6.0+
- PHP 7.4+
- ACF Pro
- Composer
- Node.js + npm

**Steps:**

```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install

# Compile SCSS
npm run sass
```

Then activate the theme in WordPress admin.

---

## Development Commands

```bash
# Compile SCSS once
npm run sass

# Watch SCSS for changes
npm run sass:watch

# Production build (minified)
npm run sass:build

# Check WordPress coding standards
php vendor/bin/phpcs --standard=WordPress src/

# Auto-fix formatting issues
php vendor/bin/phpcbf --standard=WordPress src/
```

---

## Standards Applied

- **PSR-4 autoloading** – no manual `require` statements, no functions in global namespace
- **PHPDoc on every class, method, and property**
- **All strings escaped on output** (`esc_html`, `esc_attr`, `esc_url`)
- **All input sanitized** (`sanitize_text_field`, `sanitize_email`)
- **Nonces on every form/AJAX request** for CSRF protection
- **i18n throughout** – all user-facing strings wrapped in translation functions
- **Vanilla JS** – no jQuery, uses `fetch` and modern APIs
- **WordPress Coding Standards** (WPCS) applied via PHPCBF

---

## Roadmap

- Login system (form, AJAX, session handling)
- Customer profile page (view + edit representative + company info)
- Order submission flow
- Invoice management
- Email template system with Mpdf
- Gutenberg block for customer info card
- Extract reusable functionality into companion plugin
- PHPUnit tests
- Migration script for existing customer data (if needed)

---

## Notes on Field Mapping

Because the platform runs in Slovenian, ACF field names and post type slugs remain in Slovenian to match the business terminology (`stranke`, `narocila`, `fakture`, `ime_podjetja`, `davcna_stevilka`, etc.). English is used exclusively for class names, method names, and internal code.

Form field keys (e.g. `company_name`, `rep_email`) are mapped to ACF field names in each Repository's `mapDataToMeta()` method, keeping the frontend clean and the storage backwards-compatible with the original theme's data structure.
