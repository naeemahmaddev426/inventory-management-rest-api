<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

# 🚀 Inventory Management REST API

![Laravel](https://img.shields.io/badge/Laravel-13.x-FF2D20?logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.4-777BB4?logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?logo=mysql&logoColor=white)
![Docker](https://img.shields.io/badge/Docker-Enabled-2496ED?logo=docker&logoColor=white)
![REST API](https://img.shields.io/badge/API-REST-success)
![License](https://img.shields.io/badge/License-MIT-green)

A production-style **Inventory Management REST API** built with **Laravel 13** following modern backend development practices including **Repository Pattern**, **Service Layer**, **Laravel Sanctum Authentication**, **API Resources**, **Form Request Validation**, and **Docker**.

---

# 📖 Project Overview

This project is designed as an enterprise-level Inventory Management backend that provides secure REST APIs for managing inventory, products, suppliers, customers, purchases, sales, and stock management.

The goal of this project is to demonstrate professional Laravel backend architecture and REST API development practices.

---

# ✨ Current Features

## ✅ Authentication Module

- User Registration
- User Login
- User Logout
- Forgot Password
- Reset Password
- Change Password
- Email Verification
- Laravel Sanctum Authentication
- Password Hashing
- API Token Authentication

---

## ✅ Category Module

- Create Category
- Get All Categories
- Get Single Category
- Update Category
- Delete Category
- Pagination
- Validation
- API Resources

---

# 🚧 Upcoming Modules

- Product Management
- Brand Management
- Supplier Management
- Customer Management
- Purchase Management
- Sales Management
- Warehouse Management
- Stock Management
- Reports
- Dashboard APIs
- Notifications
- Roles & Permissions
- Activity Logs

---

# 🛠 Tech Stack

| Technology         | Version |
| ------------------ | ------- |
| Laravel            | 13      |
| PHP                | 8.4     |
| MySQL              | 8       |
| Docker             | Latest  |
| Laravel Sanctum    | ✔       |
| REST API           | ✔       |
| Repository Pattern | ✔       |
| Service Layer      | ✔       |
| API Resources      | ✔       |
| Form Requests      | ✔       |
| Git & GitHub       | ✔       |

---

# 📁 Project Structure

```
app
├── Http
│   ├── Controllers
│   ├── Middleware
│   ├── Requests
│   └── Resources
│
├── Models
├── Repositories
├── Services
├── Providers
├── Traits

database
routes
storage
tests
```

---

# 🏗 Architecture

```
Client

   │

REST API

   │

Controller

   │

Service Layer

   │

Repository Layer

   │

Eloquent Model

   │

MySQL Database
```

---

# 🔐 Authentication Endpoints

| Method | Endpoint                |
| ------ | ----------------------- |
| POST   | /api/v1/register        |
| POST   | /api/v1/login           |
| POST   | /api/v1/logout          |
| POST   | /api/v1/forgot-password |
| POST   | /api/v1/reset-password  |
| POST   | /api/v1/change-password |
| GET    | /api/v1/email/verify    |

---

# 📂 Category Endpoints

| Method | Endpoint                |
| ------ | ----------------------- |
| GET    | /api/v1/categories      |
| POST   | /api/v1/categories      |
| GET    | /api/v1/categories/{id} |
| PUT    | /api/v1/categories/{id} |
| DELETE | /api/v1/categories/{id} |

---

# 🐳 Docker Installation

Clone the repository

```bash
git clone https://github.com/naeemahmaddev426/Inventory_Management_Rest_Api.git
```

Enter the project

```bash
cd Inventory_Management_Rest_Api
```

Build Docker Containers

```bash
docker compose up --build
```

Run in background

```bash
docker compose up -d
```

---

# 🌐 Application URLs

Laravel API

```
http://localhost:8002
```

phpMyAdmin

```
http://localhost:8083
```

---

# ⚙ Environment

Copy the environment file

```bash
cp .env.example .env
```

Generate Application Key

```bash
php artisan key:generate
```

Run Migrations

```bash
php artisan migrate
```

---

# 🧪 API Testing

The APIs are tested using:

- Postman
- REST Client
- JSON Responses

---

# 📌 Development Practices

- RESTful API Standards
- Clean Architecture
- Repository Pattern
- Service Layer
- API Resource Responses
- Request Validation
- Secure Authentication
- Dockerized Environment
- Versioned APIs
- Git Workflow

---

# 📈 Project Status

| Module             | Status         |
| ------------------ | -------------- |
| Authentication     | ✅ Completed   |
| Password Reset     | ✅ Completed   |
| Email Verification | ✅ Completed   |
| Category CRUD      | ✅ Completed   |
| Product Module     | 🚧 In Progress |
| Supplier Module    | ⏳ Planned     |
| Customer Module    | ⏳ Planned     |
| Purchase Module    | ⏳ Planned     |
| Sales Module       | ⏳ Planned     |

---

# 👨‍💻 Author

**Naeem Ahmad**

Backend Laravel Developer

GitHub

https://github.com/naeemahmaddev426

---

# ⭐ Support

If you like this project, don't forget to ⭐ Star this repository.

---

# 📄 License

This project is licensed under the MIT License.

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

In addition, [Laracasts](https://laracasts.com) contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

You can also watch bite-sized lessons with real-world projects on [Laravel Learn](https://laravel.com/learn), where you will be guided through building a Laravel application from scratch while learning PHP fundamentals.

## Agentic Development

Laravel's predictable structure and conventions make it ideal for AI coding agents like Claude Code, Cursor, and GitHub Copilot. Install [Laravel Boost](https://laravel.com/docs/ai) to supercharge your AI workflow:

```bash
composer require laravel/boost --dev

php artisan boost:install
```

Boost provides your agent 15+ tools and skills that help agents build Laravel applications while following best practices.

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabiliti

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
