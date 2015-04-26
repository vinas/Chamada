<?php
/************************************************************************************
* Name:				Bootstrap														*
* File:				SaSeed\bootstrap.php 											*
* Author(s):		Vinas de Andrade e Leandro Menezes								*
*																					*
* Description: 		This file loads basic Settings and starts up the right			*
*					Controller for and Action Function.								*
*																					*
* Creation Date:	15/11/2012														*
* Version:			1.13.0523														*
* License:			http://www.opensource.org/licenses/bsd-license.php BSD			*
*************************************************************************************/

	namespace SaSeed;

	use SaSeed\URLRequest;

	// Define Charset
	header('Content-type: text/html; charset=UTF-8');

	// *********************** \\
	//	Define Basic settings  \\
	// *********************** \\
	require_once('Settings.php'); // (Must be the first include)
	require_once("autoload.php");
	require_once("GeneralFunctions.php");

	// *********************** \\
	//  Include Basic Classes
	// *********************** \\
	
	require_once(AppPath.'SaSeed/Session.php');
	
	// Database Connection
	if (DB_NAME) {
		$db	= new Database();
		$db->DBConnection(DB_DRIVER, DB_HOST, DB_NAME, DB_USER, DB_PASS);
	}

	// Define General JSs
	$GLOBALS['general_js']	= '<script type="text/javascript" src="/Chamada/Application/View/js/libs/jquery-2.1.1.min.js"></script>'.PHP_EOL;	// Se não houver, definir como vazio ''
	$GLOBALS['general_js']	.= '<script type="text/javascript" src="/Chamada/Application/View/js/scripts/scripts.js"></script>'.PHP_EOL;

	// Define General CSSs
	$GLOBALS['general_css']	= '<link href="/Chamada/Application/View/css/styles.css" rel="stylesheet">'.PHP_EOL;	// Se não houver, definir como vazio ''

	// ********************************************** \\
	//	Load Specific Controller and Action Function  \\
	// ********************************************** \\
	// Define Controller, Action and Parameters
	$URLparams = new URLRequest();
	$GLOBALS['controller_name']	= $URLparams->getController();
	$GLOBALS['controller']		= "\Application\Controller\\".$URLparams->getController();
	$GLOBALS['action_function']	= $URLparams->getActionFunction();


	// Call in Controller and Functions whithin proper environment
	$obj = new $GLOBALS['controller'];
	$obj->$GLOBALS['action_function']();