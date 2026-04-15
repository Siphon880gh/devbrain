It looks like:
```
<?php

$mongoUser = 'USER';
$mongoPassword = 'PASSWORD';
$authSource = 'admin';

$uri = "mongodb://$mongoUser:$mongoPassword@localhost:27017/?authSource=$authSource";

try {
    $client = new MongoDB\Driver\Manager($uri);

    $command = new MongoDB\Driver\Command([
        'listDatabases' => 1
    ]);

    $cursor = $client->executeCommand('admin', $command);
    $result = current($cursor->toArray());

    echo "Connected successfully. Databases:\n";

    foreach ($result->databases ?? [] as $db) {
        echo " - " . ($db->name ?? '[unknown]') . "\n";
    }

} catch (Throwable $e) {
    echo "Failed to connect: " . $e->getMessage() . "\n";
}
```