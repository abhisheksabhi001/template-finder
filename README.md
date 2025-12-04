# YBT Digital - Digital Product Selling Website

A comprehensive digital marketplace built with PHP, featuring a mobile-first responsive design with native app-like experience on mobile and professional website experience on desktop.

## Features

### User Side (Frontend)
- **Authentication System**: Login, Signup, Forgot Password, User Profile
- **Responsive Design**: Mobile-first with bottom navigation, desktop with top navigation
- **Product Browsing**: Landing page, product listing with filters, product details
- **Shopping Cart**: Add to cart, cart management, checkout process
- **Order Management**: Order history, secure downloads with expiry
- **Support System**: Contact forms, FAQ, ticket system

### Admin Side (Backend)
- **Product Management**: Add/Edit/Delete products, file uploads, categories
- **Order Management**: View orders, manage refunds, payment tracking
- **User Management**: View users, block/unblock, purchase history
- **Coupon System**: Create discount codes, usage limits, expiry dates
- **Analytics**: Sales reports, top products, revenue tracking
- **Settings**: Payment gateway configuration, tax settings, branding

### Technical Features
- **Mobile-First Design**: Native app-like experience with Material Design
- **Dark/Light Mode**: Theme switching with localStorage persistence
- **Payment Integration**: Razorpay, Stripe, PayPal support
- **Security**: Secure file downloads, user authentication, input validation
- **Performance**: Lazy loading, optimized images, efficient database queries

## Tech Stack

- **Frontend**: HTML5, CSS3, JavaScript (Vanilla)
- **Backend**: PHP 7.4+
- **Database**: MySQL 5.7+
- **UI Framework**: Custom CSS with Material Design principles
- **Icons**: Font Awesome 6
- **Fonts**: Google Fonts (Inter)

## Installation

### Prerequisites
- XAMPP/WAMP/LAMP server
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web browser

### Setup Instructions

1. **Clone/Download the project**
   ```
   Place the project files in your web server directory (e.g., C:\xampp\htdocs\AA DIGITS)
   ```

2. **Database Configuration**
   - Open `config/database.php`
   - Update database credentials if needed (default: localhost, root, no password)
   - Create a database named `ybt_digital`

3. **Run Setup Script**
   - Navigate to `http://localhost/AA%20DIGITS/setup.php`
   - This will create all database tables and insert sample data

4. **Configure Settings**
   - Update `config/config.php` with your site details
   - Configure payment gateway credentials
   - Set up email SMTP settings

5. **File Permissions**
   - Ensure `uploads/` directory is writable
   - Set appropriate permissions for file uploads

### Default Admin Login
- **Email**: admin@ybtdigital.com
- **Password**: admin123

## Project Structure

```
AA DIGITS/
├── assets/
│   ├── css/
│   │   └── style.css          # Main stylesheet
│   ├── js/
│   │   └── app.js             # Main JavaScript file
│   └── images/                # Image assets
├── classes/
│   ├── User.php               # User management class
│   └── Product.php            # Product management class
├── config/
│   ├── config.php             # Global configuration
│   └── database.php           # Database connection
├── database/
│   └── schema.sql             # Database schema
├── includes/
│   ├── header.php             # Common header
│   └── footer.php             # Common footer
├── api/
│   ├── cart.php               # Cart API endpoints
│   └── search-suggestions.php # Search suggestions
├── uploads/                   # File upload directory
├── index.php                  # Homepage
├── products.php               # Product listing
├── login.php                  # Login page
├── register.php               # Registration page
├── logout.php                 # Logout handler
├── setup.php                  # Database setup script
└── README.md                  # This file
```

## Key Features Implemented

### ✅ Completed Features
1. **Project Structure & Database**: Complete schema with all required tables
2. **Authentication System**: Login, register, logout with session management
3. **Responsive Design**: Mobile-first with bottom navigation and desktop layout
4. **Landing Page**: Hero section, featured products, categories, testimonials
5. **Product Listing**: Filters, search, pagination, grid/list view
6. **Shopping Cart**: Add to cart functionality with AJAX
7. **Configuration System**: Centralized config with utility functions

### 🚧 In Progress
- Product detail pages
- Checkout system with payment integration
- Admin dashboard
- Order management system

### 📋 Pending Features
- File upload and download system
- Coupon management
- Email notifications
- Advanced analytics
- Support ticket system

## Mobile Design

The website features a native app-like experience on mobile devices:

- **App Bar**: Fixed top bar with logo and menu
- **Bottom Navigation**: 4-tab navigation (Home, Products, Cart, Profile)
- **Material Design**: Cards, buttons, and components follow Material Design
- **Touch-Friendly**: Large buttons and touch targets
- **Smooth Animations**: Native-like transitions and interactions

## Desktop Design

Professional website experience on desktop:

- **Top Navigation**: Traditional navbar with dropdowns
- **Grid Layouts**: Multi-column product grids
- **Hover Effects**: Interactive elements with hover states
- **Professional Typography**: Optimized for readability

## Browser Support

- Chrome 70+
- Firefox 65+
- Safari 12+
- Edge 79+
- Mobile browsers (iOS Safari, Chrome Mobile)

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Support

For support and questions:
- Email: support@ybtdigital.com
- Documentation: Check the code comments and this README
- Issues: Create an issue in the repository

## Changelog

### Version 1.0.0 (Current)
- Initial release with core functionality
- Mobile-first responsive design
- Basic authentication and product management
- Shopping cart functionality
- Admin foundation

### Planned Updates
- Payment gateway integration
- Advanced admin features
- Email notifications
- Performance optimizations
- Additional themes and customization options
