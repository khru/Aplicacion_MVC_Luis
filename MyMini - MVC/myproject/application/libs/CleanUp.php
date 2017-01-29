<?php
class CleanUp
{
	public static function clean($data)
	{
		return strip_tags(trim($data));
	}

	public static function secure($data, $fieldList)
	{
		foreach ($fieldList as $field) {
			if(!isset($data[$field])){
				$data[$field] = "";
			}
		}
		return $data;
	}

	public static function secureUrl($data)
	{
		$data = preg_replace('/[^A-Za-z0-9-.]+/','-',$data);
		return $data;

	}
}