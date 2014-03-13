<?php
	class crypto
	{
		function salt($length)
		{
			$ascii_start = 33;
			$ascii_end = 126;
			$salt = "";

		 	for ($i=0; $i<$length; $i++)
		 	{
		 		$salt .= chr(rand($ascii_start,$ascii_end));
			}

			return $salt;
		}

		function hash($text, $salt)
		{
			return hash("sha512",(hash("sha512",$text).$salt));
		}
	}
?>