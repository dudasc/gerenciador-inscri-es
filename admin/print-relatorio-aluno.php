<?php
include "valida_sessao.php";
/******************************************************************************/
// Arquivo: meuPrimeiroGeradorPDF.php 
// Este arquivo é parte integrante do artigo: 
// Gerando Documentos PDF com a Classe FPDF no PHP 
// Autor: José Vanol Jr. Data: 12/07/2010 
/******************************************************************************/

//Incluindo o arquivo onde está a Classe FPDF
if(isset($_GET['mat'])){
include "../classes/fpdf.php";
include "../classes/conexao.php";
include "../classes/alunoDAO.php";
include "../classes/minicursoDAO.php";
include "../classes/palestraDAO.php";


class PDF extends FPDF
{
//Page header
	function Header(){
		//Logo
		$this->Image('../img/logo.jpg',10,8,50);
		//Arial bold 15
		$this->SetFont('Arial','B',13);
		
		//Move to the right
		$this->Cell(80);
		//Title
		$this->Cell(30,0,'CST Redes de Computadores',0,0,'C');
		$this->Cell(-20);
		$this->Cell(10,25,iconv('utf-8','iso-8859-1','Semana acadêmica 2013'),0,0,'C');
		//Line break
		$this->Ln(30);
	}

	//Page footer
	function Footer(){
		//Position at 1.5 cm from bottom
		$this->SetY(-15);
		//Arial italic 8
		$this->SetFont('Arial','',8);
		  $this->SetTextColor(128);
		//Page number
	$this->Cell(370,10,iconv('utf-8','iso-8859-1','Página').$this->PageNo().'/{nb}',0,0,'C');
	}
}

//Instanciation of inherited class
$pdf=new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();


$pdf->SetFont('Arial', '', 11);
$pdf->SetDrawColor(56,56,56);
$pdf->Cell(80);
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(30, 0, iconv('utf-8','iso-8859-1', 'Relatório de aluno'), 0, 0, 'C');//'Pessoas' centralizado no meio da página
$pdf->Ln(10);


//OBTENDO DADOS DO BANCO





$dao = new alunoDAO();
$data = $dao->consulta($_GET['mat']);
$linha = mysql_fetch_assoc($data);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(null,6,'Dados do aluno', 1, null, 'C' );
$pdf->Ln();
$pdf->Cell(40,6,'Nome:', 1);
$pdf->SetFont(null, '', null);
$pdf->Cell(null,6,iconv('utf-8','iso-8859-1', $linha['nome']), 1);
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(40,6,iconv('utf-8','iso-8859-1', 'CPF'), 1);
$pdf->SetFont(null, '', null);
$pdf->Cell(null,6,iconv('utf-8','iso-8859-1', $linha['matricula']), 1);
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(40,6,'Data:', 1);
$pdf->SetFont(null, '', null);
$pdf->Cell(null,6, $linha['email'], 1);
$pdf->Ln(18);

/**************************************/

$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(35,0, iconv('utf-8','iso-8859-1', 'Minicursos - CH'),0,0,'L');
$pdf->Ln(8);

$pdf->SetFont('Arial', '', 11);
$dao2 = new minicursoDAO();
$ch_minicurso = 0;
$consulta2 = $dao2->consultaMinicursosAlunoPresenca($_GET['mat']);
$total =  mysql_num_rows($consulta2);
if($total > 0){
	while($linha2 = mysql_fetch_assoc($consulta2)){
		   $pdf->Cell(20,0, iconv('utf-8','iso-8859-1', $linha2['minicurso']." - ".$linha2['carga_horaria'].' horas' ),0,0);
			$ch_minicurso += (int)$linha2['carga_horaria'];
			$pdf->Ln(6);
	}
}else{
	$pdf->SetFont('Arial', '', 11);
	$pdf->Cell(20,0, 'Nenhum minicurso',0,0);
	$pdf->Ln(6);
}

$pdf->Ln(5);
/**************************************/

$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(35,0, iconv('utf-8','iso-8859-1', 'Palestras - CH'),0,0,'L');
$pdf->Ln(8);

$pdf->SetFont('Arial', '', 11);

$dao3 = new palestraDAO();
$ch_palestra = 0;
$consulta3 = $dao3->consultaPalestrasAlunoPresenca($_GET['mat']);
$total =  mysql_num_rows($consulta3);
if($total > 0){
	while($linha3 = mysql_fetch_assoc($consulta3)){
		  $pdf->Cell(20,0, iconv('utf-8','iso-8859-1', $linha3['palestra']." - ".$linha3['carga_horaria'].' horas' ),0,0);
		  $ch_palestra += $linha3['carga_horaria'];
		  $pdf->Ln(6);
	}
}else{
	$pdf->SetFont('Arial', '', 11);
	$pdf->Cell(20,0, 'Nenhuma palestra',0,0);
	$pdf->Ln(6);
}
$pdf->Ln(5);
$ch_total = $ch_minicurso + $ch_palestra;
$pdf->SetFont('Arial', 'B', 14);
 $pdf->Cell(0,0, iconv('utf-8','iso-8859-1', 'Carga horária total - '.$ch_total. " horas"),0,0, 'L');
$pdf->Ln(150);
$pdf->Output("relatorio-aluno.pdf","I");

}else{
	header("location: listar-alunos.php");
}
?>