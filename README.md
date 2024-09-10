 # Task Management System

This is a full-stack task management system built with Laravel (PHP) for the backend and Flask (Python) for handling task processing. The Laravel application manages task creation, listing, and completion, while the Flask API simulates external task processing.
Prerequisites

    PHP (>= 8.x)
    Composer (Dependency manager for PHP)
    Laravel (>= 9.x)
    MySQL or SQLite (Database)
    Python (>= 3.8)
    Flask (Python web framework)
    Node.js and npm (For frontend dependencies)

## Setup Guide 
 
### Step 1: Setting Up the Laravel Application

    Clone the repository:

    bash

git clone https://github.com/.git
cd TaskManager

## Install PHP dependencies:


```bash
composer install
```

Set up the .env file:

    Copy the .env.example file and rename it to .env.
    Update your .env file with the correct database credentials.
    Ensure the API_URL is set to the Flask API URL (usually http://127.0.0.1:5000):

    env

    API_URL=http://127.0.0.1:5000

Generate an application key:


```bash
php artisan key:generate
```

Set up the database:

    Update your .env file with the correct database credentials (MySQL or SQLite).
    Run the database migrations:

```bash

php artisan migrate
```

Install frontend dependencies:

```bash

npm install
```

Run Laravel development server:

```bash

php artisan serve
 ```

The Laravel app will now be running on http://127.0.0.1:8000.



### Step 2: Setting Up the Flask API

    Navigate to the Flask API directory:

```bash

cd flask-api
```

Create and activate a virtual environment (optional but recommended):

```bash

pip install -r requirements.txt
```
Run the Flask server:

```bash
    python app.py
```
        The Flask API will now be running on http://127.0.0.1:5000.

# Step 3: Connecting Laravel with Flask

    Ensure both the Laravel app and the Flask API are running.
    When a task is created via the Laravel app, a request will be sent to the Flask API to simulate task processing. The response from Flask will be displayed on the Laravel frontend.


API Endpoints
Flask API

    POST /process-task: Accepts a JSON request with a task_name and returns a response message confirming the task has been processed.

### Testing

    Laravel:
        You can run the Laravel test suite using PHPUnit:

```bash

    php artisan test
 ```

Flask:

You can run Flask unit tests using unittest or pytest:

```bash

 python -m unittest discover
 ```

### Deployment
Laravel

    Environment Setup:
        Set up your production environment (.env file, database, and web server).

    Production Build:
        Run Laravel optimizations:

        ```bash

        php artisan optimize
        ```

    Serve Application:
        Use Apache or Nginx to serve your Laravel app.

Flask

    Production Environment:
        Set up the environment with Flask in production mode and configure a WSGI server (e.g., Gunicorn).

    Run Flask:

    ```bash

    gunicorn -w 4 app:app
    ```

### Troubleshooting
# Common Issues

    Laravel Migration Issues:
        Check your .env file for correct database credentials.
        Ensure the database is running.

    Flask API Not Responding:
        Ensure the Flask API is running on the correct port (http://127.0.0.1:5000).
        Check for CORS issues or networking problems if deployed on different servers.

# Contribution

Feel free to submit issues or pull requests to improve this project. Follow the GitHub contribution guidelines.
License

This project is licensed under the MIT License.