## Give Away Voucher Campaign

### Installation
1. Clone the repo
```sh
git clone https://github.com/hein99/company-abc.git
```
2. Install Composer packages
```sh
composer install
```
3. Copy the environment file and edit it accordingly
```sh
cp .env.example .env
```
4. Generate application key
```sh
php artisan key:generate
```
5. Create Database tables and insert dummny data(*Make sure database info in .env)
```sh
php artisan migrate:fresh --seed
```
6. Serve the application
```sh
php artisan serve
```

### Documentation and Logic process for each API works
#### You can find these files in this repo
Documentation => api-documentation.html <br>
Logic of Api works => Logic-of-Api-works.pdf