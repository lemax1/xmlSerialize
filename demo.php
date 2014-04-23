<?php
require_once('utils/XmlSerializable.php');
require_once('utils/AbstractXmlSerializableArray.php');

class Employee extends XmlSerializable
{
  protected  $first;
  protected  $last;

  public function __construct($first = null, $last = null)
  {
    $this->first = $first;
    $this->last = $last;
  }
}
class Employees extends AbstractXmlSerializableArray{

  protected function getClassMap()
  {
    return array(
      'employee' => 'Employee'
    );
  }
}
class Company extends XmlSerializable
{
  protected $companyName;
  /**
   * @var Employees
   */
  protected $employees;

  function __construct($companyName=null, $employees=null)
  {
    $this->companyName = $companyName;
    $this->employees = $employees;
  }


  protected function getClassMap()
  {
    return array(
      'employees' => 'Employees'
    );
  }
}

$employees = new Employees();
$employees['AA']= new Employee('A', 'A');
$employees[]= new Employee('B', 'B');
$employees[] = new Employee('C', 'C');
$employees['DD'] = new Employee('D', 'D');

$company = new Company('ACME',$employees);


// From PHP Object to XML:
$xmlResponse = new SimpleXMLElement('<response></response>');
$company->xmlserialize($xmlResponse);

echo $xmlResponse->asXML();

//From XML to PHP Object;
$company = new Company();
$company->xmlunserialize($xmlResponse);

print_r($company);
//