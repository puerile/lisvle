<?php
	function __autoload($class_name)
	{
    	include $class_name . '.php';
	}

	session_start();

	include('header.php');

	if ($_SESSION['verified'])
	{
		$db = new db();
		$db->connect();

		$categories = mysql_query("select Category from Categories");
		$subcategories = mysql_query("select * from Subcategories left join Categories using (cID) order by Subcategories.cID");
		$forms = mysql_query("select Form from Forms");
		$priorities = mysql_query("select Priority from Priorities");

		if ($_POST['name'] != null && $_POST['category'] != null && $_POST['priority'] != null)
		{
			$cID = mysql_query("select cID from Categories where Category='".$_POST['category']."'");
			$pID = mysql_query("select pID from Priorities where Priority='".$_POST['priority']."'");
			mysql_query("insert into Items(Name, Category, Priority) values('".$_POST['name']."', ".$cID[0].", ".$pID[0].")");
		}
?>

	<form method="POST" action="">
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
		<select name="form">
			<option disabled selected>--Form--</a>
			<?php
				while ($form = mysql_fetch_array($forms))
				{
					echo "<option value='".$form[Form]."'>".$form[Form]."</option>";
				}
			?>
		</select>
		<select name="priority">
			<option disabled selected>--Priority--</a>
			<?php
				while ($priority = mysql_fetch_array($priorities))
				{
					echo "<option value='".$priority[Priority]."'>".$priority[Priority]."</option>";
				}
			?>
		</select>
		<input type="text" name="size" id="size" placeholder="Size">
		<input type="submit" value="post">
	</form>

<?php
	}

	else
	{
		echo "<span class='alert'>not logged in</span>";
	}

	include('footer.php');
?>