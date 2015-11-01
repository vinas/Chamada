<?php
/************************************************************************************
* Name:				View specifics													*
* File:				Application\FramworkCore\View.php 								*
* Author(s):		ivonascimento <ivo@o8o.com.br>, Vinas de Andrade, 				*
*					Raphael Pawlik e Leandro Menezes								*
*																					*
* Description: 		This file is a controller to interpretate and support requests.	*
*																					*
* Creation Date:	14/11/2012														*
* Version:			1.12.1114														*
* License:			http://www.opensource.org/licenses/bsd-license.php BSD			*
*************************************************************************************/

namespace SaSeed\View;

use SaSeed\View\JavaScriptHandler;
use SaSeed\View\CSSHandler;

Final class View extends FileHandler {

	public static $data	= Array();
	public static $JSHandler;
	public static $CSSHandler;

	private static $viewPath = ViewPath.DIRECTORY_SEPARATOR;

	private function __construct() {
		
	}

	public static function render($name) {
		if ($name) {

			self::$JSHandler = new JavaScriptHandler();	
			self::$CSSHandler = new CSSHandler();	
			/*
			self::ModelToViewObj();
			*/
			
			ob_start();
			extract(self::$data);
			if (self::templateFileExists($name)) {
				require self::getTemplate($name);
			} else {
				throw New \Exception ("[SaSeed\View\View::render] - " . $GLOBALS['exceptions']['VIEW']['noTemplateFileInformed']);
			}
			ob_end_flush();
		} else {
			throw New \Exception ("[SaSeed\View\View::render] - " . $GLOBALS['exceptions']['VIEW']['noTemplateFile']);
		}
	}

	private static function templateFileExists($name) {
		return file_exists(self::getTemplate($name));
	}

	/*
	Get template files' path - getRenderPath($name)
		@param string	- view's name
		@return format	- string/false
	*/
	private static function getTemplate($name = false) {
		if ($name) {
			$name	= self::setFilePath($name);
			return TemplatesPath."{$name}.html" ;
		}
		return false;
	}

	/*
	Sets a variable into View context - set($name, $value)
		@param string	- view's name
		@return format	- string/false
	*/
	public static function set($name = false, $value = false) {
		if (($name) && ($value)) {
			self::$data[$name]	= $value;
		}
	}

	public static function gotoRoot(){
		View::redirect('/',true);
	}

	/*
	Get view's path - getRenderPath($name)
		@param string	- view's name
		@return format	- string/false
	*/
	private static function getRenderPath($name = false) {
		if ($name) {
			$name	= self::setFilePath($name);
			return ViewPath."{$name}.html" ;
		}
		return false;
	}

	public static function renderTo($name) {
		try {
			ob_start();
			extract(self::$data);
			if (self::templateFileExists($name)) {
				require self::getTemplate($name);
			} else {
				throw New \Exception ("[SaSeed\View\View::render] - " . $GLOBALS['exceptions']['VIEW']['noTemplateFileInformed']);
			}
			$return	= ob_get_contents();
			ob_end_clean();
			return $return;
		} catch (Exception $e) {
			throw('[SaSeed\View\View::renderTo] - Not possible to render json object');
		}
	}

	/*
	Easy redirect - redirect($name, $full)
		@param string	- view's name
		@param boolean	- true for external url, false for internal url
		@return format	- no return
		@throws \Exception
	*/
	public static function redirect($name = false, $full = false) {
		if ($name) {
			if (!$full) {
				$name = self::setFilePath($name);
				header("Location: {$name}");
			} else {
				header("Location: {$name}");
			}
		}
	}

	/*
	Check if render exists - renderExists($name)
		@param string	- view's name
		@return format	- no return
	*/
	public static function renderExists($name) {
		return file_exists(self::getRenderPath($name));
	}

	/*
	Prints an array encoded in Json - renderJson($array)
		@param array	- data
		@return void
	*/
	public static function renderJson($array) {
		ob_start();
		extract(self::$data);
		echo json_encode($array);
		ob_end_flush();
	}

}