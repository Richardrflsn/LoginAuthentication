# Laravel + Vue.js Login & Register Authentication Project

This project is a full authentication system built using **Laravel** as the backend and **Vue.js** as the frontend. It includes features like user registration, login, logout, and authenticated routes, using **Laravel Sanctum** for secure API authentication.

## Table of Contents

- [Features](#features)
- [Getting Started](#getting-started)
- [Prerequisites](#prerequisites)
- [Installation](#installation)
- [License](#license)

## Features

- **User Registration**: New users can register, and email verification is supported.
- **User Login**: Authenticates users with email and password.
- **Secure API Authentication**: Protects routes with Laravel Sanctum for managing sessions.
- **Notifications**: Uses Vue3 Notifications for error and success messages.
- **Logout**: Users can securely log out of their accounts.

## Getting Started

To run this project locally, follow these steps.

### Prerequisites

- **PHP** (>= 8.0)
- **Composer**
- **Node.js** and **npm**
- **Laravel** (>= 9.0)
- **Vue CLI** (optional, for Vue.js tools)

### Installation

1. **Clone the repository:**

   ```bash
   git clone https://github.com/Richardrflsn/LoginAuthentication.git
   cd laravel-vue-auth
   ```
2. **Set up the Backend (Laravel):**
   - Install dependencies:
   ```bash
   git clone https://github.com/Richardrflsn/LoginAuthentication.git
   cd laravelbreezeapi
   ```
   - Copy the .env.example to .env and configure your environment settings, especially the database configuration:
   ```bash
    cp .env.example .env
   ```
   - Generate the application key:
   ```bash
    php artisan key:generate
   ```
    - Run database migrations:
   ```bash
    php artisan migrate
   ```
   - Install Laravel Sanctum for API authentication:
   ```bash
    composer require laravel/sanctum
    php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
    php artisan migrate
   ```
3. **Set up the Frontend (Vue.js):**
   - Navigate to the frontend folder:
   ```bash
    cd frontend-vue
   ```
   - Install frontend dependencies:
   ```bash
    npm install
   ```
4. Run the Development Servers:
    - Start the Laravel server:
   ```bash
   php artisan serve
   ```
   - Start the Vue.js development server:
   ```bash
    npm run dev
   ```
5. Access the application by visiting http://localhost:3000.
