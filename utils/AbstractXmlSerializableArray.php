<?php
/**
 * Created by PhpStorm.
 * User: maxim
 * Date: 1/26/14
 * Time: 4:20 PM
 */

require_once('XmlSerializableInterface.php');
abstract class AbstractXmlSerializableArray extends ArrayObject implements XmlSerializableInterface
{
  abstract protected function getClassMap();

  public function xmlserialize(SimpleXMLElement $xml)
  {
    $classMap = $this->getClassMap();
    $properties = $this;

    foreach($properties as $id=>$value)
    {
      $tagName = array_search(get_class($value),$classMap);
      if($tagName === FALSE)
        throw new Exception('Unusual bug');
      $childElem = $xml->addChild($tagName);
      $childElem['id']=$id;
      $value->xmlserialize($childElem);
    }
  }

  public function xmlunserialize(SimpleXMLElement $serialized)
  {
    $classMap = $this->getClassMap();
    $childenElems = $serialized->children();
    foreach ($childenElems as $childElem) {
      $id = (string)$childElem['id'];

      $childName = $childElem->getName();
      if (isset($classMap[$childName])) {
        $className = $classMap[$childName];
//        if($className==='string')
//          $instance = (string)$childElem;
//        else
        {
          $instance = new $className;
          $instance->xmlunserialize($childElem);
        }
      } else
        throw new Exception('Undefined XML tag:'.$childName);

      if (!empty($id)) {
        $this[$id] = $instance;
      } else {
        $this[] = $instance;
      }
    }
  }
}