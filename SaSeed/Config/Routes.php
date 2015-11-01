<?php
/************************************************************************************
* Name:				General Routes													*
* File:				SaSeed\Routes.php			 									*
* Author(s):		Vinas de Andrade												*
*																					*
* Description: 		This file holds basic route settings for the whole application.	*
*																					*
* Creation Date:	28/08/2015														*
* Version:			1.15.0828														*
* License:			http://www.opensource.org/licenses/bsd-license.php BSD			*
*************************************************************************************/

// WEB CONTEXT ROUTES
define('WebJSViewPath', '/Chamada/Application/View/js/');
define('WebCSSViewPath', '/Chamada/Application/View/css/');

// LOCAL ROUTES
$path = dirname(__FILE__);
$basePath = substr($path, 0, strpos($path, "SaSeed"));
define('ConfigPath', $basePath.'SaSeed'.DIRECTORY_SEPARATOR.'Config'.DIRECTORY_SEPARATOR);
define('ViewPath', $basePath.'Application'.DIRECTORY_SEPARATOR.'View'.DIRECTORY_SEPARATOR);
define('TemplatesPath', $basePath.'Application'.DIRECTORY_SEPARATOR.'View'.DIRECTORY_SEPARATOR.'Templates'.DIRECTORY_SEPARATOR);
define('GeneralJSPath', ViewPath.'js'.DIRECTORY_SEPARATOR);
define('GeneralCSSPath', ViewPath.'css'.DIRECTORY_SEPARATOR);
