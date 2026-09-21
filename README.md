# The Plug - Revamp

The Plug - Revamp is a PHP/MySQL e-commerce web application developed as part of a university web development project.

This version builds on the original The Plug application and was developed as a separate implementation for another module, with a focus on server-side PHP development, database interaction and e-commerce functionality.

## Features

### User Features

- User registration and login
- User authentication and sessions
- Product browsing
- Product details
- Product variants
- Shopping cart
- Checkout
- Order confirmation
- Order history
- Product reviews

### Admin Features

- Admin authentication
- Admin dashboard
- User management
- Product management
- Product creation
- Product editing
- Product deletion
- Product variant management

## Technologies

- PHP
- MySQL
- HTML5
- CSS3
- JavaScript

## Application Structure

The application is organised into several components:

- `admin/` - Administrative functionality
- `classes/` - Object-oriented PHP classes
- `css/` - Application stylesheets
- `images/` - Product and application images
- `js/` - Client-side JavaScript
- PHP files in the project root - User-facing application pages and shared components

## Object-Oriented Design

The project uses object-oriented PHP classes to separate parts of the application logic.

Key classes include:

- `Product`
- `ProductManager`
- `ProductVariant`
- `User`
- `UserManager`

These classes are used to manage products, product variants and user-related functionality.

## Database

The application uses MySQL for persistent data storage.

Database functionality is used for areas including:

- Users
- Products
- Product variants
- Shopping carts
- Orders
- Reviews

## E-Commerce Workflow

The main purchasing workflow follows:

Browse Products → View Product → Select Variant → Add to Cart → Checkout → Order Confirmation → Order History

## Admin Workflow

Administrators can manage the application's products, variants and users through the dedicated admin area.

Admin workflow:

Admin Login → Admin Dashboard → Manage Products / Manage Variants / Manage Users

## Project Structure

The main project directories include:

- `admin/` - Administrative pages and functionality
- `classes/` - PHP application classes
- `css/` - Stylesheets
- `images/` - Images and assets
- `js/` - JavaScript files

Key application pages include:

- `index.php`
- `products.php`
- `product_detail.php`
- `cart.php`
- `checkout.php`
- `confirmation.php`
- `order_history.php`
- `sign_in.php`
- `sign_up.php`

## Running the Project

### Requirements

- PHP
- MySQL
- Apache or another PHP-compatible web server

### Setup

1. Clone the repository.

2. Place the project inside your local PHP/Apache web server directory.

3. Create the required MySQL database.

4. Configure the database connection in the project configuration.

5. Start Apache and MySQL.

6. Open the application through your local web server.

> This project was developed as a university project and may require configuration changes depending on the local development environment.

## Project Background

This project was developed as a separate version of The Plug for another university module.

The project focuses on developing an e-commerce application using PHP and MySQL, with server-side processing, database interaction, authentication and administrative functionality.

## Screenshots

Screenshots of the application can be added here to demonstrate the main user interface, product pages, checkout workflow and administrative dashboard.

## Future Improvements

Potential future improvements include:

- Improved input validation
- Expanded automated testing
- Additional administrative functionality
- Improved security configuration
- Additional payment functionality
- Further UI improvements

---

*University project developed as part of a web development module.*
