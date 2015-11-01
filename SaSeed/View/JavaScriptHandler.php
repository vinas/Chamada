<?php
namespace SaSeed\View;

Final class JavaScriptHandler extends FileHandler {

	public static function declareGeneralJSLibs() {
		self::declareJSFilesFromFolder('libs');
	}

	public static function declareGeneralJS() {
		self::declareJSFilesFromFolder('general');
	}

	public static function declareSpecificJS($fileName) {
		echo self::setJSTag(self::setFilePath($fileName).'.js');
	}

	public static function loadGeneralJSLibs() {
		self::renderFilesFromFolder(GeneralJSPath.'general'.DIRECTORY_SEPARATOR, 'js');
	}

	public static function loadGeneralJS() {
		self::renderFilesFromFolder(GeneralJSPath.'libs'.DIRECTORY_SEPARATOR, 'js');
	}

	private static function declareJSFilesFromFolder($folder) {
		$files = scandir(GeneralJSPath.$folder.DIRECTORY_SEPARATOR);
		$totFiles = count($files);
		if ($totFiles > 2) {
			for ($i = 2; $i < $totFiles; $i++) {
				echo self::setJSTag($folder.'/'.$files[$i]);
			}
		}
	}

	private static function setJSTag($fileName) {
		return '<script type="text/javascript" src="'.WebJSViewPath.self::setFilePath($fileName).'"></script>'.PHP_EOL;
	}

}