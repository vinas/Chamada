<?php
/************************************************************************************
* Name:				Aluno Entity													*
* File:				Application\Controller\Entities\Aluno.php 						*
* Author(s):		Vinas de Andrade												*
*																					*
* Description: 		This' function is to feed the Controller with information.		*
*																					*
* Creation Date:	21/04/2015														*
* Version:			1.15.0421														*
* License:			http://www.opensource.org/licenses/bsd-license.php BSD			*
************************************************************************************/

namespace Application\Controller\Entities;

class Aluno {

	private $id;
	private $turmaId;
	private $nome;
	private $ra;
	private $foto;
	private $observacoes;

	public function setId($id = false) {
		$this->id = $id;
	}
	public function getId() {
		return $this->id;
	}

	public function setTurmaId($turmaId = false) {
		$this->turmaId = $turmaId;
	}
	public function getTurmaId() {
		return $this->turmaId;
	}

	public function setNome($nome = false) {
		$this->nome = $nome;
	}
	public function getNome() {
		return $this->nome;
	}

	public function setRa($ra = false) {
		$this->ra = $ra;
	}
	public function getRa() {
		return $this->ra;
	}

	public function setFoto($foto = false) {
		$this->foto = $foto;
	}
	public function getFoto() {
		return $this->foto;
	}

	public function setObservacoes($observacoes = false) {
		$this->observacoes = $observacoes;
	}
	public function getObservacoes() {
		return $this->observacoes;
	}
	public function populateEntity($array) {
		try {
			$this->setId((isset($array['id'])) ? $array['id'] : false);
			$this->setTurmaId((isset($array['turmaId'])) ? $array['turmaId'] : false);
			$this->setNome((isset($array['nome'])) ? $array['nome'] : false);
			$this->setRa((isset($array['ra'])) ? $array['ra'] : false);
			$this->setFoto((isset($array['foto'])) ? $array['foto'] : false);
			$this->setObservacoes((isset($array['observacoes'])) ? $array['observacoes'] : false);
			return $this;
		} catch (Exception $e) {
			die('[Application\Controller\Repository\Aluno::populateEntity] - '.  $e->getMessage());
		}
	}

}
