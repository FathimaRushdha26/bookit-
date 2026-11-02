# BookIt – Online Booking Management System

An online booking management system developed using PHP, MySQL, HTML, CSS and JavaScript with a custom Model–View–Controller (MVC) architecture.

## Technologies Used

- PHP 8.x
- MySQL 8.x
- PDO
- HTML5
- CSS3
- JavaScript (ES6)
- AJAX / Fetch API
- XAMPP
- Apache

## Features

### Customer Features
- User registration and login
- Secure password authentication
- Browse and search available services
- Filter services by category
- View service details
- Check real-time appointment availability
- Book appointments
- Prevent double bookings
- View booking history
- Cancel upcoming bookings
- Update personal profile
- Change account password

### Administrator Features
- Admin authentication
- Dashboard with booking statistics
- Manage services (CRUD operations)
- Activate and deactivate services
- Manage customer accounts
- View and manage all bookings
- Update booking statuses
- View revenue and booking analytics

## Architecture

Custom Model–View–Controller (MVC) Architecture.

- **Model:** Handles database operations and business logic.
- **View:** Manages application user interfaces.
- **Controller:** Processes requests and connects models with views.
- **Core:** Handles routing, database connectivity and helper functions.

## Database

MySQL database: `bookit_db`

### Database Tables
- `users`
- `services`
- `bookings`

Database file: `database/bookit_db.sql`

## Run the Project

1. Install XAMPP.
2. Clone the repository.

```bash
git clone https://github.com/FathimaRushdha26/bookit-.git
```

3. Move the project folder into the XAMPP `htdocs` directory.
4. Start Apache and MySQL from XAMPP Control Panel.
5. Open phpMyAdmin.
6. Create a database named `bookit_db`.
7. Import the `database/bookit_db.sql` file.
8. Configure database credentials in `config/config.php`.
9. Open the application in your browser:

```text
http://localhost/bookit-/
```

## Security Features

- Password hashing using BCRYPT
- SQL injection prevention using PDO prepared statements
- Cross-Site Scripting (XSS) protection
- Cross-Site Request Forgery (CSRF) protection
- Role-Based Access Control (RBAC)
- Secure session management

## Developer

**M.I.F. Rushdha**

B.Tech in Software Technology

Registration No: SOF/23/B1/03

University of Vocational Technology

GitHub: [@FathimaRushdha26](https://github.com/FathimaRushdha26)

## License

This project was developed for educational purposes.
