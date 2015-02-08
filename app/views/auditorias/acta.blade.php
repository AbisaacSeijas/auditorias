@extends('layout.base')

@section('content')

<div class="panel panel-primary" style="overflow:auto;">
<div class="panel-heading center"><p align="center">Casos</p></div>
{{ Form::open(array('url' => 'auditorias/acta', 'method' => 'post', 'id' => 'form')) }}
<table id="acta_tabla" class="table table-striped table-bordered table-hover table-responsive">
	<thead>
		<tr>
			<th>Número de Orden</th>
			<th>Fecha de Notificación</th>
			<th>Fecha de Acta de Requerimiento</th>
			<th>Fecha de Recepción</th>
			<th>Fecha de Revisión Final</th>
			<th>Número de Acta Fiscal</th>
			<th>Resultado</th>
			<th>Monto</th>
			<th>Fecha de Notificación de Resultado</th>
			<th>Fecha de Revisión de Resolución</th>
			<th>Fecha de Notificación de Resolución</th>
			<th>Status</th>
		</tr>
	</thead>
	<tbody>
	@foreach ($audits as $audit)
		<tr>
			<td>{{{$audit->order_number}}}</td>
			<td>{{Form::input('date', 'notification_date', NULL, ['class' => 'form-control', 'id' => 'notification_date'])}}</td>
			<td>{{Form::input('date', 'requirement_date', NULL, ['class' => 'form-control', 'id' => 'requirement_date'])}}</td>
			<td>{{Form::input('date', 'reception_date', NULL, ['class' => 'form-control', 'id' => 'reception_date'])}}</td>
			<td>{{Form::input('date', 'final_review_date', NULL, ['class' => 'form-control', 'id' => 'final_review_date'])}}</td>
			<td></td>
			<td>{{Form::select('result', Auditoria::$resultados, NULL, ['class' => 'form-control', 'style' => 'width:100px', 'id' => 'result'])}}</td>
			<td>{{Form::input('number', 'amount', NULL, ['class' => 'form-control', 'id' => 'amount', 'style' => 'width:100px'])}}</td>
			<td>{{Form::input('date', 'result_notification_date', NULL, ['class' => 'form-control', 'id' => 'result_notification_date'])}}</td>
			<td>{{Form::input('date', 'resolution_review_date', NULL, ['class' => 'form-control', 'id' => 'resolution_review_date'])}}</td>
			<td>{{Form::input('date', 'resolution_notification_date', NULL, ['class' => 'form-control', 'id' => 'resolution_notification_date'])}}</td>
			<td></td>
		</tr>
	@endforeach
	</tbody>		
	</table>
{{ Form::close() }}
</div>
@stop

@section('scripts')
<script type="text/javascript">
	$(document).on('ready', function(){
		$('#acta_tabla').datatable();

		if($('#notification_date').val()==NULL){
			$('#requirement_date').hide();
		}
		if($('#requirement_date').val()==NULL){
			$('#reception_date').hide();
		}
		if($('#reception_date').val()==NULL){
			$('#final_review_date').hide();
		}
		if($('#final_review_date').val()==NULL){
			$('#result').hide();
		}
		if($('#result').val()==NULL){
			$('#amount').hide();
		}
		if($('#amount').val()==NULL){
			$('#result_notification_date').hide();
		}
		if($('#resolution_notification_date').val()==NULL){
			$('#resolution_review_date').hide();
		}
		if($('#resolution_review_date').val()==NULL){
			$('#resolution_notification_date').hide();
		}
	}
</script>
	
@stop