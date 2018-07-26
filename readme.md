# DataBase Watcher

Laravel package to monitor database request , exposing an API to collect the usage statistics or using the package builtin view to represent the data on graphs using Chartjs. 

### install:

Require this package with composer using the following command:
```
composer require bakraj/databasewatcher
```

After updating composer, add the service provider to the  `providers`  array in  `config/app.php`
```
$ bakraj\DataBaseWatcher\DataBaseWatcherServiceProvider::class,
```
**Laravel 5.5**  uses Package Auto-Discovery, so doesn't require you to manually add the ServiceProvider.


### Publishing views, assets and config:
1- publishing all:
```
$ php artisan vendor:publish --provider="bakraj\DataBaseWatcher\DataBaseWatcherServiceProvider"
```
2- publishing config:
```
$ php artisan vendor:publish --tag=databasewatcer.config --force
```
3- publishing views:
```
$ php artisan vendor:publish --tag=databasewatcer.views --force
```
4- publishing assets:
```
$ php artisan vendor:publish --tag=databasewatcer.assets --force
```

### API Documentation:
#### over all statistics:
  calling the route
```
/databasewatcher/overall
```
  expected result:
```
{
	"stats":
		{
			"2018-07-25":121
		}
}
```

####  specific day statistics:
calling the route:
```
/analyze/{date}
```
expected result:
```
{
	"stats":
		{
			"2018-07-25":
				{
					"hour_request":
						{
						"1":3,"2":9
						},
						"total":12
						}
				}
	}
```