<?php
namespace DoctorScript\Autoloader;

class StandardAutoloader implements SplAutoloaderInterface
{
    /**
     * @var array
    */
    private $paths = [];
    
    /**
     * Constructor
     *
     * @param array $paths
    */
    public function __construct(array $paths = [])
    {
        if (count($paths) > 0) {
            $this->setPaths($paths);
        }
    }

    /**
     * Set paths for autoloader
     *
     * @param  array $paths
     * @return void
    */
    public function setPaths(array $paths)
    {
        $this->paths = $paths;
    }
    
    /**
     * Register autoloader
     *
     * @param  bool $throw
     * @param  bool $prepend
     * @return void
    */
    public function register($throw = true, $prepend = true)
    {
        spl_autoload_register([$this, 'autoload'], $throw, $prepend);
    }
    
    /**
     * Autoload method
     *
     * @param  string $class
     * @return void
    */
    public function autoload($class)
    {
        foreach ($this->paths as $path) {

            $realPath = realpath($path);
            if ($realPath === false) {
                throw new \RuntimeException(sprintf(
                    'Cannot resolve real path for %s', $path
                ));
            }

            $classPath = $realPath . DIRECTORY_SEPARATOR . $class . '.php';
            if (is_file($classPath)) {
                include_once($classPath);
                break;
            }
        }
    }
    
    /**
     * Unregister autoloader
     *
     * @return void
    */
    public function unregister()
    {
        spl_autoload_unregister([$this, 'autoload']);
    }
}