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

	namespace SaSeed;

	Final class View {

		public static $data	= Array();

		public static function gotoRoot(){
			View::redirect('/',true);
		}

		/*
		Renders view and variables - render($name)
			@param string	- view's name
			@return format	- view is printed
			@throws \Exception
		*/
		public static function render($name = false) {
			if ($name) {
				extract(self::$data);
				if (self::renderExists($name)) {
					require self::getRenderPath($name);
				} else {
					throw New \Exception ("[SaSeed\View::render] - arquivo de view '{$name}' nao existe");
				}
			} else {
				throw New \Exception ("[SaSeed\View::render] - render nao informado");
			}
		}

		/*
		Get view's path - getRenderPath($name)
			@param string	- view's name
			@return format	- string/false
		*/
		private static function getRenderPath($name = false) {
			if ($name) {
				$name	= str_replace('_','/', $name);
				return ViewPath."{$name}.html" ;
			}
			return false;
		}

		/*
		Works like render method but returns the renderized content instead of printing it - renderto($name)
			@param string	- view's name
			@return format	- string/false
		*/
		public static function renderto($name = false) {
			if ($name) {
				ob_start();
				View::render($name);
				$return	= ob_get_contents();
				ob_end_clean();
				return $return;
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
					$name = str_replace('_','/', $name);
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
		Prints an array encoded in Json - jsonEncode($array)
			@param array	- data
			@return void
		*/
		public static function jsonEncode($array) {
			echo json_encode($array);
		}

		/*
		Prints out modeled info - printModel($model)
			@param string	- modeled info
			@return void
		*/
		public static function printModel($model) {
			echo $model;
		}
	}