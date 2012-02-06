<?php
include('ObsidianMoonCore.php');
class ObsidianMoonTest extends PHPUnit_Framework_TestCase {
	public $core;
	
	public function testConstruct() {
		$conf = array(
			'libs' => 'testlibslocation',
			'core' => 'testcorelocation',
			'publ' => 'testpubllocation',
			'base' => 'testbaselocation'
		);
		$this->core = new ObsidianMoonCore($conf);
		$this->assertGreaterThan(0,$this->core->systime);
		$this->assertEquals(false,$this->core->is_ajax);
		$this->assertEquals('testlibslocation',$this->core->conf_libs);
		$this->assertEquals('testcorelocation',$this->core->conf_core);
		$this->assertEquals('testpubllocation',$this->core->conf_publ);
		$this->assertEquals('testbaselocation',$this->core->conf_base);
	}
}
