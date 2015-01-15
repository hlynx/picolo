<?php

namespace Picolo;

class Application extends \Silex\Application {
    private $rootDir;

    use \Silex\Application\TwigTrait;
    use \Silex\Application\MonologTrait;
    
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
    
    public function getLogDir() {
        $path = $this->getRootDir().'log'.DIRECTORY_SEPARATOR;
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }
        
        return $path;
    }
    
    public function getConfig($key) {
        return $this['config'][$key]?:null;
    }
}
