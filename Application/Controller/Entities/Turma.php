<?php
/************************************************************************************
* Name:				Turmas Entity													*
* File:				Application\Controller\Entities\Turmas.php 						*
* Author(s):		Vinas de Andrade												*
*																					*
* Description: 		This' function is to feed the Controller with information.		*
*																					*
* Creation Date:	19/04/2015														*
* Version:			1.15.0419														*
* License:			http://www.opensource.org/licenses/bsd-license.php BSD			*
************************************************************************************/

namespace Application\Controller\Entities;

class Turma {

	private $id;
	private $turma;
	private $semestre;
	private $periodo;
	private $periodoExtenso;

	public function setId($id = false) {
		$this->id = $id;
	}
	public function getId() {
		return $this->id;
	}

	public function setTurma($turma = false) {
		$this->turma = $turma;
	}
	public function getTurma() {
		return $this->turma;
	}

	public function setSemestre($semestre = false) {
		$this->semestre = $semestre;
	}
	public function getSemestre() {
		return $this->semestre;
	}

	public function setPeriodo($periodo = false) {
		$this->periodo = $periodo;
		if ($this->periodo == 1) {
			$this->periodoExtenso = 'Diurno';
		} else if ($this->periodo == 2) {
			$this->periodoExtenso = 'Noturno';
		} else {
			$this->periodoExtenso = '';
		}
	}
	public function getPeriodo() {
		return $this->periodo;
	}

	public function getPeriodoExtenso() {
		return $this->periodoExtenso;
	}

	public function populateEntity($array) {
		try {
			$this->setId((isset($array['id'])) ? $array['id'] : false);
			$this->setTurma((isset($array['turma'])) ? $array['turma'] : false);
			$this->setSemestre((isset($array['semestre'])) ? $array['semestre'] : false);
			$this->setPeriodo((isset($array['periodo'])) ? $array['periodo'] : false);
			return $this;
		} catch (Exception $e) {
			die('[Application\Controller\Repository\Turma::populateEntity] - '.  $e->getMessage());
		}
	}

}
