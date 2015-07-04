<?php
namespace DoctorScript\Mvc\View\Service;

use DoctorScript\ServiceManager\ServiceFactoryInterface;
use DoctorScript\ServiceManager\ServiceLocatorInterface;
use DoctorScript\Mvc\View\Resolver\TemplateResolver;
use DoctorScript\Mvc\View\Resolver\ResolverInterface;

class TemplateResolverFactory implements ServiceFactoryInterface
{
    /**
     * Create configured template resolver
     *
     * @param  ServiceLocatorInterface $serviceLocator
     * @return ResolverInterface
    */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $templateMap = $serviceLocator->get('config')['view_manager']['template_map'];
        return new TemplateResolver($viewPluginConfig);
    }
}