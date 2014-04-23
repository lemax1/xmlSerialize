<?php
/**
 * Created by PhpStorm.
 * User: maxim
 * Date: 1/30/14
 * Time: 11:50 AM
 */

interface XmlSerializableInterface {
  public function xmlserialize(SimpleXMLElement $xmlOutput);
  public function xmlunserialize(SimpleXMLElement $xmlInput);
}