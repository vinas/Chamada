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

	// Charset Definition
	header('Content-type: text/html; charset=UTF-8');

	//Routes
	require('Config'.DIRECTORY_SEPARATOR.'Routes.php');

	// Environment Definition
	define('ENV', 'DEV');
	//define('ENV', 'LIVE');

	// Timezone and regional Defitions
	date_default_timezone_set('America/Sao_Paulo');
	setlocale(LC_MONETARY, 'pt_BR');
	setlocale(LC_ALL, 'Portuguese_Brazil.1252 ');

	// Exceptions Defition
	$GLOBALS['exceptions'] = parse_ini_file(ConfigPath.'exceptions.ini', true);

	// XSS String List
	$xss_strings = parse_ini_file(ConfigPath.'xss.ini');