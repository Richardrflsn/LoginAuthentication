# Oracle Library Authentication System

This project is a web application that implements a full authentication system for the Oracle Library, built using **Laravel** as the backend and **Vue.js** as the frontend. It includes features like user registration, login, logout, authenticated routes, and a CRUD system for managing books, using **Laravel Sanctum** for secure API authentication.

## Table of Contents

- [Features](#features)
- [Getting Started](#getting-started)
- [Prerequisites](#prerequisites)
- [Installation](#installation)

## Features

- **User Registration**: New users can register, with email verification support.
- **User Login**: Authenticates users with email and password.
- **Secure API Authentication**: Protects routes with Laravel Sanctum for session management.
- **Notifications**: Uses Vue3 Notifications for error and success messages.
- **Logout**: Enables users to securely log out.
- **CRUD for Books**: Users can create, read, update, and delete books in the library system, with server-side validation and real-time updates on the frontend.

## Preview

<img width="520" alt="Screenshot 2024-12-18 at 12 53 00" src="https://github.com/user-attachments/assets/48e8429f-1c05-4a69-88b0-40ab1802457e" />
<img width="520" alt="Screenshot 2024-12-18 at 12 53 13" src="https://github.com/user-attachments/assets/755b9923-d847-4202-bce2-a33113910745" />
<img width="520" alt="Screenshot 2024-12-18 at 12 53 34" src="https://github.com/user-attachments/assets/aab4339a-c3c6-4ff3-90bf-8b9e7378b16a" />
<img width="520" alt="Screenshot 2024-12-18 at 12 53 43" src="https://github.com/user-attachments/assets/e672321a-b1f6-4e16-8cc2-1a7e83bfa5c4" />

## Getting Started

Follow these steps to set up and run the project locally.

### Prerequisites

- **PHP** (>= 8.0)
- **Composer**
- **Node.js** and **npm**
- **Laravel** (>= 9.0)
- **Vue CLI** (optional, for Vue.js tools)

### Installation

1. **Clone the repository:**

   ```bash
   git clone https://github.com/Richardrflsn/OracleLibrary.git
   cd OracleLibrary
   ```

2. **Set up the Backend (Laravel):**

   - Navigate to the backend folder:
     ```bash
     cd laravelbreezeapi
     ```
   - Copy the environment configuration file:
     ```bash
     cp .env.example .env
     ```
   - Update the `.env` file with your database credentials:
     ```env
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=oracle_library
     DB_USERNAME=root
     DB_PASSWORD=
     ```
   - Install Laravel dependencies and migrate the database:
     ```bash
     composer install
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

4. **Run the Development Servers:**

   - Start the Laravel server:
     ```bash
     php artisan serve
     ```
   - Start the Vue.js development server:
     ```bash
     npm run dev
     ```

5. **Access the application:**

   Visit [http://localhost:3000](http://localhost:3000) in your web browser.

---

For further information or contribution, please refer to the [documentation](https://github.com/Richardrflsn/OracleLibraryAuth/docs).
