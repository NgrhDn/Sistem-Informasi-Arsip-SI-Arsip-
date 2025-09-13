-- Optional manual database creation script for MySQL/MariaDB
-- Run this before `php artisan migrate --seed` IF the database does not yet exist.
-- Adjust charset/collation if needed.

CREATE DATABASE IF NOT EXISTS `si_arsip`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

-- After creating DB, ensure your .env has:
-- DB_DATABASE=si_arsip
-- DB_USERNAME=your_user
-- DB_PASSWORD=your_password
