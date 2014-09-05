<?php

use LaravelBook\Ardent\Ardent;

class Auditoria extends Ardent{

	public $table = 'tecnologia.auditoria';

	public $throwOnValidation = true;

	public static $rules = array();

	public $timestamps = false;

	public static $motivos= array('ranking' => 'Ranking', 'asesoria_legal' => 'Asesoría Legal', 'actividades_economicas' => 'Actividades Económicas', 'despacho' => 'Despacho');

}