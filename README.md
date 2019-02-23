## backup your application

![](https://raw.githubusercontent.com/KarimQaderi/Zoroaster-backup-tool/master/1.png)

## نصب 

```bash
composer require karim-qaderi/zoroaster-backup-tool
```



## سطح دسترسی 

برای اینکه سطح دسترسی رو بزارید فایل `app/Providers/ZoroasterServiceProvider.php` رو باز کنید کد زیر رو در `boot` قرار دهید. 

```php
/**
 * Bootstrap any application services.
 *
 * @return void
 */
protected function boot()
{
    Gate::define('Zoroaster-backup-tool', function ($user) {
        return in_array($user->email, [
            'karimqaderi1@gmail.com',
        ]);
    });
}
```