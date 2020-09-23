# tracker
Record and share your daily health updates with Tracker. This is a small example LAMP project built with the Laravel 8 framework.

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

### Prerequisites

The Laravel [documentation] (https://laravel.com/docs/8.x) does a great job summarizing what you need to get started with a Laravel project. There are no special prerequisites other than those listed at the link. 

### Installing

Once you have a dev environment running, follow the steps below.

Clone the repo

```
git clone git@github.com:willira2/tracker.git
```

Switch to the repo folder

```
cd tracker
```
Install all the dependencies using composer

```
composer install
```

Copy the example env file and make the required configuration changes in the .env file

```
cp .env.example .env
```

Generate a new application key

```
php artisan key:generate
```

Generate a new JWT authentication secret key

```
php artisan jwt:generate
```

Run the database migrations (Set the database connection in .env before migrating)

```
php artisan migrate
```

If you are using php's included server to run the project, start it with this command

```
php artisan serve
```

You can access the project in your browser at http://localhost. If you have configured a virtual host for your project, you can also access it via your chosen host name.

On your initial visit, open localhost/register to create a username and password.

## Deployment

This project has been made as an example only and has not been been tested in a live environment.

## Built With

* Laravel 8
* PHP 7.4
* MySQL 15.1

## Authors

* **Rachel Williams** rawillia90@gmail.com

## License

This project is licensed under the MIT License

## Acknowledgments

* Thank you to coffee and everyone who has released how-to's on Laravel 8 since its release two weeks ago!
