<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<title>Register</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="author" content="Yuri">
	<meta name="editor" content="Sublime Text">
	<!-- <style type="text/css" href="style.css" /> -->
</head>

<body>

<?php
	function __autoload($class_name)
	{
    	include $class_name . '.php';
	}

	function register($nick, $pw)
	{
		$account = new account();
		return $account->createUser($nick, $pw);
	}

	if ($_POST['font-size'] == null)
	{
		$_POST['font-size'] = 10;
	}

	$showForm = true;

	if (($_POST['nick'] != null) && ($_POST['password'] != null) && ($_POST['password_confirm'] != null))
	{
		if ($_POST['password'] == $_POST['password_confirm'])
		{
			$result = register($_POST['nick'], $_POST['password']);

			if ($result === true || $result === 1)
			{
				$showForm = false;
				echo "success!";
			}

			else
			{
				echo "fail: ".$result;
			}
		}

		else
		{
			echo "passwords don't match";
		}
	}

	else if (($_POST['nick'] != null) xor ($_POST['password'] != null) xor ($_POST['password_confirm'] != null))
	{
		echo "field missing";
	}

	else
	{
		$_POST['font-size']+=2;
	}

	if ($showForm)
	{
?>

<p style="font-size:<?=$_POST['font-size']?>px;">please fill in the form</p>

<form method="POST" action="">
	<input type="text" name="nick" id="nick" <? ($_POST['nick'] == null)? print 'placeholder="Nick"' : print 'value="'.$_POST[nick].'"' ?>>
	<input type="password" name="password" id="password" placeholder="Password">
	<input type="password" name="password_confirm" id="password_confirm" placeholder="Confirm Password">
	<span style="display:none;"><input type="text" name="font-size" id="font-size" value="<?=$_POST['font-size']?>"></span>
	<input type="submit" value="register">
</form>

<?php
	}
?>

</body>
</html>