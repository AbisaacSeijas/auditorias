@extends('layout.base')

@section('content')
@if (Session::has('message'))
	<div class="alert alert-success">{{Session::get('message');}}</div>
@endif
{{ Form::open(array('url' => 'auditorias/acta', 'method' => 'post', 'id' => 'form')) }}
	<div class="panel panel-primary" style="overflow:auto;">
		<div class="panel-heading center"><p align="center">Casos</p></div>		
			<table id="acta_tabla" class="table table-striped table-bordered table-hover table-responsive" style="text-align:center;">
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
					<tr data-id-audit="{{$audit->id}}" class="tr_audit">
						<td>
							{{{$audit->order_number}}}
						</td>
						<td>
							{{Form::input('date', 'notification_date', $audit->date_notification, ['class' => 'form-control modal-date', 'id' => 'Fecha de Notificación'])}}
						</td>
						<td>
						@if ($audit->date_notification!=NULL)
							{{Form::input('date', 'requirement_date', $audit->date_requirement, ['class' => 'form-control modal-date', 'id' => 'Fecha de Acta de Requerimiento'])}}
						@endif
						</td>
						<td>
						@if ($audit->date_requirement!=NULL)
							{{Form::input('date', 'reception_date', $audit->date_reception, ['class' => 'form-control modal-date', 'id' => 'Fecha de Recepción'])}}
						@endif
						</td>
						<td>
						@if ($audit->date_reception!=NULL)
							{{Form::input('date', 'final_review_date', $audit->date_final_review, ['class' => 'form-control modal-date', 'id' => 'Fecha de Revisión Final'])}}
						@endif
						</td>
						<td>
							{{{$audit->fiscal_act_number}}}
						</td>
						<td>
						@if ($audit->fiscal_act_number!=NULL)
							{{Form::select('result', Auditoria::$resultados, NULL, ['class' => 'form-control', 'style' => 'width:100px', 'id' => 'result'])}}
						@endif
						</td>
						<td>
						@if ($audit->fiscal_act_number!=NULL)
							{{Form::input('number', 'amount', $audit->amount, ['class' => 'form-control', 'id' => 'amount', 'style' => 'width:100px'])}}
						@endif
						</td>
						<td>
						@if ($audit->amount!=NULL)
							{{Form::input('date', 'result_notification_date', $audit->date_result_notification, ['class' => 'form-control', 'id' => 'result_notification_date'])}}
						@endif
						</td>
						<td>
						@if ($audit->date_result_notification!=NULL)
							{{Form::input('date', 'resolution_review_date', $audit->date_resolution_review, ['class' => 'form-control', 'id' => 'resolution_review_date'])}}
						@endif
						</td>
						<td>
						@if ($audit->date_resolution_review!=NULL)
							{{Form::input('date', 'resolution_notification_date', $audit->date_resolution_notification, ['class' => 'form-control', 'id' => 'resolution_notification_date'])}}
						@endif
						</td>
						<td></td>
					</tr>
				@endforeach
				</tbody>	
			</table>
	</div>
{{ Form::close() }}	
<div id="modal-obsrv" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
		    <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="title"></h4>
		     </div>
		     {{ Form::open(array('url' => 'auditorias/acta', 'method' => 'post', 'id' => 'form2')) }}
		     <div class="modal-body">
		     	{{Form::input('hidden', 'id_audit',  NULL, ['class' => 'form-control', 'id' => 'id_audit'])}}
		     	{{Form::input('hidden', 'status',  NULL, ['class' => 'form-control', 'id' => 'id_status'])}}
		        {{Form::input('date', 'date', NULL, ['class' => 'form-control', 'id' => 'date', 'readonly' => 'readonly'])}}
		        <h4>Observaciones</h4>
		        {{Form::textarea('observation', NULL, ['class' => 'form-control', 'id' => 'observation'])}}            
		    </div>		
		    <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary submit">Guardar Cambios</button>
		    </div>
		    {{ Form::close() }}	
		</div>
    </div>
</div>
@stop

@section('scripts')
<script>
	$(document).on('ready', function(){
		$('.modal-date').on('change', function(){
			if($(this).val()!=""){
				var id_audit=$(this).parents('tr.tr_audit').data('id-audit');
				$('#id_audit').val(id_audit);
				$('#id_status').val($(this).attr('name'));		
				$('#title').html($(this).attr('id'));
				$('#date').val($(this).val());
				$('#observation').val("");
				$('#modal-obsrv').modal('toggle');
			}
		})
	});
</script>
@stop