<?php
include('ObsidianMoonCore.php');
class ObsidianMoonCoreTest extends PHPUnit_Framework_TestCase {
	public $core;
	
	public function testConstruct() {
		$conf = array(
			'libs' => dirname(__FILE__) . '/test/libraries/',
			'core' => dirname(__FILE__) . '/',
			'publ' => dirname(__FILE__) . '/test/',
			'base' => dirname(__FILE__) . '/test/',
			'modules' => array(
				'TestClass'
			)
		);
		$this->core = new ObsidianMoonCore($conf);
		$this->assertGreaterThan(0,$this->core->systime);
		$this->assertEquals(false,$this->core->is_ajax);
		$this->assertEquals($conf['libs'],$this->core->conf_libs);
		$this->assertEquals($conf['core'],$this->core->conf_core);
		$this->assertEquals($conf['publ'],$this->core->conf_publ);
		$this->assertEquals($conf['base'],$this->core->conf_base);
	}
}
