# Laravel starter

This is a task management system. That allows a user to create, update, delete and view only theirs tasks. It sends email notifications when a task has been completed

## Getting started

### Launch the starter project

_(Assuming you've [installed Laravel](https://laravel.com/docs/11/installation))_

Clone this repository, 
```bash
git clone https://github.com/evansnawu/taskmanangementsystem.git
```
and run this in your newly created directory:

```bash
composer install
```

```bash
npm run install
```

Next you need to make a copy of the `.env.example` file and rename it to `.env` inside your project root.

Run the following command to generate your app key:

```
php artisan key:generate
```

Then start your server:

```
php artisan serve
```

Your Laravel starter project is now up and running!

### Configure the starter project

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
The run the following command to queued emails:

```
php artisan queue:work
```
