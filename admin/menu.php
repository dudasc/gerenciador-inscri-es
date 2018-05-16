<?php
include "valida_sessao.php";
?>
<div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container"> <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </a>
        <!-- <a class="brand" href="#">Semana acadêmica 2013</a><a class="brand" href="#">Semana acadêmica 2013</a>-->
          <div class="nav-collapse">
            <ul class="nav">
              <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown">Palestras <b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><a href="cad-palestra.php">Cadastrar nova palestra</a></li>
                  <li><a href="listar-palestras.php">Listar palestras</a></li>
                  <li><a href="relatorio-alunos-palestra.php">Relatório de alunos</a></li>
                </ul>
              </li>
              
              <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown">Mini-cursos<b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><a href="cad-minicurso.php">Cadastrar novo mini-curso</a></li>
                  <li><a href="listar-minicursos.php">Listar mini-cursos</a></li>
                  <li><a href="relatorio-alunos-minicurso.php">Relatório de alunos</a></li>
                </ul>
              </li>
              
              <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown">Aluno<b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><a href="listar-alunos.php">Gerenciar alunos</a></li>
                </ul>
              </li>
             
             
            </ul>
            <ul class="nav pull-right">
              <li> <a href="logout.php">Sair</a> </li>
            </ul>
          </div>
          <!-- /.nav-collapse --> 
        </div>
        <!-- /.container --> 
      </div>
      <!-- /.navbar-inner --> 
    </div>
    <!-- /.navbar --> 