# Laravel + Vue.js Login & Register Authentication Project

This project is a full authentication system built using **Laravel** as the backend and **Vue.js** as the frontend. It includes features like user registration, login, logout, and authenticated routes, using **Laravel Sanctum** for secure API authentication.

## Table of Contents

- [Features](#features)
- [Getting Started](#getting-started)
- [Prerequisites](#prerequisites)
- [Installation](#installation)

## Features

- **User Registration**: New users can register, and email verification is supported.
- **User Login**: Authenticates users with email and password.
- **Secure API Authentication**: Protects routes with Laravel Sanctum for managing sessions.
- **Notifications**: Uses Vue3 Notifications for error and success messages.
- **Logout**: Users can securely log out of their accounts.

## Preview
<img width="640" alt="Screenshot 2024-11-14 at 21 54 39" src="https://github.com/user-attachments/assets/daa615bf-a4a8-4fca-951f-883783b57710">
<img width="640" alt="Screenshot 2024-11-14 at 21 54 55" src="https://github.com/user-attachments/assets/7fd61857-a938-481d-83c7-909a62de9a51">
<img width="640" alt="Screenshot 2024-11-14 at 21 55 27" src="https://github.com/user-attachments/assets/eee4a50c-0715-4ffd-a1ef-876dac96db9f">

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
   cd LoginAuthentication-master
   ```
2. **Set up the Backend (Laravel):**
   - Install dependencies:
   ```bash
   cd laravelbreezeapi
   ```
   - Open the .env file in the root directory of the Laravel project. Find the database configuration section.
   ```bash
     cp .env.example .env
   ```
   - Change the database connection to MySQL by replacing DB_CONNECTION=sqlite with the following:
   ```bash
      DB_CONNECTION=mysql
      DB_HOST=127.0.0.1
      DB_PORT=3306
      DB_DATABASE=laravelbreezeapi
      DB_USERNAME=root
      DB_PASSWORD=
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
