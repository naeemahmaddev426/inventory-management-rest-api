
<p align="center">
  <img src="public/assets/banner.svg" alt="Inventory Management REST API Banner" width="100%">
</p>

<!-- Background -->

<rect width="1600" height="500" fill="url(#bg)"/>
  <circle cx="1250" cy="150" r="380" fill="url(#glowSpot)"/>
  <circle cx="150" cy="420" r="280" fill="url(#glowSpot)" opacity="0.5"/>

<!-- subtle grid -->

<g stroke="#1e2740" stroke-width="1" opacity="0.35">
    <line x1="0" y1="80" x2="1600" y2="80"/>
    <line x1="0" y1="420" x2="1600" y2="420"/>
    <line x1="800" y1="0" x2="800" y2="500"/>
  </g>

<!-- API network lines (right side) -->

<g stroke="#FF2D20" stroke-width="1.6" fill="none" opacity="0.55">
    <path d="M 980 90 L 1120 140 L 1260 100" />
    <path d="M 1120 140 L 1120 260" />
    <path d="M 1260 100 L 1400 170 L 1400 300" />
    <path d="M 1120 260 L 1260 320 L 1400 300" />
    <path d="M 1260 320 L 1260 400" />
    <path d="M 980 90 L 980 230 L 1120 260" />
  </g>
  <g fill="#FF2D20">
    <circle cx="980" cy="90" r="6"/>
    <circle cx="1120" cy="140" r="7"/>
    <circle cx="1260" cy="100" r="6"/>
    <circle cx="1400" cy="170" r="7"/>
    <circle cx="980" cy="230" r="5"/>
    <circle cx="1120" cy="260" r="7"/>
    <circle cx="1260" cy="320" r="6"/>
    <circle cx="1400" cy="300" r="6"/>
    <circle cx="1260" cy="400" r="5"/>
  </g>
  <g fill="#ffffff" opacity="0.85">
    <circle cx="980" cy="90" r="2.5"/>
    <circle cx="1120" cy="140" r="3"/>
    <circle cx="1260" cy="100" r="2.5"/>
    <circle cx="1400" cy="170" r="3"/>
    <circle cx="1120" cy="260" r="3"/>
    <circle cx="1260" cy="320" r="2.5"/>
    <circle cx="1400" cy="300" r="2.5"/>
  </g>

<!-- Database cylinder -->

<g transform="translate(1180,300)" filter="url(#softGlow)">
    <ellipse cx="0" cy="0" rx="70" ry="22" fill="url(#dbGrad)" stroke="#FF2D20" stroke-width="2"/>
    <path d="M -70,0 L -70,90 A 70,22 0 0 0 70,90 L 70,0" fill="url(#dbGrad)" stroke="#FF2D20" stroke-width="2"/>
    <ellipse cx="0" cy="30" rx="70" ry="22" fill="none" stroke="#FF2D20" stroke-width="1.4" opacity="0.7"/>
    <ellipse cx="0" cy="60" rx="70" ry="22" fill="none" stroke="#FF2D20" stroke-width="1.4" opacity="0.7"/>
    <ellipse cx="0" cy="0" rx="70" ry="22" fill="none" stroke="#ffffff" stroke-width="1" opacity="0.25"/>
  </g>

<!-- Inventory boxes (isometric stack), left/center-right lower area -->

