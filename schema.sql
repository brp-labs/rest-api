-- DATABASE SCHEMA

-- The following batches are written in standard SQL (ANSI) and supposed to be run in phpMyAdmin or the MySQL CLI on the local server.

-- Batch #1: Create the database named 'db'.
CREATE DATABASE db;

-- Batch #2: Switch to the database.
USE db;

-- Batch #3: Create the table named 'users' with the specified columns, data types and constraints.
CREATE TABLE users (
    id int NOT NULL AUTO_INCREMENT, 
    user_id varchar(255),
    username varchar(255) NOT NULL,
    email varchar(255) NOT NULL,
    entity varchar(255),
    entitycode varchar(4),
    PRIMARY KEY (id),
    UNIQUE (user_id),
    UNIQUE (username)
);
