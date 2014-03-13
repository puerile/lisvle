<?php
	class account
	{
		function __autoload($class_name)
		{
    		include $class_name . '.php';
		}

		function createUser($nick, $password)
		{
			$db = new db();
			$db->connect();

			$length = 30;

			$crypto = new crypto();

			$salt = $crypto->salt($length);
			$hash = $crypto->hash($password,$salt);

			// $hash = password_hash($password, PASSWORD_DEFAULT);

			$pwQuery = "insert into Users (Nick,Password,Salt) values ('".mysql_real_escape_string($nick)."','".mysql_real_escape_string($hash)."','".mysql_real_escape_string($salt)."')";

			mysql_query($pwQuery);
			$result = mysql_error();

			if ($result != "")
			{
				return $result;
			}

			else
			{
				return true;
			}
		}

		function login($user, $password)
		{
			if (checkPW($user, $password))
			{
				echo "kekse!";
			}
		}

		function checkPW($nick, $password)
		{
			$db = new db();
			$db->connect();

			$crypto = new crypto();
			$pwQuery = "select Password, Salt from Users where Nick = '".mysql_real_escape_string($nick)."'";

			$user = mysql_query($pwQuery);

			$row = mysql_fetch_array($user);

			// password_verify($password, $row[Password]);

			if ($row["Password"] == $crypto->hash($password, $row["Salt"]))
			{
				return true;
			}

			else
			{
			 	return false;
			}
		}
	}
?>