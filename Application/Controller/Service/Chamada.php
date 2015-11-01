<?php

/************************************************************************************
* Name:				Chamada Service													*
* File:				Application\Controller\Service\Chamada.php 						*
* Author(s):		Vinas de Andrade												*
*																					*
* Description: 		This' function is to feed the Controller with information.		*
*																					*
* Creation Date:	06/05/2015														*
* Version:			1.15.0506														*
* License:			http://www.opensource.org/licenses/bsd-license.php BSD			*
************************************************************************************/

namespace Application\Controller\Service;

use SaSeed\Utils;

use Application\Controller\Repository\Chamada as ChamadaRepository;

class Chamada {

	private $chamadaRepository;

	public function __construct() {
		$this->chamadaRepository = new ChamadaRepository();
	}

	public function darPresenca($idTurma, $idAluno) {
		return $this->chamadaRepository->saveNewPresenca($idTurma, $idAluno);
	}
	
	public function darFalta($idTurma, $idAluno) {
		return $this->chamadaRepository->saveNewFalta($idTurma, $idAluno);
	}

	public function getGrid($idTurma, $data = false) {
		if (!$data) {
			$data = Utils::phpDate();
		}
		return $this->chamadaRepository->getChamadaDataTurma($idTurma, Utils::mySqlNonUsDate($data));
		return false;
	}

}