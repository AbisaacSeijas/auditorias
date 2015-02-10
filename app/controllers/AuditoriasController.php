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
            $field = Input::get('tipo_cuenta2');
            if($field!='no_account'){
           		$tax = Tax::where($field, Input::get($field))->first();
    			$auditoria->id_tax = $tax->id;
    		}
    		$auditoria->id_user='1';
    		$auditoria->assingment_date=$datos['assingment_date'];
    		$auditoria->reason=$datos['reason'];
    		$años="{". implode(",", $datos['fiscal_years']) . "}";
    		$auditoria->fiscal_years=$años;
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
				}
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

		public function acta()
			{
				$audits=AuditData::all();
				return View::make('auditorias.acta')->with("audits", $audits);
			}

		public function save_acta()
			{
				$audit_status= new AuditStatus();
				$datos=Input::all();
				/*OBTENER EL STATUS DE LA AUDITORIA*/
				$status=AuditStatus::$status;
				$id_status=$status[$datos['status']];
				/*INSERTAMOS LA DATA*/
				$audit_status->id_audit=$datos['id_audit'];
				$audit_status->id_status=$id_status;
				$audit_status->date=$datos['date'];
				$audit_status->observation=$datos['observation'];
				try
				{
					DB::transaction(function() use ($audit_status)
					{
						$audit_status->save();			
					});

					return Redirect::to('auditorias/acta')->with('message', '¡Registro Exitoso!');

				}
				catch (Exception $e)
				{

					return Redirect::to('auditorias/acta')->with('message', '¡Registro Fallido!');
				}
			}
	}