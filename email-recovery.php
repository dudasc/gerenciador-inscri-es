<link href="css/bootstrap/bootstrap.css" rel="stylesheet" />
<?php
sleep(2);
//include "valida_sessao.php";
include "/classes/conexao.php";
include "/classes/alunoDAO.php";


$email = strtolower($_POST["email"]);
//if(!preg_match('/^[a-z0-9_.-]+@[a-z0-9]+\.[a-z0-9]{2,5}(\.[a-z0-9]{2,5})?$/', $email)){
	//echo 'Informe um e-mail válido';
//}else{	
	$dao = new alunoDAO();
	$consulta = $dao->buscaEmail($email);
	$total = mysql_num_rows($consulta);
	
		if($total > 0){
			$linha = mysql_fetch_array($consulta);
			$senha = $linha['senha'];
			$login = $linha['matricula'];
			$msg = "***** Esse e-mail é automático ****<br><br>Seu login é: ".$login."<br> Sua senha é: ".$senha;
					
			$to = $email;
			// assunto
			$subj = "Semana acadêmica IFC-Sombrio 2013 - Recuperação de senha";
			
			// O remetente deve ser um e-mail do seu dom�nio conforme determina a RFC 822.
			// O return-path deve ser ser o mesmo e-mail do remetente.
			$headers = "MIME-Version: 1.1\r\n";
			$headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
			$headers .= "From: no-reply@ifc-sombrio.edu.br\r\n";
			// remetente
			$headers .= "Return-Path: no-reply@ifc-sombrio.edu.br\r\n";
			// return-path	
		

			if (mail($to, $subj, $msg, $headers)) {
				echo "Sua senha foi enviada para o endereço $to";
			} else{
				//echo $msg;
				echo '<p>Serviço Indisponível. Procure o administrador do sistema.</p>';
				
			}
		}else{
			echo '<p>Serviço Indisponível. Procure o administrador do sistema.</p>';
	}
//}
	

	


