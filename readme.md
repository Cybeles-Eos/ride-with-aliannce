# D&R Laravel CMS Template

- [Developed by Monte Carlo Web Graphics Studio, Inc.](https://montecarlowebgraphics.com/)

## Requirements

- PHP -> 7.4+
- Composer -> latest version
- MySQL -> 5.8+

## Installation

1. Clone this repository to your local machine

```sh
$ git clone https://github.com/guevarawebgraphics/laravel-template.git
```

2. Create your database

```sh
$ mysql -u root -p

# you should be inside MySQL console to do this:
mysql> CREATE DATABASE lr_laraveltemplatev8_dv;
```

3. CD to project directory then install composer libraries

```sh
$ cd path/to/dnrlaravel8
$ composer install
```

4. Create Laravel .env

```sh
$ cp .env.example .env
$ php artisan key:generate
```

5. Fill in necessary fields in .env file (i.e DB setup, Mail driver, etc...)

6. Migrate and seed your database

```sh
$ php artisan migrate:fresh --seed
```

## Setup SMTP Email

1. Create Gmail Account [https://mail.google.com](https://mail.google.com/)

```sh

```

2. Navigate to "See All Settings" > "Forwarding and POP/IMAP" > Enable IMAP

```sh

```

3. Navigate to "Manage your Gmail account" > "Security" > 2-Step Verification (Turn-on)

```sh

```

4. App Passwords > Select App > Other (Custom name) > DNR SMTP > Generate (Save app password somewhere)

```sh

```

4. Update your .env values

## Setup Captcha

1. Update .env with these values

```sh
$ NOCAPTCHA_SECRET=6LdZl-YUAAAAAHXzsk6nWNevfBeFi2px7OUKGQMg
$ NOCAPTCHA_SITEKEY=6LdZl-YUAAAAAN7L8o-ePVMimXaS0ZSfZDQSV0KV
```

## Usage

1. CD to your project directory (skip if you're still in project directory)

```sh
$ cd path/to/dnrlaravel8
```

2. View all routes and its available methods

```sh
$ php artisan route:list
```
