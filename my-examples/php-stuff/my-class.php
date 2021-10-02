<?php

class MyClass
{
    private $foo;

    public function __construct(string $foo)
    {
        $this->foo = $foo;
    }
}

$a = new MyClass('test');
//print_r($a);
//print_r($a->foo);
$r = new ReflectionClass('MyClass');
$props = $r->getProperties(ReflectionProperty::IS_PRIVATE);
//print_r($props);
//print_r($props[0]->getName());

//$privateProp = $props[0];
$privateProp = new ReflectionProperty('MyClass', 'foo');
$privateProp->setAccessible(true);
$foo = $privateProp->getValue($a);
print_r($foo);