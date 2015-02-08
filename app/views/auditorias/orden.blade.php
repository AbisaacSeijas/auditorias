@extends('layout.base')

@section('content')
@if (Session::has('message'))
	<div class="alert alert-success">{{Session::get('message');}}</div>
@endif
	<?php
		$fecha=(integer)date('Y');
		for($i=0;$i<10;$i++){
			$fechas[$fecha]=$fecha;
			$fecha--;
		}
	?>
{{ Form::open(array('url' => 'auditorias/orden', 'method' => 'post', 'id' => 'form')) }}
<div class="panel panel-primary" style="overflow:scroll;">
<div class="panel-heading center"><p align="center">Cargar Orden</p></div>
	<ul class="list-group">
		<li class="list-group-item">
			<div class="row">
				<div class="col-md-6"><strong>Tipo de Cuenta</strong></div>
				<div class="col-md-6">
					<ul class="list-group">
						<li class="list-group-item">
							{{Form::select('tipo_cuenta', array('tax_account_number' => 'Cuenta Nueva', 'rent_account' => 'Cuenta Renta', 'no_account' => 'Sin Cuenta'), NULL, ['class' => 'form-control disable' , 'id' => 'tipo_cuenta' ])}}
						</li>
						<li class="list-group-item">
								{{Form::text('tax_account_number', NULL, ['class' => 'form-control disable', 'id' => 'tax_account_number'])}}
								{{Form::text('rent_account', NULL, ['class' => 'form-control disable', 'id' => 'rent_account', 'style' => 'display : none'])}}
						</li>			
					</ul>
				</div>
			</div>
			<li class="list-group-item" id="boton">
				<div class="row">
					<div class="col-md-6"><p align="right">{{Form::button('Consultar', ['id' => 'botonEnviar'])}}</p></div>
				</div>
			</li>
		</li>
		<div id="formulario" style="display:none">
			<li class="list-group-item">
				<div class="row">
					<div class="col-md-6"><strong>Razón Social</strong></div>
					<div class="col-md-6" id="razon"></div>
				</div>
			</li>
			<li class="list-group-item">
				<div class="row">
					<div class="col-md-6"><strong>Actividades</strong></div>
					<div class="col-md-6" id="actividades"></div>
				</div>
			</li>
			<li class="list-group-item">
				<div class="row">
					<div class="col-md-6"><strong>Dirección</strong></div>
					<div class="col-md-6" id="direccion"></div>
				</div>
			</li>
			<li class="list-group-item">
				<div class="row">
					<div class="col-md-6"><strong>Teléfono</strong></div>
					<div class="col-md-6" id="telefono"></div>
				</div>
			</li>
		</div>
		<div id="formulario2" style="display:none">
			<li class="list-group-item">
				<div class="row">
					<div class="col-md-6"><strong>Fecha de Asignación</strong></div>
					<div class="col-md-6">{{Form::input('date', 'assingment_date', NULL, ['class' => 'form-control', 'id' => 'fecha_asignacion'])}}
					{{Form::input('hidden', 'tipo_cuenta2', NULL, ['class' => 'form-control', 'id' => 'tipo_cuenta2'])}}
					</div>
				</div>
			</li>
			<li class="list-group-item">
				<div class="row">
					<div class="col-md-6"><strong>Motivo de la Auditoria</strong></div>
					<div class="col-md-6">{{Form::select('reason', Auditoria::$motivos, NULL, ['class' => 'form-control'])}}</div>
				</div>
			</li>
			<li class="list-group-item">
				<div class="row">
					<div class="col-md-4"><strong>Años a Auditar</strong></div>
					<div class="col-md-4">
						{{Form::select('fiscal_years[]', array(), NULL, ['multiple'=> 'multiple', 'class' => 'form-control', 'size' => '5', 'id' =>'fiscal_years'])}}
						{{Form::button('Eliminar', ['id' => 'botonEliminar'])}}
					</div>
					<div class="col-md-4">
						{{Form::select('years2', $fechas, NULL, ['class' => 'form-control', 'size' => '5', 'id' => 'years2'])}}
						{{Form::button('Agregar', ['id' => 'botonAgregar'])}}
					</div>
				</div>
			</li>
			<li class="list-group-item">
				<div class="row">
					<div class="col-md-6"><strong>Observaciones</strong></div>
					<div class="col-md-6">{{Form::textarea('observ', NULL, ['class' => 'form-control'])}}</div>
				</div>
			</li>
		<li class="list-group-item" id="boton3">
			<div class="row">
				<div class="col-md-6"><p align="right">{{Form::submit('Enviar', ['id' => 'submit'])}}</p></div>
			</div>
		</div>
	</ul>
</div>
{{ Form::close() }}
@stop

@section('scripts')

<script>
	$(document).on('ready', function(){
		$('#tipo_cuenta').on('change', function(){
			if($('#tipo_cuenta option:selected').attr('value')=='tax_account_number'){
				$('#rent_account').hide();
				$('#rent_account').val("");
				$('#tax_account_number').show();
				$('#boton').css('display', 'block');
				$('#formulario2').css('display', 'none');

			}
			else if($('#tipo_cuenta option:selected').attr('value')=='no_account'){
				$('#tax_account_number').hide();
				$('#tax_account_number').val("");
				$('#rent_account').hide();
				$('#rent_account').val("");
				$('#boton').css('display', 'none');
				$('#formulario2').show('8000');
			}
			else{
				$('#tax_account_number').hide();
				$('#tax_account_number').val("");
				$('#rent_account').show();
				$('#boton').css('display', 'block');
				$('#formulario2').css('display', 'none');
			}
		});

		$('#botonEnviar').on('click', function(){
			if($('#fecha_asignacion').val()==""){
				var tipo=$('#tipo_cuenta').val();
				var datos={'tipo':tipo, 'valor': $('#' + tipo).val()};
				$.getJSON(base_url + '/auditorias/ajax_tax', datos, function(data){
					if(data){
						$('.disable').attr('disabled', 'true');
						$('#formulario').show('8000');
						$('#formulario2').show('8000');
						$('#boton3').css('display', 'block');
						$('#boton').css('display', 'none');
						$('#razon').text(data.taxpayer.firm_name);
						$('#direccion').text(data.address);
						var html="<ul>";
						for(var i in data.tax_classifier){
							html += "<li>" + data.tax_classifier[i].name + '</li>';
						}
						$('#actividades').append(html + '</ul>');
						html="<ul>";
						for(var h in data.taxpayer.telefonos){
							html += "<li>" + data.taxpayer.telefonos[h].value + '</li>';
						}
						$('#telefono').append(html + '</ul>');
					}
				});
			}
		});

		$('#botonAgregar').on('click', function(){
			$('#years2 option:selected').appendTo('#fiscal_years');
		});
		$('#botonEliminar').on('click', function(){
			$('#fiscal_years option:selected').appendTo('#years2');
		});

		$('#submit').on('click', function(){
			var options = new Array();
			var tax=$('#tipo_cuenta option:selected').val();
			$('#tipo_cuenta2').val(tax);
			$('#fiscal_years option').each(function(){
         		$(this).html("selected", "true");
     		});
		});
	});
</script>

@stop