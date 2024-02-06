Try adding to wp_config:
```
/* All-In-One WP Migration */
define('WP_MEMORY_LIMIT', '256M');
define('MAX_EXECUTION_TIME', 300);
```

And/or:
```
@ini_set( 'upload_max_filesize' , '200M' );
@ini_set( 'post_max_size', '200M');
@ini_set( 'memory_limit', '256M' );
@ini_set( 'max_execution_time', '300' );
@ini_set( 'max_input_time', '0' );
```

Or add them both, in the order presented here