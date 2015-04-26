<?php
/************************************************************************************
* Name:				autoload														*
* File:				SaSeed\autoload.php 											*
* Author(s):		Leandro Menezes													*
*																					*
* Description: 		I have no clue whatsoever what the hell this file is for!		*
*					(Vinas)															*
*																					*
* Creation Date:	15/11/2012														*
* Version:			1.12.1115														*
* License:			http://www.opensource.org/licenses/bsd-license.php BSD			*
*************************************************************************************/

function _appautoload_($name) {
	$pathinfo		= pathinfo(dirname(__FILE__));
	$searchpath		= explode('\\', $name);
	$name			= array_pop( $searchpath );
	$searchpath		= $pathinfo['dirname'].DIRECTORY_SEPARATOR.implode(DIRECTORY_SEPARATOR,$searchpath).DIRECTORY_SEPARATOR;
	//echo "{$searchpath}{$name}.php<br>";
	if (file_exists("{$searchpath}{$name}.php")) {
        require_once("{$searchpath}{$name}.php");
	}
}

spl_autoload_register('_appautoload_');