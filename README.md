
## Prerequisites
<ul>
<li>After cloning this repository, go to the root folder, run the following command/s,
```
    composer install
    composer update
```
<li>Rename .env.example to .env and provide your database details there.</li>
Run the following command to migrate the Database
```
  php artisan migrate
```

Seed the hotel using the following command

```
  php artisan db:seed
```

The project uses jwt for authentication. Run the following command to generate a jwt secret
```
php artisan jwt:secret
```

<li>Laravel manages the frontend tools like vue using npm. So run <code>npm install</code> to get all the required dependencies.</li>
<li>Run <pre>php artisan key:generate</pre> </li>

</ul>
