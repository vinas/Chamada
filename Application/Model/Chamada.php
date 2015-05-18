<?php
/************************************************************************************
* Name:				Chamada Model													*
* File:				Application\Model\Chamada.php 									*
* Author(s):		Vinas de Andrade												*
*																					*
* Description: 		This is the Chamada's model.									*
*																					*
* Creation Date:	2/04/2015														*
* Version:			1.15.042														*
* License:			http://www.opensource.org/licenses/bsd-license.php BSD			*
*************************************************************************************/

namespace Application\Model;

use SaSeed\General;

class Chamada {

	private $classPath = 'Application\Model\Chamada';

	public function home($turmas) {
		$content = '<br />'.PHP_EOL;
		$content .= '<div>'.PHP_EOL;
		$content .= '		Selecione a turma: '.PHP_EOL;
		$content .= '		<select name="turmaId" id="turmaId">'.PHP_EOL;
		$content .= '			<option value="0">selecione a turma...</option>'.PHP_EOL;
		foreach ($turmas as $turma) {
			$content .= '			<option value="'.$turma->getId().'">'
										.$turma->getTurma().' - '.$turma->getPeriodoExtenso()
										.' - '.$turma->getSemestre().'o S</option>'.PHP_EOL;
		}	
		$content .= '		</select>'.PHP_EOL;
		$content .= '</div>'.PHP_EOL;
		return $content;
	}

	public function chamada($turma, $alunos, $listaAlunos) {
		$pilhaTurma = false;
		$totAlunos = count($listaAlunos);
		$content = '<br />'.PHP_EOL;
		$content .= '<div>'.PHP_EOL;
		$content .= '	<div><b>'.$turma->getTurma().' - '.$turma->getPeriodoExtenso()
							.' - '.$turma->getSemestre().'o S</b></div>'.PHP_EOL;
		$content .= '	<br />'.PHP_EOL;

		$content .= '		<input type="hidden" id="idTurma" name="idTurma" value="'.$turma->getId().'"/>'.PHP_EOL;

		if ($totAlunos > 0) {
			for ($i = 2; $i < $totAlunos; $i++) {
				$pilhaTurma .= ($pilhaTurma) ? ',' . $listaAlunos[$i]->getId() : $listaAlunos[$i]->getId();
			}
			$content .= '		<input type="hidden" id="pilhaTurma" name="pilhaTurma" value="'.$pilhaTurma.'"/>'.PHP_EOL;

			$content .= '	<div id="preAlunoContainer" class="alunoContainer">'.PHP_EOL;
			if (isset($alunos[1])) {
				$content .= '		<input type="hidden" id="idAluno" name="idAluno" value="'.$alunos[1]->getId().'"/>'.PHP_EOL;
				$content .= '		<div id="fotoAluno" class="fotoAluno">Foto: '.$alunos[1]->getFoto().'</div>'.PHP_EOL;
				$content .= '		<div id="nomeAluno" class="nomeAluno">Nome: '.$alunos[1]->getNome().'</div>'.PHP_EOL;
				$content .= '		<div id="obsAluno" class="obsAluno">Observacoes: '.$alunos[1]->getObservacoes().'</div>'.PHP_EOL;
				$content .= '		<br />'.PHP_EOL;
				$content .= '		<div id="veio" class="pointyWhenOver">veio</div>'.PHP_EOL;
				$content .= '		<div id="naoVeio" class="pointyWhenOver">nao veio</div>'.PHP_EOL;
				$content .= '		<br />'.PHP_EOL;
				$content .= '	</div>'.PHP_EOL;
			}
			$content .= '	<div id="alunoContainer" class="alunoContainer">'.PHP_EOL;
			$content .= '		<input type="hidden" id="idAluno" name="idAluno" value="'.$alunos[0]->getId().'"/>'.PHP_EOL;
			$content .= '		<div id="fotoAluno" class="fotoAluno">Foto: '.$alunos[0]->getFoto().'</div>'.PHP_EOL;
			$content .= '		<div id="nomeAluno" class="nomeAluno">Nome: '.$alunos[0]->getNome().'</div>'.PHP_EOL;
			$content .= '		<div id="obsAluno" class="obsAluno">Observacoes: '.$alunos[0]->getObservacoes().'</div>'.PHP_EOL;
			$content .= '		<br />'.PHP_EOL;
			$content .= '		<div id="veio" class="pointyWhenOver">veio</div>'.PHP_EOL;
			$content .= '		<div id="naoVeio" class="pointyWhenOver">nao veio</div>'.PHP_EOL;
			$content .= '		<br />'.PHP_EOL;
			$content .= '	</div>'.PHP_EOL;
		} else {
			$content .= '	<div>Não ha alunos nessa turma</div>'.PHP_EOL;
		}

	
		$content .= '</div>'.PHP_EOL;
		return $content;
	}

	public function alunoLayer($aluno) {
		$content = '';
		$content .= '		<input type="hidden" id="idAluno" name="idAluno" value="'.$aluno->getId().'"/>'.PHP_EOL;
		$content .= '		<div id="fotoAluno" class="fotoAluno">Foto: '.$aluno->getFoto().'</div>'.PHP_EOL;
		$content .= '		<div id="nomeAluno" class="nomeAluno">Nome: '.$aluno->getNome().'</div>'.PHP_EOL;
		$content .= '		<div id="obsAluno" class="obsAluno">Observacoes: '.$aluno->getObservacoes().'</div>'.PHP_EOL;
		$content .= '		<br />'.PHP_EOL;
		$content .= '		<div id="veio" class="pointyWhenOver">veio</div>'.PHP_EOL;
		$content .= '		<div id="naoVeio" class="pointyWhenOver">nao veio</div>'.PHP_EOL;
		$content .= '		<br />'.PHP_EOL;
		return $content;
	}

}
