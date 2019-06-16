<?php ?>
<h1><?= $args['plugin_name'] ?></h1>
<form id="CsvPosts" method="POST">
	<h2>Select file for import</h2>
	<input type="file" name="csv" accept=".csv">
	<input type="submit" value="Generate">
	<p class="error"></p>
</form>