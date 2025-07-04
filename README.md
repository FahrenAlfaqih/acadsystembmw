# 📘 BMW – Academic Management System

**BMW Sistem Akademik** is a Laravel-based web application designed to manage core academic operations such as teacher assignments, student records, grades, and attendance. Built with role-based access control, the system is tailored for **Tata Usaha (Admin)**, **Teachers**, and **Students** to interact through a modern, responsive interface.

---

## ⚙️ Key Features

- 🧑‍🏫 Teacher Management & Course Assignment
- 🎓 Student Registration & Academic Records
- 📝 Grade Input & Reports
- 📆 Attendance Tracking
- 🔐 Role-based Access for Admin, Teachers, and Students
- 🖥️ Clean & Responsive UI for all user types

---

## 🔍 UI Preview

### 🔑 User Login & Authentication
![image](https://github.com/user-attachments/assets/9ef87a6e-664d-45e8-ad26-745b475165b4)
![image](https://github.com/user-attachments/assets/81c38f82-bdaf-461d-97e4-fcc113e9571d)

### 👥 SuperAdmin Roles
## Dashboard
![image](https://github.com/user-attachments/assets/fad73c5e-eb4f-4521-b8a4-c382e8b92a31)
## Page for add new teachers account
![image](https://github.com/user-attachments/assets/e142e8e2-6821-4a68-a1fd-3749a7763a04)
## Page for add new students account
![image](https://github.com/user-attachments/assets/95638cf5-6a82-401a-9372-d62cd28a2420)
## Page for add new headmaster account
![image](https://github.com/user-attachments/assets/c184255a-83ae-4c9a-8deb-f863afe87535)

### 🧾 Tata Usaha Roles
## Dashboard
![image](https://github.com/user-attachments/assets/e90d5c8c-6451-4d23-8079-8c70ff724585)
## Manage Students Data
![image](https://github.com/user-attachments/assets/20b6ab73-9dfa-4e69-9b9b-889b4ed681e1)
## Manage Teachers Data
![image](https://github.com/user-attachments/assets/0b3fff11-7e11-4741-ba80-55c7ffbe5961)
## Manage HeadMasters Data
![image](https://github.com/user-attachments/assets/c7f81f6e-3d47-4bd0-962c-44ca22a468b4)
## Manage Semesters Data
![image](https://github.com/user-attachments/assets/6f769b1b-2084-4fd5-a089-45bc3deaa94f)
## Manage Subjects Data
![image](https://github.com/user-attachments/assets/a29ee52f-26b4-429c-8d2a-bd09194e2831)
## Manage Classes Data
![image](https://github.com/user-attachments/assets/e822d27f-3507-48d3-9a2c-5993ed1d7d5f)
## Manage Schedules Data
![image](https://github.com/user-attachments/assets/caf11569-99a6-4b15-b1a8-4b26bae0724c)
## Print Student Report
![image](https://github.com/user-attachments/assets/d6a07df0-5f12-40b9-9bc6-57efe70db831)

### 👨‍🏫 Teacher Roles
## Dashboard
![image](https://github.com/user-attachments/assets/a578f687-24fc-4597-9cdf-4ba7f07367d5)
## Student Scores Data
![image](https://github.com/user-attachments/assets/fec6e69e-65e7-4b7c-9496-9bad8234d2d4)
## Student Attendances Data
![image](https://github.com/user-attachments/assets/90303c28-8679-481f-9e6e-68df20527478)
## Print Student Report (HomeRoom Teacher)
![image](https://github.com/user-attachments/assets/1f9a6b3d-35ad-43a7-af9a-d1b6dbb6d2af)
## Word Files Report 
![image](https://github.com/user-attachments/assets/a93a58b7-58e1-4dcb-80d6-d49dfeb32f50)
## Grade Promotion (HomeRoom Teacher)
![image](https://github.com/user-attachments/assets/2d9097db-c903-462e-8ac6-53729fae9ce0)

### 👨‍🎓 Student Roles
## Dashboard
![image](https://github.com/user-attachments/assets/4c1ae229-875e-4e61-9426-ab8823937a71)
## Student Schedules
![image](https://github.com/user-attachments/assets/2ff72494-e3b9-4859-ad71-b4f0e629b711)
## Student Scores
![image](https://github.com/user-attachments/assets/a070010a-fec6-439e-bacc-aecdb1af4bfc)
## Student Attendance
![image](https://github.com/user-attachments/assets/bd266827-94fe-4254-b8e0-49d1d281c7ab)


## 🧰 Tech Stack

| Layer     | Technology        |
|-----------|-------------------|
| Backend   | PHP 8+, Laravel 10 |
| Frontend  | Blade Template, Bootstrap |
| Database  | MySQL             |
| Dev Tool  | Composer, Artisan, Laragon |

---

## 🚀 Getting Started

### 📦 Prerequisites

Make sure the following are installed:

- PHP ≥ 8.0
- Composer
- MySQL
- Laravel CLI (optional)
- Local server: Laragon or XAMPP

---

### 🛠️ Installation Steps

```bash
# 1. Clone the project
cd C:\laragon\www
git clone https://github.com/username/sistem-akademik.git
cd sistem-akademik

# 2. Install Laravel dependencies
composer install
composer update

# 3. Create environment config & app key
copy .env.example .env
php artisan key:generate

# 4. Configure .env to match your local database
```
### 🧱 Database Migration & Seeding
```bash
# 5. Run database migrations
php artisan migrate

# 6. Seed the database with initial data
php artisan db:seed

# 7. Create symbolic link for storage
php artisan storage:link

# 8. Launch the local development server
php artisan serve
```

### 🙋‍♂️ Developer
Developed by Fahren Al Faqih as part of a full-stack academic management system project using Laravel framework.
