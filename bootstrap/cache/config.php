<?php return array (
  'app' => 
  array (
    'name' => 'laravel-shop',
    'env' => 'local',
    'debug' => false,
    'url' => 'http://127.0.0.1:9091',
    'asset_url' => NULL,
    'timezone' => 'Asia/Tehran',
    'locale' => 'fa',
    'locales' => 
    array (
      'fa' => 
      array (
        'name' => 'فارسی',
        'direction' => 'rtl',
        'english_name' => 'Persian',
      ),
      'en' => 
      array (
        'name' => 'English',
        'direction' => 'ltr',
        'english_name' => 'English',
      ),
      'tr' => 
      array (
        'name' => 'Turkey',
        'direction' => 'ltr',
        'english_name' => 'Turkey',
      ),
    ),
    'fallback_locale' => 'fa',
    'faker_locale' => 'fa_IR',
    'key' => 'base64:/VwBgVZddvBeNkfkPAR3ZNRvQZ6DWS4hff7apy6XYe4=',
    'cipher' => 'AES-256-CBC',
    'providers' => 
    array (
      0 => 'Illuminate\\Auth\\AuthServiceProvider',
      1 => 'Illuminate\\Broadcasting\\BroadcastServiceProvider',
      2 => 'Illuminate\\Bus\\BusServiceProvider',
      3 => 'Illuminate\\Cache\\CacheServiceProvider',
      4 => 'Illuminate\\Foundation\\Providers\\ConsoleSupportServiceProvider',
      5 => 'Illuminate\\Cookie\\CookieServiceProvider',
      6 => 'Illuminate\\Database\\DatabaseServiceProvider',
      7 => 'Illuminate\\Encryption\\EncryptionServiceProvider',
      8 => 'Illuminate\\Filesystem\\FilesystemServiceProvider',
      9 => 'Illuminate\\Foundation\\Providers\\FoundationServiceProvider',
      10 => 'Illuminate\\Hashing\\HashServiceProvider',
      11 => 'Illuminate\\Mail\\MailServiceProvider',
      12 => 'Illuminate\\Notifications\\NotificationServiceProvider',
      13 => 'Illuminate\\Pagination\\PaginationServiceProvider',
      14 => 'Illuminate\\Pipeline\\PipelineServiceProvider',
      15 => 'Illuminate\\Queue\\QueueServiceProvider',
      16 => 'Illuminate\\Redis\\RedisServiceProvider',
      17 => 'Illuminate\\Auth\\Passwords\\PasswordResetServiceProvider',
      18 => 'Illuminate\\Session\\SessionServiceProvider',
      19 => 'Illuminate\\Translation\\TranslationServiceProvider',
      20 => 'Illuminate\\Validation\\ValidationServiceProvider',
      21 => 'Illuminate\\View\\ViewServiceProvider',
      22 => 'Intervention\\Image\\ImageServiceProvider',
      23 => 'RachidLaasri\\LaravelInstaller\\Providers\\LaravelInstallerServiceProvider',
      24 => 'Shetabit\\Payment\\Provider\\PaymentServiceProvider',
      25 => 'Codedge\\Updater\\UpdaterServiceProvider',
      26 => 'App\\Providers\\AppServiceProvider',
      27 => 'App\\Providers\\AuthServiceProvider',
      28 => 'App\\Providers\\BroadcastServiceProvider',
      29 => 'App\\Providers\\EventServiceProvider',
      30 => 'App\\Providers\\RouteServiceProvider',
    ),
    'aliases' => 
    array (
      'App' => 'Illuminate\\Support\\Facades\\App',
      'Arr' => 'Illuminate\\Support\\Arr',
      'Artisan' => 'Illuminate\\Support\\Facades\\Artisan',
      'Auth' => 'Illuminate\\Support\\Facades\\Auth',
      'Blade' => 'Illuminate\\Support\\Facades\\Blade',
      'Broadcast' => 'Illuminate\\Support\\Facades\\Broadcast',
      'Bus' => 'Illuminate\\Support\\Facades\\Bus',
      'Cache' => 'Illuminate\\Support\\Facades\\Cache',
      'Config' => 'Illuminate\\Support\\Facades\\Config',
      'Cookie' => 'Illuminate\\Support\\Facades\\Cookie',
      'Crypt' => 'Illuminate\\Support\\Facades\\Crypt',
      'DB' => 'Illuminate\\Support\\Facades\\DB',
      'Eloquent' => 'Illuminate\\Database\\Eloquent\\Model',
      'Event' => 'Illuminate\\Support\\Facades\\Event',
      'File' => 'Illuminate\\Support\\Facades\\File',
      'Gate' => 'Illuminate\\Support\\Facades\\Gate',
      'Hash' => 'Illuminate\\Support\\Facades\\Hash',
      'Http' => 'Illuminate\\Support\\Facades\\Http',
      'Lang' => 'Illuminate\\Support\\Facades\\Lang',
      'Log' => 'Illuminate\\Support\\Facades\\Log',
      'Mail' => 'Illuminate\\Support\\Facades\\Mail',
      'Notification' => 'Illuminate\\Support\\Facades\\Notification',
      'Password' => 'Illuminate\\Support\\Facades\\Password',
      'Queue' => 'Illuminate\\Support\\Facades\\Queue',
      'Redirect' => 'Illuminate\\Support\\Facades\\Redirect',
      'Redis' => 'Illuminate\\Support\\Facades\\Redis',
      'Request' => 'Illuminate\\Support\\Facades\\Request',
      'Response' => 'Illuminate\\Support\\Facades\\Response',
      'Route' => 'Illuminate\\Support\\Facades\\Route',
      'Schema' => 'Illuminate\\Support\\Facades\\Schema',
      'Session' => 'Illuminate\\Support\\Facades\\Session',
      'Storage' => 'Illuminate\\Support\\Facades\\Storage',
      'Str' => 'Illuminate\\Support\\Str',
      'URL' => 'Illuminate\\Support\\Facades\\URL',
      'Validator' => 'Illuminate\\Support\\Facades\\Validator',
      'View' => 'Illuminate\\Support\\Facades\\View',
      'Image' => 'Intervention\\Image\\Facades\\Image',
    ),
  ),
  'auth' => 
  array (
    'defaults' => 
    array (
      'guard' => 'web',
      'passwords' => 'users',
    ),
    'guards' => 
    array (
      'web' => 
      array (
        'driver' => 'session',
        'provider' => 'users',
      ),
      'api' => 
      array (
        'driver' => 'token',
        'provider' => 'users',
        'hash' => false,
      ),
      'sanctum' => 
      array (
        'driver' => 'sanctum',
        'provider' => NULL,
      ),
    ),
    'providers' => 
    array (
      'users' => 
      array (
        'driver' => 'eloquent',
        'model' => 'App\\Models\\User',
      ),
    ),
    'passwords' => 
    array (
      'users' => 
      array (
        'provider' => 'users',
        'table' => 'password_resets',
        'expire' => 60,
        'throttle' => 60,
      ),
    ),
    'password_timeout' => 10800,
  ),
  'backup' => 
  array (
    'backup' => 
    array (
      'name' => 'site-backup',
      'source' => 
      array (
        'files' => 
        array (
          'include' => 
          array (
            0 => 'C:\\laragon\\www\\novintarasheh\\public/uploads',
          ),
          'exclude' => 
          array (
            0 => 'C:\\laragon\\www\\novintarasheh\\vendor',
            1 => 'C:\\laragon\\www\\novintarasheh\\node_modules',
          ),
          'follow_links' => false,
          'ignore_unreadable_directories' => false,
          'relative_path' => NULL,
        ),
        'databases' => 
        array (
          0 => 'mysql',
        ),
      ),
      'database_dump_compressor' => NULL,
      'destination' => 
      array (
        'filename_prefix' => '',
        'disks' => 
        array (
          0 => 'backup',
        ),
      ),
      'temporary_directory' => 'C:\\laragon\\www\\novintarasheh\\storage\\app/backup-temp',
    ),
    'notifications' => 
    array (
      'notifications' => 
      array (
        'Spatie\\Backup\\Notifications\\Notifications\\BackupHasFailed' => 
        array (
          0 => 'mail',
        ),
        'Spatie\\Backup\\Notifications\\Notifications\\UnhealthyBackupWasFound' => 
        array (
          0 => 'mail',
        ),
        'Spatie\\Backup\\Notifications\\Notifications\\CleanupHasFailed' => 
        array (
          0 => 'mail',
        ),
        'BackupWasSuccessful' => 
        array (
          0 => 'mail',
        ),
        'Spatie\\Backup\\Notifications\\Notifications\\HealthyBackupWasFound' => 
        array (
          0 => 'mail',
        ),
        'Spatie\\Backup\\Notifications\\Notifications\\CleanupWasSuccessful' => 
        array (
          0 => 'mail',
        ),
      ),
      'notifiable' => 'Spatie\\Backup\\Notifications\\Notifiable',
      'mail' => 
      array (
        'to' => 'your@example.com',
        'from' => 
        array (
          'address' => 'hello@example.com',
          'name' => 'Example',
        ),
      ),
    ),
    'monitor_backups' => 
    array (
      0 => 
      array (
        'name' => 'laravel-shop',
        'disks' => 
        array (
          0 => 'local',
        ),
        'health_checks' => 
        array (
          'Spatie\\Backup\\Tasks\\Monitor\\HealthChecks\\MaximumAgeInDays' => 1,
          'Spatie\\Backup\\Tasks\\Monitor\\HealthChecks\\MaximumStorageInMegabytes' => 5000,
        ),
      ),
    ),
    'cleanup' => 
    array (
      'strategy' => 'Spatie\\Backup\\Tasks\\Cleanup\\Strategies\\DefaultStrategy',
      'default_strategy' => 
      array (
        'keep_all_backups_for_days' => 7,
        'keep_daily_backups_for_days' => 16,
        'keep_weekly_backups_for_weeks' => 8,
        'keep_monthly_backups_for_months' => 4,
        'keep_yearly_backups_for_years' => 2,
        'delete_oldest_backups_when_using_more_megabytes_than' => 5000,
      ),
    ),
  ),
  'barcode' => 
  array (
    'store_path' => 'C:\\laragon\\www\\novintarasheh\\public\\/uploads/barcodes/',
  ),
  'broadcasting' => 
  array (
    'default' => 'log',
    'connections' => 
    array (
      'pusher' => 
      array (
        'driver' => 'pusher',
        'key' => '',
        'secret' => '',
        'app_id' => '',
        'options' => 
        array (
          'cluster' => NULL,
          'host' => 'api-mt1.pusher.com',
          'port' => 443,
          'scheme' => 'https',
          'encrypted' => true,
          'useTLS' => true,
        ),
        'client_options' => 
        array (
        ),
      ),
      'websocket' => 
      array (
        'driver' => 'pusher',
        'key' => '',
        'secret' => '',
        'app_id' => '',
        'options' => 
        array (
          'cluster' => NULL,
          'host' => 'pusher.t-nateghi.ir',
          'port' => 6001,
          'encrypted' => true,
          'useTLS' => true,
          'scheme' => 'https',
          'curl_options' => 
          array (
            81 => 0,
            64 => 0,
          ),
        ),
      ),
      'ably' => 
      array (
        'driver' => 'ably',
        'key' => NULL,
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'connection' => 'default',
      ),
      'log' => 
      array (
        'driver' => 'log',
      ),
      'null' => 
      array (
        'driver' => 'null',
      ),
    ),
  ),
  'cache' => 
  array (
    'default' => 'file',
    'stores' => 
    array (
      'apc' => 
      array (
        'driver' => 'apc',
      ),
      'array' => 
      array (
        'driver' => 'array',
        'serialize' => false,
      ),
      'database' => 
      array (
        'driver' => 'database',
        'table' => 'cache',
        'connection' => NULL,
        'lock_connection' => NULL,
      ),
      'file' => 
      array (
        'driver' => 'file',
        'path' => 'C:\\laragon\\www\\novintarasheh\\storage\\framework/cache/data',
      ),
      'memcached' => 
      array (
        'driver' => 'memcached',
        'persistent_id' => NULL,
        'sasl' => 
        array (
          0 => NULL,
          1 => NULL,
        ),
        'options' => 
        array (
        ),
        'servers' => 
        array (
          0 => 
          array (
            'host' => '127.0.0.1',
            'port' => 11211,
            'weight' => 100,
          ),
        ),
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'connection' => 'cache',
        'lock_connection' => 'default',
      ),
      'dynamodb' => 
      array (
        'driver' => 'dynamodb',
        'key' => NULL,
        'secret' => NULL,
        'region' => 'us-east-1',
        'table' => 'cache',
        'endpoint' => NULL,
      ),
    ),
    'prefix' => 'laravel_shop_cache',
  ),
  'captcha' => 
  array (
    'disable' => false,
    'characters' => 
    array (
      0 => '2',
      1 => '3',
      2 => '4',
      3 => '6',
      4 => '7',
      5 => '8',
      6 => '9',
      7 => 'a',
      8 => 'b',
      9 => 'c',
      10 => 'd',
      11 => 'e',
      12 => 'f',
      13 => 'g',
      14 => 'h',
      15 => 'j',
      16 => 'm',
      17 => 'n',
      18 => 'p',
      19 => 'q',
      20 => 'r',
      21 => 't',
      22 => 'u',
      23 => 'x',
      24 => 'y',
      25 => 'z',
      26 => 'A',
      27 => 'B',
      28 => 'C',
      29 => 'D',
      30 => 'E',
      31 => 'F',
      32 => 'G',
      33 => 'H',
      34 => 'J',
      35 => 'M',
      36 => 'N',
      37 => 'P',
      38 => 'Q',
      39 => 'R',
      40 => 'T',
      41 => 'U',
      42 => 'X',
      43 => 'Y',
      44 => 'Z',
    ),
    'default' => 
    array (
      'length' => 9,
      'width' => 120,
      'height' => 36,
      'quality' => 90,
      'math' => false,
      'expire' => 60,
      'encrypt' => false,
    ),
    'math' => 
    array (
      'length' => 9,
      'width' => 120,
      'height' => 36,
      'quality' => 90,
      'math' => true,
    ),
    'flat' => 
    array (
      'length' => 4,
      'width' => 160,
      'height' => 60,
      'quality' => 90,
      'lines' => 3,
      'bgImage' => false,
      'bgColor' => '#ecf2f4',
      'fontColors' => 
      array (
        0 => '#2c3e50',
        1 => '#c0392b',
        2 => '#16a085',
        3 => '#c0392b',
        4 => '#8e44ad',
        5 => '#303f9f',
        6 => '#f57c00',
        7 => '#795548',
      ),
      'contrast' => -5,
    ),
    'mini' => 
    array (
      'length' => 3,
      'width' => 60,
      'height' => 32,
    ),
    'inverse' => 
    array (
      'length' => 5,
      'width' => 120,
      'height' => 36,
      'quality' => 90,
      'sensitive' => true,
      'angle' => 12,
      'sharpen' => 10,
      'blur' => 2,
      'invert' => true,
      'contrast' => -5,
    ),
  ),
  'cors' => 
  array (
    'paths' => 
    array (
      0 => 'api/*',
      1 => 'sanctum/csrf-cookie',
    ),
    'allowed_methods' => 
    array (
      0 => '*',
    ),
    'allowed_origins' => 
    array (
      0 => '*',
    ),
    'allowed_origins_patterns' => 
    array (
    ),
    'allowed_headers' => 
    array (
      0 => '*',
    ),
    'exposed_headers' => 
    array (
    ),
    'max_age' => 0,
    'supports_credentials' => false,
  ),
  'database' => 
  array (
    'default' => 'mysql',
    'connections' => 
    array (
      'sqlite' => 
      array (
        'driver' => 'sqlite',
        'url' => NULL,
        'database' => 'novintarashe',
        'prefix' => '',
        'foreign_key_constraints' => true,
      ),
      'mysql' => 
      array (
        'driver' => 'mysql',
        'url' => NULL,
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'novintarashe',
        'username' => 'root',
        'password' => '',
        'unix_socket' => '',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
        'prefix_indexes' => true,
        'strict' => true,
        'engine' => 'InnoDB',
        'options' => 
        array (
        ),
        'dump' => 
        array (
          'dump_binary_path' => '/usr/bin/',
          0 => 'use_single_transaction',
          'timeout' => 600,
        ),
      ),
      'pgsql' => 
      array (
        'driver' => 'pgsql',
        'url' => NULL,
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'novintarashe',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8',
        'prefix' => '',
        'prefix_indexes' => true,
        'schema' => 'public',
        'sslmode' => 'prefer',
      ),
      'sqlsrv' => 
      array (
        'driver' => 'sqlsrv',
        'url' => NULL,
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'novintarashe',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8',
        'prefix' => '',
        'prefix_indexes' => true,
      ),
    ),
    'migrations' => 'migrations',
    'redis' => 
    array (
      'client' => 'predis',
      'options' => 
      array (
        'cluster' => 'redis',
        'prefix' => 'laravel_shop_database_',
      ),
      'default' => 
      array (
        'url' => NULL,
        'host' => '127.0.0.1',
        'password' => NULL,
        'port' => '6379',
        'database' => '0',
      ),
      'cache' => 
      array (
        'url' => NULL,
        'host' => '127.0.0.1',
        'password' => NULL,
        'port' => '6379',
        'database' => '1',
      ),
    ),
  ),
  'debugbar' => 
  array (
    'enabled' => false,
    'except' => 
    array (
      0 => 'telescope*',
      1 => 'horizon*',
    ),
    'storage' => 
    array (
      'enabled' => true,
      'driver' => 'file',
      'path' => 'C:\\laragon\\www\\novintarasheh\\storage\\debugbar',
      'connection' => NULL,
      'provider' => '',
      'hostname' => '127.0.0.1',
      'port' => 2304,
    ),
    'editor' => 'phpstorm',
    'remote_sites_path' => '',
    'local_sites_path' => '',
    'include_vendors' => true,
    'capture_ajax' => true,
    'add_ajax_timing' => false,
    'error_handler' => false,
    'clockwork' => false,
    'collectors' => 
    array (
      'phpinfo' => true,
      'messages' => true,
      'time' => true,
      'memory' => true,
      'exceptions' => true,
      'log' => true,
      'db' => true,
      'views' => true,
      'route' => true,
      'auth' => false,
      'gate' => true,
      'session' => true,
      'symfony_request' => true,
      'mail' => true,
      'laravel' => false,
      'events' => false,
      'default_request' => false,
      'logs' => false,
      'files' => false,
      'config' => false,
      'cache' => false,
      'models' => true,
      'livewire' => true,
    ),
    'options' => 
    array (
      'auth' => 
      array (
        'show_name' => true,
      ),
      'db' => 
      array (
        'with_params' => true,
        'backtrace' => true,
        'backtrace_exclude_paths' => 
        array (
        ),
        'timeline' => false,
        'explain' => 
        array (
          'enabled' => false,
          'types' => 
          array (
            0 => 'SELECT',
          ),
        ),
        'hints' => false,
        'show_copy' => false,
      ),
      'mail' => 
      array (
        'full_log' => false,
      ),
      'views' => 
      array (
        'data' => false,
      ),
      'route' => 
      array (
        'label' => true,
      ),
      'logs' => 
      array (
        'file' => NULL,
      ),
      'cache' => 
      array (
        'values' => true,
      ),
    ),
    'inject' => true,
    'route_prefix' => '_debugbar',
    'route_domain' => NULL,
    'theme' => 'auto',
    'debug_backtrace_limit' => 50,
  ),
  'excel' => 
  array (
    'exports' => 
    array (
      'chunk_size' => 1000,
      'pre_calculate_formulas' => false,
      'csv' => 
      array (
        'delimiter' => ',',
        'enclosure' => '"',
        'line_ending' => '
',
        'use_bom' => false,
        'include_separator_line' => false,
        'excel_compatibility' => false,
      ),
    ),
    'imports' => 
    array (
      'read_only' => true,
      'heading_row' => 
      array (
        'formatter' => 'slug',
      ),
      'csv' => 
      array (
        'delimiter' => ',',
        'enclosure' => '"',
        'escape_character' => '\\',
        'contiguous' => false,
        'input_encoding' => 'UTF-8',
      ),
    ),
    'extension_detector' => 
    array (
      'xlsx' => 'Xlsx',
      'xlsm' => 'Xlsx',
      'xltx' => 'Xlsx',
      'xltm' => 'Xlsx',
      'xls' => 'Xls',
      'xlt' => 'Xls',
      'ods' => 'Ods',
      'ots' => 'Ods',
      'slk' => 'Slk',
      'xml' => 'Xml',
      'gnumeric' => 'Gnumeric',
      'htm' => 'Html',
      'html' => 'Html',
      'csv' => 'Csv',
      'tsv' => 'Csv',
      'pdf' => 'Dompdf',
    ),
    'value_binder' => 
    array (
      'default' => 'Maatwebsite\\Excel\\DefaultValueBinder',
    ),
    'cache' => 
    array (
      'driver' => 'memory',
      'batch' => 
      array (
        'memory_limit' => 60000,
      ),
      'illuminate' => 
      array (
        'store' => NULL,
      ),
      'default_ttl' => 10800,
    ),
    'transactions' => 
    array (
      'handler' => 'db',
    ),
    'temporary_files' => 
    array (
      'local_path' => 'C:\\Users\\Mahdi\\AppData\\Local\\Temp',
      'remote_disk' => NULL,
      'remote_prefix' => NULL,
    ),
  ),
  'file-manager' => 
  array (
    'configRepository' => 'Alexusmai\\LaravelFileManager\\Services\\ConfigService\\DefaultConfigRepository',
    'aclRepository' => 'Alexusmai\\LaravelFileManager\\Services\\ACLService\\ConfigACLRepository',
    'routePrefix' => 'file-manager',
    'diskList' => 
    array (
      0 => 'ckeditor',
      1 => 'downloads',
    ),
    'leftDisk' => NULL,
    'rightDisk' => NULL,
    'leftPath' => NULL,
    'rightPath' => NULL,
    'cache' => NULL,
    'windowsConfig' => 1,
    'maxUploadFileSize' => NULL,
    'allowFileTypes' => 
    array (
    ),
    'hiddenFiles' => true,
    'middleware' => 
    array (
      0 => 'web',
      1 => 'Admin',
      2 => 'can:file-manager',
    ),
    'acl' => false,
    'aclHideFromFM' => true,
    'aclStrategy' => 'blacklist',
    'aclRulesCache' => NULL,
    'aclRules' => 
    array (
      '' => 
      array (
      ),
      1 => 
      array (
      ),
    ),
  ),
  'filesystems' => 
  array (
    'default' => 'local',
    'disks' => 
    array (
      'local' => 
      array (
        'driver' => 'local',
        'root' => 'C:\\laragon\\www\\novintarasheh\\public\\uploads',
      ),
      'public' => 
      array (
        'driver' => 'local',
        'root' => 'C:\\laragon\\www\\novintarasheh\\public\\/',
        'url' => 'http://127.0.0.1:9091',
        'visibility' => 'public',
      ),
      'backup' => 
      array (
        'driver' => 'local',
        'root' => 'C:\\laragon\\www\\novintarasheh\\storage\\app/backups',
      ),
      'downloads' => 
      array (
        'driver' => 'local',
        'root' => 'C:\\laragon\\www\\novintarasheh\\storage\\app/downloads',
      ),
      'ckeditor' => 
      array (
        'driver' => 'local',
        'root' => 'C:\\laragon\\www\\novintarasheh\\public\\uploads/ckeditor',
        'url' => '/uploads/ckeditor',
        'visibility' => 'public',
      ),
      's3' => 
      array (
        'driver' => 's3',
        'key' => NULL,
        'secret' => NULL,
        'region' => NULL,
        'bucket' => NULL,
        'url' => NULL,
        'endpoint' => NULL,
      ),
      'themes' => 
      array (
        'driver' => 'local',
        'root' => 'C:\\laragon\\www\\novintarasheh\\themes',
      ),
    ),
    'links' => 
    array (
      'C:\\laragon\\www\\novintarasheh\\public\\storage' => 'C:\\laragon\\www\\novintarasheh\\storage\\app/public',
    ),
  ),
  'general' => 
  array (
    'api_url' => 'http://laravel-shop.ir/api/v1',
    'admin_route_prefix' => 'admin',
    'current_theme' => 'DefaultTheme',
    'permissions' => 
    array (
      'users' => 
      array (
        'title' => 'مدیریت کاربران',
        'values' => 
        array (
          'index' => 'لیست کاربران',
          'view' => 'مشاهده کاربر',
          'create' => 'ایجاد کاربر',
          'update' => 'ویرایش کاربر',
          'delete' => 'حذف کاربر',
          'export' => 'خروجی گرفتن',
          'wallet' => 'مدیریت کیف پول',
        ),
      ),
      'posts' => 
      array (
        'title' => 'مدیریت نوشته ها',
        'values' => 
        array (
          'index' => 'لیست نوشته ها',
          'create' => 'ایجاد نوشته',
          'update' => 'ویرایش نوشته',
          'delete' => 'حذف نوشته',
          'category' => 'مدیریت دسته بندی ها',
        ),
      ),
      'products' => 
      array (
        'title' => 'مدیریت محصولات',
        'values' => 
        array (
          'index' => 'لیست محصولات',
          'create' => 'ایجاد محصول',
          'update' => 'ویرایش محصول',
          'delete' => 'حذف محصول',
          'export' => 'خروجی گرفتن',
          'category' => 'مدیریت دسته بندی ها',
          'spectypes' => 'مدیریت نوع مشخصات',
          'sizetypes' => 'مدیریت سایزبندی ها',
          'stock-notify' => 'مدیریت لیست اطلاع از موجودی',
          'brands' => 'مدیریت برندها',
          'prices' => 'قیمت ها',
        ),
      ),
      'discounts' => 
      array (
        'title' => 'مدیریت تخفیف ها',
        'values' => 
        array (
          'index' => 'لیست تخفیف ها',
          'create' => 'ایجاد تخفیف',
          'update' => 'ویرایش تخفیف',
          'delete' => 'حذف تخفیف',
        ),
      ),
      'attributes' => 
      array (
        'title' => 'مدیریت ویژگی ها',
        'values' => 
        array (
          'groups.index' => 'لیست گروه ویژگی ها',
          'groups.show' => 'مشاهده گروه ویژگی',
          'groups.create' => 'ایجاد گروه ویژگی',
          'groups.update' => 'ویرایش گروه ویژگی',
          'groups.delete' => 'حذف گروه ویژگی',
          'index' => 'لیست ویژگی ها',
          'create' => 'ایجاد ویژگی',
          'update' => 'ویرایش ویژگی',
          'delete' => 'حذف ویژگی',
        ),
      ),
      'filters' => 
      array (
        'title' => 'مدیریت فیلترها',
        'values' => 
        array (
          'index' => 'لیست فیلترها',
          'create' => 'ایجاد فیلتر',
          'update' => 'ویرایش فیلتر',
          'delete' => 'حذف فیلتر',
        ),
      ),
      'orders' => 
      array (
        'title' => 'مدیریت سفارشات',
        'values' => 
        array (
          'index' => 'لیست سفارشات',
          'create' => 'افزودن سفارش جدید',
          'view' => 'مشاهده سفارش',
          'update' => 'ویرایش سفارش',
          'delete' => 'حذف سفارش',
          'export' => 'خروجی گرفتن',
        ),
      ),
      'carriers' => 
      array (
        'title' => 'مدیریت حمل و نقل',
        'values' => 
        array (
          'provinces.index' => 'لیست استان ها',
          'provinces.update' => 'ویرایش استان',
          'provinces.delete' => 'حذف استان',
          'provinces.create' => 'ایجاد استان',
          'provinces.show' => 'مشاهده استان',
          'cities.update' => 'ویرایش شهر',
          'cities.delete' => 'حذف شهر',
          'cities.create' => 'ایجاد شهر',
        ),
      ),
      'sliders' => 
      array (
        'title' => 'مدیریت اسلایدرها',
        'values' => 
        array (
          'index' => 'لیست اسلایدرها',
          'create' => 'ایجاد اسلایدر',
          'update' => 'ویرایش اسلایدر',
          'delete' => 'حذف اسلایدر',
        ),
      ),
      'banners' => 
      array (
        'title' => 'مدیریت بنرها',
        'values' => 
        array (
          'index' => 'لیست بنرها',
          'create' => 'ایجاد بنر',
          'update' => 'ویرایش بنر',
          'delete' => 'حذف بنر',
        ),
      ),
      'links' => 
      array (
        'title' => 'مدیریت لینک های فوتر',
        'values' => 
        array (
          'index' => 'لیست لینک ها',
          'create' => 'ایجاد لینک',
          'update' => 'ویرایش لینک',
          'delete' => 'حذف لینک',
          'groups' => 'مدیریت گروه ها',
        ),
      ),
      'backups' => 
      array (
        'title' => 'مدیریت بکاپ ها',
        'values' => 
        array (
          'index' => 'لیست بکاپ ها',
          'create' => 'ایجاد بکاپ',
          'download' => 'دانلود بکاپ',
          'delete' => 'حذف بکاپ',
        ),
      ),
      'apikeys' => 
      array (
        'title' => 'مدیریت کلیدهای وب سرویس',
        'values' => 
        array (
          'index' => 'لیست کلیدهای وب سرویس',
          'create' => 'ایجاد کلید وب سرویس',
          'update' => 'ویرایش کلید وب سرویس',
          'delete' => 'حذف کلید وب سرویس',
        ),
      ),
      'pages' => 
      array (
        'title' => 'مدیریت صفحات',
        'values' => 
        array (
          'index' => 'لیست صفحات',
          'create' => 'ایجاد صفحه',
          'update' => 'ویرایش صفحه',
          'delete' => 'حذف صفحه',
        ),
      ),
      'roles' => 
      array (
        'title' => 'مدیریت مقام ها',
        'values' => 
        array (
          'index' => 'لیست مقام ها',
          'create' => 'ایجاد مقام',
          'update' => 'ویرایش مقام',
          'delete' => 'حذف مقام',
        ),
      ),
      'statistics' => 
      array (
        'title' => 'گزارشات',
        'values' => 
        array (
          'orders' => 'سفارشات',
          'users' => 'کاربران',
          'views' => 'بازدیدها',
          'viewsList' => 'لیست بازدیدها',
          'viewers' => 'بازدید کنندگان امروز',
          'sms' => 'لاگ پیامک های ارسالی',
        ),
      ),
      'themes' => 
      array (
        'title' => 'مدیریت قالب ها',
        'values' => 
        array (
          'index' => 'لیست قالب ها',
          'create' => 'افزودن قالب',
          'update' => 'تغییر قالب',
          'delete' => 'حذف قالب',
          'settings' => 'تنظیمات قالب',
          'widgets' => 'مدیریت صفحه اصلی',
        ),
      ),
      'file-manager' => 'مدیریت فایل ها',
      'tickets' => 
      array (
        'title' => 'مدیریت تیکت ها',
        'values' => 
        array (
          'index' => 'لیست تیکت ها',
          'show' => 'مشاهده تیکت',
          'create' => 'ایجاد تیکت',
          'update' => 'ویرایش تیکت',
          'delete' => 'حذف تیکت',
        ),
      ),
      'menus' => 
      array (
        'title' => 'مدیریت منو ها',
        'values' => 
        array (
          'index' => 'لیست منو ها',
          'create' => 'ایجاد منو',
          'update' => 'ویرایش منو',
          'delete' => 'حذف منو',
        ),
      ),
      'payments' => 
      array (
        'title' => 'مدیریت پرداخت',
        'values' => 
        array (
          'transactions.index' => 'لیست تراکنش ها',
          'transactions.view' => 'مشاهده تراکنش',
          'transactions.delete' => 'حذف تراکنش',
          'currencies' => 'مدیریت ارزها',
          'wallet-histories.index' => 'تاریخچه کیف پول',
        ),
      ),
      'contacts' => 
      array (
        'title' => 'مدیریت تماس با ما',
        'values' => 
        array (
          'index' => 'لیست تماس با ما',
          'view' => 'مشاهده تماس با ما',
          'delete' => 'حذف تماس با ما',
        ),
      ),
      'comments' => 
      array (
        'title' => 'مدیریت نظرات',
        'values' => 
        array (
          'index' => 'لیست نظرات',
          'view' => 'مشاهده نظر',
          'update' => 'ویرایش نظر',
          'delete' => 'حذف نظر',
        ),
      ),
      'settings' => 
      array (
        'title' => 'تنظیمات',
        'values' => 
        array (
          'information' => 'اطلاعات سایت',
          'socials' => 'شبکه های اجتماعی',
          'gateway' => 'درگاه های پرداخت',
          'others' => 'تنظیمات دیگر',
          'sms' => 'تنظیمات پیامک',
        ),
      ),
    ),
    'static_menus' => 
    array (
      'posts' => 
      array (
        'title' => 'وبلاگ',
      ),
      'products' => 
      array (
        'title' => 'محصولات',
      ),
    ),
    'supported_gateways' => 
    array (
      'behpardakht' => 'به پرداخت ملت',
      'payir' => 'pay.ir',
      'zarinpal' => 'زرین پال',
      'payping' => 'پی پینگ',
      'saman' => 'سامان',
      'sepehr' => 'بانک صادرات',
      'idpay' => 'idpay',
      'sadad' => 'بانک ملی',
      'zibal' => 'زیبال',
      'check1' => 'پرداخت چک یک ماه',
      'check2' => 'پرداخت چک دو ماه',
      'check3' => 'پرداخت چک سه ماه',
      'check4' => 'پرداخت چک چهارماه',
      'check5' => 'پرداخت چک پنج ماه',
      'check6' => 'پرداخت چک شش ماه',
    ),
    'video-helpes' => 
    array (
      'installing' => 
      array (
        'title' => 'آموزش نصب کردن اسکریپت',
        'link' => 'https://www.aparat.com/v/2ZzrD',
        'type' => 'creator',
      ),
      'sms-config' => 
      array (
        'title' => 'آموزش ثبت نام و تنظیم پنل پیامک',
        'link' => 'https://aparat.com/v/wbQ9D',
        'type' => 'admin',
      ),
      'updater' => 
      array (
        'title' => 'آموزش بروزرسانی اسکریپت',
        'link' => 'https://aparat.com/v/CfgAF',
        'type' => 'creator',
      ),
      'cronjob' => 
      array (
        'title' => 'آموزش تنظیم کرون جاب',
        'link' => 'https://aparat.com/v/BpAN1',
        'type' => 'creator',
      ),
      'users' => 
      array (
        'title' => 'آموزش بخش کاربران',
        'link' => 'https://aparat.com/v/pWeUw',
        'type' => 'admin',
      ),
      'products-create' => 
      array (
        'title' => 'آموزش ایجاد محصول',
        'link' => 'https://aparat.com/v/Re0US',
        'type' => 'admin',
      ),
    ),
    'non_language_options' => 
    array (
      0 => 'multi_language_enabled',
      1 => 'debugbar_enabled',
      2 => 'enable_help_videos',
      3 => 'user_register_gift_credit',
    ),
  ),
  'hashing' => 
  array (
    'driver' => 'bcrypt',
    'bcrypt' => 
    array (
      'rounds' => 10,
    ),
    'argon' => 
    array (
      'memory' => 1024,
      'threads' => 2,
      'time' => 2,
    ),
  ),
  'installer' => 
  array (
    'core' => 
    array (
      'minPhpVersion' => '7.3.0',
    ),
    'final' => 
    array (
      'key' => true,
      'publish' => false,
    ),
    'requirements' => 
    array (
      'php' => 
      array (
        0 => 'openssl',
        1 => 'pdo',
        2 => 'mbstring',
        3 => 'tokenizer',
        4 => 'JSON',
        5 => 'cURL',
        6 => 'fileinfo',
        7 => 'zip',
      ),
      'apache' => 
      array (
        0 => 'mod_rewrite',
      ),
    ),
    'laravel-version' => '8.x',
    'permissions' => 
    array (
      'storage/framework/' => '745',
      'storage/logs/' => '745',
      'bootstrap/cache/' => '745',
    ),
    'environment' => 
    array (
      'form' => 
      array (
        'rules' => 
        array (
          'database_hostname' => 'required|string|max:50',
          'database_port' => 'required|numeric',
          'database_name' => 'required|string|max:50',
          'database_username' => 'required|string|max:50',
          'database_password' => 'nullable|string|max:50',
        ),
      ),
    ),
    'installed' => 
    array (
      'redirectOptions' => 
      array (
        'route' => 
        array (
          'name' => 'admin.dashboard',
          'data' => 
          array (
          ),
        ),
        'abort' => 
        array (
          'type' => '404',
        ),
        'dump' => 
        array (
          'data' => 'Dumping a not found message.',
        ),
      ),
    ),
    'installedAlreadyAction' => '',
    'updaterEnabled' => 'true',
  ),
  'kavenegar' => 
  array (
    'apikey' => '',
  ),
  'logging' => 
  array (
    'default' => 'stack',
    'channels' => 
    array (
      'stack' => 
      array (
        'driver' => 'stack',
        'channels' => 
        array (
          0 => 'single',
        ),
        'ignore_exceptions' => false,
      ),
      'single' => 
      array (
        'driver' => 'single',
        'path' => 'C:\\laragon\\www\\novintarasheh\\storage\\logs/laravel.log',
        'level' => 'debug',
      ),
      'daily' => 
      array (
        'driver' => 'daily',
        'path' => 'C:\\laragon\\www\\novintarasheh\\storage\\logs/laravel.log',
        'level' => 'debug',
        'days' => 14,
      ),
      'slack' => 
      array (
        'driver' => 'slack',
        'url' => NULL,
        'username' => 'Laravel Log',
        'emoji' => ':boom:',
        'level' => 'debug',
      ),
      'papertrail' => 
      array (
        'driver' => 'monolog',
        'level' => 'debug',
        'handler' => 'Monolog\\Handler\\SyslogUdpHandler',
        'handler_with' => 
        array (
          'host' => NULL,
          'port' => NULL,
        ),
      ),
      'stderr' => 
      array (
        'driver' => 'monolog',
        'handler' => 'Monolog\\Handler\\StreamHandler',
        'formatter' => NULL,
        'with' => 
        array (
          'stream' => 'php://stderr',
        ),
      ),
      'syslog' => 
      array (
        'driver' => 'syslog',
        'level' => 'debug',
      ),
      'errorlog' => 
      array (
        'driver' => 'errorlog',
        'level' => 'debug',
      ),
      'null' => 
      array (
        'driver' => 'monolog',
        'handler' => 'Monolog\\Handler\\NullHandler',
      ),
      'emergency' => 
      array (
        'path' => 'C:\\laragon\\www\\novintarasheh\\storage\\logs/laravel.log',
      ),
    ),
  ),
  'logviewer' => 
  array (
    'max_file_size' => 52428800,
    'pattern' => '*.log',
    'storage_path' => 'C:\\laragon\\www\\novintarasheh\\storage\\logs',
  ),
  'mail' => 
  array (
    'default' => 'smtp',
    'mailers' => 
    array (
      'smtp' => 
      array (
        'transport' => 'mail',
        'url' => NULL,
        'host' => 'smtp.mailtrap.io',
        'port' => '2525',
        'encryption' => 'tls',
        'username' => '',
        'password' => '',
        'timeout' => NULL,
        'local_domain' => NULL,
      ),
      'ses' => 
      array (
        'transport' => 'ses',
      ),
      'mailgun' => 
      array (
        'transport' => 'mailgun',
      ),
      'postmark' => 
      array (
        'transport' => 'postmark',
      ),
      'sendmail' => 
      array (
        'transport' => 'sendmail',
        'path' => '/usr/sbin/sendmail -bs',
      ),
      'log' => 
      array (
        'transport' => 'log',
        'channel' => NULL,
      ),
      'array' => 
      array (
        'transport' => 'array',
      ),
    ),
    'from' => 
    array (
      'address' => 'hello@example.com',
      'name' => 'Example',
    ),
    'markdown' => 
    array (
      'theme' => 'default',
      'paths' => 
      array (
        0 => 'C:\\laragon\\www\\novintarasheh\\resources\\views/vendor/mail',
      ),
    ),
  ),
  'melipayamak' => 
  array (
    'username' => '',
    'password' => '',
  ),
  'payment' => 
  array (
    'default' => 'zarinpal',
    'drivers' => 
    array (
      'local' => 
      array (
        'callbackUrl' => '/callback',
        'title' => 'درگاه پرداخت تست',
        'description' => 'این درگاه *صرفا* برای تست صحت روند پرداخت و لغو پرداخت میباشد',
        'orderLabel' => 'شماره سفارش',
        'amountLabel' => 'مبلغ قابل پرداخت',
        'payButton' => 'پرداخت موفق',
        'cancelButton' => 'پرداخت ناموفق',
      ),
      'fanavacard' => 
      array (
        'baseUri' => 'https://fcp.shaparak.ir',
        'apiPaymentUrl' => '_ipgw_//payment/',
        'apiPurchaseUrl' => 'ref-payment/RestServices/mts/generateTokenWithNoSign/',
        'apiVerificationUrl' => 'ref-payment/RestServices/mts/verifyMerchantTrans/',
        'apiReverseAmountUrl' => 'ref-payment/RestServices/mts/reverseMerchantTrans/',
        'username' => 'xxxxxxx',
        'password' => 'xxxxxxx',
        'callbackUrl' => 'http://yoursite.com/path/to',
      ),
      'atipay' => 
      array (
        'atipayTokenUrl' => 'https://mipg.atipay.net/v1/get-token',
        'atipayRedirectGatewayUrl' => 'https://mipg.atipay.net/v1/redirect-to-gateway',
        'atipayVerifyUrl' => 'https://mipg.atipay.net/v1/verify-payment',
        'apikey' => '',
        'currency' => 'R',
        'callbackUrl' => 'http://yoursite.com/path/to',
        'description' => 'payment using Atipay',
      ),
      'asanpardakht' => 
      array (
        'apiPaymentUrl' => 'https://asan.shaparak.ir',
        'apiRestPaymentUrl' => 'https://ipgrest.asanpardakht.ir/v1/',
        'username' => '',
        'password' => '',
        'merchantConfigID' => '',
        'callbackUrl' => 'http://yoursite.com/path/to',
        'description' => 'payment using asanpardakht',
      ),
      'behpardakht' => 
      array (
        'apiPurchaseUrl' => 'https://bpm.shaparak.ir/pgwchannel/services/pgw?wsdl',
        'apiPaymentUrl' => 'https://bpm.shaparak.ir/pgwchannel/startpay.mellat',
        'apiVerificationUrl' => 'https://bpm.shaparak.ir/pgwchannel/services/pgw?wsdl',
        'terminalId' => '',
        'username' => '',
        'password' => '',
        'callbackUrl' => 'http://yoursite.com/path/to',
        'description' => 'payment using behpardakht',
      ),
      'digipay' => 
      array (
        'apiOauthUrl' => 'https://api.mydigipay.com/digipay/api/oauth/token',
        'apiPurchaseUrl' => 'https://api.mydigipay.com/digipay/api/businesses/ticket?type=0',
        'apiPaymentUrl' => 'https://api.mydigipay.com/digipay/api/purchases/ipg/pay/',
        'apiVerificationUrl' => 'https://api.mydigipay.com/digipay/api/purchases/verify/',
        'username' => 'username',
        'password' => 'password',
        'client_id' => '',
        'client_secret' => '',
        'callbackUrl' => 'http://yoursite.com/path/to',
      ),
      'etebarino' => 
      array (
        'apiPurchaseUrl' => 'https://api.etebarino.com/public/merchant/request-payment',
        'apiPaymentUrl' => 'https://panel.etebarino.com/gateway/public/ipg',
        'apiVerificationUrl' => 'https://api.etebarino.com/public/merchant/verify-payment',
        'merchantId' => '',
        'terminalId' => '',
        'username' => '',
        'password' => '',
        'callbackUrl' => 'http://yoursite.com/path/to',
        'description' => 'payment using etebarino',
      ),
      'idpay' => 
      array (
        'apiPurchaseUrl' => 'https://api.idpay.ir/v1.1/payment',
        'apiPaymentUrl' => 'https://idpay.ir/p/ws/',
        'apiSandboxPaymentUrl' => 'https://idpay.ir/p/ws-sandbox/',
        'apiVerificationUrl' => 'https://api.idpay.ir/v1.1/payment/verify',
        'merchantId' => '',
        'callbackUrl' => 'http://yoursite.com/path/to',
        'description' => 'payment using idpay',
        'sandbox' => false,
      ),
      'irankish' => 
      array (
        'apiPurchaseUrl' => 'https://ikc.shaparak.ir/XToken/Tokens.xml',
        'apiPaymentUrl' => 'https://ikc.shaparak.ir/TPayment/Payment/index/',
        'apiVerificationUrl' => 'https://ikc.shaparak.ir/XVerify/Verify.xml',
        'merchantId' => '',
        'sha1Key' => '',
        'callbackUrl' => 'http://yoursite.com/path/to',
        'description' => 'payment using irankish',
      ),
      'nextpay' => 
      array (
        'apiPurchaseUrl' => 'https://nextpay.org/nx/gateway/token',
        'apiPaymentUrl' => 'https://nextpay.org/nx/gateway/payment/',
        'apiVerificationUrl' => 'https://nextpay.org/nx/gateway/verify',
        'merchantId' => '',
        'callbackUrl' => 'http://yoursite.com/path/to',
        'description' => 'payment using nextpay',
      ),
      'parsian' => 
      array (
        'apiPurchaseUrl' => 'https://pec.shaparak.ir/NewIPGServices/Sale/SaleService.asmx?wsdl',
        'apiPaymentUrl' => 'https://pec.shaparak.ir/NewIPG/',
        'apiVerificationUrl' => 'https://pec.shaparak.ir/NewIPGServices/Confirm/ConfirmService.asmx?wsdl',
        'merchantId' => '',
        'callbackUrl' => 'http://yoursite.com/path/to',
        'description' => 'payment using parsian',
      ),
      'pasargad' => 
      array (
        'apiPaymentUrl' => 'https://pep.shaparak.ir/payment.aspx',
        'apiGetToken' => 'https://pep.shaparak.ir/Api/v1/Payment/GetToken',
        'apiCheckTransactionUrl' => 'https://pep.shaparak.ir/Api/v1/Payment/CheckTransactionResult',
        'apiVerificationUrl' => 'https://pep.shaparak.ir/Api/v1/Payment/VerifyPayment',
        'merchantId' => '',
        'terminalCode' => '',
        'certificate' => '',
        'certificateType' => 'xml_file',
        'callbackUrl' => 'http://yoursite.com/path/to',
      ),
      'payir' => 
      array (
        'apiPurchaseUrl' => 'https://pay.ir/pg/send',
        'apiPaymentUrl' => 'https://pay.ir/pg/',
        'apiVerificationUrl' => 'https://pay.ir/pg/verify',
        'merchantId' => 'test',
        'callbackUrl' => 'http://yoursite.com/path/to',
        'description' => 'payment using payir',
      ),
      'paypal' => 
      array (
        'apiPurchaseUrl' => 'https://www.paypal.com/cgi-bin/webscr',
        'apiPaymentUrl' => 'https://www.zarinpal.com/pg/StartPay/',
        'apiVerificationUrl' => 'https://ir.zarinpal.com/pg/services/WebGate/wsdl',
        'sandboxApiPurchaseUrl' => 'https://www.sandbox.paypal.com/cgi-bin/webscr',
        'sandboxApiPaymentUrl' => 'https://sandbox.zarinpal.com/pg/StartPay/',
        'sandboxApiVerificationUrl' => 'https://sandbox.zarinpal.com/pg/services/WebGate/wsdl',
        'mode' => 'normal',
        'currency' => '',
        'id' => '',
        'callbackUrl' => 'http://yoursite.com/path/to',
        'description' => 'payment using paypal',
      ),
      'payping' => 
      array (
        'apiPurchaseUrl' => 'https://api.payping.ir/v1/pay/',
        'apiPaymentUrl' => 'https://api.payping.ir/v1/pay/gotoipg/',
        'apiVerificationUrl' => 'https://api.payping.ir/v1/pay/verify/',
        'merchantId' => '',
        'callbackUrl' => 'http://yoursite.com/path/to',
        'description' => 'payment using payping',
      ),
      'paystar' => 
      array (
        'apiPurchaseUrl' => 'https://core.paystar.ir/api/pardakht/create/',
        'apiPaymentUrl' => 'https://core.paystar.ir/api/pardakht/payment/',
        'apiVerificationUrl' => 'https://core.paystar.ir/api/pardakht/verify/',
        'gatewayId' => '',
        'signKey' => '',
        'callbackUrl' => 'http://yoursite.com/path/to',
        'description' => 'payment using paystar',
      ),
      'poolam' => 
      array (
        'apiPurchaseUrl' => 'https://poolam.ir/invoice/request/',
        'apiPaymentUrl' => 'https://poolam.ir/invoice/pay/',
        'apiVerificationUrl' => 'https://poolam.ir/invoice/check/',
        'merchantId' => '',
        'callbackUrl' => 'http://yoursite.com/path/to',
        'description' => 'payment using poolam',
      ),
      'sadad' => 
      array (
        'apiPaymentByIdentityUrl' => 'https://sadad.shaparak.ir/api/v0/PaymentByIdentity/PaymentRequest',
        'apiPaymentUrl' => 'https://sadad.shaparak.ir/api/v0/Request/PaymentRequest',
        'apiPurchaseByIdentityUrl' => 'https://sadad.shaparak.ir/vpg/api/v0/Request/PaymentRequest',
        'apiPurchaseUrl' => 'https://sadad.shaparak.ir/Purchase',
        'apiVerificationUrl' => 'https://sadad.shaparak.ir/VPG/api/v0/Advice/Verify',
        'key' => '',
        'merchantId' => '',
        'terminalId' => '',
        'callbackUrl' => '',
        'mode' => 'normal',
        'PaymentIdentity' => '',
        'description' => 'payment using sadad',
      ),
      'saman' => 
      array (
        'apiPurchaseUrl' => 'https://sep.shaparak.ir/Payments/InitPayment.asmx?WSDL',
        'apiPaymentUrl' => 'https://sep.shaparak.ir/payment.aspx',
        'apiVerificationUrl' => 'https://sep.shaparak.ir/payments/referencepayment.asmx?WSDL',
        'merchantId' => '',
        'callbackUrl' => '',
        'description' => 'payment using saman',
      ),
      'sepehr' => 
      array (
        'apiGetToken' => 'https://mabna.shaparak.ir:8081/V1/PeymentApi/GetToken',
        'apiPaymentUrl' => 'https://mabna.shaparak.ir:8080/pay',
        'apiVerificationUrl' => 'https://mabna.shaparak.ir:8081/V1/PeymentApi/Advice',
        'terminalId' => '',
        'callbackUrl' => '',
        'description' => 'payment using sepehr(saderat)',
      ),
      'walleta' => 
      array (
        'apiPurchaseUrl' => 'https://cpg.walleta.ir/payment/request.json',
        'apiPaymentUrl' => 'https://cpg.walleta.ir/ticket/',
        'apiVerificationUrl' => 'https://cpg.walleta.ir/payment/verify.json',
        'merchantId' => '',
        'callbackUrl' => 'http://yoursite.com/path/to',
        'description' => 'payment using walleta',
      ),
      'yekpay' => 
      array (
        'apiPurchaseUrl' => 'https://gate.yekpay.com/api/payment/server?wsdl',
        'apiPaymentUrl' => 'https://gate.yekpay.com/api/payment/start/',
        'apiVerificationUrl' => 'https://gate.yekpay.com/api/payment/server?wsdl',
        'fromCurrencyCode' => 978,
        'toCurrencyCode' => 364,
        'merchantId' => '',
        'callbackUrl' => 'http://yoursite.com/path/to',
        'description' => 'payment using yekpay',
      ),
      'zarinpal' => 
      array (
        'apiPurchaseUrl' => 'https://api.zarinpal.com/pg/v4/payment/request.json',
        'apiPaymentUrl' => 'https://www.zarinpal.com/pg/StartPay/',
        'apiVerificationUrl' => 'https://api.zarinpal.com/pg/v4/payment/verify.json',
        'sandboxApiPurchaseUrl' => 'https://sandbox.zarinpal.com/pg/services/WebGate/wsdl',
        'sandboxApiPaymentUrl' => 'https://sandbox.zarinpal.com/pg/StartPay/',
        'sandboxApiVerificationUrl' => 'https://sandbox.zarinpal.com/pg/services/WebGate/wsdl',
        'zaringateApiPurchaseUrl' => 'https://ir.zarinpal.com/pg/services/WebGate/wsdl',
        'zaringateApiPaymentUrl' => 'https://www.zarinpal.com/pg/StartPay/:authority/ZarinGate',
        'zaringateApiVerificationUrl' => 'https://ir.zarinpal.com/pg/services/WebGate/wsdl',
        'mode' => 'normal',
        'merchantId' => '',
        'callbackUrl' => 'http://yoursite.com/path/to',
        'description' => 'payment using zarinpal',
      ),
      'zibal' => 
      array (
        'apiPurchaseUrl' => 'https://gateway.zibal.ir/v1/request',
        'apiPaymentUrl' => 'https://gateway.zibal.ir/start/',
        'apiVerificationUrl' => 'https://gateway.zibal.ir/v1/verify',
        'mode' => 'normal',
        'merchantId' => '',
        'callbackUrl' => 'http://yoursite.com/path/to',
        'description' => 'payment using zibal',
      ),
      'sepordeh' => 
      array (
        'apiPurchaseUrl' => 'https://sepordeh.com/merchant/invoices/add',
        'apiPaymentUrl' => 'https://sepordeh.com/merchant/invoices/pay/id:',
        'apiDirectPaymentUrl' => 'https://sepordeh.com/merchant/invoices/pay/automatic:true/id:',
        'apiVerificationUrl' => 'https://sepordeh.com/merchant/invoices/verify',
        'mode' => 'normal',
        'merchantId' => '',
        'callbackUrl' => 'http://yoursite.com/path/to',
        'description' => 'payment using sepordeh',
      ),
      'rayanpay' => 
      array (
        'apiPurchaseUrl' => 'https://bpm.shaparak.ir/pgwchannel/startpay.mellat',
        'apiTokenUrl' => 'https://pms.rayanpay.com/api/v1/auth/token/generate',
        'apiPayStart' => 'https://pms.rayanpay.com/api/v1/ipg/payment/start',
        'apiPayVerify' => 'https://pms.rayanpay.com/api/v1/ipg/payment/response/parse',
        'username' => '',
        'client_id' => '',
        'password' => '',
        'callbackUrl' => '',
      ),
      'sizpay' => 
      array (
        'apiPurchaseUrl' => 'https://rt.sizpay.ir/KimiaIPGRouteService.asmx?WSDL',
        'apiPaymentUrl' => 'https://rt.sizpay.ir/Route/Payment',
        'apiVerificationUrl' => 'https://rt.sizpay.ir/KimiaIPGRouteService.asmx?WSDL',
        'merchantId' => '',
        'terminal' => '',
        'username' => '',
        'password' => '',
        'SignData' => '',
        'callbackUrl' => '',
      ),
      'vandar' => 
      array (
        'apiPurchaseUrl' => 'https://ipg.vandar.io/api/v3/send',
        'apiPaymentUrl' => 'https://ipg.vandar.io/v3/',
        'apiVerificationUrl' => 'https://ipg.vandar.io/api/v3/verify',
        'callbackUrl' => '',
        'merchantId' => '',
        'description' => 'payment using Vandar',
      ),
      'aqayepardakht' => 
      array (
        'apiPurchaseUrl' => 'https://panel.aqayepardakht.ir/api/v2/create',
        'apiPaymentUrl' => 'https://panel.aqayepardakht.ir/startpay/',
        'apiPaymentUrlSandbox' => 'https://panel.aqayepardakht.ir/startpay/sandbox/',
        'apiVerificationUrl' => 'https://panel.aqayepardakht.ir/api/v2/verify',
        'mode' => 'normal',
        'callbackUrl' => '',
        'pin' => '',
        'invoice_id' => '',
        'mobile' => '',
        'email' => '',
        'description' => 'payment using Aqayepardakht',
      ),
    ),
    'map' => 
    array (
      'local' => 'Shetabit\\Multipay\\Drivers\\Local\\Local',
      'fanavacard' => 'Shetabit\\Multipay\\Drivers\\Fanavacard\\Fanavacard',
      'asanpardakht' => 'Shetabit\\Multipay\\Drivers\\Asanpardakht\\Asanpardakht',
      'atipay' => 'Shetabit\\Multipay\\Drivers\\Atipay\\Atipay',
      'behpardakht' => 'Shetabit\\Multipay\\Drivers\\Behpardakht\\Behpardakht',
      'digipay' => 'Shetabit\\Multipay\\Drivers\\Digipay\\Digipay',
      'etebarino' => 'Shetabit\\Multipay\\Drivers\\Etebarino\\Etebarino',
      'idpay' => 'Shetabit\\Multipay\\Drivers\\Idpay\\Idpay',
      'irankish' => 'Shetabit\\Multipay\\Drivers\\Irankish\\Irankish',
      'nextpay' => 'Shetabit\\Multipay\\Drivers\\Nextpay\\Nextpay',
      'parsian' => 'Shetabit\\Multipay\\Drivers\\Parsian\\Parsian',
      'pasargad' => 'Shetabit\\Multipay\\Drivers\\Pasargad\\Pasargad',
      'payir' => 'Shetabit\\Multipay\\Drivers\\Payir\\Payir',
      'paypal' => 'Shetabit\\Multipay\\Drivers\\Paypal\\Paypal',
      'payping' => 'Shetabit\\Multipay\\Drivers\\Payping\\Payping',
      'paystar' => 'Shetabit\\Multipay\\Drivers\\Paystar\\Paystar',
      'poolam' => 'Shetabit\\Multipay\\Drivers\\Poolam\\Poolam',
      'sadad' => 'Shetabit\\Multipay\\Drivers\\Sadad\\Sadad',
      'saman' => 'Shetabit\\Multipay\\Drivers\\Saman\\Saman',
      'sepehr' => 'Shetabit\\Multipay\\Drivers\\Sepehr\\Sepehr',
      'walleta' => 'Shetabit\\Multipay\\Drivers\\Walleta\\Walleta',
      'yekpay' => 'Shetabit\\Multipay\\Drivers\\Yekpay\\Yekpay',
      'zarinpal' => 'Shetabit\\Multipay\\Drivers\\Zarinpal\\Zarinpal',
      'zibal' => 'Shetabit\\Multipay\\Drivers\\Zibal\\Zibal',
      'sepordeh' => 'Shetabit\\Multipay\\Drivers\\Sepordeh\\Sepordeh',
      'rayanpay' => 'Shetabit\\Multipay\\Drivers\\Rayanpay\\Rayanpay',
      'sizpay' => 'Shetabit\\Multipay\\Drivers\\Sizpay\\Sizpay',
      'vandar' => 'Shetabit\\Multipay\\Drivers\\Vandar\\Vandar',
      'aqayepardakht' => 'Shetabit\\Multipay\\Drivers\\Aqayepardakht\\Aqayepardakht',
    ),
  ),
  'queue' => 
  array (
    'default' => 'database',
    'connections' => 
    array (
      'sync' => 
      array (
        'driver' => 'sync',
      ),
      'database' => 
      array (
        'driver' => 'database',
        'table' => 'jobs',
        'queue' => 'default',
        'retry_after' => 900,
      ),
      'beanstalkd' => 
      array (
        'driver' => 'beanstalkd',
        'host' => 'localhost',
        'queue' => 'default',
        'retry_after' => 90,
        'block_for' => 0,
      ),
      'sqs' => 
      array (
        'driver' => 'sqs',
        'key' => NULL,
        'secret' => NULL,
        'prefix' => 'https://sqs.us-east-1.amazonaws.com/your-account-id',
        'queue' => 'your-queue-name',
        'suffix' => NULL,
        'region' => 'us-east-1',
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'connection' => 'default',
        'queue' => 'default',
        'retry_after' => 90,
        'block_for' => NULL,
      ),
    ),
    'failed' => 
    array (
      'driver' => 'database-uuids',
      'database' => 'mysql',
      'table' => 'failed_jobs',
    ),
  ),
  'sanctum' => 
  array (
    'stateful' => 
    array (
      0 => 'localhost',
      1 => 'localhost:3000',
      2 => '127.0.0.1',
      3 => '127.0.0.1:8000',
      4 => '::1',
      5 => '127.0.0.1',
    ),
    'guard' => 
    array (
      0 => 'web',
    ),
    'expiration' => NULL,
    'middleware' => 
    array (
      'verify_csrf_token' => 'App\\Http\\Middleware\\VerifyCsrfToken',
      'encrypt_cookies' => 'App\\Http\\Middleware\\EncryptCookies',
    ),
  ),
  'self-update' => 
  array (
    'default' => 'http',
    'version_installed' => '1.13.1',
    'repository_types' => 
    array (
      'github' => 
      array (
        'type' => 'github',
        'repository_vendor' => '',
        'repository_name' => '',
        'repository_url' => '',
        'download_path' => '/tmp',
        'private_access_token' => '',
        'use_branch' => '',
      ),
      'http' => 
      array (
        'type' => 'http',
        'repository_url' => 'http://laravel-shop.ir/updates/',
        'pkg_filename_format' => 'webapp-v_VERSION_',
        'download_path' => '/tmp',
        'private_access_token' => '',
      ),
    ),
    'exclude_folders' => 
    array (
      0 => '__MACOSX',
      1 => 'node_modules',
      2 => 'storage/app',
      3 => 'storage/framework',
      4 => 'storage/logs',
      5 => 'storage/self-update',
      6 => 'public/uploads',
    ),
    'log_events' => false,
    'notifications' => 
    array (
      'notifications' => 
      array (
      ),
      'notifiable' => 'Codedge\\Updater\\Notifications\\Notifiable',
      'mail' => 
      array (
        'to' => 
        array (
          'address' => 'notifications@example.com',
          'name' => '',
        ),
        'from' => 
        array (
          'address' => 'updater@example.com',
          'name' => 'Update',
        ),
      ),
    ),
    'artisan_commands' => 
    array (
      'pre_update' => 
      array (
      ),
      'post_update' => 
      array (
        'updater:after' => 
        array (
          'class' => 'App\\Console\\Commands\\UpdaterAfter',
          'params' => 
          array (
          ),
        ),
      ),
    ),
    'updater_token' => NULL,
  ),
  'services' => 
  array (
    'mailgun' => 
    array (
      'domain' => NULL,
      'secret' => NULL,
      'endpoint' => 'api.mailgun.net',
    ),
    'postmark' => 
    array (
      'token' => NULL,
    ),
    'ses' => 
    array (
      'key' => NULL,
      'secret' => NULL,
      'region' => 'us-east-1',
    ),
  ),
  'session' => 
  array (
    'driver' => 'database',
    'lifetime' => '120',
    'expire_on_close' => false,
    'encrypt' => false,
    'files' => 'C:\\laragon\\www\\novintarasheh\\storage\\framework/sessions',
    'connection' => NULL,
    'table' => 'sessions',
    'store' => NULL,
    'lottery' => 
    array (
      0 => 2,
      1 => 100,
    ),
    'cookie' => 'laravel_shop_session',
    'path' => '/',
    'domain' => NULL,
    'secure' => true,
    'http_only' => true,
    'same_site' => 'none',
  ),
  'sitemap' => 
  array (
    'use_cache' => false,
    'cache_key' => 'laravel-sitemap.http://127.0.0.1:9091',
    'cache_duration' => 3600,
    'escaping' => true,
    'use_limit_size' => false,
    'max_size' => NULL,
    'use_styles' => true,
    'styles_location' => '/vendor/sitemap/styles/',
    'use_gzip' => false,
  ),
  'sluggable' => 
  array (
    'source' => NULL,
    'maxLength' => NULL,
    'maxLengthKeepWords' => true,
    'method' => 'sluggable_helper_function',
    'separator' => '-',
    'unique' => true,
    'uniqueSuffix' => NULL,
    'firstUniqueSuffix' => 2,
    'includeTrashed' => false,
    'reserved' => NULL,
    'onUpdate' => true,
    'slugEngineOptions' => 
    array (
    ),
  ),
  'toastr' => 
  array (
    'maxItems' => NULL,
    'options' => 
    array (
      'positionClass' => 'toast-bottom-left',
      'timeOut' => 5000,
    ),
  ),
  'view' => 
  array (
    'paths' => 
    array (
      0 => 'C:\\laragon\\www\\novintarasheh\\resources\\views',
    ),
    'compiled' => 'C:\\laragon\\www\\novintarasheh\\storage\\framework\\views',
  ),
  'webpush' => 
  array (
    'vapid' => 
    array (
      'subject' => NULL,
      'public_key' => NULL,
      'private_key' => NULL,
      'pem_file' => NULL,
    ),
    'model' => 'NotificationChannels\\WebPush\\PushSubscription',
    'table_name' => 'push_subscriptions',
    'database_connection' => 'mysql',
    'client_options' => 
    array (
    ),
    'gcm' => 
    array (
      'key' => NULL,
      'sender_id' => NULL,
    ),
  ),
  'flare' => 
  array (
    'key' => NULL,
    'reporting' => 
    array (
      'anonymize_ips' => true,
      'collect_git_information' => false,
      'report_queries' => true,
      'maximum_number_of_collected_queries' => 200,
      'report_query_bindings' => true,
      'report_view_data' => true,
      'grouping_type' => NULL,
      'report_logs' => true,
      'maximum_number_of_collected_logs' => 200,
      'censor_request_body_fields' => 
      array (
        0 => 'password',
      ),
    ),
    'send_logs_as_events' => true,
    'censor_request_body_fields' => 
    array (
      0 => 'password',
    ),
  ),
  'ignition' => 
  array (
    'editor' => 'phpstorm',
    'theme' => 'light',
    'enable_share_button' => true,
    'register_commands' => false,
    'ignored_solution_providers' => 
    array (
      0 => 'Facade\\Ignition\\SolutionProviders\\MissingPackageSolutionProvider',
    ),
    'enable_runnable_solutions' => NULL,
    'remote_sites_path' => '',
    'local_sites_path' => '',
    'housekeeping_endpoint_prefix' => '_ignition',
  ),
  'image' => 
  array (
    'driver' => 'gd',
  ),
  'trustedproxy' => 
  array (
    'proxies' => NULL,
    'headers' => 30,
  ),
  'imagecache' => 
  array (
    'route' => NULL,
    'paths' => 
    array (
      0 => 'C:\\laragon\\www\\novintarasheh\\public\\upload',
      1 => 'C:\\laragon\\www\\novintarasheh\\public\\images',
    ),
    'templates' => 
    array (
      'small' => 'Intervention\\Image\\Templates\\Small',
      'medium' => 'Intervention\\Image\\Templates\\Medium',
      'large' => 'Intervention\\Image\\Templates\\Large',
    ),
    'lifetime' => 43200,
  ),
  'front' => 
  array (
    'theme_name' => 'DefaultTheme',
    'sliderGroups' => 
    array (
      0 => 
      array (
        'group' => 'main_sliders',
        'name' => 'اسلایدر اصلی',
        'width' => 1780,
        'height' => 890,
        'count' => 2,
        'size' => '890 * 1780',
        'images' => 
        array (
          0 => 'src/resources/assets/img/default/slider1.jpg',
          1 => 'src/resources/assets/img/default/slider2.jpg',
        ),
      ),
      1 => 
      array (
        'group' => 'mobile_sliders',
        'name' => 'اسلایدر حالت موبایل',
        'width' => 658,
        'height' => 436,
        'count' => 2,
        'size' => '436 * 658',
        'images' => 
        array (
          0 => 'src/resources/assets/img/default/slider3.jpg',
          1 => 'src/resources/assets/img/default/slider4.jpg',
        ),
      ),
      2 => 
      array (
        'group' => 'coworker_sliders',
        'name' => 'اسلایدر لوگو همکاران',
        'width' => 100,
        'height' => 100,
        'count' => 5,
        'size' => '100 * 100',
        'images' => 
        array (
          0 => 'src/resources/assets/img/default/slider5.png',
          1 => 'src/resources/assets/img/default/slider6.png',
          2 => 'src/resources/assets/img/default/slider7.png',
          3 => 'src/resources/assets/img/default/slider8.png',
          4 => 'src/resources/assets/img/default/slider9.png',
        ),
      ),
      3 => 
      array (
        'group' => 'sevices_sliders',
        'name' => 'اسلایدر خدمات',
        'width' => 60,
        'height' => 60,
        'count' => 3,
        'size' => '60 * 60',
        'images' => 
        array (
          0 => 'src/resources/assets/img/default/slider10.svg',
          1 => 'src/resources/assets/img/default/slider11.svg',
          2 => 'src/resources/assets/img/default/slider12.svg',
        ),
        'titles' => 
        array (
          0 => 'پشتیبانی قوی',
          1 => 'کالای اصل',
          2 => 'ارسال سریع کالا',
        ),
      ),
    ),
    'bannerGroups' => 
    array (
      0 => 
      array (
        'group' => 'index_middle_banners',
        'name' => 'بنر دوتایی',
        'width' => 820,
        'height' => 300,
        'count' => 2,
        'size' => '300 * 820',
        'images' => 
        array (
          0 => 'src/resources/assets/img/default/banner3.jpg',
          1 => 'src/resources/assets/img/default/banner4.jpg',
        ),
      ),
      1 => 
      array (
        'group' => 'index_slider_banners',
        'name' => 'بنر کنار اسلایدر اصلی',
        'width' => 856,
        'height' => 428,
        'count' => 2,
        'size' => '428 * 856',
        'images' => 
        array (
          0 => 'src/resources/assets/img/default/banner1.jpg',
          1 => 'src/resources/assets/img/default/banner2.jpg',
        ),
      ),
    ),
    'imageSizes' => 
    array (
      'productCategoryImage' => '500 * 500',
      'CategoryImage' => '500 * 500',
      'postImage' => '300 * 400',
      'productGalleryImage' => '720 * 1280',
      'productImage' => '600 * 600',
      'logo' => '36 * 128',
      'icon' => '32 * 32',
    ),
    'linkGroups' => 
    array (
      0 => 
      array (
        'name' => 'گروه اول',
        'key' => 1,
      ),
      1 => 
      array (
        'name' => 'گروه دوم',
        'key' => 2,
      ),
      2 => 
      array (
        'name' => 'گروه سوم',
        'key' => 3,
      ),
    ),
    'errors' => 
    array (
      404 => 'front::errors.404',
    ),
    'pages' => 
    array (
      'login' => 'front::auth.login',
      'register' => 'front::auth.register',
      'forgot-password' => 'front::auth.forgot-password',
      'login-with-code' => 'front::auth.login-with-code',
      'one-time-login' => 'front::auth.one-time-login',
    ),
    'routes' => 
    array (
      'verify' => 'front.verify.showVerify',
      'change-password' => 'front.user.force-change-password',
      'change-password-routes' => 
      array (
        0 => 'front.user.force-change-password',
        1 => 'front.user.force-update-password',
      ),
    ),
    'exceptVerifyCsrfToken' => 
    array (
      0 => 'orders/payment/callback/*',
      1 => 'wallet/payment/callback/*',
    ),
    'asset_path' => 'themes/defaultTheme/',
    'theme_path' => 'themes/DefaultTheme/',
    'mainfest_path' => 'themes/defaultTheme',
    'demo' => 
    array (
      'image' => 'demo/preview.jpg',
      'name' => 'قالب پیش فرض',
      'description' => 'قالب پیش فرض اسکریپت فروشگاهی فن وب',
    ),
    'socials' => 
    array (
      0 => 
      array (
        'name' => 'تلگرام',
        'key' => 'social_telegram',
        'icon' => 'fa fa-telegram',
      ),
      1 => 
      array (
        'name' => 'اینستاگرام',
        'key' => 'social_instagram',
        'icon' => 'feather icon-instagram',
      ),
      2 => 
      array (
        'name' => 'واتساپ',
        'key' => 'social_whatsapp',
        'icon' => 'fa fa-whatsapp',
      ),
      3 => 
      array (
        'name' => 'روبیکا',
        'key' => 'social_rubika',
        'icon' => 'fa fa-rubika',
      ),
      4 => 
      array (
        'name' => 'ایتا',
        'key' => 'social_eita',
        'icon' => 'fa fa-eita',
      ),
    ),
    'settings' => 
    array (
      'fields' => 
      array (
        0 => 
        array (
          'title' => 'رنگ بندی قالب',
          'key' => 'dt_theme_color',
          'input-type' => 'select',
          'class' => 'col-md-4 col-6',
          'options' => 
          array (
            0 => 
            array (
              'value' => 'default',
              'title' => 'پیش فرض',
            ),
            1 => 
            array (
              'value' => 'amber-color',
              'title' => 'کهربایی',
            ),
            2 => 
            array (
              'value' => 'blue-color',
              'title' => 'آبی',
            ),
            3 => 
            array (
              'value' => 'blue-grey-color',
              'title' => 'آبی خاکستری',
            ),
            4 => 
            array (
              'value' => 'brown-color',
              'title' => 'قهوه ای',
            ),
            5 => 
            array (
              'value' => 'cyan-color',
              'title' => 'فیروزه ای',
            ),
            6 => 
            array (
              'value' => 'green-color',
              'title' => 'سبز',
            ),
            7 => 
            array (
              'value' => 'indigo-color',
              'title' => 'نیلی',
            ),
            8 => 
            array (
              'value' => 'lime-color',
              'title' => 'لیمویی',
            ),
            9 => 
            array (
              'value' => 'orange-color',
              'title' => 'نارنجی',
            ),
            10 => 
            array (
              'value' => 'purple-color',
              'title' => 'بنفش',
            ),
            11 => 
            array (
              'value' => 'red-color',
              'title' => 'قرمز',
            ),
            12 => 
            array (
              'value' => 'teal-color',
              'title' => 'سبز پر رنگ',
            ),
          ),
          'attributes' => 'required',
        ),
        1 => 
        array (
          'title' => 'نمایش نمودار قیمت محصول',
          'key' => 'dt_show_price_change_chart',
          'input-type' => 'select',
          'class' => 'col-md-3 col-6',
          'options' => 
          array (
            0 => 
            array (
              'value' => 'yes',
              'title' => 'بله',
            ),
            1 => 
            array (
              'value' => 'no',
              'title' => 'خیر',
            ),
          ),
          'attributes' => 'required',
        ),
        2 => 
        array (
          'title' => 'نمایش اشتراک گذاری محصول',
          'key' => 'show_product_share_links',
          'input-type' => 'select',
          'class' => 'col-md-3 col-6',
          'options' => 
          array (
            0 => 
            array (
              'value' => '1',
              'title' => 'بله',
            ),
            1 => 
            array (
              'value' => '0',
              'title' => 'خیر',
            ),
          ),
          'attributes' => 'required',
        ),
        3 => 
        array (
          'title' => 'متن توضیحات نظرات محصول',
          'key' => 'dt_product_reviews_description',
          'input-type' => 'inline-editor',
          'class' => 'col-md-7',
        ),
        4 => 
        array (
          'input-type' => 'linebreak',
          'html' => '<hr>',
        ),
        5 => 
        array (
          'title' => 'بازیابی رمز ورود',
          'key' => 'forgot_password_link',
          'input-type' => 'select',
          'class' => 'col-md-3 col-6',
          'options' => 
          array (
            0 => 
            array (
              'value' => 'on',
              'title' => 'فعال',
            ),
            1 => 
            array (
              'value' => 'off',
              'title' => 'غیرفعال',
            ),
          ),
          'attributes' => 'required',
        ),
      ),
      'rules' => 
      array (
        'dt_show_price_change_chart' => 'required|in:yes,no',
      ),
    ),
    'links' => 
    array (
      'C:\\laragon\\www\\novintarasheh\\public\\themes/defaultTheme' => 'C:\\laragon\\www\\novintarasheh\\themes/DefaultTheme/src/resources/assets',
    ),
    'home-widgets' => 
    array (
      'main-slider' => 
      array (
        'title' => 'اسلایدر اصلی و بنر کناری',
        'image' => 'widgets/slider.jpg',
        'options' => 
        array (
          0 => 
          array (
            'title' => 'تعداد اسلایدر',
            'key' => 'number',
            'input-type' => 'input',
            'type' => 'number',
            'default' => '5',
            'class' => 'col-md-4 col-6',
            'attributes' => 'required',
          ),
          1 => 
          array (
            'title' => 'جایگاه بنر',
            'key' => 'banner_position',
            'input-type' => 'select',
            'class' => 'col-md-4 col-6',
            'options' => 
            array (
              0 => 
              array (
                'value' => 'left',
                'title' => 'سمت چپ',
              ),
              1 => 
              array (
                'value' => 'right',
                'title' => 'سمت راست',
              ),
            ),
            'attributes' => 'required',
          ),
          2 => 
          array (
            'title' => 'ترتیب نمایش',
            'key' => 'ordering',
            'input-type' => 'select',
            'class' => 'col-md-4',
            'options' => 
            array (
              0 => 
              array (
                'value' => 'asc',
                'title' => 'صعودی',
              ),
              1 => 
              array (
                'value' => 'desc',
                'title' => 'نزولی',
              ),
            ),
          ),
        ),
        'rules' => 
        array (
          'number' => 'required',
          'banner_position' => 'required|in:right,left',
        ),
      ),
      'products-default-block' => 
      array (
        'title' => 'کادر محصولات ساده',
        'image' => 'widgets/products-default.jpg',
        'options' => 
        array (
          0 => 
          array (
            'title' => 'عنوان',
            'key' => 'title',
            'input-type' => 'input',
            'type' => 'text',
            'class' => 'col-md-4 col-6',
          ),
          1 => 
          array (
            'title' => 'نوع محصولات',
            'key' => 'products_type',
            'input-type' => 'select',
            'class' => 'col-md-4 col-6',
            'options' => 
            array (
              0 => 
              array (
                'value' => 'all',
                'title' => 'همه',
              ),
              1 => 
              array (
                'value' => 'discount',
                'title' => 'تخفیف خورده',
              ),
              2 => 
              array (
                'value' => 'special',
                'title' => 'پیشنهاد ویژه',
              ),
            ),
            'attributes' => 'required',
          ),
          2 => 
          array (
            'title' => 'وضعیت موجودی',
            'key' => 'inventory_status',
            'input-type' => 'select',
            'class' => 'col-md-4 col-6',
            'options' => 
            array (
              0 => 
              array (
                'value' => 'all',
                'title' => 'همه',
              ),
              1 => 
              array (
                'value' => 'available',
                'title' => 'موجود',
              ),
              2 => 
              array (
                'value' => 'unavailable',
                'title' => 'نا موجود',
              ),
            ),
            'attributes' => 'required',
          ),
          3 => 
          array (
            'title' => 'نوع مرتب سازی',
            'key' => 'sort_type',
            'input-type' => 'select',
            'class' => 'col-md-4 col-6',
            'options' => 
            array (
              0 => 
              array (
                'value' => 'latest',
                'title' => 'جدیدترین',
              ),
              1 => 
              array (
                'value' => 'sell',
                'title' => 'پرفروش ترین',
              ),
              2 => 
              array (
                'value' => 'view',
                'title' => 'پربازدید ترین',
              ),
              3 => 
              array (
                'value' => 'cheapest',
                'title' => 'ارزانترین',
              ),
              4 => 
              array (
                'value' => 'expensivest',
                'title' => 'گرانترین',
              ),
            ),
            'attributes' => 'required',
          ),
          4 => 
          array (
            'title' => 'لینک',
            'key' => 'link',
            'input-type' => 'input',
            'type' => 'text',
            'class' => 'col-md-4 col-6',
          ),
          5 => 
          array (
            'title' => 'عنوان لینک',
            'key' => 'link_title',
            'input-type' => 'input',
            'type' => 'text',
            'class' => 'col-md-4 col-6',
          ),
          6 => 
          array (
            'title' => 'نمایش محصولات موجود در اول',
            'key' => 'order_by_stock',
            'input-type' => 'select',
            'class' => 'col-md-4 col-6',
            'options' => 
            array (
              0 => 
              array (
                'value' => 'yes',
                'title' => 'بله',
              ),
              1 => 
              array (
                'value' => 'no',
                'title' => 'خیر',
              ),
            ),
            'attributes' => 'required',
          ),
          7 => 
          array (
            'title' => 'تعداد',
            'key' => 'number',
            'input-type' => 'input',
            'type' => 'number',
            'class' => 'col-md-4 col-6',
            'default' => '10',
            'attributes' => 'required',
          ),
          8 => 
          array (
            'title' => 'انتخاب دسته بندی ها (اختیاری)',
            'key' => 'categories',
            'input-type' => 'product_categories',
            'class' => 'col-md-9',
          ),
          9 => 
          array (
            'title' => 'شامل محصولات زیر دسته ها',
            'key' => 'sub_category_products',
            'input-type' => 'select',
            'class' => 'col-md-3',
            'options' => 
            array (
              0 => 
              array (
                'value' => 'yes',
                'title' => 'بله',
              ),
              1 => 
              array (
                'value' => 'no',
                'title' => 'خیر',
              ),
            ),
          ),
        ),
        'rules' => 
        array (
          'products_type' => 'required|in:all,discount,special',
          'inventory_status' => 'required|in:all,available,unavailable',
          'sort_type' => 'required|in:latest,sell,view,cheapest,expensivest',
          'order_by_stock' => 'required|in:yes,no',
          'link' => 'nullable|string',
          'link_title' => 'nullable|string',
          'number' => 'required',
          'categories' => 'nullable|array',
          'categories.*' => 'exists:categories,id',
        ),
      ),
      'products-colorful-block' => 
      array (
        'title' => 'کادر محصولات با پس زمینه',
        'image' => 'widgets/special.jpg',
        'options' => 
        array (
          0 => 
          array (
            'title' => 'نوع محصولات',
            'key' => 'products_type',
            'input-type' => 'select',
            'class' => 'col-md-4 col-6',
            'options' => 
            array (
              0 => 
              array (
                'value' => 'all',
                'title' => 'همه',
              ),
              1 => 
              array (
                'value' => 'discount',
                'title' => 'تخفیف خورده',
              ),
              2 => 
              array (
                'value' => 'special',
                'title' => 'پیشنهاد ویژه',
              ),
            ),
            'attributes' => 'required',
          ),
          1 => 
          array (
            'title' => 'وضعیت موجودی',
            'key' => 'inventory_status',
            'input-type' => 'select',
            'class' => 'col-md-4 col-6',
            'options' => 
            array (
              0 => 
              array (
                'value' => 'all',
                'title' => 'همه',
              ),
              1 => 
              array (
                'value' => 'available',
                'title' => 'موجود',
              ),
              2 => 
              array (
                'value' => 'unavailable',
                'title' => 'نا موجود',
              ),
            ),
            'attributes' => 'required',
          ),
          2 => 
          array (
            'title' => 'نوع مرتب سازی',
            'key' => 'sort_type',
            'input-type' => 'select',
            'class' => 'col-md-4 col-6',
            'options' => 
            array (
              0 => 
              array (
                'value' => 'latest',
                'title' => 'جدیدترین',
              ),
              1 => 
              array (
                'value' => 'sell',
                'title' => 'پرفروش ترین',
              ),
              2 => 
              array (
                'value' => 'view',
                'title' => 'پربازدید ترین',
              ),
              3 => 
              array (
                'value' => 'cheapest',
                'title' => 'ارزانترین',
              ),
              4 => 
              array (
                'value' => 'expensivest',
                'title' => 'گرانترین',
              ),
            ),
            'attributes' => 'required',
          ),
          3 => 
          array (
            'title' => 'نمایش محصولات موجود در اول',
            'key' => 'order_by_stock',
            'input-type' => 'select',
            'class' => 'col-md-4 col-6',
            'options' => 
            array (
              0 => 
              array (
                'value' => 'yes',
                'title' => 'بله',
              ),
              1 => 
              array (
                'value' => 'no',
                'title' => 'خیر',
              ),
            ),
            'attributes' => 'required',
          ),
          4 => 
          array (
            'title' => 'لینک',
            'key' => 'link',
            'input-type' => 'input',
            'type' => 'text',
            'class' => 'col-md-4 col-6',
          ),
          5 => 
          array (
            'title' => 'عنوان لینک',
            'key' => 'link_title',
            'input-type' => 'input',
            'type' => 'text',
            'class' => 'col-md-4 col-6',
          ),
          6 => 
          array (
            'title' => 'رنگ پس زمینه کادر',
            'key' => 'block_color',
            'input-type' => 'input',
            'default' => '#ef394e',
            'type' => 'color',
            'class' => 'col-md-4 col-6',
          ),
          7 => 
          array (
            'title' => 'تصویر',
            'key' => 'image',
            'input-type' => 'file',
            'type' => 'file',
            'class' => 'col-md-4 col-6',
            'attributes' => 'accept="image/*"',
            'help' => 'بهترین اندازه 850 * 500',
          ),
          8 => 
          array (
            'title' => 'تعداد',
            'key' => 'number',
            'input-type' => 'input',
            'type' => 'number',
            'class' => 'col-md-4 col-6',
            'default' => '10',
            'attributes' => 'required',
          ),
          9 => 
          array (
            'title' => 'انتخاب دسته بندی ها (اختیاری)',
            'key' => 'categories',
            'input-type' => 'product_categories',
            'class' => 'col-md-9',
          ),
          10 => 
          array (
            'title' => 'شامل محصولات زیر دسته ها',
            'key' => 'sub_category_products',
            'input-type' => 'select',
            'class' => 'col-md-3',
            'options' => 
            array (
              0 => 
              array (
                'value' => 'yes',
                'title' => 'بله',
              ),
              1 => 
              array (
                'value' => 'no',
                'title' => 'خیر',
              ),
            ),
          ),
        ),
        'rules' => 
        array (
          'products_type' => 'required|in:all,discount,special',
          'inventory_status' => 'required|in:all,available,unavailable',
          'sort_type' => 'required|in:latest,sell,view,cheapest,expensivest',
          'order_by_stock' => 'required|in:yes,no',
          'link' => 'nullable|string',
          'link_title' => 'nullable|string',
          'block_color' => 'nullable|string',
          'number' => 'required',
          'image' => 'nullable|image',
        ),
      ),
      'middle-banners' => 
      array (
        'title' => 'بنر دوتایی',
        'image' => 'widgets/banner.jpg',
        'options' => 
        array (
          0 => 
          array (
            'title' => 'تعداد قابل نمایش',
            'key' => 'number',
            'input-type' => 'input',
            'type' => 'number',
            'default' => '2',
            'class' => 'col-md-4 col-6',
            'attributes' => 'required',
          ),
          1 => 
          array (
            'title' => 'ترتیب نمایش',
            'key' => 'ordering',
            'input-type' => 'select',
            'class' => 'col-md-4',
            'options' => 
            array (
              0 => 
              array (
                'value' => 'asc',
                'title' => 'صعودی',
              ),
              1 => 
              array (
                'value' => 'desc',
                'title' => 'نزولی',
              ),
            ),
          ),
        ),
        'rules' => 
        array (
          'number' => 'required',
        ),
      ),
      'coworker-sliders' => 
      array (
        'title' => 'اسلایدر لوگو همکاران',
        'image' => 'widgets/customer.jpg',
        'options' => 
        array (
          0 => 
          array (
            'title' => 'تعداد قابل نمایش',
            'key' => 'number',
            'input-type' => 'input',
            'type' => 'number',
            'default' => '10',
            'class' => 'col-md-4 col-6',
            'attributes' => 'required',
          ),
        ),
        'rules' => 
        array (
          'number' => 'required',
        ),
      ),
      'sevices-sliders' => 
      array (
        'title' => 'اسلایدر خدمات',
        'image' => 'widgets/support.jpg',
        'options' => 
        array (
          0 => 
          array (
            'title' => 'تعداد قابل نمایش',
            'key' => 'number',
            'input-type' => 'input',
            'type' => 'number',
            'default' => '4',
            'class' => 'col-md-4 col-6',
            'attributes' => 'required',
          ),
        ),
        'rules' => 
        array (
          'number' => 'required',
        ),
      ),
      'categories' => 
      array (
        'title' => 'دسته بندی محصولات',
        'image' => 'widgets/categories.png',
        'options' => 
        array (
          0 => 
          array (
            'title' => 'انتخاب دسته بندی ها',
            'key' => 'categories',
            'input-type' => 'product_categories',
            'class' => 'col-md-12',
          ),
        ),
        'rules' => 
        array (
          'categories' => 'required',
          'categories.*' => 'exists:categories,id',
        ),
      ),
      'posts' => 
      array (
        'title' => 'نوشته های وبلاگ',
        'image' => 'widgets/posts.png',
        'options' => 
        array (
          0 => 
          array (
            'title' => 'عنوان',
            'key' => 'title',
            'input-type' => 'input',
            'type' => 'text',
            'class' => 'col-md-4 col-6',
          ),
          1 => 
          array (
            'title' => 'نوع مرتب سازی',
            'key' => 'sort_type',
            'input-type' => 'select',
            'class' => 'col-md-4 col-6',
            'options' => 
            array (
              0 => 
              array (
                'value' => 'latest',
                'title' => 'جدیدترین',
              ),
              1 => 
              array (
                'value' => 'view',
                'title' => 'پربازدید ترین',
              ),
            ),
            'attributes' => 'required',
          ),
          2 => 
          array (
            'title' => 'لینک',
            'key' => 'link',
            'input-type' => 'input',
            'type' => 'text',
            'class' => 'col-md-4 col-6',
          ),
          3 => 
          array (
            'title' => 'عنوان لینک',
            'key' => 'link_title',
            'input-type' => 'input',
            'type' => 'text',
            'class' => 'col-md-4 col-6',
          ),
          4 => 
          array (
            'title' => 'تعداد',
            'key' => 'number',
            'input-type' => 'input',
            'type' => 'number',
            'class' => 'col-md-4 col-6',
            'default' => '10',
            'attributes' => 'required',
          ),
          5 => 
          array (
            'title' => 'انتخاب دسته بندی ها (اختیاری)',
            'key' => 'categories',
            'input-type' => 'post_categories',
            'class' => 'col-md-9',
          ),
        ),
        'rules' => 
        array (
          'sort_type' => 'required|in:latest,view',
          'link' => 'nullable|string',
          'link_title' => 'nullable|string',
          'number' => 'required',
          'categories' => 'nullable|array',
          'categories.*' => 'exists:categories,id',
        ),
      ),
    ),
    'cache-forget' => 
    array (
      'categories' => 
      array (
        0 => 'front.productcats',
        1 => 'front.index.categories',
      ),
      'products' => 
      array (
      ),
      'posts' => 
      array (
      ),
      'sliders' => 
      array (
      ),
      'banners' => 
      array (
      ),
    ),
  ),
  'tinker' => 
  array (
    'commands' => 
    array (
    ),
    'alias' => 
    array (
    ),
    'dont_alias' => 
    array (
      0 => 'App\\Nova',
    ),
  ),
);
