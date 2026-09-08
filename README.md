# Government Service Portal

Government Service Portal is a Laravel-based web application for managing citizen applications, departmental services, fee payments, notices, feedback, and administrative review workflows.

## Features

- Citizen registration and authentication
- Service browsing and application submission
- Document upload for applications
- QR-based payment flow with payment statement upload
- Payment verification status tracking
- OTP-based forgot password flow
- Citizen and admin dashboards
- Department, service, notice, and feedback management
- Role-based access control for citizen and admin users

## Tech Stack

- Laravel 13
- PHP 8.4
- MySQL
- Blade templates
- Bootstrap 5
- Vite
- Tailwind CSS utilities for supporting assets

## Prerequisites

- PHP 8.4 or newer
- Composer
- Node.js and npm
- MySQL 8+

## Installation

Clone the repository and install dependencies:

```bash
composer install
npm install
```

Copy the environment file and generate an application key:

```bash
copy .env.example .env
php artisan key:generate
```

Update `.env` with your database and mail settings.

## Environment Setup

Important `.env` values:

```env
APP_URL=http://localhost:8000
DB_CONNECTION=mysql
DB_DATABASE=government_service
DB_HOST=127.0.0.1
DB_PORT=3306
DB_USERNAME=root
DB_PASSWORD=your_password

MAIL_MAILER=smtp
MAIL_SCHEME=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_FROM_ADDRESS=your_email@gmail.com
MAIL_FROM_NAME="Government Service"
```

## Database Setup

Run migrations and seeders:

```bash
php artisan migrate
php artisan db:seed
```

## Development

Start the Laravel server:

```bash
php artisan serve
```

In another terminal, start the frontend build watcher:

```bash
npm run dev
```

## Testing

Run the test suite:

```bash
php artisan test
```

## Key User Flows

### Citizen

- Register and log in
- Browse available government services
- Submit an application with required documents
- Pay fees through QR-based flow
- Upload payment statement image
- Track payment verification status

### Password Reset

- Enter email on the forgot password page
- Receive a 6-digit OTP by email
- Verify OTP and set a new password

### Admin

- Review submitted applications
- Update application status
- Inspect uploaded documents and payment statements
- Manage services, departments, notices, and feedback

## Project Structure

- `app/Http/Controllers` - citizen, admin, and auth controllers
- `app/Models` - Eloquent models
- `app/Enums` - application and payment status enums
- `resources/views` - Blade views for citizen, admin, and auth pages
- `database/migrations` - database schema changes
- `routes` - web and auth routes

## Notes

- Payment receipt and verification screens depend on a running MySQL service.
- OTP password reset uses Gmail SMTP in `.env`.
- If you change `.env`, run `php artisan config:clear` before testing mail or auth flows.

## License

This project is built with Laravel and follows the license terms of the underlying framework and project assets.
