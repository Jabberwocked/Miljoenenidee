


<?php
include_once ("../config/config.php");
include_once (TEMPLATES_PATH . "/header.php");
?>

<script>
// $(document).ready(function(){

// // Save question (is submit form) when another question is clicked. Doesn't work.
// 	$("button").click(function() {
// 	$('#question4').submit();

// });
</script> 	


<form action="test123.php" method="get">
	<button type=button name=1 value=on>Example question 1</button><br>
	<button type=button name=2 value=on>Example question 2</button><br>
	<button type=submit name=3 value=on>Example question 3</button><br>
<form id='question4' method="get" action="test123.php">
	<input type=text name=4 placeholder='Example question 4'>
	<button type='submit'>Submit</button>
</form>