<g transform="translate(960,360)">
    <!-- box 1 -->
    <g transform="translate(0,0)">
      <polygon points="0,-20 40,-40 80,-20 40,0" fill="url(#boxTop)" stroke="#FF2D20" stroke-width="1.5"/>
      <polygon points="0,-20 40,0 40,40 0,20" fill="url(#boxFront)" stroke="#FF2D20" stroke-width="1.5"/>
      <polygon points="40,0 80,-20 80,20 40,40" fill="url(#boxSide)" stroke="#FF2D20" stroke-width="1.5"/>
      <line x1="20" y1="-10" x2="20" y2="30" stroke="#FF2D20" stroke-width="1" opacity="0.5"/>
      <line x1="60" y1="-10" x2="60" y2="30" stroke="#FF2D20" stroke-width="1" opacity="0.5"/>
    </g>
    <!-- box 2 -->
    <g transform="translate(-95,25)">
      <polygon points="0,-20 40,-40 80,-20 40,0" fill="url(#boxTop)" stroke="#FF2D20" stroke-width="1.5"/>
      <polygon points="0,-20 40,0 40,40 0,20" fill="url(#boxFront)" stroke="#FF2D20" stroke-width="1.5"/>
      <polygon points="40,0 80,-20 80,20 40,40" fill="url(#boxSide)" stroke="#FF2D20" stroke-width="1.5"/>
      <line x1="20" y1="-10" x2="20" y2="30" stroke="#FF2D20" stroke-width="1" opacity="0.5"/>
      <line x1="60" y1="-10" x2="60" y2="30" stroke="#FF2D20" stroke-width="1" opacity="0.5"/>
    </g>
    <!-- box 3 stacked -->
    <g transform="translate(-47,-40)">
      <polygon points="0,-20 40,-40 80,-20 40,0" fill="url(#boxTop)" stroke="#FF2D20" stroke-width="1.5"/>
      <polygon points="0,-20 40,0 40,40 0,20" fill="url(#boxFront)" stroke="#FF2D20" stroke-width="1.5"/>
      <polygon points="40,0 80,-20 80,20 40,40" fill="url(#boxSide)" stroke="#FF2D20" stroke-width="1.5"/>
      <line x1="20" y1="-10" x2="20" y2="30" stroke="#FF2D20" stroke-width="1" opacity="0.5"/>
      <line x1="60" y1="-10" x2="60" y2="30" stroke="#FF2D20" stroke-width="1" opacity="0.5"/>
    </g>
  </g>

<!-- Laravel-esque angular accent mark near title -->

<g transform="translate(75,60)">
    <polygon points="0,40 30,0 60,40 30,80" fill="none" stroke="#FF2D20" stroke-width="2.5" opacity="0.9"/>
    <polygon points="15,40 30,20 45,40 30,60" fill="#FF2D20" opacity="0.85"/>
  </g>

<!-- red accent bar under title -->

<rect x="80" y="255" width="120" height="6" rx="3" fill="#FF2D20"/>
  <rect x="80" y="255" width="120" height="6" rx="3" fill="url(#redGlow)"/>

<!-- Title -->

<text x="80" y="230" font-family="Arial, Helvetica, sans-serif" font-size="58" font-weight="800" fill="#ffffff" letter-spacing="0.5">
    Inventory Management
  </text>
  <text x="80" y="230" dy="62" font-family="Arial, Helvetica, sans-serif" font-size="58" font-weight="800" fill="#FF2D20" letter-spacing="0.5">
    REST API
  </text>

<!-- Subtitle -->

<text x="82" y="410" font-family="Arial, Helvetica, sans-serif" font-size="22" fill="#aab2c8" letter-spacing="0.5">
    Enterprise Backend System
    <tspan fill="#FF2D20" dx="10">|</tspan>
    <tspan fill="#aab2c8" dx="10">Laravel 13</tspan>
    <tspan fill="#FF2D20" dx="10">|</tspan>
    <tspan fill="#aab2c8" dx="10">Docker</tspan>
    <tspan fill="#FF2D20" dx="10">|</tspan>
    <tspan fill="#aab2c8" dx="10">REST API</tspan>
  </text>

<!-- thin top/bottom frame lines -->

<rect x="0" y="0" width="1600" height="500" fill="none" stroke="#FF2D20" stroke-opacity="0.15" stroke-width="2"/>
</svg>

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

## 👨‍💻 Author

Naeem Ahmad

Backend Laravel Developer

GitHub

https://github.com/naeemahmaddev426

---

## ⭐ Support

