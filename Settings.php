<?php

  namespace PhiladelPhia\App;

  use PhiladelPhia\App\Exceptions;
  use PhiladelPhia\App\Interfaces\SettingsInterface;
  use PhiladelPhia\Helpers\Path;

  /**
   * Settings
   * 
   * 
   */
  class Settings
  {
    public static $pathOrArray;
    public static $settings;

    public $file;

    // Initialitation var config.
    private $config = [
      'database' => [],
      'jwt' => []
  ];

    // Default configuratio
    private $defaultItemsSettings = [
      'database' => [
          'driver' => '',
          'host' => '',
          'port' => '',
          'dbname' => '',
          'username' => '',
          'password' => '',
          'chatset' => 'utf8',
          'persistent' => false,
      ],
      'jwt' => [
        'host' => '',
        'privateKey' => '',
        'algorithm' => ''
      ]
    ];
    
    public static function setSettingsToDatabase($pathOrArray)
    {
      static::$pathOrArray = $pathOrArray;
    }
    
    public function __construct()
    {
      if (!is_array(static::$pathOrArray)) 
      {
        if (!file_exists(static::$pathOrArray))
        {
          throw new Exceptions("File settings not exists, inside projects $pathOrArray");
        }
  
        $this->file = parse_ini_file(static::$pathOrArray);
      }

      $this->file = static::$pathOrArray;

      $this->extractParams();

      static::$settings = $this;
    }

    private function extractParams() 
    {
      if (!array_key_exists('database', $this->file)) 
      {
        $this->config['database'] = $this->defaultItemsSettings['database'];
      }

      $database = $this->defaultItemsSettings['database'];

      $this->config['database']['driver'] = array_key_exists('driver', $this->file) 
                      ? $this->file['driver']
                        : $database['driver'];
      $this->config['database']['host'] = array_key_exists('host', $this->file) 
                      ? $this->file['host']
                        : $database['host'];
      $this->config['database']['dbname'] = array_key_exists('dbname', $this->file) 
                      ? $this->file['dbname']
                        : $database['dbname'];
      $this->config['database']['username'] = array_key_exists('username', $this->file)  
                      ? $this->file['username']
                        : $database['username'];
      $this->config['database']['password'] = array_key_exists('password', $this->file)
                      ? $this->file['password']
                        : $database['password'];
      $this->config['database']['chatset'] = array_key_exists('chatset', $this->file) 
                      ? $this->file['chatset']
                        : $database['chatset'];
      $this->config['database']['persistent'] = array_key_exists('persistent', $this->file)
                      ? $this->file['persistent']
                        : $database['persistent'];
          
      if (!array_key_exists('jwt', $this->file)) 
      {
        $this->config['jwt'] = $this->defaultItemsSettings['jwt'];
      }

      $jwt = $this->defaultItemsSettings['jwt'];

      $this->config['jwt']['host'] = array_key_exists('host', $this->file)
                      ? $this->file['host']
                        : $jwt['host'];

      $this->config['jwt']['privateKey'] = array_key_exists('privateKey', $this->file)
                      ? $this->file['privateKey']
                        : $jwt['privateKey'];
      
      $this->config['jwt']['algorithm'] = array_key_exists('algorithm', $this->file)
                      ? $this->file['algorithm']
                        : $jwt['algorithm'];
    }

    /**
     * Get params by path typing string.
     * 
     * @param string $id
     * @return any 
     */
    public function get($id)
    {   
      $parts = Path::normalize($id);
      
      return (Path::loop($parts, $this->config));
    }

    /**
     * Has params by path typing string.
     * 
     * @param string $id
     * @return bool
     */
    public function has($id)
    {
      $parts = Path::normalize($id);

      return (Path::loop($parts, $this->config) ? true : false);
    }
  }