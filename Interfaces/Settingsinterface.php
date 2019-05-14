<?php
    
  namespace PhiladelPhia\App\interfaces;

  /**
   * Settings Interface.
   */
  interface SettingsInterface 
  {

    /**
     * Set settings a way static.
     */
    public static function setSettings($settings);

    /**
     * Set settings at app.
     */
    public function __construct();

    /**
     * Get by id a property to array.
     * 
     * @return any.
     */
    public function get(string $id);

    /**
     * Check if a property exists inside array.
     * 
     * @return bool.
     */
    public function has(string $id);
  };