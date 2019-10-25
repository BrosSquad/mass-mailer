<?php


namespace App\Dto;


abstract class Base
{
    public function __construct(array $properties)
    {
        foreach ($properties as $property => $value) {
            $this->__set($property, $value);
        }
    }

    public function __get($name)
    {
        if (property_exists($this, $name)) {
            return $this->{$name};
        }
        return NULL;
    }

    public function __set($name, $value)
    {
        if (property_exists($this, $name)) {
            $this->{$name} = $value;
        }
    }

    public function __isset($name)
    {
        if (property_exists($this, $name)) {
            return true;
        }
        return false;
    }
}
