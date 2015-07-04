<?php
namespace DoctorScript\Autoloader;

interface SplAutoloaderInterface
{
    /**
     * Set paths for autoloader
     *
     * @param  array $paths
     * @return void
    */
    public function setPaths(array $paths);

    /**
     * Register autoloader
     *
     * @param  bool $throw
     * @param  bool $prepend
     * @return void
    */
    public function register($throw = true, $prepend = true);

    /**
     * Autoload method
     *
     * @param  string $class
     * @return void
    */
    public function autoload($class);

    /**
     * Unregister autoloader
     *
     * @return void
    */
    public function unregister();
}