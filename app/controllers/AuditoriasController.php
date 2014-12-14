<?php 
	class AuditoriasController extends Basecontroller {
		public function orden()
		{
			return View::make('auditorias.orden');
		}

		public function save_orden()
		{
			$status = new Status();
			$audit_status= new AuditStatus();
			$auditoria = new Auditoria();
    		$datos = Input::all();
    		var_dump($datos);
    		/*
            $field = Input::get('tipo_cuenta');
            if($field!='no_account'){
           		$tax = Tax::where($field, Input::get($field))->first();
    			$auditoria->id_tax = $tax->id;
    		}
    		$auditoria->id_user='1';
    		$auditoria->assingment_date=$datos['assingment_date'];
    		$auditoria->reason=$datos['reason'];
    		$auditoria->observ=$datos['observ'];


		try
		{
			DB::transaction(function() use ($auditoria)
			{
				$auditoria->save();			
			});

			return Redirect::to('auditorias/orden')->with('message', '¡Registro Exitoso!');

		}
		catch (Exception $e)
		{

			return Redirect::to('auditorias/orden')->with('message', '¡Registro Fallido!');
		}*/
	}


		public function ajax_tax()
		{
			/*
			Return Tax::with(['taxpayer' ,'taxClassifier'])
			->where(Input::get('tipo'),Input::get('valor'))
			->first();
			*/
			return Tax::with(['taxpayer.telefonos','taxClassifier'])
			->where(Input::get('tipo'),Input::get('valor'))
			->first();
		}
	}


