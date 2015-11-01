<?php
namespace SaSeed\View;

Final class CSSHandler extends FileHandler {

	public static function declareGeneralCSS() {
		self::declareCSSFilesFromFolder();
	}

	public static function declareSpecificCSS($fileName) {
		echo self::setCSSTag($fileName).'.css';
	}

	private static function declareCSSFilesFromFolder($folder = '') {
		$files = scandir(GeneralCSSPath);
		$totFiles = count($files);
		if ($totFiles > 2) {
			for ($i = 2; $i < $totFiles; $i++) {
				echo self::setCSSTag($folder.'/'.$files[$i]);
			}
		}
	}

	private static function setCSSTag($fileName) {
		return '<link href="'.WebCSSViewPath.self::setFilePath($fileName).'" rel="stylesheet"/>'.PHP_EOL;
	}

}