# Car Rental Information System

A web application for managing a car rental fleet, built with **PHP** and **MySQL/MariaDB**. It has two kinds of users, **Admin** and **Customer**, with different permissions. New accounts must be approved by an admin before they can log in.

## Features

### Admin
- Dashboard with fleet statistics (total, available, rented, in maintenance), customer count and pending approvals
- Add, edit and delete cars
- View all cars with search, category/status filters and pagination
- Manage users: search, filter by role or approval status, add, approve and delete (an admin cannot delete their own account)
- Change password

### Customer
- Dashboard
- Browse available cars with search, category/status filters and pagination
- Change password

### Everyone
- Register a new account (stays **pending** until an admin approves it)
- Forgot password: confirm username and email, then set a new password
- Login and logout

## Tech Stack
- PHP 8+ (procedural, `mysqli` with prepared statements)
- MySQL / MariaDB
- HTML and CSS (styles are in `includes/style.php`)
- Runs on XAMPP, WAMP or any PHP + MySQL host

## Project Structure

```
car_rental/
├── config.php                  # DB settings, session, helpers (auth, CSRF, flash messages)
├── index.php                   # Redirects to login or dashboard
├── login.php / logout.php
├── register.php                # Self-registration (pending approval)
├── forgot_password.php
├── change_password.php
├── dashboard.php
├── cars.php                    # List, search, filter, paginate cars
├── add_car.php / edit_car.php / delete_car.php
├── users.php                   # Admin: manage users
├── add_user.php / approve_user.php / delete_user.php
├── car_rental_system (1).sql   # Database schema and sample data
└── includes/
    ├── header.php / footer.php
    ├── auth_top.php / auth_bottom.php
    ├── car_card.php / car_form.php / car_validate.php
    └── style.php
```

## Database

Database name: `car_rental_system`

| Table   | Purpose | Key columns |
|---------|---------|-------------|
| `users` | Admin and customer accounts | `id`, `full_name`, `username` (unique), `email`, `password` (hashed), `role` (`admin`/`customer`) |
| `cars`  | Rental fleet | `id`, `brand`, `model`, `year`, `plate_number` (unique), `color`, `category`, `seats`, `transmission`, `fuel`, `price_per_day`, `status`, `description`, `added_by` |

- `category`: Economy, SUV, Luxury, Van, Pickup
- `status`: available, rented, maintenance
- `cars.added_by` references `users.id` (set to `NULL` if that user is deleted)

The sample data contains 14 cars and 4 users (1 admin, 3 customers).

## Installation (Local: XAMPP / WAMP)

1. Copy the `car_rental` folder into `htdocs` (XAMPP) or `www` (WAMP).
2. Start **Apache** and **MySQL**.
3. Open phpMyAdmin and create an empty database named `car_rental_system`.
4. Select that database and **Import** the file `car_rental_system (1).sql`.
   (The dump has no `CREATE DATABASE` line, so the database must exist and be selected first.)
5. Check the settings in `config.php`:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'root');
   define('DB_PASS', '');
   define('DB_NAME', 'car_rental_system');
   define('PER_PAGE', 6);   // items per page
   ```
6. Open `http://localhost/car_rental/` in your browser.

## Deployment (Free Hosting)

1. Create a hosting account and a MySQL database. Note the host, database name, username and password.
2. Import the SQL file with phpMyAdmin into that database.
3. Update `config.php` with the hosting database details.
4. Upload all project files to `public_html` using File Manager or FTP.
5. Open your site URL.

## Sample Login Accounts

| Role     | Full name            | Username  | Password      |
|----------|----------------------|-----------|---------------|
| Admin    | System Administrator | `Admin`   | `admin123`    |
| Customer | IRANZI Jean de Dieu  | `Iranzi`  | `customer123` |
| Customer | AKAYEZU Achelle      | `Achelle` | `customer123` |
| Customer | UWIZEYE Belyse       | `Belyse`  | `customer123` |

Change these passwords before using the system anywhere public.

## Usage

1. **Log in** with one of the sample accounts below.
2. **New users** click *Create new account* on the login page. Their account is pending.
3. **Admin approves** them under *Manage Users* (pending accounts are listed first).
4. Approved users can log in and use the features for their role.

### Creating or resetting an admin password
If you cannot log in with the sample accounts, create a PHP file that prints a hash:

```php
<?php echo password_hash('YourNewPassword', PASSWORD_DEFAULT);
```

Then paste the result into the `password` column of the `users` table for the admin row in phpMyAdmin, and delete the helper file.

## How Account Approval Works

No extra database column is used. A newly registered account stores its password hash with a `PENDING:` prefix, which blocks login. When an admin approves the account, the prefix is removed. Accounts created directly by an admin are approved immediately.

## Security Notes
- Passwords are hashed with `password_hash()` and verified with `password_verify()`
- All database queries use prepared statements
- Forms are protected with CSRF tokens; output is escaped with `htmlspecialchars`
- Session ID is regenerated on login
- Admin pages are protected by role checks (`require_login('admin')`)

**Known limitations** (worth fixing before real-world use):
- The registration form lets anyone choose the **Admin** role. It still needs approval, but approval requires an existing admin to notice the request.
- Password reset only checks username + email, with no email verification link.
- There is no booking or rental transaction module yet; cars have a status but customers cannot reserve them in the app.

## License
For educational use.
