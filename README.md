# Mini-Ecommerce API

A Laravel-based e-commerce API with JWT authentication, role-based access control, and product management with image uploads.

## Features

- **JWT Authentication**: Secure token-based authentication using Tymon/JWT
- **Role-Based Access Control**: Two user roles (Admin and User) with different permissions
- **Product Management**: Full CRUD operations for products (Admin only)
- **Image Management**: Upload and delete multiple product images (Admin only)
- **Comments System**: Authenticated users can comment on products
- **Public Access**: Guests can view products without authentication

## User Roles & Permissions

### Admin
- Create, update, and delete products
- Upload and delete product images
- Full access to all resources

### User (Authenticated)
- View products
- Create, update, and delete their own comments

### Guest (Unauthenticated)
- View products (read-only)

## Prerequisites

- PHP 8.4
- Laravel 12
- MySQL

## Installation

### 1. Clone and Install Dependencies
```bash
composer install
```

### 2. Configure Environment
```bash
cp .env.example .env
php artisan key:generate
```

### 3. Configure Database

Update your `.env` file with database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mini_ecommerce
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 4. Generate JWT Secret

Generate the JWT secret key for authentication:
```bash
php artisan jwt:secret
```

This command will add `JWT_SECRET` to your `.env` file.

### 5. Run Installation Command
```bash
php artisan project:install
```

This command will:
- Run database migrations
- Seed the database with test users and products
- Create storage symlink
- Clear caches

### 6. Test Users

The seeder creates two default users:

**Admin User:**
- Email: `admin@admin.com`
- Password: `password`
- Role: Admin

**Regular User:**
- Email: `testuser@gmail.com`
- Password: `password`
- Role: User

### 7. Start Development Server
```bash
composer run dev
```

Or manually:
```bash
php artisan serve
```

## Documentation

- **Postman Collection**: Import `Mini Ecommerce.postman_collection.json` from the repository root for API testing
- **Database Schema**: View `ERD.png` in the repository root for the database structure

## API Endpoints

### Authentication Endpoints
- `POST /api/auth/register` - Register new user
- `POST /api/auth/login` - Login and receive JWT token
- `GET /api/auth/refresh-token` - Refresh JWT token (requires authentication)
- `GET /api/auth/user` - Get authenticated user details (requires authentication)
- `POST /api/auth/logout` - Logout (requires authentication)

### Product Endpoints
- `GET /api/products` - List all products (public)
- `GET /api/products/{id}` - Get single product (public)
- `POST /api/products` - Create product (admin only)
- `PUT /api/products/{id}` - Update product (admin only)
- `DELETE /api/products/{id}` - Delete product (admin only)

### Product Image Endpoints
- `POST /api/products/{product}/images` - Upload image (admin only)
- `DELETE /api/products/{product}/images/{media}` - Delete image (admin only)

### Comment Endpoints
- `POST /api/products/{product}/comments` - Create comment on product (authenticated users)
- `PUT /api/products/{product}/comments/{comment}` - Update own comment (authenticated users)
- `DELETE /api/products/{product}/comments/{comment}` - Delete own comment (authenticated users)