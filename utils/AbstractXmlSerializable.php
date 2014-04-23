<?php
/**
 * Created by PhpStorm.
 * User: maxim
 * Date: 1/26/14
 * Time: 4:20 PM
 */

require_once('XmlSerializableInterface.php');

abstract class AbstractXmlSerializable implements XmlSerializableInterface
{
  abstract protected function getClassMap();

  public function xmlserialize(SimpleXMLElement $xml)
  {
    $classMap = $this->getClassMap();
    $properties = get_object_vars($this);

    foreach($properties as $propertyName=>$value)
    {
      if(isset($classMap[$propertyName]))
      {
        if(is_a($value,$classMap[$propertyName]))
        {
          $childElem = $xml->addChild($propertyName);
          $value->xmlserialize($childElem);
        }
        else
          throw new Exception('UnSerializable property:'.$propertyName);
      }
      else
        $xml->addChild($propertyName,(string)$value);
    }
  }

  public function xmlunserialize(SimpleXMLElement $serialized)
  {
    $classMap = $this->getClassMap();
    $childrenElems = $serialized->children();

    foreach($childrenElems as $childElem)
    {
      $childName = $childElem->getName();
      $propertyName = self::propertyAdopt($childName);
      if(property_exists($this,$propertyName))
      {
        if(isset($classMap[$childName]))
        {
          $instance = new $classMap[$childName];
          $instance->xmlunserialize($childElem);
        }
        else
          $instance = (string)$childElem;

        $this->$propertyName = $instance;//$this->parseXmlChild($childElem,$childName);
      }
      else
        throw new Exception('Undefined class property:'.$childName);
    }
  }
  protected static function propertyAdopt($name){
    return str_replace('-','_',$name);
  }
}