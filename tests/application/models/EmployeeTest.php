<?php

require_once ('../application/models/Employee.php');

class Model_EmployeeTest extends ControllerTestCase
{                 
/*
    public function testCanDoUnitTest()
    {
        $this->assertTrue(true);
    }
  */
    protected $employee;

    public function setUp()
    {
        parent::setUp();
        $this->employee = new Application_Model_Employee();
    }

    public function testCanAddEmployee()
    {
        
        $testData = array(
                    'VMware (EMC) ID' => 'testuser',
                    'Name' => 'Test User',
                    'Email' => 'testuser@vmware.com',
                    'People Mgr?' => 'Yes',
                    'Employee Type' => 'Regular',
                    'CC #' => '74400',
                    'Region' => null,
                    'Country Name' => null,
                    'Business Title' => 'Test Account',
                    'Manager' => 'Test Manager',
                    'Mgr VMware (EMC) ID' => 'testmanager',
                );
        $this->employee->insertNewEmployee($testData);
        
        
        $employee = $this->employee->getEmployee('testuser');

        $this->assertTrue(!empty($employee), 'Can not find testuser from Employee DB');

    }

    

}

