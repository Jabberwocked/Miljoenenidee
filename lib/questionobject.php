<?php 

	
/**
 * Class questionobject
 */


class questionobject {
	public $orderno;
	public $questionid;
	public $question;
	public $type;
	public $typeshort;
	public $questionscore;
	public $answers;
	public $scorepercentages;

/**
 * To make a new questionobject with orderno, question, type, answers
 * based on array-input (e.g. form)
 */
	
	function __construct( $data = array() )
	{
		if (isset($data['orderno'])) $this->orderno = $data['orderno'];
		if (isset($data['question'])) $this->question = $data['question'];
		if (isset($data['type'])) $this->type = $data['type'];
		if (isset($data['questionscore'])) $this->questionscore = $data['questionscore'];
		if (isset($data['answers'])) $this->answers = $data['answers'];
		if (isset($data['scorepercentages'])) $this->scorepercentages = $data['scorepercentages'];
		
		if ($this->type == "shortanswer")
		{
			$this->typeshort = "SA";
		}
		if ($this->type == "multichoice")
		{
			$this->typeshort = "MC";
		}
		
	}

	
/**
 * To make a new questionobject with questionno, question, type, answers
 * based on questionid and pulled from db
 * orderno given manually
 */
	
	function pullfromdb($orderno, $questionid)
	{
		$db = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
		$sql = "SELECT * FROM Questions WHERE QuestionId=".$questionid;
		$resultquestions = $db->query($sql);
		
		$sql = "SELECT * FROM Answers WHERE QuestionId=".$questionid;
		$resultanswers = $db->query($sql);
		
// 		$sql = "SELECT * FROM Test_Question WHERE QuestionId=".$questionid;
// 		$resultquestionscores = $db->query($sql);
		
		foreach ($resultanswers as $tempanswersobject)
		{
			$tempanswersarray[] = $tempanswersobject['Answer'];
			$tempscorepercentagesarray[] = $tempanswersobject['Scorepercentage'];
		}
		
		
		
		foreach ($resultquestions as $tempquestionobject)
		{
			$this->orderno = $orderno;
			$this->questionid = $questionid;
			$this->question = $tempquestionobject['Question'];
			$this->type = $tempquestionobject['Type'];
// 			$this->$questionscore = $questionscore;
			$this->answers = $tempanswersarray;
			$this->scorepercentages = $tempscorepercentagesarray;
		}
		
		
		if ($this->type == "shortanswer")
		{
			$this->typeshort = "SA";
		}
		if ($this->type == "multichoice")
		{
			$this->typeshort = "MC";
		}
	}
	
	
	
/**
 * Show a questionobject as a clickable button.
 */
		
	function show()
	{
		?>

		<button class='textlayout' type="submit" name="itemtoedit" value="<?php echo $this->orderno ?>" >
			<p>
			<span style='font-weight:bold'><?php echo $this->orderno . ". " . $this->question ; ?></span>
			<span style='font-weight:normal'>(<?php echo $this->typeshort; ?>)</span><br>
			<span><?php $n = 1; foreach($this->answers as $answer){if ($n > 1){echo ", ";}$n ++;echo $answer;}?></span>
			</p>
		</button><br>
		
		<?php 
	}
	
	

	
	
}


?>