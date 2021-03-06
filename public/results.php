<?php
include_once ("../config/config.php");
include_once (TEMPLATES_PATH . "/header.php");
include_once (MENU_PATH . "/menu_tests.php");
?>



<style type="text/css">
td {
	padding: 0px 10px
}
</style>

<div style="width: 800px; margin: 0px auto; border: 1px dotted; padding: 20px 20px 100px 20px">

<!-- TO DO
	<div style="text-align:center">
		<nav style="margin:0px auto;">
			<a href="" style="font-size: small; margin-top:0px">Show all results</a>
			<a href="" style="font-size: small; margin-top:0px">Show in folders</a>
			<div style="display:inline; margin: 0px 0px 0px 20px">Filter by:</div>
			<a href="" style="font-size: small; margin: 0px 2px">topic</a>
			<a href="" style="font-size: small; margin: 0px 2px">label</a>
			<a href="" style="font-size: small; margin: 0px 2px">user</a>
			<a href="" style="font-size: small; margin: 0px 2px">test</a>
		</nav>
	</div>
-->

<br>
<table>
	<tr style="font-weight: bold; margin-bottom: 20px;">
		
		<td>Test</td>
<!--  TO DO
		<td>User</td>
		<td>Owner</td>
		<td>Topic</td>
		<td>Labels</td>
-->
		<td>Score</td>
		<td>Percentage</td>
		<td>Date</td>
		<td></td>
	</tr>
	
<?php

$db = new PDO(DB_TESTS, DB_USERNAME, DB_PASSWORD);

$testsquery = $db->prepare("SELECT * FROM test_attempts WHERE userid=:userid ORDER BY attemptid");
$testsquery->execute(array(
	':userid' => $_SESSION['userid'],
));
$results = $testsquery->fetchAll();


if (!$results)
	{ ?>

</table>
<br><br><br><p style='font-style:italic'>You have no saved results.</p>

	<?php  }
	
	else 
	{
		foreach ($results as $resultrow)
		{
			$attemptid = $resultrow['attemptid'];
			$testid = $resultrow['testid'];
			$userid = $resultrow['userid'];
			$date = $resultrow['datetime'];
			$sumscores = $resultrow['sumscores'];
			$maxsumscores = 0;
			
			$db = new PDO(DB_TESTS, DB_USERNAME, DB_PASSWORD);
			$sql = "SELECT * FROM test_responses WHERE attemptid=" . $attemptid;
			$responses = $db->query($sql);
			foreach ($responses as $response)
			{
				$maxscore_logged = $response['maxscore_logged'];
				$maxsumscores += $maxscore_logged; 
			}
			
			$percentage = $sumscores / $maxsumscores * 100;
						
			$db = new PDO(DB_TESTS, DB_USERNAME, DB_PASSWORD);
			$sql = "SELECT * FROM tests WHERE testid=" . $testid;
			$tests = $db->query($sql);
			foreach ($tests as $test)
			{
				$testname = $test['testname'];
				$userid_owner = $test['userid_owner'];
			}
			
			$db = new PDO(DB_USERS, DB_USERNAME, DB_PASSWORD);
			$sql = "SELECT * FROM users WHERE userid=" . $userid_owner;
			$dbusers = $db->query($sql);
			foreach ($dbusers as $dbuser)
			{
				$owner = $dbuser['username'];
			}
			$sql = "SELECT * FROM users WHERE userid=" . $userid;
			$dbusers = $db->query($sql);
			foreach ($dbusers as $dbuser)
			{
				$user = $dbuser['username'];
			}	
				
			
			$topic = "";
			$labels = "";
			
			?>
				
			<tr>
			
			<td><?php echo ucfirst($testname) ?></td>
<?php /* TO DO
			<td><?php echo ucfirst($user) ?></td>
			<td><?php echo ucfirst($owner) ?></td>
*/?>
			<td><?php echo $sumscores . " / " . $maxsumscores?></td>
			<td><?php echo round($percentage,0) . " %" ?></td>
			<td><?php echo $date ?></td>
			<td>
				<form style="display:inline" action=<?php echo htmlspecialchars('testpage_check.php');?> method="post"><button type="submit" name="attemptid" value="<?php echo $attemptid ?>" >View</button></form>
			</td>
			</tr>
		
			
			
	<?php 
		}
	} 
	?>
		
	</table>
	</div>
	





<?php
include_once (TEMPLATES_PATH . "/footer.php");
?> 