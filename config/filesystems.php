<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */
    //如果FILESYSTEM_DISK沒設定,就會預設走local
    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been set up for each driver as an example of the required values.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */
//當你disk走 local /  public 的設定....
    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'), //laravelbook/storage/app
            'throw' => false,
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
            'throw' => false,
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => false,
        ],
        'gcs' => [
            'driver' => 'gcs',
            
            //GOOGLE_CLOUD_PROJECT_ID=你專案的id
            //機密資訊放在.env裡面讀取
            'project_id' => env('GOOGLE_CLOUD_PROJECT_ID', ''),
            
            //申請GCP API憑證的時候會有一組json檔案
            //把他製作成service-account.json丟到專案裡面並透過base_path 讀取到路徑
            'key_file_path' => env('GOOGLE_CLOUD_KEY_FILE', base_path('service-account.json')), 
            
            //你的Storage Bucket 的名稱,機密 設在.env
            'bucket' => env('GOOGLE_CLOUD_STORAGE_BUCKET', ''),
            
            //設定資料夾名稱,也可以在程式碼新增時設定
            //或者放在第二參數
            'path_prefix' => env('GOOGLE_CLOUD_STORAGE_PATH_PREFIX', '資料夾名稱'),
            
            //還沒使用到,沒動到
            'storage_api_uri' => env('GOOGLE_CLOUD_STORAGE_API_URI', null), // see: Public URLs below
            
            //可以顯示錯誤訊息
            'throw' => true,
            
            //感覺有歷史原因所以才需要加上這段
            'visibility_handler' => \League\Flysystem\GoogleCloudStorage\UniformBucketLevelAccessVisibility::class,
                ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
