<?php

/************************************************************************************
* Nome:			Biblioteca de Funções de Busca e Paginação							*
* Arquivo:		\Repository\dbFunctions.php 										*
* Autor(es):	Vinas																*
*																					*
* Descrição: 	Este arquivo contém funções gerais que fazem a busca paginada e 	*
*				e retorna os resultados juntos com os dados de paginação.		 	*
*				Ele deve poder ser utilizado por qualquer repositório.				*
*																					*
* Data da criação: 23/05/2013														*
* Versão: 1.15.0326																	*
*************************************************************************************/

namespace Application\Controller\Service\dbUtils;

class dbFunctions {

	/* Função pega dados dos registros e de paginação - getPage($table, $conditions, $pg_num, $max, $select_what)
	 * @param string	- Campos a serem selecionados
	 * @param string	- Origem dos dados
	 * @param string	- Condições da consulta
	 * @param integer	- Número máximo de registros por consulta
	 * @param integer	- Página atual
	 * @param string	- Ordenação
	 * @param string	- Sentido da ordenação
	 * @return array */
	public function getPage($select_what = false, $table = false, $conditions = '1', $limit = 20, $pg_num = 1, $ordering = 'id', $direction = 'ASC') {
		$db								= $GLOBALS['db'];
		// Inicializa variáveis
		$return							= false;
		// Se dados básicos foram enviados
		if (($select_what) && ($table)) {
			// Faz cálculos da paginação
			list ($tot_rows, $tot_pages, $offset, $next, $previous) = $this->paginate($table, $conditions, $pg_num, $limit);
			// Pega os dados dos registros
			if ($ordering) {
				$conditions				.= ' ORDER BY '.$ordering;
				if ($direction) {
					$conditions			.= ' '.$direction;
				}
			}
			// Pega dados da base
			$rows						= $db->getAllRows_Arr($table, $select_what, $conditions, $offset, $limit);
			// Prepara dados de paginação para serem enviados
			$returned					= count($rows);
			$paging_info['returned']	= $returned;
			$paging_info['pg_num']		= $pg_num;
			$paging_info['tot_pages']	= $tot_pages;
			$paging_info['tot_rows']	= $tot_rows;
			$paging_info['previous']	= $previous;
			$paging_info['next']		= $next;
			$paging_info['offset']		= $offset;
			$paging_info['limit']		= $limit;
			$paging_info['direction']	= $direction;
			$paging_info['ordering']	= $ordering;
			// Prepara retorno
			$return[0]					= $rows;
			$return[1]					= $paging_info;
		}
		// Retorna dados
		return $return;
	}

	/* Função que calcula dados de paginação - paginate($table, $conditions, $pg_num, $max)
	 * @param string	- Nome da tabela
	 * @param string	- Especificação da pesquisa
	 * @param integer	- Página atual
	 * @param integer	- Número de registros por página
	 * @return array */
	private function paginate($table = false, $conditions = '1', $pg_num = 1, $limit = 0) {
		// Inicializa variáveis
		$pagination_data	= '';
		// Database Connection
		$db					= $GLOBALS['db'];
		// Tira ordenação das condições
		$order_pos			= strpos($conditions, "ORDER");
		if ($order_pos) {
			$conditions		= substr($conditions, 0, $order_pos);
		}
		// Calcula paginação
		$select_what		= 'count(*) AS total';
		$tot_rows			= $db->getRow($table, $conditions, $select_what);
		$tot_rows			= $tot_rows['total'];			// total de registros
		$tot_pages			= ceil($tot_rows/$limit);		// Total de páginas
		$offset				= $pg_num * $limit - $limit;	// Página atual
		// Calcula a próxima página
		if ($tot_pages > $pg_num) {
			$next			= $pg_num + 1;
			$next			= $next;
		} else {
			$next			= '';
		}
		// Calcula a página anterior
		if ($pg_num > 1) {
			$previous		= $pg_num - 1;
		} else {
			$previous		= '';
		}
		// Prepara dados para serem enviados
		$pagination_data[]	= $tot_rows;
		$pagination_data[]	= $tot_pages;
		$pagination_data[]	= $offset;
		$pagination_data[]	= $next;
		$pagination_data[]	= $previous;
		// Retorna dados
		return $pagination_data;
	}

}