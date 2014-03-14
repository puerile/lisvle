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

	include('header.php');

	if ($_POST['font-size'] == null)
	{
		$_POST['font-size'] = 10;
	}

	$showForm = true;

	// lots of spaghetti code here
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
				echo "<span class='alert'>fail: ".$result."</span>";
			}
		}

		else
		{
			echo "<span class='alert'>passwords don't match</span>";
		}
	}

	else if (($_POST['nick'] != null) xor ($_POST['password'] != null) xor ($_POST['password_confirm'] != null))
	{
		echo "<span class='alert'>field missing</span>";
	}

	// if someone tries to send an empty form, emphasise that we want it filled
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

	include('footer.php');
?>