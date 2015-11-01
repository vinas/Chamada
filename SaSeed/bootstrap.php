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

	require_once('Settings.php'); // (Must be the first include)
	require_once("autoload.php");

	// Degub
	if (ENV == 'DEV') {
		ini_set('display_errors', 1);
		error_reporting(E_ALL);
	} else {
		ini_set('display_errors', 0);
	}

	// ********************************************** \\
	//	Load Specific Controller and Action Function  \\
	// ********************************************** \\
	$URLRequest = new URLRequest();
	$controller		= "\Application\Controller\\".$URLRequest->getController();
	$actionFunction	= $URLRequest->getActionFunction();
	$obj = new $controller;
	$obj->$actionFunction();