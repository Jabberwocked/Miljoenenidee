<?php
include_once ("../config/config.php");
include_once (TEMPLATES_PATH . "/header.php");
include_once (MENU_PATH . "/menu_tests.php");
?>


<div style="width: 500px; margin: 0px auto; border: 1px dotted; padding: 20px 170px 100px 170px">

<?php 

/** 
 * Get questionids from SESSION and user answers from POST
 */

$questionids = $_SESSION['test']->questionids; // array(orderno => questionid)
$useranswers = $_POST; // array(questionid => answer)

/**
 * Check answers
 * Save useranswers, grades and test data to db
 * Show results
 */

$grades_logged = $_SESSION['test']->checkanswers($useranswers);
$_SESSION['test']->saveresultstodb($useranswers, $grades_logged);
$_SESSION['test']->showresults($useranswers, $grades_logged);


?>
</div>
<?php
include_once (TEMPLATES_PATH . "/footer.php");
?>