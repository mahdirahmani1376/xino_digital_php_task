# Xino Php Task

## project description
this is an implementation of an E-learning platform like: udemy
users can enroll in courses and currently there are 3 subscrption_plans
which will alow users to access different sections

## Setup
- clone the repo and run the following commands
```sh
cp .env .env.example
docker compose up -d --build
docker exec -it xino_digital_php_task-php-1 composer install
docker exec -it xino_digital_php_task-php-1 php artisan migrate --seed
docker exec -it xino_digital_php_task-php-1 php artisan test
```
## How to test the application in PostMan
1. Login the User via the "User/Login" request the Token global variable will be set autolatically on all other requests2. Create an invoice with the "Invoice/Store" request
3. Pay the Created Invoice with the "Invoice/Pay" request
4. Activate your subscription with the "Payment/Successful callback" request
5. AutoRenew your subscription by "Create Plan" request
6. Test the webhook functionality to advance the Subscription monthly
7. Test the "Course" area based on your subscription plan
## How Does the payment system works
when you want to pay an Invoice Back-End Application returns a url in response
then the Front-End will redirect the user to that url for the payment to process
after that the payment gateway will call the callback url on our site
and on a successful callback an active subscription will be created for the user
the user can activate autorenwal via webhook by calling the create-plan method
after that on end of every month the user will be charged automatically and its subscription will be renewed

