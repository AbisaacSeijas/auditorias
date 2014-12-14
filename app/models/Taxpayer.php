<?php

use LaravelBook\Ardent\Ardent;

class Taxpayer extends Ardent {

	public $table = 'public.taxpayer';

	public $throwOnValidation = true;

	public static $rules = array();

	public function taxes()
	{
		return $this->hasMany('Tax', 'id_taxpayer');
	}

	public function telefonos()
	{
		return $this->hasMany('InfTaxpayer', 'id_taxpayer')->where('id_inf_contact_type', '1');
	}
/*
	public static $relationsData = array(
	    'taxes' => array(self::HAS_MANY, 'Tax', 'id_taxpayer'),
	    #'orders'  => array(self::HAS_MANY, 'Order'),
	    #'groups'  => array(self::BELONGS_TO_MANY, 'Group', 'table' => 'groups_have_users')
	);
*/
}