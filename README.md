
## Laravel Email Auditing

To use the Email Auditing Service, ensure it's integrated into your email sending process. Once integrated, all outgoing emails will be monitored and stored in the `email_auditing` table.


## Installing


```bash
composer require roland/laravel-email-auditing
```


## Publishing migrations
Lets publish package migrations

```
php artisan vendor:publish --tag=email-auditing-migrations 
```

## Migrating database
```
php artisan migrate
```


## Usage and reports
There is already aliased eloquent model
```php
use Roland\LaravelEmailAuditingLog\Models\EmailAuditing;

EmailAuditing::all();
```


