<?php
/**
 * Created by PhpStorm.
 * User: maxim
 * Date: 1/26/14
 * Time: 4:20 PM
 */

require_once('AbstractXmlSerializable.php');
class XmlSerializable extends AbstractXmlSerializable {

  protected function getClassMap()
  {
    return array();
  }
}