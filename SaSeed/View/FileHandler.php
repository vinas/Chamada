<?php
namespace SaSeed\View;

class FileHandler {

	public static function renderFilesFromFolder($folder, $type) {
		$files = scandir($folder);
		$totFiles = count($files);
		if ($totFiles > 2) {
			switch ($type) {
				case 'js':
					echo '<script>'.PHP_EOL;
					break;
				case 'css':
					echo '<style>'.PHP_EOL;
					break;
			}
			for ($i = 2; $i < $totFiles; $i++) {
				require_once($folder.DIRECTORY_SEPARATOR.$files[$i]);
			}
			switch ($type) {
				case 'js':
					echo '</script>'.PHP_EOL;
					break;
				case 'css':
					echo '</style>'.PHP_EOL;
					break;
			}
		}
	}

	public static function appendTemplate($file) {
		require_once(TemplatesPath.self::setFilePath($file.'.html'));
	}

	public static function setFilePath($file) {
		return str_replace('_','/', $file);
	}

	private static function compress($buffer) {
		// remove comments
		$buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
		// remove tabs, spaces, newlines, etc.
		$buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  '), '', $buffer);
		// remove unnecessary spaces.
		$buffer = str_replace('{ ', '{', $buffer);
		$buffer = str_replace(' }', '}', $buffer);
		$buffer = str_replace('; ', ';', $buffer);
		$buffer = str_replace(', ', ',', $buffer);
		$buffer = str_replace(' {', '{', $buffer);
		$buffer = str_replace('} ', '}', $buffer);
		$buffer = str_replace(': ', ':', $buffer);
		$buffer = str_replace(' ,', ',', $buffer);
		$buffer = str_replace(' ;', ';', $buffer);
		return $buffer;
	}


}