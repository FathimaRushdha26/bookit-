<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'bookit_db');
define('DB_USER', 'root');
define('DB_PASS', '');

define('APP_NAME', 'BookIt');
// Auto-detect base path (works in XAMPP sub-folders)
define('BASE_URL', rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/'));

// Bookable hourly slots
define('TIME_SLOTS', ['09:00','10:00','11:00','12:00','13:00','14:00','15:00','16:00']);
