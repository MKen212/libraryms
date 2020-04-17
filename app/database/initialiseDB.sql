/* Database and Table Initialisation SQL Statements for libraryms*/

-- Create libraryms main database
CREATE DATABASE IF NOT EXISTS libraryms;

-- Use privnet database
USE libraryms;

-- Create users table
CREATE TABLE IF NOT EXISTS users (
  UserID INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  UserName VARCHAR(40) NOT NULL UNIQUE,
  UserPassword VARCHAR(100) NOT NULL,
  FirstName VARCHAR(40),
  LastName VARCHAR (40),
  Email VARCHAR (40),
  ContactNo VARCHAR(40),
  IsAdmin BOOLEAN NOT NULL DEFAULT 0,
  UserStatus BOOLEAN NOT NULL DEFAULT 0
);

-- Load initial test users - use registration.php
INSERT INTO users
  (UserName, UserPassword, FirstName, LastName, Email, ContactNo, IsAdmin, UserStatus) VALUES
  ("UserTest", "####", "User", "Test", "usertest@gmail.com", "12345", "0", "1"),
  ("AdminTest", "####", "Admin", "Test", "admintest@gmail.com", "98765", "1", "1");

-- Update Admin Status
UPDATE users SET UserStatus = "1" WHERE UserID = 1 OR UserID = 2;
UPDATE users SET IsAdmin = "1" WHERE UserID = 2;
