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
    		#var_dump($datos); exit;
            $field = Input::get('tipo_cuenta');
            $tax = Tax::where($field, Input::get($field))->first();
            #var_dump($tax); exit;
    		$auditoria->id_tax = $tax->id;
    		$auditoria->id_user='1';
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

