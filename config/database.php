<?php

return [

    /*
    |--------------------------------------------------------------------------
    | PDO Fetch Style
    |--------------------------------------------------------------------------
    |
    | By default, database results will be returned as instances of the PHP
    | stdClass object; however, you may desire to retrieve records in an
    | array format for simplicity. Here you can tweak the fetch style.
    |
    */

    'fetch' => PDO::FETCH_CLASS,

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */

    'default' => env('DB_CONNECTION', 'webmm'),       

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */

    'connections' => [

        'sqlite' => [
            'driver'   => 'sqlite',
            'database' => storage_path('database.sqlite'),
            'prefix'   => '',
        ],

        'webmm' => [     
            'driver'    => 'mysql',
            'host'      => env('DB_HOST', '172.31.17.5'),
            'database'  => env('DB_DATABASE', 'dbklik'),
            'username'  => env('DB_USERNAME', 'klikIgrApp'),
            'password'  => env('DB_PASSWORD', 'kl1kappIGR'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
            'strict'    => false,
        ],

//        'webmm' => [
//            'driver'    => 'mysql',
//            'host'      => env('DB_HOST', '192.168.11.157'),
//            'database'  => env('DB_DATABASE', 'dbklikigr'),
//            'username'  => env('DB_USERNAME', 'dbklikigr'),
//            'password'  => env('DB_PASSWORD', 'igr123'),
//            'charset'   => 'utf8',
//            'collation' => 'utf8_unicode_ci',
//            'prefix'    => '',
//            'strict'    => false,
//        ],

        'webmm1' => [   
            'driver'    => 'mysql',
            'host'      => env('DB_HOST', '172.31.1.32'),
            'database'  => env('DB_DATABASE', 'dbklikigr'),
            'username'  => env('DB_USERNAME', 'admin'),
            'password'  => env('DB_PASSWORD', '1nd0gr0s1r@nc0l1992'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
            'strict'    => false,
        ],

        'dbwebmm' => [
            'driver'    => 'mysql',
            'host'      => '172.31.1.32',
            'database'  => 'webmm',
            'username'  => 'admin',
            'password'  => '1nd0gr0s1r@nc0l1992',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
            'strict'    => false,
        ],

        'cms' => [
            'driver'    => 'mysql',
            'host'      => '192.168.10.100',
            'database'  => 'cms',
            'username'  => 'OLAP',
            'password'  => 'igrolap',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
            'strict'    => false,
        ],

        'igrcpg' => [
            'driver' => 'oracle',
            'host' => env('DB_HOST', '192.168.226.191'),
            'port' => '1521',
            'database' => env('DB_DATABASE', 'IGRCPG'),
            'username' => env('DB_USERNAME', 'IGRCPG'),
            'password' => env('DB_PASSWORD', 'M1ghtyth0rcpg!'),
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'simcpg' => [
            'driver' => 'oracle',
            'host' => env('DB_HOST', '192.168.226.193'),
            'port' => '1521',
            'database' => env('DB_DATABASE', 'SIMCPG'),
            'username' => env('DB_USERNAME', 'SIMCPG'),
            'password' => env('DB_PASSWORD', 'SIMCPG'),
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],      

        'igrsby' => [
            'driver' => 'oracle',
            'host' => env('DB_HOST', '192.9.220.192'),
            'port' => '1521',
            'database' => env('DB_DATABASE', 'IGRSBY2'),
            'username' => env('DB_USERNAME', 'IGRSBY'),
            'password' => env('DB_PASSWORD', 'V1s10nsby!'),
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'simsby' => [
            'driver' => 'oracle',
            'host' => env('DB_HOST', '192.9.220.193'),
            'port' => '1521',
            'database' => env('DB_DATABASE', 'SIMSBY'),
            'username' => env('DB_USERNAME', 'SIMSBY'),
            'password' => env('DB_PASSWORD', 'SIMSBY'),
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],
//
        'igrbdg' => [
            'driver' => 'oracle',
            'host' => env('DB_HOST', '192.168.222.191'),
            'port' => '1521',
            'database' => env('DB_DATABASE', 'IGRBDG'),
            'username' => env('DB_USERNAME', 'IGRBDG'),
            'password' => env('DB_PASSWORD', 'Ind0gros1r2018'),          
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],
//
        'simbdg' => [
            'driver' => 'oracle',
            'host' => env('DB_HOST', '192.168.222.193'),
            'port' => '1521',
            'database' => env('DB_DATABASE', 'SIMBDG'),
            'username' => env('DB_USERNAME', 'SIMBDG'),
            'password' => env('DB_PASSWORD', 'SIMBDG'),
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'igrtgr' => [
            'driver' => 'oracle',
            'host' => env('DB_HOST', '192.168.228.191'),
            'port' => '1521',
            'database' => env('DB_DATABASE', 'IGRTGR'),
            'username' => env('DB_USERNAME', 'IGRTGR'),
            'password' => env('DB_PASSWORD', 'Gr34thulktgr!'),
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'simtgr' => [
            'driver' => 'oracle',
            'host' => env('DB_HOST', '192.168.228.193'),
            'port' => '1521',
            'database' => env('DB_DATABASE', 'IGRSIMDB'),
            'username' => env('DB_USERNAME', 'IGRSIM4'),
            'password' => env('DB_PASSWORD', 'IGRSIM4'),
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'igrygy' => [
            'driver' => 'oracle',
            'host' => env('DB_HOST', '192.168.224.191'), 
            'port' => '1521',
            'database' => env('DB_DATABASE', 'IGRYGY'),
            'username' => env('DB_USERNAME', 'IGRYGY'),
            'password' => env('DB_PASSWORD', 'Sp1d3rmanyog!'),      
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'simygy' => [
            'driver' => 'oracle',
            'host' => env('DB_HOST', '192.168.224.193'),
            'port' => '1521',
            'database' => env('DB_DATABASE', 'SIMIGRYGY'),
            'username' => env('DB_USERNAME', 'SIMYGY'),
            'password' => env('DB_PASSWORD', 'SIMYGY'),
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],
//
        'igrmdn' => [
            'driver' => 'oracle',
            'host' => env('DB_HOST', '192.168.229.192'),
            'port' => '1521',
            'database' => env('DB_DATABASE', 'IGRMDN2'),
            'username' => env('DB_USERNAME', 'IGRMDN'),
            'password' => env('DB_PASSWORD', 'Sc4rl3tw1cmdn!'),
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'simmdn' => [
            'driver' => 'oracle',
            'host' => env('DB_HOST', '192.168.229.193'),
            'port' => '1521',
            'database' => env('DB_DATABASE', 'igrmdnsim'),
            'username' => env('DB_USERNAME', 'SIMMDN'),
            'password' => env('DB_PASSWORD', 'SIMMDN'),
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'igrbks' => [
            'driver' => 'oracle',
            'host' => env('DB_HOST', '192.168.225.191'),
            'port' => '1521',
            'database' => env('DB_DATABASE', 'IGRBKS'),
            'username' => env('DB_USERNAME', 'IGRBKS'),
            'password' => env('DB_PASSWORD', '1r0nm4nbks!'),
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'simbks' => [
            'driver' => 'oracle',
            'host' => env('DB_HOST', '192.168.225.200'),
            'port' => '1521',
            'database' => env('DB_DATABASE', 'SIMDBBKS'),
            'username' => env('DB_USERNAME', 'IGRBKS'),
            'password' => env('DB_PASSWORD', 'IGRBKS'),
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'igrplg' => [
            'driver' => 'oracle',
            'host' => env('DB_HOST', '192.168.232.192'),
            'port' => '1521',
            'database' => env('DB_DATABASE', 'IGRPLG2'),
            'username' => env('DB_USERNAME', 'IGRPLG'),
            'password' => env('DB_PASSWORD', 'IGRPLG'),
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'simplg' => [
            'driver' => 'oracle',
            'host' => env('DB_HOST', '192.168.232.193'),
            'port' => '1521',
            'database' => env('DB_DATABASE', 'SIMPLG'),
            'username' => env('DB_USERNAME', 'SIMPLG'),
            'password' => env('DB_PASSWORD', 'SIMPLG'),
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'igrkmy' => [
            'driver' => 'oracle',
            'host' => env('DB_HOST', '192.168.234.191'),
            'port' => '1521',
            'database' => env('DB_DATABASE', 'IGRKMY'),
            'username' => env('DB_USERNAME', 'IGRKMY'),
            'password' => env('DB_PASSWORD', 'C4ptus4kmy!'),
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],
     
        'simkmy' => [
            'driver' => 'oracle',
            'host' => env('DB_HOST', '192.168.234.6'),
            'port' => '1521',
            'database' => env('DB_DATABASE', 'DB1KMY'),
            'username' => env('DB_USERNAME', 'KMYSIM'),
            'password' => env('DB_PASSWORD', 'KMYSIM'),
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'igrpku' => [
            'driver' => 'oracle',
            'host' => env('DB_HOST', '192.168.235.191'),    
            'port' => '1521',
            'database' => env('DB_DATABASE', 'IGRPKU'),      
            'username' => env('DB_USERNAME', 'IGRPKU'),
            'password' => env('DB_PASSWORD', 'Bl4ckw1dowpku!'),
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'simpku' => [
            'driver' => 'oracle',
            'host' => env('DB_HOST', '192.168.235.193'),
            'port' => '1521',
            'database' => env('DB_DATABASE', 'SIMPKU'),
            'username' => env('DB_USERNAME', 'SIMPKU'),
            'password' => env('DB_PASSWORD', 'SIMPKU'),
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'igrsmd' => [
            'driver' => 'oracle',
            'host' => env('DB_HOST', '192.168.236.191'),
            'port' => '1521',
            'database' => env('DB_DATABASE', 'IGRSMD'),
            'username' => env('DB_USERNAME', 'IGRSMD'),
            'password' => env('DB_PASSWORD', 'IGRSMD'),
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'simsmd' => [
            'driver' => 'oracle',
            'host' => env('DB_HOST', '192.168.236.193'),
            'port' => '1521',
            'database' => env('DB_DATABASE', 'SIMSMD'),
            'username' => env('DB_USERNAME', 'SIMSMD'),
            'password' => env('DB_PASSWORD', 'SIMSMD'),    
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'igrsmg' => [
            'driver' => 'oracle',
            'host' => env('DB_HOST', '192.168.237.191'),
            'port' => '1521',
            'database' => env('DB_DATABASE', 'IGRSMG'),
            'username' => env('DB_USERNAME', 'IGRSMG'),
            'password' => env('DB_PASSWORD', 'H4wkey3smg!'), 
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'simsmg' => [
            'driver' => 'oracle',
            'host' => env('DB_HOST', '192.168.237.193'),
            'port' => '1521',
            'database' => env('DB_DATABASE', 'SIMSMG'),
            'username' => env('DB_USERNAME', 'SIMSMG'),
            'password' => env('DB_PASSWORD', 'SIMSMG'),
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'igrbgr' => [
            'driver' => 'oracle',
            'host' => env('DB_HOST', '192.168.240.191'),
            'port' => '1521',
            'database' => env('DB_DATABASE', 'IGRBGR'),
            'username' => env('DB_USERNAME', 'IGRBGR'),
            'password' => env('DB_PASSWORD', '4ntm4nbgr!'), 
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'simbgr' => [
            'driver' => 'oracle',
            'host' => env('DB_HOST', '192.168.240.193'),
            'port' => '1521',
            'database' => env('DB_DATABASE', 'SIMBGR'),
            'username' => env('DB_USERNAME', 'SIMBGR'),
            'password' => env('DB_PASSWORD', 'SIMBGR'),
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'igrptk' => [
            'driver' => 'oracle',
            'host' => env('DB_HOST', '192.168.238.191'),
            'port' => '1521',
            'database' => env('DB_DATABASE', 'IGRPTK'),
            'username' => env('DB_USERNAME', 'IGRPTK'),
            'password' => env('DB_PASSWORD', 'IGRPTK'),
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'simptk' => [
            'driver' => 'oracle',
            'host' => env('DB_HOST', '192.168.238.193'),
            'port' => '1521',
            'database' => env('DB_DATABASE', 'SIMPTK'),
            'username' => env('DB_USERNAME', 'SIMPTK'),
            'password' => env('DB_PASSWORD', 'SIMPTK'),
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'igrbms' => [
            'driver' => 'oracle',
            'host' => env('DB_HOST', '192.168.239.191'),
            'port' => '1521',
            'database' => env('DB_DATABASE', 'IGRBMS'),
            'username' => env('DB_USERNAME', 'IGRBMS'),
            'password' => env('DB_PASSWORD', 'IGRBMS'),
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'simbms' => [
            'driver' => 'oracle',
            'host' => env('DB_HOST', '192.168.239.193'),
            'port' => '1521',
            'database' => env('DB_DATABASE', 'SIMBMS'),
            'username' => env('DB_USERNAME', 'SIMBMS'),
            'password' => env('DB_PASSWORD', 'SIMBMS'),
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

//
        'igrmdo' => [
            'driver' => 'oracle',
            'host' => env('DB_HOST', '192.168.241.191'),
            'port' => '1521',
            'database' => env('DB_DATABASE', 'IGRMDO'),
            'username' => env('DB_USERNAME', 'IGRMDO'),
            'password' => env('DB_PASSWORD', 'IGRMDO'),
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],
         
        'simmdo' => [
            'driver' => 'oracle',
            'host' => env('DB_HOST', '192.168.241.193'),
            'port' => '1521',
            'database' => env('DB_DATABASE', 'SIMMDO'),
            'username' => env('DB_USERNAME', 'SIMMDO'),
            'password' => env('DB_PASSWORD', 'SIMMDO'),
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],
		
				// 31 = Makasar
		'igrmks' => [
			'driver' => 'oracle',
			'host' => env('DB_HOST', '192.168.243.191'),
			'port' => '1521',
			'database' => env('DB_DATABASE', 'IGRMKS'),
			'username' => env('DB_USERNAME', 'IGRMKS'),
			'password' => env('DB_PASSWORD', 'IGRMKS'),
			'charset' => 'AL32UTF8',
			'prefix' => '',
		],
		// 32 = Jambi
		'igrjbi' => [ 
			'driver' => 'oracle',
			'host' => env('DB_HOST', '192.168.242.191'),
			'port' => '1521',
			'database' => env('DB_DATABASE', 'IGRJBI'),
			'username' => env('DB_USERNAME', 'IGRJBI'),
			'password' => env('DB_PASSWORD', 'B4bygr0otjbi!'),             
			'charset' => 'AL32UTF8',
			'prefix' => '',
		],
		// 33 = Kendari
		'igrkri' => [
			'driver' => 'oracle',
			'host' => env('DB_HOST', '192.168.244.191'),
			'port' => '1521',
			'database' => env('DB_DATABASE', 'IGRKRI'),
			'username' => env('DB_USERNAME', 'IGRKRI'),
			'password' => env('DB_PASSWORD', 'IGRKRI'),
			'charset' => 'AL32UTF8',
			'prefix' => '',
		],

        'igrcpt' => [ 
            'driver' => 'oracle',
            'host' => env('DB_HOST', '192.168.245.191'),
            'port' => '1521',
            'database' => env('DB_DATABASE', 'IGRCPT'),
            'username' => env('DB_USERNAME', 'IGRCPT'),
            'password' => env('DB_PASSWORD', 'Slvsurf3rcpt!'),         
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'igrkrw' => [
            'driver' => 'oracle',
            'host' => env('DB_HOST', '192.168.231.191'),
            'port' => '1521',
            'database' => env('DB_DATABASE', 'IGRKRW'),
            'username' => env('DB_USERNAME', 'IGRKRW'),
            'password' => env('DB_PASSWORD', 'F4lc0nkrw!'),
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'simkrw' => [
            'driver' => 'oracle',
            'host' => env('DB_HOST', '192.168.231.193'),
            'port' => '1521',
            'database' => env('DB_DATABASE', 'SIMKRW'),
            'username' => env('DB_USERNAME', 'SIMKRW'),
            'password' => env('DB_PASSWORD', 'SIMKRW'),
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'igrmlg' => [
            'driver' => 'oracle',
            'host' => env('DB_HOST', '192.168.246.191'),
            'port' => '1521',
            'database' => env('DB_DATABASE', 'IGRMLG'),
            'username' => env('DB_USERNAME', 'IGRMLG'),
            'password' => env('DB_PASSWORD', 'IGRMLG'),
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],


    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
    */

    'migrations' => 'migrations',

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer set of commands than a typical key-value systems
    | such as APC or Memcached. Laravel makes it easy to dig right in.
    |
    */

    'redis' => [

        'cluster' => false,

        'default' => [
            'host'     => '127.0.0.1',
            'port'     => 6379,
            'database' => 0,
        ],

    ],

];
