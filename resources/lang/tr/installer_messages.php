<?php

return [

    'laravel-version' => '',

    'title' => 'Laravel Shop Otomatik Kurulum Sistemi',
    'next' => 'İleri',
    'back' => 'Geri',
    'finish' => 'Kurulum',
    'forms' => [
        'errorTitle' => 'Aşağıdaki hataları düzeltin:',
    ],

    'welcome' => [
        'templateTitle' => 'Hoş Geldiniz',
        'title'   => 'Laravel Shop Otomatik Kurulum Sistemi',
        'message' => 'Mağazayı kurmaya hazır mısınız?',
        'next'    => 'Gereksinimleri Kontrol Et',
    ],

    'requirements' => [
        'templateTitle' => 'Adım 1 | Sunucu Gereksinimleri',
        'title' => 'Sunucu Gereksinimleri',
        'next'    => 'Erişim İzinlerini Kontrol Et',
    ],

    'permissions' => [
        'templateTitle' => 'Adım 2 | Erişim İzinleri',
        'title' => 'Erişim İzinleri',
        'next' => 'Ana Ayarlar',
    ],


    'environment' => [
        'menu' => [
            'templateTitle' => 'Adım 3 | Ana Ayarlar',
            'title' => 'Ana Ayarlar',
            'desc' => 'Lütfen <code class="ltr">env.</code> dosyasına veri girişi yapma yöntemini seçin.',
            'wizard-button' => 'Form Düzenleyici',
            'classic-button' => 'Klasik Düzenleyici',
        ],
        'wizard' => [
            'templateTitle' => 'Adım 3 | Ana Ayarlar | Form Düzenleyici',
            'title' => 'Ana Ayarlar',
            'tabs' => [
                'environment' => 'Çevre',
                'database' => 'Veritabanı',
                'application' => 'Uygulama',
            ],
        'form' => [
                'name_required' => 'An environment name is required.',
                'app_name_label' => 'App Name',
                'app_name_placeholder' => 'App Name',
                'app_environment_label' => 'App Environment',
                'app_environment_label_local' => 'Local',
                'app_environment_label_developement' => 'Development',
                'app_environment_label_qa' => 'Qa',
                'app_environment_label_production' => 'Production',
                'app_environment_label_other' => 'Other',
                'app_environment_placeholder_other' => 'Enter your environment...',
                'app_debug_label' => 'App Debug',
                'app_debug_label_true' => 'True',
                'app_debug_label_false' => 'False',
                'app_log_level_label' => 'App Log Level',
                'app_log_level_label_debug' => 'debug',
                'app_log_level_label_info' => 'info',
                'app_log_level_label_notice' => 'notice',
                'app_log_level_label_warning' => 'warning',
                'app_log_level_label_error' => 'error',
                'app_log_level_label_critical' => 'critical',
                'app_log_level_label_alert' => 'alert',
                'app_log_level_label_emergency' => 'emergency',
                'app_url_label' => 'App Url',
                'app_url_placeholder' => 'App Url',
                'db_connection_failed' => 'Could not connect to the database.',
                'db_connection_label' => 'Database Connection',
                'db_connection_label_mysql' => 'mysql',
                'db_connection_label_sqlite' => 'sqlite',
                'db_connection_label_pgsql' => 'pgsql',
                'db_connection_label_sqlsrv' => 'sqlsrv',
                'db_host_label' => 'میزبان پایگاه داده',
                'db_host_placeholder' => '',
                'db_port_label' => 'پورت پایگاه داده',
                'db_port_placeholder' => '',
                'db_name_label' => 'نام پایگاه داده',
                'db_name_placeholder' => '',
                'db_username_label' => 'نام کاربری پایگاه داده',
                'db_username_placeholder' => '',
                'db_password_label' => 'رمز عبور پایگاه داده',
                'db_password_placeholder' => '',

                'app_tabs' => [
                    'more_info' => 'More Info',
                    'broadcasting_title' => 'Broadcasting, Caching, Session, Queue',
                    'broadcasting_label' => 'Broadcast Driver',
                    'broadcasting_placeholder' => 'Broadcast Driver',
                    'cache_label' => 'Cache Driver',
                    'cache_placeholder' => 'Cache Driver',
                    'session_label' => 'Session Driver',
                    'session_placeholder' => 'Session Driver',
                    'queue_label' => 'Queue Driver',
                    'queue_placeholder' => 'Queue Driver',
                    'redis_label' => 'Redis Driver',
                    'redis_host' => 'Redis Host',
                    'redis_password' => 'Redis Password',
                    'redis_port' => 'Redis Port',

                    'mail_label' => 'Mail',
                    'mail_driver_label' => 'Mail Driver',
                    'mail_driver_placeholder' => 'Mail Driver',
                    'mail_host_label' => 'Mail Host',
                    'mail_host_placeholder' => 'Mail Host',
                    'mail_port_label' => 'Mail Port',
                    'mail_port_placeholder' => 'Mail Port',
                    'mail_username_label' => 'Mail Username',
                    'mail_username_placeholder' => 'Mail Username',
                    'mail_password_label' => 'Mail Password',
                    'mail_password_placeholder' => 'Mail Password',
                    'mail_encryption_label' => 'Mail Encryption',
                    'mail_encryption_placeholder' => 'Mail Encryption',

                    'pusher_label' => 'Pusher',
                    'pusher_app_id_label' => 'Pusher App Id',
                    'pusher_app_id_palceholder' => 'Pusher App Id',
                    'pusher_app_key_label' => 'Pusher App Key',
                    'pusher_app_key_palceholder' => 'Pusher App Key',
                    'pusher_app_secret_label' => 'Pusher App Secret',
                    'pusher_app_secret_palceholder' => 'Pusher App Secret',

                    'other_label' => 'Other',
                    'other_app_id_label' => 'Other App Id',

                ],
            'buttons' => [
                'setup_database' => 'Veritabanı Kurulumu',
                'setup_application' => 'Uygulama Kurulumu',
                'install' => 'Kurulum',
            ],

        ],
        ],
        'classic' => [
            'templateTitle' => 'Adım 3 | Ana Ayarlar | Klasik Düzenleyici',
            'title' => 'Metin Düzenleyici Ayarları',
            'save' => '.env Dosyasını Kaydet',
            'back' => 'Form Düzenleyici Kullan',
            'install' => 'Kaydet ve Kur',
        ],
        'success' => '.env Ayarları dosyanız başarıyla kaydedildi.',
        'errors' => '.env Dosyası oluşturulamadı, lütfen manuel olarak oluşturun.',

    ],

    'install' => 'Kurulum',

    /*
     *
     * Installed Log translations.
     *
     */
    'installed' => [
        'success_log_message' => 'Kurulum başarıyla tamamlandı tarihinde: ',
    ],


    /*
     *
     * Final page translations.
     *
     */
    'final' => [
        'title' => 'Kurulum Tamamlandı',
        'templateTitle' => 'Kurulum Tamamlandı',
        'finished' => 'Yazılım başarıyla kuruldu.',
        'migration' => 'Migration &amp; Seed Konsol Çıkışı:',
        'console' => 'Uygulama Konsol Çıkışı:',
        'log' => 'Kurulum Günlüğü Girişi:',
        'env' => 'Son .env Dosyası:',
        'exit' => 'Kurulum Sürecini Sonlandır',
    ],


    /*
     *
     * Update specific translations
     *
     */
    'updater' => [
        /*
         *
         * Shared translations.
         *
         */
        'title' => 'Laravel Updater',

        /*
         *
         * Welcome page translations for update feature.
         *
         */
        'welcome' => [
            'title'   => 'Welcome To The Updater',
            'message' => 'Welcome to the update wizard.',
        ],

        /*
         *
         * Welcome page translations for update feature.
         *
         */
        'overview' => [
            'title'   => 'Overview',
            'message' => 'There is 1 update.|There are :number updates.',
            'install_updates' => 'Install Updates',
        ],

        /*
         *
         * Final page translations.
         *
         */
        'final' => [
            'title' => 'Finished',
            'finished' => 'Application\'s database has been successfully updated.',
            'exit' => 'Click here to exit',
        ],

        'log' => [
            'success_message' => 'Laravel Installer successfully UPDATED on ',
        ],
    ],
];
