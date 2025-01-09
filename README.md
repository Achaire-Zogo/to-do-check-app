#### HOW TO RUN THE APP

1. Clone the repository from Heroku CLI
2. Install all the necessary packages by: $ composer install or $ composer update 
3. Create the .env file by typing the command:$ cp .env.example .env
4. Generate Application key with: $ php artisan key:generate
5. Run the migration (create the database): $ php artisan migrate
6. Insert dummy data: $ php artisan db:seed
7. Run the app: $ php artisan serve and launch your browser on the url from your local machine
8. Enjoy !!!