If you like this project, don't forget to star this repository.

---

## 📄 License

This project is licensed under the MIT License.

<svg viewBox="0 0 1600 500" xmlns="http://www.w3.org/2000/svg"></svg>
<defs></defs>

    <feMerge>                            </defs>

<!-- Background -->

<rect width="1600" height="500" fill="url(#bg)"/>
  <circle cx="1250" cy="150" r="380" fill="url(#glowSpot)"/>
  <circle cx="150" cy="420" r="280" fill="url(#glowSpot)" opacity="0.5"/>

<!-- subtle grid -->

<g stroke="#1e2740" stroke-width="1" opacity="0.35">
    <line x1="0" y1="80" x2="1600" y2="80"/>
    <line x1="0" y1="420" x2="1600" y2="420"/>
    <line x1="800" y1="0" x2="800" y2="500"/>
  </g>

<!-- API network lines (right side) -->

<g stroke="#FF2D20" stroke-width="1.6" fill="none" opacity="0.55">
    <path d="M 980 90 L 1120 140 L 1260 100" />
    <path d="M 1120 140 L 1120 260" />
    <path d="M 1260 100 L 1400 170 L 1400 300" />
    <path d="M 1120 260 L 1260 320 L 1400 300" />
    <path d="M 1260 320 L 1260 400" />
    <path d="M 980 90 L 980 230 L 1120 260" />
  </g>
  <g fill="#FF2D20">
    <circle cx="980" cy="90" r="6"/>
    <circle cx="1120" cy="140" r="7"/>
    <circle cx="1260" cy="100" r="6"/>
    <circle cx="1400" cy="170" r="7"/>
    <circle cx="980" cy="230" r="5"/>
    <circle cx="1120" cy="260" r="7"/>
    <circle cx="1260" cy="320" r="6"/>
    <circle cx="1400" cy="300" r="6"/>
    <circle cx="1260" cy="400" r="5"/>
  </g>
  <g fill="#ffffff" opacity="0.85">
    <circle cx="980" cy="90" r="2.5"/>
    <circle cx="1120" cy="140" r="3"/>
    <circle cx="1260" cy="100" r="2.5"/>
    <circle cx="1400" cy="170" r="3"/>
    <circle cx="1120" cy="260" r="3"/>
    <circle cx="1260" cy="320" r="2.5"/>
    <circle cx="1400" cy="300" r="2.5"/>
  </g>

<!-- Database cylinder -->

<g transform="translate(1180,300)" filter="url(#softGlow)">
    <ellipse cx="0" cy="0" rx="70" ry="22" fill="url(#dbGrad)" stroke="#FF2D20" stroke-width="2"/>
    <path d="M -70,0 L -70,90 A 70,22 0 0 0 70,90 L 70,0" fill="url(#dbGrad)" stroke="#FF2D20" stroke-width="2"/>
    <ellipse cx="0" cy="30" rx="70" ry="22" fill="none" stroke="#FF2D20" stroke-width="1.4" opacity="0.7"/>
    <ellipse cx="0" cy="60" rx="70" ry="22" fill="none" stroke="#FF2D20" stroke-width="1.4" opacity="0.7"/>
    <ellipse cx="0" cy="0" rx="70" ry="22" fill="none" stroke="#ffffff" stroke-width="1" opacity="0.25"/>
  </g>

<!-- Inventory boxes (isometric stack), left/center-right lower area -->

