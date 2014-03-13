<?php
	session_start();
	if ($_SESSION['verified'])
	{
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<title>New Entry</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="author" content="Yuri">
	<meta name="editor" content="Sublime Text">
	<!--<style type="text/css" href="style.css" />-->
</head>

<?php
	function __autoload($class_name)
	{
    	include $class_name . '.php';
	}

	$db = new db();
	$db->connect();

	$categories = mysql_query("select Category from Categories");
	$subcategories = mysql_query("select * from Subcategories left join Categories using (cID) order by Subcategories.cID");
	$priorities = mysql_query("select Priority from Priorities");
?>

<body>
	<form method="POST" action="post.php">
		<input type="text" name="title" id="title" placeholder="Name">
		<input type="text" name="link" id="link" placeholder="Link">
		<select name="category">
			<option disabled selected>--Category--</a>
			<?php
				$lastID = 0;

				while ($subcategory = mysql_fetch_array($subcategories))
				{
					$id = $subcategory[cID];

					if ($id != $lastID)
					{
						$category = mysql_fetch_array($categories);
						echo "<option disabled>---".$category[Category]."---</option>";
					}

					echo "<option value='".$subcategory[Subcategory]."'>".$subcategory[Subcategory]."</option>";

					$lastID = $id;
				}
			?>
		</select>
		<select name="priority">
			<option disabled selected>--Priority--</a>
			<?php
				while ($priority = mysql_fetcharray($priorities))
				{
					echo "<option value='".$priority[Priority]."'>".$priority[Priority]."</option>";
				}
			?>
		<input type="submit" value="post">
	</form>

<?php } ?>
</body>
</html>