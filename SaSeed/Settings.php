<?php
/************************************************************************************
* Name:				General Settings												*
* File:				Application\FramworkCore\Settings.php 							*
* Author(s):		Vinas de Andrade, Raphael Pawlik e Leandro Menezes				*
*																					*
* Description: 		This file holds basic settings for the whole web-site.			*
*																					*
* Creation Date:	14/11/2012														*
* Version:			1.13.0523														*
* License:			http://www.opensource.org/licenses/bsd-license.php BSD			*
*************************************************************************************/


	// General Settings
	$pathinfo = pathinfo(dirname(__FILE__));
	define('AppPath', $pathinfo['dirname'].DIRECTORY_SEPARATOR);
	define('ViewPath',	AppPath.'/Application/View'.DIRECTORY_SEPARATOR);
	define('UrlPath', '/teste'); // DEV
	define('ENV',		'DEV');
	//define('ENV',		'LIVE');

	// Degub Setting (comment when in production)
	ini_set('display_errors', 1); 
	error_reporting(E_ALL);

	// Timezone and regional settings
	date_default_timezone_set('America/Sao_Paulo');
	setlocale(LC_MONETARY,	'pt_BR');
	setlocale(LC_ALL,		'Portuguese_Brazil.1252 ');

	// Database Settings
	$conection_config = parse_ini_file(AppPath.'/SaSeed/Config/database.ini', true);
	define('DB_HOST', $conection_config['DATABASE_'.ENV]['local']);
	define('DB_USER', $conection_config['DATABASE_'.ENV]['user']);
	define('DB_PASS', $conection_config['DATABASE_'.ENV]['password']);
	define('DB_NAME', $conection_config['DATABASE_'.ENV]['dbname']);
	define('DB_DRIVER', $conection_config['DATABASE_'.ENV]['driver']);

	$GLOBALS['exceptions'] = parse_ini_file(AppPath.'/SaSeed/Config/exceptions.ini', true);

	// XSS String List
	$xss_strings	= parse_ini_file(AppPath.'/SaSeed/Config/xss.ini');