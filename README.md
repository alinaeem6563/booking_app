# Booking App

A full-featured, modern web-based **Booking Application** built with **Laravel**, **Tailwind CSS**, **FullCalendar**, and **Vite**. This system allows users to seamlessly book appointments, service providers to manage their availability, and admins to oversee operations.

## 🚀 Features

- **User Dashboard**
  - Browse services and available providers
  - View real-time availability and book slots
  - Make secure **online payments**
  - Save favorite providers for quick access

- **Service Provider Dashboard**
  - Add and manage **multiple services**
  - Create and manage **available time slots**
  - Set **off-days** and unavailability
  - View and manage upcoming bookings

- **Admin Panel**
  - Manage users, providers, and services
  - Monitor bookings and payment activity

- **Booking Calendar**
  - Real-time slot visibility using **FullCalendar**
  - Click-to-book interactions for users
  - Drag-and-drop or rescheduling support (if enabled)

## 🧩 Tech Stack

| Tool | Purpose |
|------|---------|
| Laravel | Backend Framework (MVC Architecture) |
| Vite | Frontend build tool for fast development |
| Tailwind CSS | Utility-first CSS framework |
| Alpine.js | Lightweight reactive components |
| FullCalendar | Booking calendar UI |
| Axios | API requests and AJAX |
| Laravel Vite Plugin | Seamless integration with Laravel |
| PostCSS & Autoprefixer | CSS post-processing |

## 📦 Project Structure & Dependencies

### `package.json`

```json
{
  "private": true,
  "type": "module",
  "scripts": {
    "dev": "vite",
    "build": "vite build"
  },
  "devDependencies": {
    "@tailwindcss/forms": "^0.5.2",
    "alpinejs": "^3.4.2",
    "autoprefixer": "^10.4.2",
    "axios": "^1.6.4",
    "laravel-vite-plugin": "^1.0",
    "postcss": "^8.4.31",
    "tailwindcss": "^3.1.0",
    "vite": "^5.0"
  },
  "dependencies": {
    "@fullcalendar/core": "^6.1.17",
    "@fullcalendar/daygrid": "^6.1.17",
    "@fullcalendar/interaction": "^6.1.17",
    "fullcalendar": "^6.1.17"
  }
}
📋 Installation
Clone the repository

bash
Copy
Edit
git clone https://github.com/your-username/booking_app.git
cd booking_app
Install PHP dependencies

bash
Copy
Edit
composer install
Install Node dependencies

bash
Copy
Edit
npm install
Configure environment

Copy .env.example to .env

Set up your database and Stripe (or other) payment keys

bash
Copy
Edit
php artisan key:generate
php artisan migrate --seed
Start development server

bash
Copy
Edit
npm run dev
php artisan serve
📆 Booking Flow
Admin/Provider adds time slots and services

User sees real-time availability

User selects slot and proceeds to payment

Booking is confirmed and appears in dashboards

🔒 Security
CSRF protection

Role-based access (Admin, Provider, User)

Secure online payments integration (e.g. Stripe, SafePay)

📤 Deployment
Build frontend assets:

bash
Copy
Edit
npm run build
Configure server (e.g., Apache, Nginx, or Railway)

🙌 Contribution
Have a feature request or bug report? Feel free to fork the project and submit a pull request.

Author: Ali Naeem
GitHub: alinaeem6563