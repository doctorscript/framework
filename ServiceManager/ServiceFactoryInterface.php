<?php
namespace DoctorScript\ServiceManager;

interface ServiceFactoryInterface
{
    /**
     * Service logic implements method
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
    */
    public function createService(ServiceLocatorInterface $serviceLocator);
}