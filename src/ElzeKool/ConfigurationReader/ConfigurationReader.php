<?php

namespace ElzeKool\ConfigurationReader;

/**
 * Framework independent .ini configuration reader
 *
 * @author Elze Kool <info@kooldevelopment.nl>
 **/
class ConfigurationReader
{
    
    /**
     * Loaded configuration
     * @var mixed[]
     */
    protected $Configuration;
   
    /**
     * Process INI file
     * 
     * @param string $filename Filename
     * 
     * @return mixed[] Parsed ini file
     */
    protected function parseIniFile($filename) 
    {
        if (!file_exists($filename)) {
            return;
        }        
        $ini = parse_ini_file($filename, true, INI_SCANNER_NORMAL);
        if ($this->Configuration === null) {
            $this->Configuration = $ini;                
        } else {                            
            foreach(array_keys($ini) as $key) {
                if (!isset($this->Configuration[$key])) {
                    $this->Configuration[$key] = $ini[$key];
                } else {
                    $this->Configuration[$key] = array_merge($this->Configuration[$key], $ini[$key]);
                }
            }                
        }        
    }

    /**
     * Constructor
     * 
     * $files can be an array or an string containing configuration files
     * to parse. Files are read in given order, overloading settings as they
     * are read.
     * 
     * @param string[]|string $files File(s) to parse
     */
    public function __construct($files) {        

        // Check if files is an array, if not make it an array
        if (!is_array($files)) {
            $files = array($files);
        }
        
        // Go trough files in given order
        foreach($files as $file) {
            $this->parseIniFile($file);
        }
        
        // If no files where found/parsed make configuration an empty
        // array
        if ($this->Configuration === null) {
            $this->Configuration = array();         
        }

    }

    /**
     * Read Setting, return default if not found
     *
     * Supported settings names:
     * - name       : Gives value from option not inside a group
     * - group      : Gives group back as an array
     * - group.name : Gives value from option inside given group
     * 
     * group and name can contain the following chars: a-z, A-Z, 0-9 and _
     * 
     * @param string $setting Setting name
     * @param mixed  $default Default value
     *
     * @return mixed Setting value 
     */
    public function get($setting, $default = null)
    {
        $m = array();
        if (preg_match('/^([a-zA-Z0-9_]+?)\.([a-zA-Z0-9_]+?)$/', $setting, $m) != 0) {
            return isset($this->Configuration[$m[1]][$m[2]]) ? $this->Configuration[$m[1]][$m[2]] : $default;
        } else if (preg_match('/^([a-zA-Z0-9_]+)$/', $setting)) {
            return isset($this->Configuration[$setting]) ? $this->Configuration[$setting] : $default;
        } else {
            throw new \InvalidArgumentException('Invalid setting name');
        }
    }

}