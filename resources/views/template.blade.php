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
			<div class="mobile-menu-icon">
				<i class="fa fa-bars"></i>
			</div>
			<nav class="templatemo-left-nav">          
				<ul>
					<li><a href="/" class="@if(Request::is('/')) active @endif"><i class="fa fa-home fa-fw"></i>Início</a></li>
					<li><a href="/financeiros" class="@if(Request::is('financeiros')) active @endif"><i class="fa fa-money fa-fw"></i>Histórico Financeiro</a></li>
					@if(Auth::user()->isAdmin())
					<li class="submenu">
						<a href="#"><i class="fa fa-user-secret"></i> Administração <i class="caret-down fa fa-arrow-circle-down"></i></a>
						<ul>
							<li><a href="/administracao/users" class="@if(Request::is('administracao/users')) active @endif"><i class="fa fa-users fa-fw"></i>Usuários</a></li>
							<li><a href="/administracao/transferencias" class="@if(Request::is('administracao/transferencias')) active @endif"><i class="fa fa-money fa-fw"></i>Transferências</a></li>
							<li><a href="/administracao/partidas?tipo=liga" class="@if(Request::is('administracao/partidas') && $tipo == 'liga') active @endif"><i class="fa fa-gamepad fa-fw"></i>Liga FEDIA</a></li>
							<li><a href="/administracao/partidas?tipo=copa" class="@if(Request::is('administracao/partidas') && $tipo == 'copa') active @endif"><i class="fa fa-gamepad fa-fw"></i>Copa FEDIA</a></li>
							<li><a href="/administracao/temporadas" class="@if(Request::is('administracao/temporadas')) active @endif"><i class="fa fa-list fa-fw"></i>Temporadas</a></li>
							<li><a href="/administracao/indisponiveis" class="@if(Request::is('administracao/indisponiveis')) active @endif"><i class="fa fa-ambulance fa-fw"></i>Cartões e Lesões</a></li>
						</ul>
					</li>
					@else
					<li><a href="/administracao/partidas?tipo=liga" class="@if(Request::is('administracao/partidas') && $tipo == 'liga') active @endif"><i class="fa fa-gamepad fa-fw"></i>Liga FEDIA</a></li>
					<li><a href="/administracao/partidas?tipo=copa" class="@if(Request::is('administracao/partidas') && $tipo == 'copa') active @endif"><i class="fa fa-gamepad fa-fw"></i>Copa FEDIA</a></li>
					@endif
					<li><a href="javascript:;" data-toggle="modal" data-target="#confirmModal"><i class="fa fa-eject fa-fw"></i>Sair</a></li>
				</ul>  
			</nav>
		</div>
		<!-- Main content --> 
		<div class="templatemo-content col-1 light-gray-bg">
			<div class="templatemo-top-nav-container">
				<div class="row">
					<nav class="templatemo-top-nav col-lg-8 col-md-8 col-xs-12 form-group">
						<ul class="text-uppercase">
							<li><a href="{{ route('administracao.users.edit', ['id' => Auth::user()->id, 'config' => 'true']) }}" @if(!empty($config))class="active" @endif>Configurações</a></li>
							<li><a href="javascript:;" data-toggle="modal" data-target="#confirmModal">Sair</a></li>
						</ul>  
					</nav>
					<div class="col-md-4 col-xs-12 user_online"><span>Olá {{ Auth::user()->nome }}!</span></div>
				</div>
			</div>
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
	@if(Request::is('administracao*')) <script type="text/javascript">$('.submenu > a').trigger( "click" );</script> @endif
	<script type="text/javascript">
		$(".chzn-select").chosen();
	</script>
</body>
</html>