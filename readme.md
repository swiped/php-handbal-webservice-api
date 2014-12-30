## KNKV Webservice API Wrapper

** Under construction **

Use Composer to install this package (`"fruitcakestudio/knkv-webservice-api": "0.1.x@dev",`) and require the autoloader.

You can use the HttpClient to make requests to the API directly or use the API object to get more abstracted results.

All objects have public properties, matching the key/value from the API directly. getProgam, getResults and getStandings can be called on the API directly, or on a team. The Team ID is then passed on automatically.

See the documentation on http://www.onswebbond.nl/userfiles/knkv/webservice.zip

You need a subscription to the Onsweb Clubplugin for KNKV: http://www.onswebbond.nl/

> Note: the API limits unique requests to 1 per hour. See Cache usage below.

> Note: the `page` parameter on getResults doesn't seem to be working yet.

Simple example:

```php
require_once __DIR__ .'/../vendor/autoload.php';

use KNKV\Webservice\Api;

// Create a new API instance
$api = new Api($code);

$program = $api->getProgram(true);

foreach($api->getTeams() as $team){
    echo $team->getName();
    $results = $team->getResults();

    foreach($team->getStandings() as $standing){
        echo $standing->poule->getName();
        foreach ($standing->lines as $line) {
            echo $line->position .'. ' . $line->team_name;
        }
    }
}
```

### Cache

You can use the cache component from Laravel (illuminate/cache). By default, an ArrayCache is used, which only caches for the current request. If you want to use a FileCache for example, composer require `"illuminate/filesystem": "~4.0` and do the following:

```php
$filesystem = new \Illuminate\Filesystem\Filesystem;
$cacheStore = new \Illuminate\Cache\FileStore($filesystem, __DIR__.'/cache');

// Create a new API instance
$api = new Api($code, $cacheStore);
```

When using Laravel, you can use `Cache::getStore()` to get the Cache store.