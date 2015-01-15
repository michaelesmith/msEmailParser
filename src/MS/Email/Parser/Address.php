<?php

namespace MS\Email\Parser;
use JsonSerializable;

/**
 * @author msmith
 * @author sebastien monterisi <sebastienmonterisi@yahoo.fr>
 */
class Address implements JsonSerializable
{
    protected $name;

    protected $address;

    protected $original;

    public function __construct($str)
    {
        $str = trim($str);
        if(strpos($str, '<') === false){
            $this->address = $str;
            $this->original = $str;
        }else{
            $matches = array();
            preg_match('/(.*)(<.*>)/', $str, $matches);
            $this->name = trim($matches[1], "\" \t\r\n\0\x0B");
            $this->address = trim($matches[2], "<> \t\r\n\0\x0B");
            $this->original = $str;
        }
    }

    public function __toString()
    {
        return trim(sprintf("%s <%s>", $this->getName(), $this->getAddress()));
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function getOriginal()
    {
        return $this->original;
    }

    public function getName()
    {
        return $this->name;
    }

    public function jsonSerialize()
    {
        return ['name'=> $this->getName(),
                'address' => $this->getAddress(),
            ];
    }

}
