<?php
	class display
	{
		function verified()
		{
			header("Location: entry.php");
		}

		function denied($nick)
		{
			header("Location: login.php?nick=".urlencode($nick));
		}
	}
?>