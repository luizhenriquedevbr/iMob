<?php 

	require __DIR__ . '/../vendor/autoload.php';

	$co_autorizado = Security::getUser()['co_autorizado'];
	
?>

<!DOCTYPE html>

<html style="height: auto; min-height: 100%;">
    <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>DCCI | SIGIF2 - Sistema de Investigação de Incapacidade Física em Menores de 15 anos</title>
      <!-- Tell the browser to be responsive to screen width -->
      <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
      <!-- Bootstrap 3.3.7 -->
      <link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">
      <!-- Font Awesome -->
      <link rel="stylesheet" href="../bower_components/font-awesome/css/font-awesome.min.css">
      <!-- Ionicons -->
      <link rel="stylesheet" href="../bower_components/Ionicons/css/ionicons.min.css">
      <!-- Theme style -->
      <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
      <link rel="stylesheet" href="../dist/css/skins/skin-blue.css">
      <link rel="stylesheet" href="../plugins/iCheck/square/blue.css">
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
      <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      <style>
          .disclaimer {
            color:#000;
            position:absolute;
            bottom:100px;
            width:100%;
            text-align:center;
          }

          .swal2-container {
			      zoom: 1.5;
			    }
      </style>
    </head>

    <body class="hold-transition login-page">
	    <section class="content">
		    <div class="row">
		    	<div class="col-lg-3">
		    	</div>
		    	<div class="col-lg-6">
					<div class="box">
						<div class="box-header with-border" style="background-color: #f39c12; text-align: center;">
							<h3 class="box-title"><a href="../seguranca/login.php" style="color: white; font-size: 40px;">sigif2</a></h3>
						</div>
						<div class="box-body">
							<div class="row">
								<div class="col-lg-12" align="center">
									<h3><b>Termo de Uso</b></h3>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-12">
									<p style="text-align: justify;">
										Este documento busca esclarecer os direitos e obrigações do fornecedor e do usuário do Sistema de Investigação de Incapacidade Física em Menores de 15 anos (SIGIF2), bem como as condições da correta utilização do referido sistema.
									</p>
									<p style="text-align: justify;">
										Ao utilizar o SIGIF2 você se torna um USUÁRIO, e isso implica a aceitação plena e sem reserva de todos os itens do presente TERMO. Para aceitar o termo, ao final, clique em “Declaro que li e concordo com os termos e condições apresentados acima”. Caso não concorde com estes termos, clique em "Sair".
									</p>
									<h5><b>Como funciona?</b></h5>
									<p style="text-align: justify;">
										O Sistema SIGIF2 é um software público que atende as necessidades de modernização do processo de investigação de casos de hanseníase em menores de 15 anos com grau 2 de incapacidade física. O sistema é compartilhado sem ônus pelo link http://h-sigif2.aids.gov.br no portal do Ministério da Saúde (MS). O software é de responsabilidade do Departamento de Doenças de Condições Crônicas e Infecções Sexualmente Transmissíveis (DCCI). 
									</p>
									<h5><b>Cadastro de usuários</b></h5>
									<p style="text-align: justify;">
										O cadastramento do perfil das coordenações estaduais e municipais de saúde, bem como o cadastro dos profissionais lotados como usuários do sistema, é feito no próprio sistema SIGIF2. A responsabilidade de alimentação, atualização e monitoramento dos dados é da gestão nacional, estadual e municipal. Portanto, qualquer informação relacionada ao perfil das coordenações e usuários que estejam em desacordo com a realidade deverá ser adequada no SIGIF2.
									</p>
									<h5><b>Acessando o sistema</b></h5>
									<p style="text-align: justify;">
										O acesso ao sistema se dá única e exclusivamente por meio de LOGIN e SENHA. Estes são de seu uso pessoal e intransferível, devendo, portanto, o USUÁRIO do sistema tomar todas as medidas necessárias para manter em sigilo as referidas informações.
									</p>
									<h5><b>Proteção dos dados</b></h5>
									<p style="text-align: justify;">
										O Sistema SIGIF2 facilita a comunicação entre as coordenações nacional, estaduais e municipais de hanseníase, compartilhando informações por meio do sistema. Para isso, será necessário o aceite do presente TERMO. As informações a serem compartilhadas referem-se às registradas pelo usuário do sistema, na investigação de casos de hanseníase em menores de 15 anos com grau 2 de incapacidade física no diagnóstico.
									</p>
									<p style="text-align: justify;">
										É importante o esclarecimento e o consentimento por pelo menos um dos pais ou pelo responsável legal, em relação ao tratamento dos dados, informando o objetivo da coleta de dados. O consentimento deve ser registrado no prontuário, em texto livre, com data e hora, e assinatura com número do conselho profissional de quem atendeu o indivíduo. O profissional, deve esclarecer que os dados da investigação serão utilizados como parte das ações necessárias à execução, pela administração pública, de estratégias para redução da carga da hanseníase no Brasil.
									</p>
									<p style="text-align: justify;">
										Caso um dos pais ou o responsável opte por não compartilhar os dados do menor de 15 anos com GIF2, basta o registro da não autorização em prontuário. O profissional responsável pela investigação deverá comunicar a decisão a coordenação nacional e estadual de hanseníase.
									</p>
									<p style="text-align: justify;">
										O Sistema SIGIF2 mantém conduta de respeito à privacidade e, sobretudo, confidencialidade dos dados da investigação, nos termos dos códigos de éticas que regulamentam as profissões de saúde, da Lei Geral de Proteção de Dados, do Código Penal e de todas as normas brasileiras aplicáveis nesse contexto a Constituição Federal. Recomendamos que o USUÁRIO do sistema, ao acessá-lo, mantenha a conduta dentro dos parâmetros legais e éticos, mantendo o máximo de cuidado na proteção dos dados coletados. Após o LOGIN, todo registro feito pelo usuário do sistema será de sua responsabilidade.
									</p>
									<p style="text-align: justify;">
										O USUÁRIO do sistema é responsável pelos resultados obtidos por meio do uso de qualquer ferramenta deste software, inclusive aqueles decorrentes do uso indevido e da não execução dos processos complementares que garantam a segurança dos registros. Deverá realizar a guarda, a proteção e o tratamento dos dados do SIGIF2, seguindo as disposições presentes na Lei no. 13.709/2018. Ademais, realizar a anonimização e a desidentificação dos dados quando estes forem extraídos com a finalidade de gerar relatórios gerenciais.
									</p>
								</div>
							</div>
							<br>
							<form name="frm_termo" id="frm_termo" method="post">
								<input type="hidden" class="form-control" id="co_autorizado" name="co_autorizado" value="<?php echo $co_autorizado; ?>" />
								<div class="row">
									<div class="col-lg-12" align="center">
										<div class="form-group">
							               	<label class="checkbox-inline">
						                        <input type="checkbox" name="st_termo" id="st_termo" value="1">
						                            <small>Li e estou de acordo com <b>Termo de Uso e Política de Privacidade</b></small>
						                    </label>
							            </div>
							        </div>
								</div>
								<br>
								<div class="row">
									<div class="col-lg-4">
									</div>
									<div class="col-lg-4">
							            <div class="row">
							            	<div class="col-lg-12">
								                <div class="form-group">
								            		<input type="password" class="form-control" id="senha" name="senha" placeholder="nova senha">
								            	</div>
								            </div>
								        </div>
								        <div class="row">
								            <div class="col-lg-12">
								                <div class="form-group">
								                    <input type="password" class="form-control" id="senha1" name="senha1" placeholder="confirmar nova senha">
								                </div>
								            </div>
								        </div>
									    <div class="row">
									    	<div class="col-lg-12" align="right">
							                    <button name="alterar" id="alterar" class="btn btn-success" type="button">Salvar</button>
							                </div>
							            </div>
							   		</div>
							   		<div class="col-lg-4">
									</div>
								</div>
							</form>
						</div>
						<div class="box-footer">
							<div class="pull-right hidden-xs">
						        <b>SVS</b> Ministério da Saúde
						    </div>
						    Departamento de Doenças de Condições Crônicas e Infecções Sexualmente Transmissíveis - <strong>DCCI</strong>
						</div>
					</div>
				</div>
				<div class="col-lg-3">
		    	</div>
			</div>
		</section>
	</body>
