# 🏛 Pensioner Management System

A Secure & Scalable Laravel-Based Pension Administration Platform

![Laravel](https://img.shields.io/badge/Laravel-9.x-red?logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.2-blue?logo=php)
![MySQL](https://img.shields.io/badge/MySQL-8-blue?logo=mysql)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5-purple?logo=bootstrap)

---

## Project Overview

The Pensioner Management System (PMS) is a web-based application designed to digitally manage pensioners, officers/admins, and pension-related operations.

It allows authorized officers to manage pensioner records, issue payslips, export reports, and ensure transparent and efficient pension administration.

---

## Features

-   Officer / Admin account management (Create, Update, Delete)
-   Pensioner record management (Add, Edit, Delete)
-   Pension payslip generation
-   Office-wise data management (One office → multiple officers & pensioners)
-   Search functionality for officers and pensioners
-   Export data to Excel (.xlsx) with serial numbers
-   Fully responsive UI using Bootstrap 5

---

## Technology Stack

Backend : Laravel 9.x  
Frontend : Blade + Bootstrap 5  
Language : PHP 8.2  
Database : MySQL 8  
Export : Laravel Excel

---

## Project Structure

pensioner-management/
├── app/
├── database/
├── public/
├── resources/
├── routes/
├── storage/
├── .env
└── artisan

---

## Installation Guide (Windows Server – Production)

### Step 1: Server Preparation

-   Windows Server 2019 / 2022
-   Enable .NET Framework 4.8
-   Configure firewall for HTTP/HTTPS

---

### Step 2: Install Git

Download from:
https://git-scm.com/download/win

Verify:
git --version

---

### Step 3: Install Node.js using NVM

Download:
https://github.com/coreybutler/nvm-windows/releases

Install Node:
nvm install 18
nvm use 18
node -v
npm -v

---

### Step 4: Install PHP 8.2

Download:
https://windows.php.net/download

Extract to:
C:\php

Add C:\php to System PATH

Enable extensions in php.ini:
extension=openssl
extension=pdo_mysql
extension=mbstring
extension=fileinfo
extension=gd
extension=zip

Verify:
php -v

---

### Step 5: Install Composer

Download:
https://getcomposer.org/Composer-Setup.exe

Verify:
composer -V

---

### Step 6: Install MySQL 8

Download:
https://dev.mysql.com/downloads/installer/

Create database:
CREATE DATABASE pensioner_db;

---

### Step 7: Clone Project

git clone https://github.com/your-username/pensioner-management.git
cd pensioner-management

---

### Step 8: Environment Setup

copy .env.example .env

Update .env:
APP_NAME="Pensioner Management System"
APP_ENV=production
APP_DEBUG=false
APP_URL=http://your-domain.com

DB_DATABASE=pensioner_db
DB_USERNAME=root
DB_PASSWORD=your_password

---

### Step 9: Install Dependencies

composer install
npm install
npm run build

---

### Step 10: Application Setup

php artisan key:generate
php artisan migrate --force
php artisan db:seed --force
php artisan storage:link

---

### Step 11: Install Nginx

Download:
https://nginx.org/en/download.html

Sample Nginx Config:
server {
listen 80;
server_name your-domain.com;

    root C:/projects/pensioner-management/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass 127.0.0.1:9000;
        include fastcgi.conf;
    }

}

---

### Step 12: Run PHP using NSSM

Download:
https://nssm.cc/download

Create service:
nssm install php-fcgi

Path:
C:\php\php-cgi.exe

Arguments:
-b 127.0.0.1:9000

Start service:
nssm start php-fcgi

---

## Production Checklist

-   APP_DEBUG=false
-   .env secured
-   Database backup enabled
-   HTTPS configured

---

## License

MIT License

---

## Support

If this project helps you, please star the repository ⭐
