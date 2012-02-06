<?php
include('ObsidianMoonCore.php');
class ObsidianMoonTest extends PHPUnit_Framework_TestCase {
	public $core;
	
	public function setUp(){ }  
	public function tearDown(){ } 
	public function StartTest() {
		$this->core = new ObsidianMoonCore();
		$this->assertGreaterThan(0,$this->core->systime);
		$this->assertEqual(false,$this->core->is_ajax);
	}
}
