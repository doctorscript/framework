<?php
namespace DoctorScript\Mvc\View\Service;

use DoctorScript\ServiceManager\ServiceFactoryInterface;
use DoctorScript\ServiceManager\ServiceLocatorInterface;
use DoctorScript\ServiceManager\Plugin\PluginManagerInterface;
use DoctorScript\Mvc\View\ViewPluginManager;

class ViewPluginManagerFactory implements ServiceFactoryInterface
{
    /**
     * Create configured view plugin manager
     *
     * @param  ServiceLocatorInterface $serviceLocator
     * @return PluginManagerInterface
    */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $viewPluginConfig = $serviceLocator->get('config')['view_manager']['plugins'];
        return new ViewPluginManager($viewPluginConfig);
    }
}