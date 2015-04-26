<?php
/************************************************************************************
* Name:				Database Functions												*
* File:				Application\FramworkCore\Database.php 							*
* Author(s):		Vinas de Andrade												*
*																					*
* Description: 		This file holds basic Database functions for the whole			*
*					web-site. It also contains Database connection and query		*
*					functions.														*
*																					*
* Creation Date:	22/09/2011														*
* Version:			2.13.0219														*
* License:			http://www.opensource.org/licenses/bsd-license.php BSD			*
*************************************************************************************/

	namespace SaSeed;

	class Database {

		private $connection;					// Link de conexão
		private $lastConnection	= null;		// Contém as informações da última conexão usada
		private $error			= '';		// Retorna o texto da mensagem de erro da última operação sql
		private $displayErrors	= '';		// Erro a ser exibido
		private $errorNumber	= '';		// Retorna o valor numérico da mensagem de erro da última operação sql
		private $isLocked		= false;	// Existe alguma tabela travada agora?


		// ** CONEXãO ** \\
		// ************* \\

		/* Função de conexão
		 * @var(s) string
		 * @return boolean */
		public function DBConnection($dbHost = false, $dbUser = false, $dbPass = '', $dbName = false) {
			if (($dbHost) && ($dbUser) && ($dbName)) {
				$this->connection = mysql_connect($dbHost, $dbUser, $dbPass);
				if ($this->connection) {
					if (mysql_select_db($dbName, $this->connection)) {
						$this->lastConnection = &$this->connection;
						return $this->connection;
					}
					$this->displayErrors('- N&atilde;o foi poss&iacute;vel selecionar o Banco de Dados: '.$dbName.'<br>Erro: '.mysql_error());
					return false;
				}
				$this->displayErrors('- N&atilde;o foi poss&iacute;vel conectar-se o Banco de Dados: '.$dbName.'<br>Erro: '.mysql_error());
				return false;
			}
			$this->displayErrors('- Valores de conex&atilde;o n&atilde;o foram enviados!');
			return false;
		}

		/* Fecha a conexão MySQL
		 * @param  none
		 * @return boolean */
		public function close() {
			$this->msql = '';
			return mysql_close($this->connection);
		}

		// ** CRUD ** \\
		// ********** \\

		/* Roda uma Query
		 * @param  string  - A query
		 * @return mixed */
		private function runQuery($query) {
			$this->lastConnection = &$this->connection;
			$this->msql = &$query;
			$result = mysql_query($query, $this->connection);
			if ($result) {
				$this->queries_count++;
				return $result;
			}
			$this->displayErrors();
			return false;
		}

		/* Pega linha de resultado como um array associativo
		 * @param  string  - A query
		 * @return array */
		private function fetch($query) {
			return mysql_fetch_assoc($query);
		}

		/* Pega linha de resultado como array numérico, associatvo ou ambos
		 * @param  string - A query
		 * @return array */
		private function afetch($query) {
			return mysql_fetch_array($query);
		}

		/* Pega linha de resultado como um objeto
		 * @param  string - A query
		 * @return array */
		private function ofetch($query) {
			return mysql_fetch_object($query);
		}

		/* Retorna a última ID PK (campo auto_increment) da última linha inserida
		 * @return  integer*/
		public function lastId() {
			return mysql_insert_id($this->connection);
		}

		// *** Funções CRUD pré-preparadas ***

		/* Pega vários registros de uma tabela podendo-se usar condições, selecionar campos,
		   e definir a paginação
		 *
		 * @param string	- Tabela alvo
		 * @param string	- Condições
		 * @param string	- Que campos pegar (mto útil ao se usar JOINs)
		 * @param integer	- Regsitro de início (paginação)
		 * @param integer	- Máximo de registros (paginação)
		 *
		 * @return mixed */
		public function getAllRows($table, $limit = 0, $max = 0, $selectWhat = '*', $conditions = '1') {
			$query = 'SELECT '.$selectWhat.' FROM '.$table.' WHERE '.$conditions;
			if (($max != 0) && ($limit != 0)) {
				$query .= ' LIMIT '.$limit.', '.$max;
			}
			$res = $this->runQuery($query);
			return $res;
		}

		/* Pega vários registros de uma tabela podendo-se usar condições, selecionar campos,
		   e definir a paginação. Retorna um array
		 *
		 * @param string	- Tabela origem dos dados
		 * @param string	- Condições
		 * @param string	- Que campos pegar (mto útil ao se usar JOINs)
		 * @param integer	- Regsitro de início (paginação)
		 * @param integer	- Máximo de registros (paginação)
		 *
		 * @return array 	- $rows[contador][campo] */
		public function getAllRows_Arr($table, $selectWhat = '*', $conditions = '1', $limit = 0, $max = 0) {
			$rows = '';
			$query = 'SELECT '.$selectWhat.' FROM '.$table.' WHERE '.$conditions;
			if (($max != 0) && ($limit != 0)) {
				$query .= ' LIMIT '.$limit.', '.$max;
			}
			// Executa a pesquisa
			$res = $this->runQuery($query);
			$contador = 0;
			while ($row = $this->fetch($res)) {
				$totFields = count($row);
				for ($i = 0; $i < $totFields; $i++) {
					$key[] = key($row);
					next($row);
				}
				foreach ($key as $value) {
					$rows[$contador][$value] = $row[$value];
				}
				$contador++;
			}
			return $rows;
		}

		/* Pega um único registro podendo-se utilizar condições e selecionar os campos
		 *
		 * @param string	- Tabela alvo
		 * @param string	- quais as condições
		 * @param string	- Que campos pegar. (mto útil ao se usar JOINs)
		 *
		 * @return mixed */
		public function getRow($table, $selectWhat = '*', $conditions = '1') {
			$query = 'SELECT '.$selectWhat.' FROM '.$table.' WHERE '.$conditions;
			$res = $this->runQuery($query);
			$row = $this->fetch($res);
			return $row;
		}

		/* Atualiza ou mais registros (apenas uma condição)
		 *
		 * @param string	- Tabela alvo
		 * @param string	- Condições
		 * @param string	- Que campos pegar. (mto útil ao se usar JOINs)
		 *
		 * @return boolean */
		public function updateRow($table, $fields, $values, $condition) {
			$i = 0;
			$query = '';
			if (count($fields) == count($values)) {
				$query = 'UPDATE '.$table.' SET ';
				foreach ($fields as $campo) {
					if ($i != 0) {
						$query .= ', ';
					}
					$query .= $campo.' = ';
					if (is_int($values[$i])) { // numérico
						$query .= $values[$i];
					} else if (gettype($values[$i]) == 'object') { // data/objeto
						foreach ($values[$i] as $variavel) {
								$valor = $variavel;
								break;
						}
						$query .= "'".$valor."'";
					} else { // string
						$query .= "'".$values[$i]."'";
					}
					$i++;
				}
				$query .= ' WHERE '.$condition;
			}
			$res = $this->runQuery($query);
			return $res;
		}

		/* Deleta um ou mais registros (apenas uma condição)
		 * @param  string - A tabela em questão
		 * @param  string - Condições da query
		 * @return boolean */
		public function deleteRow($table = '', $condition = '') {
			$query = 'DELETE FROM '.$table.' WHERE '.$condition;
			$res = $this->runQuery($query);
			return $res;
		}

		/* Insere um novo registro
		 * @param  string - A tabela em questão
		 * @param  array  - Valores a seres inseridos
		 * @param  array  - Campos que receberão valores
		 * @return boolean */
		public function insertRow($table, $values, $fields = '') {
			$query = 'INSERT INTO '.$table.' (';
			if ($fields == '') {
				$fields = $this->listFields_noid($table);
				for ($i = 0; $i < count($fields); $i++) {
					if ($i > 0) {
						$query .= ', ';
					}
					$query .= $fields[$i];
				}
			} else {
				for ($i = 0; $i < count($fields); $i++) {
					if ($i > 0) {
						$query .= ', ';
					}
					$query .= $fields[$i];
				}
			}
			$query .= ') VALUES (';
			for ($i = 0; $i < count($values); $i++) {
				if ($i != 0) {
					$query .= ', ';
				}

				if (is_int($values[$i])) {
					$query .= $values[$i];
				} else if (gettype($values[$i]) == 'object') {
					foreach ($values[$i] as $variavel) {
							$valor = $variavel;
							break;
					}
					$query .= "'".$valor."'";
				} else {
					$query .= "'".$this->stringEscape($values[$i])."'";
				}
			}
			$query .= ')';
			$res = $this->runQuery($query);
			return $res;
		}

		// ** FUNÇÕES AUXILIARES ** \\
		// ************************ \\

		/* Retorna os nomes dos campos de uma tabela
		 * @param  string  - A tabela
		 * @return array */
		public function listFields($table) {
			$query = 'SHOW COLUMNS FROM '.$table;
			$res = $this->runQuery($query);
			while ($row = $this->fetch($res)) {
				$fields[] = $row['Field'];
			}
			return $fields;
		}

		/* Retorna os nomes dos campos de uma tabela (menos campo ID)
		 * @param  string  - A tabela
		 * @return array */
		public function listFields_noid($table) {
			$contador = 0;
			$query = 'SHOW COLUMNS FROM '.$table;
			$res = $this->runQuery($query);
			while ($row = $this->fetch($res)) {
				if ($contador != 0) {
					$fields[] = $row['Field'];
				}
				$contador++;
			}
			return $fields;
		}

		/* Retorna número de campos de uma tabela
		 * @param  string  - A tabela
		 * @return integer */
		public function numFields($table) {
			$query = 'DESCRIBE '.$table;
			$res = $this->runQuery($query);
			$value = $this->numRows($res);
			return $res;
		}

		/* Retorna o número de linhas de uma query já executada
		 * @param  string - O resultado da query.
		 * @return integer */
		public function numRows($result) {
			return mysql_num_rows($result);
		}

		/* Retorna o número de linhas afetadas pela última query
		 * @return integer */
		public function affectedRows() {
			return mysql_affected_rows($this->lastConnection);
		}

		/* Retorna o número total de queries executadas. (Vai geralmente no fim do script)
		 * @return integer */
		public function numQueries() {
			return $this->queries_count;
		}

		/* Trava uma(s) tabela(s)
		 * @param   array  - Array das tabelas => Tipo de trava
		 * @return  void */
		public function lockTables($tables) {	
			if ((is_array($tables)) && (count($tables) > 0)) {
				$msql = '';
				foreach ($tables as $name=>$type){
					$msql .= (!empty($msql)?', ':'').''.$name.' '.$type.'';
				}
				$this->runQuery('LOCK TABLES '.$msql.'');
				$this->isLocked = true;
			}
		}

		/* Destrava tabela(s) do banco */ 
		public function unlockTables() {
			if ($this->isLocked){
				$this->runQuery('UNLOCK TABLES');
				$this->isLocked = false;
			}
		}

		/* Trata um valor para ser usado com segurança em queries
		 * @param  string  - String a ser tratada
		 * @param  bool    - Caso tratar '%' e '_' seja preciso
		 * @return string */
		public function stringEscape($string, $fullEscape = false) {
			if ($fullEscape) $string = str_replace(array('%', '_'), array('\%', '\_'), $string);
			$string = stripslashes($string);
			if (function_exists('mysql_real_escape_string')) {
				return mysql_real_escape_string($string, $this->connection);
			} else{
				return mysql_escape_string($string);
			}
		}

		/* Limpa o resultado
		 * @param  string  - O resultado a ser limpo ($result)
		 * @return boolean */
		public function freeResult($result) {
			return mysql_free_result($result);
		}

		/* Retorna a mensagem de erro do MySQL
		 * @return string */
		public function error() {
			$this->error = (is_null($this->lastConnection)) ? '' : mysql_error($this->lastConnection);
			return $this->error;
		}

		/* Retorna o número do erro MySQL
		 * @return string */
		public function errorNumber() {
			$this->errorNumber = (is_null($this->lastConnection)) ? 0 : mysql_errno($this->lastConnection);
			return $this->errorNumber;
		}

		/* Se um erro de BD acontecer, o script vai ser parado e uma mensagem de erro exibida
		 * @param  string  - A mensagem de erro. Se vazia, será criada como $this->sql.
		 * @return string */
		private function displayErrors($errorMessage='') {
			if ($this->lastConnection) {
				$this->error = $this->error($this->lastConnection);
				$this->errorNumber = $this->errorNumber($this->lastConnection);
			}
			if (!$errorMessage) {
				$errorMessage = '- Erro na query: '.$this->msql;
			}
			$message = ''.$errorMessage.'<br />
			'.(($this->errorNumber != '') ? '- Error: '.$this->error.' (Error #'.$this->errorNumber.')<br />' : '').'
			- File: '.$_SERVER['SCRIPT_FILENAME'].'<br />';
			die('Erro de Banco de Dados, favor tentar novamente mais tarde.<br />'.$message.'');
			//die('Erro de Banco de Dados:<br /><br />Um erro ocorreu na pesquisa, a mesma estava vazia ou era invalida.<br />Favor tentar novamente mais tarde.<br /><br />- debug: dbfc.displayErrors');
		}
	}