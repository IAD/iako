<ul>
<?php
foreach ($response->menu as $val)
{
	echo "<li>".anchor($val['url'], $val['text']);
}
?>
</ul>