<g transform="translate(960,360)">
    <!-- box 1 -->
    <g transform="translate(0,0)">
      <polygon points="0,-20 40,-40 80,-20 40,0" fill="url(#boxTop)" stroke="#FF2D20" stroke-width="1.5"/>
      <polygon points="0,-20 40,0 40,40 0,20" fill="url(#boxFront)" stroke="#FF2D20" stroke-width="1.5"/>
      <polygon points="40,0 80,-20 80,20 40,40" fill="url(#boxSide)" stroke="#FF2D20" stroke-width="1.5"/>
      <line x1="20" y1="-10" x2="20" y2="30" stroke="#FF2D20" stroke-width="1" opacity="0.5"/>
      <line x1="60" y1="-10" x2="60" y2="30" stroke="#FF2D20" stroke-width="1" opacity="0.5"/>
    </g>
    <!-- box 2 -->
    <g transform="translate(-95,25)">
      <polygon points="0,-20 40,-40 80,-20 40,0" fill="url(#boxTop)" stroke="#FF2D20" stroke-width="1.5"/>
      <polygon points="0,-20 40,0 40,40 0,20" fill="url(#boxFront)" stroke="#FF2D20" stroke-width="1.5"/>
      <polygon points="40,0 80,-20 80,20 40,40" fill="url(#boxSide)" stroke="#FF2D20" stroke-width="1.5"/>
      <line x1="20" y1="-10" x2="20" y2="30" stroke="#FF2D20" stroke-width="1" opacity="0.5"/>
      <line x1="60" y1="-10" x2="60" y2="30" stroke="#FF2D20" stroke-width="1" opacity="0.5"/>
    </g>
    <!-- box 3 stacked -->
    <g transform="translate(-47,-40)">
      <polygon points="0,-20 40,-40 80,-20 40,0" fill="url(#boxTop)" stroke="#FF2D20" stroke-width="1.5"/>
      <polygon points="0,-20 40,0 40,40 0,20" fill="url(#boxFront)" stroke="#FF2D20" stroke-width="1.5"/>
      <polygon points="40,0 80,-20 80,20 40,40" fill="url(#boxSide)" stroke="#FF2D20" stroke-width="1.5"/>
      <line x1="20" y1="-10" x2="20" y2="30" stroke="#FF2D20" stroke-width="1" opacity="0.5"/>
      <line x1="60" y1="-10" x2="60" y2="30" stroke="#FF2D20" stroke-width="1" opacity="0.5"/>
    </g>
  </g>

<!-- Laravel-esque angular accent mark near title -->

<g transform="translate(75,60)">
    <polygon points="0,40 30,0 60,40 30,80" fill="none" stroke="#FF2D20" stroke-width="2.5" opacity="0.9"/>
    <polygon points="15,40 30,20 45,40 30,60" fill="#FF2D20" opacity="0.85"/>
  </g>

<!-- red accent bar under title -->

<rect x="80" y="255" width="120" height="6" rx="3" fill="#FF2D20"/>
  <rect x="80" y="255" width="120" height="6" rx="3" fill="url(#redGlow)"/>

<!-- Title -->

<text x="80" y="230" font-family="Arial, Helvetica, sans-serif" font-size="58" font-weight="800" fill="#ffffff" letter-spacing="0.5">
    Inventory Management
  </text>
  <text x="80" y="230" dy="62" font-family="Arial, Helvetica, sans-serif" font-size="58" font-weight="800" fill="#FF2D20" letter-spacing="0.5">
    REST API
  </text>

<!-- Subtitle -->

<text x="82" y="410" font-family="Arial, Helvetica, sans-serif" font-size="22" fill="#aab2c8" letter-spacing="0.5">
    Enterprise Backend System
    <tspan fill="#FF2D20" dx="10">|</tspan>
    <tspan fill="#aab2c8" dx="10">Laravel 13</tspan>
    <tspan fill="#FF2D20" dx="10">|</tspan>
    <tspan fill="#aab2c8" dx="10">Docker</tspan>
    <tspan fill="#FF2D20" dx="10">|</tspan>
    <tspan fill="#aab2c8" dx="10">REST API</tspan>
  </text>

<!-- thin top/bottom frame lines -->

<rect x="0" y="0" width="1600" height="500" fill="none" stroke="#FF2D20" stroke-opacity="0.15" stroke-width="2"/>
</svg>

<p align="center">
  <img src="./assets/banner.svg" alt="Inventory Management REST API Banner" width="100%">
</p>
