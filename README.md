# BriBooks Mini Book Writing Platform

## Overview

BriBooks Mini Book Writing Platform is a Laravel-based REST API application that enables authors to create, manage, review, version, and publish books through a structured workflow.

The platform supports role-based access control, manuscript uploads, content moderation, version history, and publishing workflows.

---

# Technology Stack

* PHP 8.3
* Laravel 12
* MySQL
* JWT Authentication
* PHPUnit
* REST API

---

# Architecture

The project follows a layered architecture:

```text
Controller
    ↓
Service Layer
    ↓
Repository Layer
    ↓
Database
```

### Components

* Controllers
* Services
* Repositories
* DTOs
* Policies
* Request Validation
* Enums
* Feature Tests

### Design Patterns

* Service Pattern
* Repository Pattern
* DTO Pattern
* Policy-Based Authorization
* Dependency Injection

---

# Features

## Authentication

* Register
* Login
* Profile
* Logout
* JWT Authentication

---

## User Roles

### Author

* Create Books
* Manage Chapters
* Manage Pages
* Upload Manuscripts
* Submit Books

### Reviewer

* Review Submitted Books
* Approve Books
* Reject Books

### Admin

* Publish Approved Books
* View Platform Data

---

## Book Management

* Create Book
* Update Book
* Delete Book
* View Book
* Ownership Validation

---

## Chapter Management

* Create Chapter
* Update Chapter
* Delete Chapter
* List Chapters

---

## Page Management

* Create Page
* Update Page
* Delete Page
* List Pages

---

## Version Control

* Snapshot Storage
* Version History
* Rollback Support
* Audit Trail

---

## Upload Management

* Upload Manuscripts
* Track Upload Status
* Conversion Processing
* Upload History

---

## Moderation Service

Detects:

* Restricted Words
* Profanity
* Unsafe Content

Examples:

```text
bomb
terrorism
violence
idiot
abuse
```

---

## Publishing Workflow

```text
Draft
   ↓
Submitted
   ↓
Approved
   ↓
Published
```

Workflow Rules:

* Authors submit books
* Reviewers approve/reject books
* Admins publish books
* Published books become read-only

---

## Dashboard

Provides statistics:

* Total Books
* Draft Books
* Submitted Books
* Approved Books
* Published Books
* Chapters Count
* Pages Count
* Upload Count

---

# Installation

## Clone Repository

```bash
git clone https://github.com/saurabh-98/bribooks.git

cd bribooks
```

## Install Dependencies

```bash
composer install
```

## Configure Environment

```bash
cp .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

Generate JWT secret:

```bash
php artisan jwt:secret
```

Configure database credentials in:

```env
.env
```

Run migrations:

```bash
php artisan migrate
```

---

# Seed Database

The project includes seeders for testing different user roles.

Run:

```bash
php artisan db:seed
```

or

```bash
php artisan migrate:fresh --seed
```

Default Seeded Users:

| Role     | Email                                         |
| -------- | --------------------------------------------- |
| Admin    | [admin@test.com](mailto:admin@test.com)       |
| Reviewer | [reviewer@test.com](mailto:reviewer@test.com) |
| Author   | [author@test.com](mailto:author@test.com)     |

Password for all users:

```text
password
```

---

# Start Application

```bash
php artisan serve
```

Application URL:

```text
http://127.0.0.1:8000
```

---

# API Endpoints

## Authentication

| Method | Endpoint           |
| ------ | ------------------ |
| POST   | /api/auth/register |
| POST   | /api/auth/login    |
| GET    | /api/auth/profile  |
| POST   | /api/auth/logout   |

---

## Dashboard

| Method | Endpoint       |
| ------ | -------------- |
| GET    | /api/dashboard |

---

## Books

| Method | Endpoint          |
| ------ | ----------------- |
| GET    | /api/books        |
| POST   | /api/books        |
| GET    | /api/books/{book} |
| PUT    | /api/books/{book} |
| PATCH  | /api/books/{book} |
| DELETE | /api/books/{book} |

---

## Chapters

| Method | Endpoint                   |
| ------ | -------------------------- |
| GET    | /api/books/{book}/chapters |
| POST   | /api/books/{book}/chapters |
| GET    | /api/chapters/{chapter}    |
| PUT    | /api/chapters/{chapter}    |
| PATCH  | /api/chapters/{chapter}    |
| DELETE | /api/chapters/{chapter}    |

---

## Pages

| Method | Endpoint                      |
| ------ | ----------------------------- |
| GET    | /api/chapters/{chapter}/pages |
| POST   | /api/chapters/{chapter}/pages |
| GET    | /api/pages/{page}             |
| PUT    | /api/pages/{page}             |
| PATCH  | /api/pages/{page}             |
| DELETE | /api/pages/{page}             |

---

## Versions

| Method | Endpoint                                      |
| ------ | --------------------------------------------- |
| POST   | /api/books/{book}/versions                    |
| GET    | /api/books/{book}/versions                    |
| GET    | /api/books/{book}/versions/{version}          |
| POST   | /api/books/{book}/versions/{version}/rollback |

---

## Uploads

| Method | Endpoint                  |
| ------ | ------------------------- |
| POST   | /api/books/{book}/upload  |
| GET    | /api/books/{book}/uploads |
| GET    | /api/uploads/{upload}     |
| DELETE | /api/uploads/{upload}     |

---

## Workflow

| Method | Endpoint                  |
| ------ | ------------------------- |
| POST   | /api/books/{book}/submit  |
| POST   | /api/books/{book}/approve |
| POST   | /api/books/{book}/reject  |
| POST   | /api/books/{book}/publish |

---

# Testing

Run all tests:

```bash
php artisan test
```

Latest Result:

```text
PASS 33 Tests
PASS 47 Assertions
FAILURES 0
```

Covered Areas:

* Authentication
* Authorization
* Book CRUD
* Moderation Service
* Workflow Logic
* Review Process
* Version Management
* Dashboard

---

# Security Features

* JWT Authentication
* Password Hashing
* Request Validation
* Authorization Policies
* Protected Routes
* Role-Based Access Control

---

# Assumptions

* Uploaded manuscripts are converted into pages.
* Version snapshots are stored as JSON.
* Submitted books are eligible for review.
* Published books cannot be modified.

---

# Author

**Saurabh Kumar Jha**

PHP / Laravel Developer

GitHub:
https://github.com/saurabh-98
