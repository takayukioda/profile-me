<?php
class Input
{
	public static function post ($key, $default = null)
	{
		if (! isset($_POST[$key])) return $default;
		$val = $_POST[$key];
		if (! is_string($val)) return $default;
		return $val;
	}
}
