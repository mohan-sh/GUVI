# Developer Internship Task Web Application

This project implements a web application with a Register -> Login -> Profile flow using HTML, CSS, Bootstrap, JavaScript (jQuery + AJAX) for the frontend, PHP for the backend, MySQL for registration data, MongoDB for profile data, and Redis for session management.

## Project Structure

```
project-root/
│
├── frontend/
│   ├── index.html          # Landing Page (optional)
│   ├── signup.html         # Registration page
│   ├── login.html          # Login page
│   ├── profile.html        # Profile page
│   ├── assets/
│   │   ├── css/
│   │   │   └── style.css   # Custom styles
│   │   ├── js/
│   │   │   ├── signup.js   # AJAX for signup
│   │   │   ├── login.js    # AJAX for login
│   │   │   └── profile.js  # AJAX for profile update
│   │   └── img/            # Any images or logos
│   └── lib/
│       └── bootstrap/      # Bootstrap files (installed via npm)
│       └── jquery/         # jQuery files (installed via npm)
│
├── backend/
│   ├── config/
│   │   ├── db.php          # MySQL connection with Prepared Statements
│   │   ├── mongo.php       # MongoDB connection
│   │   └── redis.php       # Redis connection
│   ├── api/
│   │   ├── signup.php      # Handles user registration
│   │   ├── login.php       # Handles user login + Redis session
│   │   └── profile.php     # Handles fetching & updating profile
│   └── utils/
│       └── helpers.php     # Helper functions (validation, etc.)
│
├── database/
│   ├── mysql_schema.sql    # MySQL schema for users
│   └── mongo_collections/  # MongoDB structure details (conceptual, no files here)
│
├── README.md               # Documentation + setup instructions
├── package.json            # NPM package file
├── composer.json           # Composer package file
└── .gitignore
```

## Setup Instructions

### Prerequisites

- **PHP 7.4+**: The easiest way to get PHP, Apache, and MySQL on Windows is to install **XAMPP** or WAMP Server. Download XAMPP from [https://www.apachefriends.org/download.html](https://www.apachefriends.org/download.html) and follow the installation instructions. Ensure `php.exe` (e.g., `D:\xampp\php\php.exe`) is accessible in your system's PATH or you use its full path when running PHP commands.
- **Composer**: Ensure Composer is installed and available in your system's PATH. Download the installer from [https://getcomposer.org/Composer-Setup.exe](https://getcomposer.org/Composer-Setup.exe). During installation, make sure it points to your PHP installation (e.g., `D:\xampp\php\php.exe`).
- Web server (e.g., Apache, Nginx) with PHP configured (provided by XAMPP).
- MySQL database server.
- MongoDB database server.
- Redis server.
- Node.js and npm (for frontend dependencies).

### 1. Database Setup

#### MySQL

1. Create a MySQL database (e.g., `guvi_project`).
2. Import the schema from `database/mysql_schema.sql`:
   ```bash
   mysql -u your_username -p guvi_project < database/mysql_schema.sql
   ```
3. Update `backend/config/db.php` with your MySQL credentials.

#### MongoDB

1. Ensure MongoDB is running.
2. The `profiles` collection will be created automatically upon the first profile update.
3. Update `backend/config/mongo.php` with your MongoDB database name if it's different from `guvi_project`.

#### Redis

1. Ensure Redis is running.
2. Update `backend/config/redis.php` if your Redis server is not on `127.0.0.1:6379`.

### 2. Backend Dependencies (PHP)

Install the MongoDB PHP driver and Predis using Composer. If Composer is not installed, please install it first by following the instructions above.

1. Navigate to the project root directory.
2. Run the following commands (if you haven't already run `composer init`):
   ```bash
   composer init --no-interaction
   composer require mongodb/mongodb
   composer require predis/predis
   ```
   *Note: If `composer init` asks for information, you can press enter for defaults or provide details.*

### 3. Frontend Dependencies

Install jQuery and Bootstrap using npm:

1. Navigate to the project root directory.
2. If not already initialized, run:
   ```bash
   npm init -y
   ```
3. Install dependencies:
   ```bash
   npm install jquery bootstrap --prefix frontend/lib
   ```
   This will install jQuery and Bootstrap into `frontend/lib/jquery` and `frontend/lib/bootstrap` respectively.

### 4. Web Server Configuration

Configure your web server to serve the `frontend/` directory as the document root.

### 5. Access the Application

Open `index.html` in your browser, or navigate to your configured web server URL.
