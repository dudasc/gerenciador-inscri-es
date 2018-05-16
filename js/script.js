$(document).ready(function(){
	$(".checkbox-presencas-minicurso").change(function() {		
		var mat = $(this).val();	
		var codigo = $("#codigo-minicurso").val();	
		var carregando = $(this).next();
		carregando.hide();				
		$.ajax({
			url : "presencas-minicurso.php",
			type: "GET",
			data : {'mat': mat, 'codigo': codigo},
			beforeSend : function() {
				carregando.fadeIn(180);
			},
			complete: function(data) {
				carregando.fadeOut(180);				
			},
			error : function(msg) {
				alert("Erro");
			}	
		});
	});
	
	$(".checkbox-presencas-palestra").change(function() {
		var mat = $(this).val();	
		var codigo = $("#codigo-palestra").val();	
		var carregando = $(this).next();
		carregando.hide();				
		$.ajax({
			url : "presencas-palestra.php",
			type: "GET",
			data : {'mat': mat, 'codigo': codigo},
			beforeSend : function() {
				carregando.fadeIn(180);
			},
			complete: function(data) {
				carregando.fadeOut(180);	
			},
			error : function(msg) {
				alert("Erro");
			}
	
		});
	});	
	
	
	$('#form-cadastro').validate({
		rules: {
			curso: {
	        	required: true
	      	},
	      	nome: {
	        	required: true
	      	},
	      	senha: {
	        	required: true,
				minlength: 6,
	      	},
		  	email: {
	        	required: true,
				email: true,
			},
			senha2: {
				required: true,
				equalTo: "#senha"
			},
			mat: {
				minlength: 11,
				number: true,
				required: true
			}
		},
		messages:{
				curso:{
                    required: "Campo curso é obrigatório"
                },
                nome:{
                    required: "Campo nome é obrigatório"
                },
                mat: {
                    required: "Campo matrícula é obrigatório",
                    number: "O CPF deve conter somente números",
					minlength: "O CPF deve conter no mínimo 5 caracteres"
                },
                senha: {
                    required: "Campo senha é obrigatório",
					minlength: "Senha deve conter no mínimo 6 caracteres"
                },
                senha2:{
                    required: "Campo confirmar senha é obrigatório",
                    equalTo: "Senhas não coincidem"
                },
				email:{
                    required: "Campo e-mail é obrigatorio",
                    email: "Infome um e-mail válido"
                }
            },
			highlight: function(element) {
				$(element).closest('.control-group spam').removeClass('success').addClass('error');
			}/*,
			success: function(element) {
				element
				.text('OK!').addClass('valid')
				.closest('.control-group spam').removeClass('error').addClass('success');
			}*/
	  });
	  
	  $('#form-login').validate({
	    rules: {
	      mat: {
	        required: true
	      },
		  login: {
	        required: true
	      },
	      senha: {
	        required: true,
	      }
	    },
		messages:{
                senha:{
                    required: "Campo senha é obrigatório",
                },
				login:{
                    required: "Campo login é obrigatório",
                },
                mat: {
                    required: "Campo CPF é obrigatorio",
                    number: "Campo CPF deve conter somente números"
                },
            },
			highlight: function(element) {
				$(element).closest('.control-group spam').removeClass('success').addClass('error');
			}/*,
			success: function(element) {
				element
				.text('OK!').addClass('valid')
				.closest('.control-group spam').removeClass('error').addClass('success');
			}*/
	  });
	  
	   $('#fodrm-login-recovery').validate({
	    rules: {
	      email: {
	        required: true,
			email: true
	      },
	    },
		messages:{
                email:{
                    required: "Campo senha é obrigatorio",
					email: "E-mail inválido"
                },
               
            },
			highlight: function(element) {
				$(element).closest('.control-group spam').removeClass('success').addClass('error');
			}/*,
			success: function(element) {
				element
				.text('OK!').addClass('valid')
				.closest('.control-group spam').removeClass('error').addClass('success');
			}*/
	  });
	  
	  $('#form-cadastro-palestra').validate({
	    rules: {
	      data: {
	        required: true
	      },
		  tema: {
	        required: true
	      },
		  hora: {
	        required: true
	      },
		  pale: {
	        required: true,
	      },
		  local: {
	        required: true,
	      },
		  vagas: {
	        required: true,
	      },
		  carga_horaria:{
            required: true,
          },
	    },
		messages:{
                data:{
                    required: "Campo data é obrigatório",
                },
				tema:{
                    required: "Campo tema é obrigatório",
                },
				hora:{
                    required: "Campo horario é obrigatório",
                },
				pale:{
                    required: "Campo palestrante é obrigatório",
                },
				local:{
                    required: "Campo local é obrigatório",
                },
				vagas:{
                    required: "Campo nº de vagas é obrigatório",
                },
				carga_horaria:{
                    required: "Campo carga horária é obrigatório",
                },
               
            },
			highlight: function(element) {
				$(element).closest('.control-group spam').removeClass('success').addClass('error');
			}/*,
			success: function(element) {
				element
				.text('OK!').addClass('valid')
				.closest('.control-group spam').removeClass('error').addClass('success');
			}*/
	  });
	  
	  
	    $('#form-cadastro-minicurso').validate({
	    rules: {
	      data: {
	        required: true
	      },
		  nome: {
	        required: true
	      },
		  hora: {
	        required: true
	      },
		  res: {
	        required: true,
	      },
		  local: {
	        required: true
	      },
		  vagas: {
	        required: true
	      },
		  carga_horaria: {
	        required: true
	      },
	    },
		messages:{
                data:{
                    required: "Campo data é obrigatorio",
                },
				nome:{
                    required: "Campo nome é obrigatório",
                },
				hora:{
                    required: "Campo horario é obrigatório",
                },
				local:{
                    required: "Campo palestrante é obrigatório",
                },
				res:{
                    required: "Campo responsável é obrigatório",
                },
				vagas:{
                    required: "Campo nº de vagas é obrigatório",
                },
				carga_horaria:{
                    required: "Campo carga horária é obrigatório",
                },
               
            },
			highlight: function(element) {
				$(element).closest('.control-group spam').removeClass('success').addClass('error');
			}/*,
			success: function(element) {
				element
				.text('OK!').addClass('valid')
				.closest('.control-group spam').removeClass('error').addClass('success');
			}*/
	  });
	  
	  
	  $('#form-busca-alunos').validate({
	    rules: {
	      minicurso: {
	        required: true
	      },
		  palestra: {
	        required: true
	      },
	    },
		messages:{
                minicurso:{
                    required: "Campo minicurso obrigatório",
                },
				palestra:{
                    required: "Campo palestra obrigatório",
                },				
               
            }
	  });
	  
	  $("#form-login-recovery").submit(function() {
		var email = $("#email").val();
		$("#msg").html('<p>Enviando e-mail <img src="img/loading-mini.gif" /> </p>');	
		$.post('email-recovery.php', {email: email},
		function(resposta) {
			$("#msg").fadeIn();
			$("#msg").html(resposta);
			$("#email").val("");
		});
	});


}); // end document.ready

function confirmaExclusao(){
	if (confirm("Confirmar exclusão?")) { return true; } else { return false; }
}