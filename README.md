Installation of a project

1) Clone the repository to your local  machine from github
2) Run `composer install` in the terminal inside root
3)Copy .env.example file in to the root and rename it to .env.Setup cofigurations for database in the following section

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_test
DB_USERNAME=root
DB_PASSWORD=root

4)After successfully setup process, run 
`php artisan migrate` to create tables in DB

5) run `php artisan db:seed` to seed the data in DB. 
6) Login to  the site with admin role credentials 
	login: admin@gmail.com
	password: password1111

Login to the site with user role  credentials
	login: user@gmail.com
	password: password
