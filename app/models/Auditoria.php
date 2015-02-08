<?php

use LaravelBook\Ardent\Ardent;

class Auditoria extends Ardent{

	public $table = 'audit.audits';

	public $throwOnValidation = true;

	public static $rules = array();

	public static $motivos= array('ranking' => 'Ranking', 'asesoria_legal' => 'Asesoría Legal', 'actividades_economicas' => 'Actividades Económicas', 'despacho' => 'Despacho');
	public static $resultados= array('repair' => 'Reparo', 'finiquito' => 'Finiquito', 'crédito' => 'Crédito');

}