<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">  
	<title>FEDIA</title>
	<meta name="description" content="">
	<meta name="author" content="templatemo">
    <!-- 
    Visual Admin Template
    http://www.templatemo.com/preview/templatemo_455_visual_admin
-->
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,700' rel='stylesheet' type='text/css'>
<link href="/css/font-awesome.min.css" rel="stylesheet">
<link href="/css/bootstrap.min.css" rel="stylesheet">
<link href="/css/templatemo-style.css" rel="stylesheet">
<link href="/css/chosen.css" rel="stylesheet">
<link rel="icon" href="/images/logo.png">

<!-- jQuery -->
<script src="/js/jquery-1.11.2.min.js" type="text/javascript"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

</head>
<body>  
	<!-- Left column -->
	<div class="templatemo-flex-row">
		<div class="templatemo-sidebar">
			<header class="templatemo-site-header">
				<!-- <div class="square"></div> -->
				<div class="logo"><img src="/images/logo.png"></div>
				<h1>FEDIA</h1>
			</header>
			<!-- <div class="profile-photo-container">
				<img src="images/profile-photo.jpg" alt="Profile Photo" class="img-responsive">  
				<div class="profile-photo-overlay"></div>
			</div>       -->
			<!-- Search box -->
			@if(Auth::check())
			<div class="mobile-menu-icon">
				<i class="fa fa-bars"></i>
			</div>
			<nav class="templatemo-left-nav">          
				<ul>
					<li><a href="/" class="@if(Request::is('/')) active @endif"><i class="fa fa-home fa-fw"></i>Início</a></li>
					<li class="submenu elencos">
						<a href="#"><i class="fa fa-users fa-fw"></i>Jogadores <i class="caret-down fa fa-arrow-circle-down"></i></a>
						<ul>
							<li><a href="/elencos" class="@if(Request::is('elencos*')) active @endif">Todos os Elencos</a></li>
							<li><a href="/jogadores" class="@if(Request::is('jogadores*')) active @endif">Todos os Jogadores</a></li>
							<li><a href="/calcula_valor" class="@if(Request::is('calcula_valor*')) active @endif">Calcular Valor</a></li>
						</ul>
					</li>
					<li><a href="/noticias" class="@if(Request::is('noticias*')) active @endif"><i class="fa fa-newspaper-o fa-fw"></i>Notícias</a></li>
					<li><a href="/financeiros" class="@if(Request::is('financeiros*')) active @endif"><i class="fa fa-money fa-fw"></i>Histórico Financeiro</a></li>
					<li><a href="/transferencias" class="@if(Request::is('transferencias')) active @endif"><i class="fa fa-exchange fa-fw"></i>Transferências</a></li>
					<li class="submenu partidas">
						<a href="#"><i class="fa fa-gamepad"></i> Partidas <i class="caret-down fa fa-arrow-circle-down"></i></a>
						<ul>
							<li><a href="/partidas_time" class="@if(Request::is('partidas_time*')) active @endif">Calendário de Partidas</a></li>
							<li><a href="/amistosos?tipo=0" class="@if(Request::is('amistosos*') && $tipo == 0) active @endif">Amistosos</a></li>
							<li><a href="/amistosos?tipo=1" class="@if(Request::is('amistosos*') && $tipo == 1) active @endif">Classificatória da Copa FEDIA</a></li>
							<li><a href="/amistosos?tipo=2" class="@if(Request::is('amistosos*') && $tipo == 2) active @endif">SuperCopa FEDIA</a></li>
							<li><a href="/partidas?tipo=liga" class="@if(Request::is('partidas*') && @$tipo == 'liga') active @endif">Liga FEDIA</a></li>
							<li><a href="/partidas?tipo=copa" class="@if(Request::is('partidas*') && @$tipo == 'copa') active @endif">Copa FEDIA</a></li>
						</ul>
					</li>
					<li><a href="{{ url('artilharia') }}" class="@if(Request::is('artilharia')) active @endif"><i class="fa fa-soccer-ball-o"></i>Artilharia</a></li>
					<li><a href="/partidas_temporadas" class="@if(Request::is('partidas_temporadas')) active @endif"><i class="fa fa-list fa-fw"></i>Temporadas</a></li>
					<li><a href="/indisponiveis" class="@if(Request::is('indisponiveis')) active @endif"><i class="fa fa-ambulance fa-fw"></i>Cartões e Lesões</a></li>
					<li class="submenu legislacao">
						<a href="#"><i class="fa fa-check-square"></i> Legislação <i class="caret-down fa fa-arrow-circle-down"></i></a>
						<ul>
							<li><a href="/legislacao/premiacoes" class="@if(Request::is('legislacao/premiacoes')) active @endif">Premiações</a></li>
							<li><a href="/legislacao/regras"  target="_blank">Regras</a></li>
						</ul>
					</li>
					<li><a href="/users" class="@if(Request::is('users')) active @endif"><i class="fa fa-users fa-fw"></i>Usuários</a></li>
					@if(Auth::user()->isAdmin())
					<li class="submenu admin">
						<a href="#"><i class="fa fa-user-secret"></i> Administração <i class="caret-down fa fa-arrow-circle-down"></i></a>
						<ul>
							<li><a href="/administracao/eras" class="@if(Request::is('administracao/eras')) active @endif">Eras</a></li>
							<li><a href="/administracao/multa_create" class="@if(Request::is('administracao/multa_create')) active @endif">Aplicar Multa</a></li>
							<li><a href="/administracao/ausencia_create" class="@if(Request::is('administracao/ausencia_create')) active @endif">Ausências</a></li>
							<li><a href="/administracao/wo_create" class="@if(Request::is('administracao/wo_create')) active @endif">Aplicar WO</a></li>
							<li><a href="/administracao/copa_create" class="@if(Request::is('administracao/copa_create')) active @endif">Gerenciar Copa FEDIA</a></li>
						</ul>
					</li>
					@endif
					<li><a href="javascript:;" data-toggle="modal" data-target="#confirmModal"><i class="fa fa-eject fa-fw"></i>Sair</a></li>
				</ul>  
			</nav>
			@endif
		</div>
		<!-- Main content --> 
		<div class="templatemo-content col-1 light-gray-bg">
			@if(Auth::check())
			<div class="templatemo-top-nav-container">
				<div class="row">
					<nav class="templatemo-top-nav col-lg-4 col-md-4 col-xs-12 form-group">
						<ul class="text-uppercase">
							<li><a href="{{ route('users.edit', ['id' => Auth::user()->id, 'config' => 'true']) }}" @if(!empty($config))class="active" @endif>Configurações</a></li>
							<li><a href="javascript:;" data-toggle="modal" data-target="#confirmModal">Sair</a></li>
						</ul>  
					</nav>
					<div class="col-md-4 col-xs-12">
						{!! Form::open(['route' => ['administracao.eras.change', @Session::get('era')->id], 'method' => 'post', 'class' => 'form-horizontal']) !!}
						<div class="input-group">
							<div class="input-group-addon">Era: </div>
							{!! Form::select('id', get_eras(), @Session::get('era')->id, ['class' => 'form-control']) !!}
							<span class="input-group-btn">
								<button type="submit" class="btn btn-info search-button"><i class="fa fa-check"></i></button>
							</span>
						</div>
						{!! Form::close() !!}
					</div>
					<div class="col-md-4 col-xs-12 user_online"><span>Olá {{ Auth::user()->nome }}!</span></div>
				</div>
			</div>
			@endif
			<div class="templatemo-content-container">
				@yield('content')
				<footer class="text-right">
					<p>
						Copyright &copy; 2018 I9 Technology
						<a href="http://www.i9technology.com.br" target="_blank">
							{!! Html::image("/images/logo.png", "I9 Technology", ['id' => 'logo']) !!}
						</a>
					</p>
				</footer>         
			</div>
		</div>
	</div>

	<!-- Modals -->
	<div class="modal fade" id="confirm_delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Deseja realmente excluir este registro?</h4>
				</div>
				<div class="modal-footer">
					{!! Form::open(['route' => null, 'method' => 'delete', 'id' => 'form-delete']) !!}
					@if(isset($responsavel)) <input type="hidden" name="responsavel" value="true"> @endif
					<button type="submit" class="btn btn-danger">Sim</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Deseja realmente sair do sistema?</h4>
				</div>
				<div class="modal-footer">
					<a href="/auth/logout" class="btn btn-primary">Sim</a>
					<button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
				</div>
			</div>
		</div>
	</div>

	<!-- JS -->
	<script src="/js/jquery.mask.min.js"></script>
	<script src="/js/jquery-migrate-1.2.1.min.js"></script>
	<script src="/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="/js/bootstrap-filestyle.min.js"></script>  <!-- http://markusslima.github.io/bootstrap-filestyle/ -->
	<script type="text/javascript" src="/js/templatemo-script.js"></script>
	<script src="/js/chosen.js" type="text/javascript"></script>
	<script src="/js/collapse.js" type="text/javascript"></script>
	<script src="/js/transition.js" type="text/javascript"></script>
	@if(Request::is('legislacao*')) <script type="text/javascript">$('.submenu.legislacao > a').trigger( "click" );</script> @endif
	@if(Request::is('administracao*')) <script type="text/javascript">$('.submenu.admin > a').trigger( "click" );</script> @endif
	@if((Request::is('partidas*') || Request::is('amistosos*')) && !Request::is('partidas_temporadas*')) <script type="text/javascript">$('.submenu.partidas > a').trigger( "click" );</script> @endif 
	@if(Request::is('elencos*') || Request::is('jogadores*') || Request::is('calcula_valor*')) <script type="text/javascript">$('.submenu.elencos > a').trigger( "click" );</script> @endif
	<script type="text/javascript">
		$(".chzn-select").chosen();
		$('.collapse').collapse();
		$(".chzn-container-multi").each(function( index ) {
			$tamanho = $(this).width();
			$(this).width('100%');
			$(this).find(".chzn-drop").width(($tamanho-2)+"%");
		});
	</script>
</body>
</html>