## Installation

Clone the repo locally:

```sh
git clone https://github.com/lionwalker/customer-relationship-management.git customer-relationship-management
cd customer-relationship-management
```

Install PHP dependencies:

```sh
composer install
```

Install NPM dependencies:

```sh
npm install
```

Build assets:

```sh
npm run dev
```

Setup configuration with database information:

```sh
cp .env.example .env
```

Generate application key:

```sh
php artisan key:generate
```

Create MySql database if not already created:

```sh
php artisan make:default-db
```

Run database migrations:

```sh
php artisan migrate
```

Run database seeder:

```sh
php artisan db:seed
```

Run the dev server (the output will give the address):

```sh
php artisan serve
```

Ready to go! Visit CRM in your browser, and login with:

- **Username:** admin@admin.com
- **Password:** Admin@123

#### API documentation

```sh
http://{base_url}/api/documentation
```
