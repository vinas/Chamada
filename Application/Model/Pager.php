<?php
/************************************************************************************
* Name:				Standart Pager Model											*
* File:				Application\Model\Pager.php 									*
* Author(s):		Vinas de Andrade												*
*																					*
* Description: 		This is the Pager's model. It is itented to work with data		*
*					originally generated on \Controller\Repository\dbFunctions.php.	*
*																					*
* Creation Date:	09/05/2013														*
* Version:			1.13.0509														*
* License:			http://www.opensource.org/licenses/bsd-license.php BSD			*
*************************************************************************************/

	namespace Application\Model;

	Final class Pager {

		public static function pagerOptions($paging_info = false, $this_page = false, $action = false
		) {
			$content				= '';
			if ($paging_info) {
				$returned			= $paging_info['returned'];
				// Monta valores para navegação/paginação
				$content .= '		<input type="hidden" name="ordering" id="ordering" value="'.$paging_info['ordering'].'" />'.PHP_EOL;
				$content .= '		<input type="hidden" name="next" id="next" value="'.$paging_info['next'].'" />'.PHP_EOL;
				$content .= '		<input type="hidden" name="previous" id="previous" value="'.$paging_info['previous'].'" />'.PHP_EOL;
				$content .= '		<input type="hidden" name="pager_pg_num" id="pager_pg_num" value="'.$paging_info['pg_num'].'" />'.PHP_EOL;
				$content .= '		<input type="hidden" name="pager_tot_pages" id="pager_tot_pages" value="'.$paging_info['tot_pages'].'" />'.PHP_EOL;
				$content .= '		<input type="hidden" name="pager_tot_rows" id="pager_tot_rows" value="'.$paging_info['tot_rows'].'" />'.PHP_EOL;
				$content .= '		<input type="hidden" name="max" id="offset" value="'.$paging_info['offset'].'" />'.PHP_EOL;
				$content .= '		<input type="hidden" name="limit" id="limit" value="'.$paging_info['limit'].'" />'.PHP_EOL;
				$content .= '		<input type="hidden" name="direction" id="direction" value="'.$paging_info['direction'].'" />'.PHP_EOL;
				$content .= '		<input type="hidden" name="this_page" id="this_page" value="'.$this_page.'" />'.PHP_EOL;
				$content .= '		<input type="hidden" name="action" id="action" value="'.$action.'" />'.PHP_EOL;
				// Monta conteúdo
				$content			.= '					Page '.PHP_EOL;
				if ($paging_info['previous']) {
					$content		.= '					<a href="#" class="goto_page" key="'.$paging_info['previous'].'"><img src="/questionmaster/Chamada/Application/View/img/arrow_left.gif" width="16" height="16" border="0" /></a>'.PHP_EOL;
				} else {
					$content		.= '					<img src="/questionmaster/Chamada/Application/View/img/pixel.gif" width="16" height="16" />'.PHP_EOL;
				}
				$content			.= '					<input size="1" type="text" name="pager_num" id="pager_num" class="pager" value="'.$paging_info['pg_num'].'" /> '.PHP_EOL;
				if ($paging_info['next']) {
					$content		.= '					<a href="#" class="goto_page" key="'.$paging_info['next'].'"><img src="/questionmaster/Chamada/Application/View/img/arrow_right.gif" width="16" height="16" border="0" /></a>'.PHP_EOL;
				} else {
					$content		.= '					<img src="/questionmaster/Chamada/Application/View/img/pixel.gif" width="10" height="16" />'.PHP_EOL;
				}
				$content			.= '					of<img src="/questionmaster/Chamada/Application/View/img/pixel.gif" width="10" height="16" />'.$paging_info['tot_pages'].'<img src="/questionmaster/Chamada/Application/View/img/pixel.gif" width="30" height="16" />|<img src="/questionmaster/Chamada/Application/View/img/pixel.gif" width="30" height="16" />See'.PHP_EOL;
				$content			.= '					<select name="max_actv" id="max_actv" class="pager_select">'.PHP_EOL;
				// Opções de quantos usuários por página
				if ($paging_info['limit'] != 0) {
					if ($paging_info['limit'] == '20') {
						$content	.= '						<option value="20" selected="selected">20&nbsp;</option>'.PHP_EOL;
					} else {
						$content	.= '						<option value="20">20&nbsp;</option>'.PHP_EOL;
					}
					if ($paging_info['limit'] == '30') {
						$content	.= '						<option value="30" selected="selected">30&nbsp;</option>'.PHP_EOL;
					} else {
						$content	.= '						<option value="30">30&nbsp;</option>'.PHP_EOL;
					}
					if ($paging_info['limit'] == '50') {
						$content	.= '						<option value="50" selected="selected">50&nbsp;</option>'.PHP_EOL;
					} else {
						$content	.= '						<option value="50">50&nbsp;</option>'.PHP_EOL;
					}
					if ($paging_info['limit'] == '100') {
						$content	.= '						<option value="100" selected="selected">100&nbsp;</option>'.PHP_EOL;
					} else {
						$content	.= '						<option value="100">100&nbsp;</option>'.PHP_EOL;
					}
				} else {
					$content		.= '						<option value="20">20&nbsp;</option>'.PHP_EOL;
					$content		.= '						<option value="30">30&nbsp;</option>'.PHP_EOL;
					$content		.= '						<option value="50">50&nbsp;</option>'.PHP_EOL;
					$content		.= '						<option value="100">100&nbsp;</option>'.PHP_EOL;
				}
				$content			.= '					</select> '.PHP_EOL;
				$content			.= '					per page<img src="/questionmaster/Chamada/Application/View/img/pixel.gif" width="30" height="16" />|<img src="/questionmaster/Chamada/Application/View/img/pixel.gif" width="30" height="16" />Total: <strong>'.$paging_info['tot_rows'].'</strong> records found'.PHP_EOL;
			}
			return $content;
		}
	}