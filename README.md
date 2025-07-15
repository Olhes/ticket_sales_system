# Ticket Sales System

A web-based application for managing and selling bus ticket reservations. This project uses custom PHP for the backend and plain HTML/CSS/JavaScript for the frontend.

# Main Page

![alt text](image.png)

## Features

- User registration and authentication
- View available bus routes and schedules
- Book and cancel tickets
- View user ticket history
- Admin management for routes, schedules, and users

## Project Structure

```
backend/
  api/           # API endpoints (auth, routes, schedules, tickets)
  classes/       # PHP classes (User, Ticket, Bus, etc.)
  config/        # Database configuration
  db/            # Database schema (SQL)
  utils/         # Helper functions
frontend/
  css/           # Stylesheets
  images/        # Images
  js/            # JavaScript files
  form.php       # Registration/Login form
  index.php      # Main frontend entry
index.php        # Main entry point (can route to frontend or backend)
```

## How to Run

1. **Prerequisites:**
    - PHP 7.4 or higher
    - MySQL or MariaDB
    - Web server (Apache, Nginx) or PHP built-in server

2. **Clone the repository:**
    ```bash
    git clone https://github.com/Olhes/ticket_sales_system.git
    cd ticket_sales_system
    ```

3. **Configure the database:**
    - Make sure MySQL/MariaDB is running
    - Update database credentials in `backend/config/databases.php` if needed
    - Default settings: host=localhost, user=root, password=empty

4. **Initialize the database:**
    - Run the PHP built-in server:
    ```bash
    php -S localhost:8000
    ```
    - Open your browser and go to `http://localhost:8000/setup.php`
    - This will create the database, tables, and sample data automatically

5. **Access the application:**
    - **Main page:** `http://localhost:8000/` or `http://localhost:8000/frontend/index.php`
    - **Login/Register:** `http://localhost:8000/frontend/form.php`
    - **Dashboard:** `http://localhost:8000/frontend/dashboard.php` (requires login)

## Features Implemented

- ✅ User registration and authentication
- ✅ Dashboard with statistics
- ✅ View available routes and schedules
- ✅ Book tickets with passenger information
- ✅ View user's booked tickets
- ✅ Responsive design
- ✅ Complete database integration
- ✅ Sample data for testing

## Usage

1. **Register a new account** or login with existing credentials
2. **Browse available routes** in the dashboard
3. **Select a route and schedule** to book a ticket
4. **Fill passenger information** and seat number
5. **View your booked tickets** in the "Mis Boletos" section

## Notes
- No external PHP frameworks are required.
- All backend logic is in the `backend/` directory.
- Frontend assets are in the `frontend/` directory.
