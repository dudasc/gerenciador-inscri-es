
<?php
include "valida_sessao.php";
/******************************************************************************/
// Arquivo: meuPrimeiroGeradorPDF.php 
// Este arquivo é parte integrante do artigo: 
// Gerando Documentos PDF com a Classe FPDF no PHP 
// Autor: José Vanol Jr. Data: 12/07/2010 
/******************************************************************************/

//Incluindo o arquivo onde está a Classe FPDF
if(isset($_GET['cd'])){
include "../classes/fpdf.php";
include "../classes/conexao.php";
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


//OBTENDO DADOS DO BANCO
$dao = new palestraDAO();
$data = $dao->consultaAlunosPalestra((int)$_GET['cd']);
$linha = mysql_fetch_array($data);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(null,6,'Dados da palestra', 1, null, 'C' );
$pdf->Ln();
$pdf->Cell(40,6,'Nome:', 1);
$pdf->SetFont(null, '', null);
$pdf->Cell(null,6,iconv('utf-8','iso-8859-1', $linha['tema']), 1);
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(40,6,iconv('utf-8','iso-8859-1', 'Palestrante'), 1);
$pdf->SetFont(null, '', null);
$pdf->Cell(null,6,iconv('utf-8','iso-8859-1', $linha['palestrante']), 1);
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(40,6,'Data:', 1);
$pdf->SetFont(null, '', null);
$pdf->Cell(null,6,implode("/",array_reverse(explode("-",$linha['data']))), 1);
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(40,6,iconv('utf-8','iso-8859-1', 'Início'), 1);
$pdf->SetFont(null, '', null);
$pdf->Cell(null,6,$linha['horario'], 1);
$pdf->Ln(10);



$pdf->SetFont('Arial', '', 11);
$pdf->SetDrawColor(56,56,56);
$pdf->Cell(80);
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(30, 12, iconv('utf-8','iso-8859-1', 'Relatório de alunos presentes'), 0, 0, 'C');//'Pessoas' centralizado no meio da página
$pdf->Ln(12);



$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(35, 10, 'Matricula/CPF', 1);
$pdf->Cell(75, 10, 'Nome', 1);
$pdf->Cell(80, 10, 'E-mail', 1);
$pdf->Ln();

$pdf->SetFont('Arial', '', 11);
//POPULANDO A TABELA
$data2 = $dao->consultaAlunosPresencasPalestra((int)$_GET['cd']);
//print_r($linha);
while($linha2 = mysql_fetch_array($data2)){
		$pdf->Cell(35, 10, $linha2['matricula'], 1);
		$pdf->Cell(75, 10, iconv('utf-8','iso-8859-1', $linha2['nome_aluno']), 1);
		$pdf->Cell(80, 10, $linha2['email'], 1);
		$pdf->Ln();
}
$pdf->Ln(150);
$pdf->Output("relatorio-".$linha['tema'].".pdf","I");
}else{
	header("location: relatorio-alunos-minicurso.php");
}
?>