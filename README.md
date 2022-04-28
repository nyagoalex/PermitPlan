<p align="center">PERMIT PLAN</p>

----------

# Getting started
Permit plan is an online platform that facilitates easy management of tour tickets and permits. 
This project contains 2 branches (**frontend**) and (**backend**) linked by an API.

## <p align="center">BACKEND</p>
<p align="center">This is designed to be a backend for a permit plan. it is powered by laravel a php framework and 
serves  RESTful APIs that are linked to a 
frontend.</p>
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

## Installation

Clone the repository

    git clone git@github.com:nyagoalex/PermitPlan.git backend

Switch to the repo folder

    cd backend

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000

**TL;DR command list**

    git clone git@github.com:nyagoalex/PermitPlan.git backend
    cd backend
    composer install
    cp .env.example .env
    php artisan key:generate
    
**Make sure you set the correct database connection information before running the migrations** [Environment variables](#environment-variables)

    php artisan migrate
    php artisan serve

## Database seeding

**No seeders are required for this application**

The api can be accessed at [http://localhost:8000/api](http://localhost:8000/api).

## Testing APIs
Application follows test driven design run the following command to test the api

    php vendor/bin/phpunit --testdox --configuration phpunit.xml --colors=always

Thank you for considering my work

----------

## <p align="center">FRONTEND</p>
<p align="center">This is designed to be a frontent for a permit plan. It is designed using vuejs.</p>

## Prerequisites
You will need [Node.js](https://nodejs.org) version 6.0 or greater installed on your system.

## Setup

Get the code by either cloning this repository using git

    > git clone git@github.com:nyagoalex/PermitPlan.git frontend
... or [downloading source code](https://github.com/nyagoalex/PermitPlan/archive/refs/heads/master.zip) code as a zip archive.

Once downloaded, open the terminal in the project directory, and continue with:

```
npm install
```
### Compiles and hot-reloads for development
```
npm run serve
```

### Compiles and minifies for production
```
npm run build
```

### Lints and fixes files
```
npm run lint
```