</html>

	<script src="../bower_components/jquery/dist/jquery.min.js"></script>
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../plugins/iCheck/icheck.min.js"></script>
    <script src="../dist/js/bootbox.min.js"></script>
    <script language="JavaScript" type="text/JavaScript" src="../dist/js/jquery.maskedinput.min.js"></script>

	<script>

		$('#alterar').click(function () {

			co_autorizado 	= $('#co_autorizado').val();
			st_termo 		= $('#st_termo').val();
            senha 			= $('#senha').val();
            senha1 			= $('#senha1').val();

            
            if($("[name='st_termo']").filter(':checked').length === 0){
                Swal.fire({
                      title: 'Atenção!',
                      html: 'Favor ler e aceitar o <b>Termo</b>.',
                      icon: 'warning',
                      confirmButtonColor: '#337ab7'
                    });
                    return false;
            }

            if (senha == '' || senha1 == ''){
                Swal.fire({
                      title: 'Atenção!',
                      html: 'Preencha todos os campos para alterar a senha.',
                      icon: 'warning',
                      confirmButtonColor: '#337ab7'
                    });
                    return false;
            }

            if (senha != senha1){
                Swal.fire({
                  title: 'Atenção!',
                  html: '<small>Os campos <b>Nova senha</b> e <b>Confirmar nova senha</b> devem ser iguais.</small>',
                  icon: 'warning',
                  confirmButtonColor: '#337ab7'
                });
                return false;
            }

            if($("[name='senha']").val().length < 8){
				Swal.fire({
		            title: 'Atenção!',
		            html: 'A <b> nova senha</b> deve conter no mínimo 8 caracteres.',
		            icon: 'warning',
		            confirmButtonColor: '#337ab7'
		        });
				return false;
			}

            $.ajax({
                url: 'validaTermo.php'
                , type:'post'
                , data: $('#frm_termo').serialize()
                , success:function(xhr) {
                    $(location).attr('href', xhr.url);
                    Swal.fire({
                      title: 'Termo aceito com sucesso!',
                      html: 'Favor realizar login com a nova senha.',
                      icon: 'success',
                      confirmButtonColor: '#337ab7'
                    }).then(okay => {
                        if (okay) {
                        	location.href = '../index.php';
                        }
                    });
                },
                error: function(xhr){
                    alert(JSON.parse(xhr.responseText).message);
                }
            });
        });

	</script>

</body>
</html>
