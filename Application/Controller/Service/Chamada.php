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

use Application\Controller\Repository\Chamada as ChamadaRepository;

class Chamada {

	private $chamadaRepository;

	public function __construct() {
		$this->chamadaRepository = new ChamadaRepository();
	}

	public function darPresenca($idTuma, $idAluno) {
		return $this->chamadaRepository->saveNewPresenca($idTuma, $idAluno);
	}
	
	public function darFalta($idTuma, $idAluno) {
		return $this->chamadaRepository->saveNewFalta($idTuma, $idAluno);
	}

}