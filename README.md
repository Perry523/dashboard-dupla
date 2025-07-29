# Dashboard dupla - Pix Payments

### Build Setup (dev):

```
* Install dependencies
> npm install

* Build project(Vue and Node dependencies)
> npm run build

* Install php dependencies
> composer install --ignore-platform-reqs

* Generate laravel project key
> php artisan key:generate

* (optional/recommended) Clean reload php config
> php artisan config:cache

* Configure manually enviroment tags
> Configurar DB tags in .env

* Loads required database schemas
> php artisan migrate

*(optional) Run in real time node libraries
> npm run dev — —host

* Up artisan server to host project
> (parallel) php artisan serve --host 192.168.0.107 --port 5173

*(optional) Looks the log exit
> (parallel) npm run logs
```