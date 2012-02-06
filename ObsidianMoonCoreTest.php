<?php
include('ObsidianMoonCore.php');
class ObsidianMoonTest extends PHPUnit_Framework_TestCase {
	public $core;
	
	public function setUp(){ }  
	public function tearDown(){ } 
	public function StartTest() {
		$this->core = new obsidian_moon_core();
		$this->assertGreaterThan(0,$this->core->time);
		$this->assertEqual(false,$this->core->is_ajax);
	}
}
