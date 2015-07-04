<?php
namespace DoctorScript\Hydrator;

class ClassMethods extends AbstractHydrator
{
    /**
     * Populate object properties named as $data array keys if any property exists in passed object
     *
     * @param object $object
     * @param array $data
     * @return void
    */
    public function hydrate($object, array $data)
    {
        foreach ($data as $key => $value) {
            $method = 'set'.ucfirst($key);
            if (method_exists($object, $method)) {
                $object->$method($value);
            }
        }
    }

    /**
     * By default export all object properties to array
     * If $skipProps is used, export only not skipped properties
     *
     * @param  object $object
     * @param  array $skipProps
     * @return array object properties
    */
    public function export($object, array $skipProps = [])
    {
        $result = [];
        
        foreach (get_class_methods($object) as $method) {
            $property = lcfirst(str_replace('get', '', $method));
            if (strpos($method, 'get') === 0 && !in_array($property, $skipProps)) {
                $result[$property] = $object->$method();
            }
        }

        return $result;
    }
}