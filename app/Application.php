<?php

namespace Picolo;

class Application extends \Silex\Application {
    private $rootDir;

    use \Silex\Application\TwigTrait;
    
    public function getRootDir() {
        if(!$this->rootDir) {
            $this->rootDir = realpath(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR);
            $this->rootDir .= substr($this->rootDir, -1) == DIRECTORY_SEPARATOR?'':DIRECTORY_SEPARATOR;
        }
        
        return $this->rootDir;
    }

    public function getCacheDir() {
        $path = $this->getRootDir().'cache'.DIRECTORY_SEPARATOR;
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }
        
        return $path;
    }
    
    public function getConfig($key) {
        return $this['config'][$key]?:null;
    }


    /**
     * Adds a log record.
     *
     * @param string $message The log message
     * @param array $context The log context
     * @param integer $level The logging level
     *
     * @return Boolean Whether the record has been processed
     */
//    public function log($message, array $context = array(), $level = Logger::INFO) {
//        return $this['monolog']->addRecord($level, $message, $context);
//    }

}