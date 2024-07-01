##  Job Board API
The Job Board API is based on finding the suitable jobs for job seekers and also it allows employer to register their company to this system so that they can announce vacancies and hire suitable candidate to the suitable position.

### Installation
```bash
https://github.com/bishal221973/job_board_api.git
```

```bash
cd job_board_api
```

```bash
composer install
```

```bash
cp .env.example .env
```

Now, set the environment variables in ``` .env ``` file .

Generate application keys:
```bash
php artisan key:generate
```

Make sure you have configured database details.

Now migrate  database using:

```bash
php artisan migrate 
```

Seed the database with some defaults values:
```bash
php artisan db:seed
```

Create symbolic link for storage
```bash
php artisan storage:link
```

Optionally you can migrate and seed in single command: ```php artisan migrate --seed``` . This command will first migrate the database and then run the `DatabaseSeeder>` class , which will be used to call other seed classes. 


