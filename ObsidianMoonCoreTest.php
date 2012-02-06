<?php
include('ObsidianMoonCore.php');
class ObsidianMoonTest extends PHPUnit_Framework_TestCase {
	public $core;
	
	public function setUp(){ }  
	public function tearDown(){ } 
	public function testConstruct() {
		$this->core = new ObsidianMoonCore();
		$this->assertGreaterThan(0,$this->core->systime);
		$this->assertEquals(false,$this->core->is_ajax);
	}
}
