

<h1 align="center">🎉 Event Organizer System 🎤</h1>

<p align="center">A full-featured event management platform built with Laravel 11.</p>

---

## 🧠 Project Overview

**Event Organizer** is a web application that facilitates the organization, submission, and management of professional events. It allows **organizers**, **speakers**, and **users** to collaborate effectively.

### 🔑 Key Features

- **Authentication & Roles**: Secure login system with role-based access (Admin, Organizer, Speaker).
- **Event Management**: Organizers can create, update, delete, and list events.
- **Speaker Proposals**: Speakers can submit proposals (title, description, CV) for any public event.
- **Proposal Review System**: Organizers can accept/reject proposals and view all submissions per event.
- **Dashboard & Admin Controls**: Admins can view user activity and control system settings.
- **Validation**: All forms are validated using Laravel Form Requests.
- **File Uploads**: CVs are uploaded and stored securely.

---

## ⚙️ Technologies Used

- **Framework**: Laravel 11
- **Database**: MySQL / MariaDB
- **UI**: Blade, Tailwind CSS (optional)
- **Authentication**: Laravel Breeze (or Jetstream/Inertia, if used)
- **Storage**: Local file storage (CV uploads)
- **Routing**: RESTful Routes with Controllers
- **Validation**: Laravel Form Requests
- **Git**: Version control using Git & GitHub

---

## 🖼️ System Roles

| Role       | Description                                          |
|------------|------------------------------------------------------|
| Admin      | Full control over users, roles, and system settings. |
| Organizer  | Can manage events and moderate speaker proposals.    |
| Speaker    | Can submit proposals to participate in events.       |

---

## 📸 Screenshots

> **🎞️ Demo UI (Optional):**
> You can include images or GIFs using:
>
> ```md
> ![Dashboard Screenshot](screenshots/dashboard.png)
> ![Proposal Submission](screenshots/proposal-form.gif)
> ```

---

## 🚀 How to Run the Project

```bash
# 1. Clone the Repository
git clone https://github.com/your-username/event-organizer.git

# 2. Install Dependencies
composer install
npm install && npm run dev

# 3. Environment Setup
cp .env.example .env

# 4. Database Setup
php artisan migrate 

# 5. Storage Link
php artisan storage:link

# 6. Start the Server
php artisan serve
