# Laravel 11 Docker Kickstart

This repository provides a kickstart template for starting a Laravel 11 project with Docker. It includes services for PHP, MySQL, phpMyAdmin, and Redis, allowing for easy development and testing of your Laravel application.

## Prerequisites

Before you begin, ensure you have the following prerequisites installed on your local machine:

- Docker
- Docker Compose

## Getting Started

To get started with this Laravel Docker project, follow these steps:

1. Clone this repository to your local machine:

   ```
   git clone https://github.com/rayrlam/kickstart
   ```

2. Navigate to the project directory:

   ```
   cd laravel-docker-kickstart
   ```

3. Run the Docker containers:

   ```
   docker-compose up -d
   ```

   This command starts the Docker containers in detached mode, allowing them to run in the background.

4. Access your Laravel application in the browser:

   - Laravel Application: [http://localhost:8000]
   - phpMyAdmin: [http://localhost:8080]

5. Start developing your Laravel application!

## Services

This Laravel Docker project includes the following services:

- **PHP**: PHP 8.3.7
- **MySQL**: MySQL database server
- **phpMyAdmin**: Web-based MySQL administration tool
- **Redis**: Redis server for caching and session management

## Using the Makefile

This project includes a Makefile with common tasks for Laravel development. Here's how to use it:

- **Clear Laravel configuration cache**: `make config-clear`
- **Clear Laravel application cache**: `make cache-clear`
- **Clear compiled views**: `make view-clear`
- **Run Laravel tests**: `make test`
- **Clear content of daily Laravel log files**: `make clear-log`
- **Delete daily Laravel log files**: `make del-log`
- **Run all common tasks**: `make all`

## Directory Structure

The directory structure of this Laravel project is as follows:

```
laravel-docker-kickstart/
│
├── app/                    # Laravel application code
│   ├── ...
│
├── database/               # Database migrations and seeds
│   ├── ...
│
├── public/                 # Publicly accessible files
│   ├── ...
│
├── storage/                # Application storage (logs, cache, sessions)
│   ├── ...
│
├── tests/                  # Unit and feature tests
│   ├── ...
│
├── .env.example            # Example environment configuration
├── docker-compose.yml      # Docker Compose configuration
├── Dockerfile              # Dockerfile for PHP service
└── README.md               # Project README
```

## License

This Laravel Docker Kickstart template is open-source software licensed under the [MIT License].
