# Lumen Session Example

###### Example of 
[https://stackoverflow.com/questions/47050984/enabling-session-in-lumen-framework/47055083#47055083](https://stackoverflow.com/questions/47050984/enabling-session-in-lumen-framework/47055083#47055083)

#### Note

I've updated this repo to support to all lumen version starting from 5.6 to 8.0. All versions are in their corresponding branches whereas master branch correspond to `laravel/lumen-framework 8.0`.

####  How-To

Laravel has officially stopped supporting sessions & views in `laravel/lumen` framework from version 5.2 and on wards.

But `laravel` still have a component `illuminate/session` which can be installed in `lumen/framework` and we can play around with this.

**Step - 1**

install `illuminate/session` using 

`composer require illuminate/session`

**Step - 2**

Now goto `bootstrap/app.php` and add this middleware

```php
$app->middleware([
    \Illuminate\Session\Middleware\StartSession::class,
]);
```

Purpose of adding the above middleware is to start session on every request and save session before serving response.


**Step - 3**

Now add `config/session.php`, since it is not present in `Lumen` by default. You can take `session.php` from [Laravel official repo](https://github.com/laravel/laravel/blob/master/config/session.php).

**Step - 4**

Create framework session storage directory by 

```bash

mkdir -p storage/framework/sessions

```

Thanks to [DayDream](https://stackoverflow.com/a/50080632/2190807)

**Step - 5**

In `bootstrap/app.php` add bindings for `\Illuminate\Session\SessionManager`

```php
$app->singleton(Illuminate\Session\SessionManager::class, function () use ($app) {
    return $app->loadComponent('session', Illuminate\Session\SessionServiceProvider::class, 'session');
});

$app->singleton('session.store', function () use ($app) {
    return $app->loadComponent('session', Illuminate\Session\SessionServiceProvider::class, 'session.store');
});
```

Thanks to [@xxRockOnxx](https://laracasts.com/@xxRockOnxx) for finding `loadComponent` method. 
It takes 3 arguments, 

* first one is `config` file name. (file should be present in `config/` directory)
* second is ServiceProvider FQN
* third is return of this method.

`loadComponent` just calls the `$app->register` and inject `$app` while building the `ServiceProvider`

**How to Use**

``` PHP

// Save Session
$router->get('/', function (\Illuminate\Http\Request $request) {

    $request->session()->put('name', 'Lumen-Session');

    return response()->json([
        'session.name' => $request->session()->get('name')
    ]);
});


// Test session
$router->get('/session', function (\Illuminate\Http\Request $request) {

    return response()->json([
        'session.name' => $request->session()->get('name'),
    ]);
});
```


**How to use this example**

You can clone this project using

```bash

git clone git@github.com:rummykhan/lumen-session-example.git 

cp .env.example .env

composer install

php  artisan serve

```

### Contact

[rehan_manzoor@outlook.com](mailto://rehan_manzoor@outlook.com)
