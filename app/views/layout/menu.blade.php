<div class="row affix-row">
	<div class="col-sm-3 col-md-2 affix-sidebar">
		<div class="sidebar-nav">
			<div class="navbar navbar-inverse" role="navigation">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-navbar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<span class="visible-xs navbar-brand">Menu principal</span>
				</div>
				<div class="navbar-collapse collapse sidebar-navbar-collapse">
					<ul class="nav navbar-nav" id="menu-principal">
						<li class="active">
							<a href="{{url('/')}}" data-parent="#menu-principal" class="collapsed">
								<h4><small>AUDITORIAS</small></h4>
							</a>
						</li>
						<li>
							<a href="#" data-toggle="collapse" data-target="#auditorias" data-parent="#auditorias" class="collapsed">
								<span class="glyphicon glyphicon-zoom-in"></span>Auditorias</a><span class="caret pull-right"></span>
							</a>
							<div class="collapse" id="auditorias" style="height: 0px;">
								<ul class="nav nav-list">
									<li class="text-right"><a href="{{url('auditorias/orden')}}"><span class="glyphicon glyphicon-list-alt"></span>Orden</a></li>
									<li class="text-right"><a href="{{url('auditorias/acta')}}"><span class="glyphicon glyphicon-list"></span>Actas</a></li>
								</ul>
							</div>
						</li>
						<li>
							<a href="#" data-toggle="collapse" data-target="#usuarios" data-parent="#usuarios" class="collapsed">
								<span class="glyphicon glyphicon-user"></span>Usuarios</a><span class="caret pull-right"></span>
							</a>
							<div class="collapse" id="usuarios" style="height: 0px;">
								<ul class="nav nav-list">
									<li class="text-right"><a href="#"><span class="glyphicon glyphicon-plus"></span>Nuevo</a></li>
									<li class="text-right"><a href="#"><span class="glyphicon glyphicon-user"></span>Usuarios</a></li>
								</ul>
							</div>
						</li>
					</ul>
				</div><!--/.nav-collapse -->
			</div>
		</div>
	</div>
	<div class="col-sm-9 col-md-10 affix-content">
		<div class="container">
			@yield('content')
		</div>
	</div>
</div>