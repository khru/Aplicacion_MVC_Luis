<?php
class Helpers
{
	public static function chooseData($data, $input1, $input2)
	{
		if(isset($input1[$data])){
			return $input1[$data];
		}elseif(isset($input2[$data])){
			return $input2[$data];
		}else{
			return "";
		}
	}

	public static function br2nl($data)
	{
		return str_replace(["<br />", "<br>", "<br/>"], "\n", $data);
	}

	public static function nl2br($data)
	{
		return str_replace("\n", "<br />", $data);
	}

	public static function reName($dir, $name)
	{
		$exist_name = true;
		$filePathName = $dir . $name;
        while($exist_name){
            if(file_exists($filePathName)){
            	$nameArray = preg_split("/[\.]+/", $name);
            	$nameArray[0] = $nameArray[0] . "-" . mt_rand(1000, 9000);
            	$name = implode(".", $nameArray);
            	$filePathName = $dir . $name;
            }else{
            	$exist_name = false;
            }
        }
        return $name;
	}// reName()
}