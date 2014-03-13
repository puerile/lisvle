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
		$priorities = mysql_query("select Priority from Priorities");
?>

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

<?php
	}

	else
	{
		echo "not logged in";
	}

	include('footer.php');
?>