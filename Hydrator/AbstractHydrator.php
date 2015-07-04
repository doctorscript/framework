<?php
namespace DoctorScript\Hydrator;

abstract class AbstractHydrator implements HydratorInterface
{
    /**
     * Populate object properties named as passed json keys if any property exists in passed object
     *
     * @param  object $object
     * @param  string $json
     * @return void
    */
    public function hydrateJson($object, $json)
    {
        $data = json_decode($json, true);
        $this->hydrate($object, $data);
    }
}