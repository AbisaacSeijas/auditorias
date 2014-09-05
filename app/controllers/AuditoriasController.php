<?php 
	class AuditoriasController extends Basecontroller {
		public function orden()
		{
			return View::make('auditorias.orden');
		}

		public function save_orden()
		{
			$auditoria = new Auditoria();
    		$datos = Input::all();
    		//var_dump($datos);
    		$auditoria->id_tax='157247';
    		$auditoria->id_user='95';
    		$auditoria->fecha_asignacion=$datos['fecha_asignacion'];
    		$auditoria->motivo=$datos['motivo'];
    		$auditoria->observaciones=$datos['observaciones'];
    		$auditoria->save();

    	if($auditoria->save()){
    			return Redirect::to('auditorias/orden')->with('message', '¡Registro Exitoso!');
    		}
    	else{
    			return Redirect::to('auditorias/orden')->with('message', '¡Registro Fallido!');
    		}
		}

	}

