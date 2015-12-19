<?php
// Config
$config = array();
switch($_SERVER['HTTP_HOST'])
{
	case 'localhost:8888':
		$config['debug']   = false;
		$config['db_host'] = 'localhost';
		$config['db_name'] = 'hetictraining';
		$config['db_user'] = 'root';
		$config['db_pass'] = 'root';
		break;
}