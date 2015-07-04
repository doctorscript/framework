<?php
namespace DoctorScript\Hydrator;

class Reflection extends AbstractHydrator
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
        $rClass = new \ReflectionClass($object);
        
        foreach($data as $key=>$value){
            
            if($rClass->hasProperty($key)){
                $rProperty = $rClass->getProperty($key);
                $rProperty->setAccessible(true);
                $rProperty->setValue($object, $value);
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
        $result     = [];
        $properties = (new \ReflectionClass($object))->getProperties();

        foreach($properties as $property){
            $property->setAccessible(true);
            $result[$property->getName()] = $property->getValue($object);
        }

        return !empty($skipProps) ? array_diff_key($result, array_flip($skipProps)) : $result;
    }
}