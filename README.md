# Xino Php Task

## project description
this is an implementation of an E-learning platform like: udemy
users can enroll in courses and currently there are 3 subscrption_plans
which will alow users to access different sections

## Setup
- clone the repo and run the following commands
```sh
composer install
cp .env .env.example
```
- fill your database credentials for the mysql connection
- for the testing env an sqlite database is used
```sh
php artisan migrate --seed
php artisan test
```
## How to test the application in PostMan
1. Login the User via the "User/Login" request
2. Create an invoice with the "Invoice/Store" request
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

