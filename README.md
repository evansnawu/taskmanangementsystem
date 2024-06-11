# Task Management System

This comprehensive task management system empowers users to efficiently manage their personal tasks. It provides the functionality to create, update, delete, and view tasks exclusively assigned to them. Additionally, the system ensures timely communication by sending email notifications upon the completion of tasks. It is designed to enhance productivity and streamline task tracking, making it an invaluable tool for both personal and professional use.

## Getting started

### Launch the Task Management System

_(Assuming you've [installed composer](https://laravel.com/docs/11.x),[node](https://nodejs.org/en/learn/getting-started/how-to-install-nodejs),[php8.2](https://www.php.net/manual/en/install.php), [mysql](https://dev.mysql.com/doc/mysql-installation-excerpt/5.7/en/))_

Clone this repository, 
```bash
git clone https://github.com/evansnawu/taskmanangementsystem.git
```
and run this in your newly created directory:

```bash
composer install
```

```bash
npm install
```

Next you need to make a copy of the `.env.example` file and rename it to `.env` inside your project root.

Run the following command to generate your app key:

```
Change as per your db credentials in .env

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=sail
DB_PASSWORD=password

php artisan migrate --seed
```

```
php artisan key:generate
```

Then start your server:

```
php artisan serve

npm run dev
```

Your Laravel starter project is now up and running!

### Configure the Task Management System Emails

Insert you mailing server credentials to send email in .env:

```
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=xxxxxxxx
MAIL_PASSWORD=xxxxxxx
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=xxxxxxxxx
MAIL_FROM_NAME="${APP_NAME}"

```
The run the following command to run queued emails:

```
php artisan queue:work
```


The run the following command to run test ensure db connection and correct mail smpt credentials before running tests:

```
 php artisan optimize:clear

 then

php artisan test

```
