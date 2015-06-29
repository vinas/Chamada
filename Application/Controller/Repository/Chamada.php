<?php

/************************************************************************************
* Name:				Chamada Repository												*
* File:				Application\Controller\Repository\Chamada.php 					*
* Author(s):		Vinas de Andrade												*
*																					*
* Description: 		This' function is to feed the Service with information.			*
*																					*
* Creation Date:	06/05/2015														*
* Version:			1.15.0506														*
* License:			http://www.opensource.org/licenses/bsd-license.php BSD			*
************************************************************************************/

namespace Application\Controller\Repository;

use SaSeed\General;

class Chamada {

	private $db;
	private $table = 'chamada';
	private $classPath = 'Application\Controller\Repository\Chamada';

	public function __construct() {
		$this->db = $GLOBALS['db'];
	}

	public function saveNewPresenca($idTuma, $idAluno) {
		try {
			$this->db->insertRow(
				$this->table,
				array(
					$idTuma,
					$idAluno,
					true,
					General::mySqlDate()
				)
			);
			return true;
		} catch (Exception $e) {
			die('['.$this->classPath.'::saveNewPresenca] - '.  $e->getMessage());
		}
	}

	public function saveNewFalta($idTuma, $idAluno) {
		try {
			$this->db->insertRow(
				$this->table,
				array(
					$idTuma,
					$idAluno,
					false,
					General::mySqlDate()
				)
			);
			return true;
		} catch (Exception $e) {
			die('['.$this->classPath.'::saveNewFalta] - '.  $e->getMessage());
		}
	}

	public function listTurmasChamadasHoje() {
		try {
			return $this->db->getAllRows($this->table, 'turmaId', "1 AND data = '".General::mySqlDate()."' GROUP BY turmaId");
		} catch (Exception $e) {
			die('['.$this->classPath.'::listTurmasChamadasHoje] - '.  $e->getMessage());
		}
	}

	public function getChamadaDataTurma($idTuma, $data) {
		try {
			return $this->db->getAllRows($this->table . ' AS c JOIN aluno AS a ON (c.alunoId = a.id)', 'c.alunoId, a.nome, a.observacoes, c.presente', "c.turmaId = {$idTuma} AND c.data = '".$data."'");
		} catch (Exception $e) {
			die('['.$this->classPath.'::getChamadaDataTurma] - '.  $e->getMessage());
		}
	}
}
