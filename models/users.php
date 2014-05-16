<?php

class Users extends Model
{
	protected static $_table_name = 'users';
	protected static $_properties = array(
		'id' => array(
			'type' => 'int',
		),
		'username' => array(
			'type' => 'varchar',
		),
		'mail' => array(
			'type' => 'varchar',
		),
		'password' => array(
			'type' => 'varchar',
		),
		'self_promotion' => array(
			'type' => 'text',
		),
		'created_at' => array(
			'type' => 'datetime',
		),
		'updated_at' => array(
			'type' => 'datetime',
		),
	);

	public function create ()
	{
		if (! $this->is_new()) return false;

		$sql = sprintf("INSERT INTO (%s) VALUES (%s);");
	}
}
