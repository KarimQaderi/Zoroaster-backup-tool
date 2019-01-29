## backup your application



## نصب 

فایل composer.json باز کنید و کد زیر رو قرار دهید :

```json
    "require": {
        "karim-qaderi/zoroaster-backup-tool": "*"
    },
    "repositories": [
        {
            "type": "git",
            "url": "https://github.com/KarimQaderi/Zoroaster-backup-tool.git"
        }
    ],
```

```bash
composer update
```



## سطع دسترسی 

برای اینکه سطع دسترسی رو بزارید فایل `app/Providers/ZoroasterServiceProvider.php` رو باز کنید کد زیر رو در `boot` قرار دهید. 

```php
/**
 * Bootstrap any application services.
 *
 * @return void
 */
protected function boot()
{
    Gate::define('Zoroaster-cache-card', function ($user) {
        return in_array($user->email, [
            'karimqaderi1@gmail.com',
        ]);
    });
}
```