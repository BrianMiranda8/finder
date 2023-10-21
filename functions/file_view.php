<?php
//how to view if target is a file
function file_view($target)
{
	//title
	$target = $_SERVER['DOCUMENT_ROOT'] . $target;
	echo '<div class="title">
		<div class="sixteen columns">
	<img onclick="history.back()" src="/policy-code/images/back-icon-35.png" class="scale-with-grid" title="Go Back"><a href="index.php"><img src="/policy-code/images/home-icon-35.png" class="scale-with-grid" style="border: none;"></a>
	<span class="titleText">Viewing</span></div></div>';

	if (stripos($target, '.html') == true) {
		include($target);
	} else {
		echo '<div class="article">';
		include($target);
		echo '</div>';
	}
}
