<?php
namespace DoctorScript\ServiceManager;

interface ServiceLocatorAwareInterface
{
    /**
     * Set ServiceLocatorInterface implementation
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return void
    */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator);

    /**
     * Get ServiceLocatorInterface implementation
     *
     * @return ServiceLocatorInterface
    */
    public function getServiceLocator();
}