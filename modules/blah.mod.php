<?php

class Blah extends CubePoints_Module {

	public static $module = array(
		'name' => 'The Blah',
		'version' => '0.1',
		'module_uri' => 'http://jon.sg/blah',
		'author_name' => 'Blah Co',
		'author_uri' => 'http://blah.sg',
		'description' => 'Blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah.',
		'settings_link' => 'admin.php?page=cubepoints_settings#blah'
	);

	public function main() {
		echo 'blah blah blah. this module is running!';
	}
	
}



























