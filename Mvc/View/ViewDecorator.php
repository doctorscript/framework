<?php
namespace DoctorScript\Mvc\View;

use DoctorScript\ServiceManager\ServiceLocatorInterface;
use DoctorScript\Mvc\View\Resolver\ResolverInterface;
use DoctorScript\ServiceManager\Plugin\PluginManagerInterface;
use DoctorScript\ServiceManager\Plugin\PluginManagerAwareInterface;

class ViewDecorator implements PluginManagerAwareInterface
{
    /**
     * @var PluginManagerInterface
    */
    private $pluginManager;
    
    /**
     * @var ResolverInterface
    */
    private $templateResolver;
    
    /**
     * Constructor
     *
     * @param ServiceLocatorInterface $pluginManager
     * @param ResolverInterface $templateResolver
    */
    public function __construct(ServiceLocatorInterface $pluginManager, ResolverInterface $templateResolver)
    {
        $this->pluginManager    = $pluginManager;
        $this->templateResolver = $templateResolver;
    }
    
    /**
     * Set plugin manager
     *
     * @param  ServiceLocatorInterface $pluginManager
     * @return void
    */
    public function setPluginManager(ServiceLocatorInterface $pluginManager)
    {
        $this->pluginManager = $pluginManager;
    }
    
    /**
     * Get plugin manager
     *
     * @return ServiceLocatorInterface
    */
    public function getPluginManager()
    {
        return $this->pluginManager;
    }
    
    /**
     * Set template resolver
     *
     * @param  ResolverInterface $resolver
     * @return void
    */
    public function setTemplateResolver(ResolverInterface $templateResolver)
    {
        $this->templateResolver = $templateResolver;
    }
    
    /**
     * Get template resolver
     *
     * @return ResolverInterface $resolver
    */
    public function getTemplateResolver()
    {
        return $this->templateResolver;
    }

    /**
     * Render view
     *
     * @param  ViewInterface
     * @return string
    */
    public function render(ViewInterface $view)
    {
        $view->setPluginManager($this->getPluginManager());
        $view->setTemplateResolver($this->getTemplateResolver());

        return $view->render();
    }
}