# Visitor Management System Backend

## Introduction
This is the backend for a Visitor Management System. It handles functionalities like user registration, login, and managing check-in/check-out timings.

## Setup and Installation

### Prerequisites
- PHP (and required extensions)
- Composer
- Laravel
- MySQL (or any other compatible database system)

### Steps
1. **Clone the repository:**
   ```bash
   git clone https://github.com/johnleerightnow/visitor-management-system-backend.git

2. **Navigate to the project directory**:

cd register-backend

3. **Install Dependencies**:

composer install

4. **Setup .env**:
Copy the `.env.example` file to `.env` and fill in the required configuration settings, such as database details and JWT secret.


5. **Generate Application Key**:

php artisan key:generate

6. **Run Migrations**:

php artisan migrate

7. **Serve the Application**:

php artisan serve


Now, you should be able to access the backend at http://localhost:8000.

API Endpoints
User Registration:

URL: /register
Method: POST
Body:
email
mobile
full_name
vehicle (optional)
walk_in (optional)
purpose
Check-In/Check-Out:

URL: /checkinout
Method: POST
Body:
user_id
check_in (timestamp)
check_out (timestamp)
