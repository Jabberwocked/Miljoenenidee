<?php

class User
{

	public $username = null;

	public $password = null;

	public $salt = "Zo4rU5Z1YyKJAASY0PT6EUg7BBYdlEhPaNLuxAwU8lqu1ElzHv0Ri7EM6irpx5w";


	public function __construct( $data = array() )
	{
		if (isset($data['username'])) $this->username = stripslashes(strip_tags($data['username']));
		if (isset($data['password'])) $this->password = stripslashes(strip_tags($data['password']));
	}


	public function storeFormValues( $params )
	{
		// store the parameters
		$this->__construct($params);
	}


	/**
	 * Checks whether the given username is already in the database.
	 *
	 * @param string userName The user name that will be searched for.
	 * 
	 * @return boolean True when the username exists.
	 */
	public function isDuplicateUserName( $userName )
	{
		$con = new PDO(DB_USERS, DB_USERNAME, DB_PASSWORD);
		$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		$sql = "SELECT * FROM users WHERE username = :username";
		
		$stmt = $con->prepare($sql);
		$stmt->bindValue("username", $this->username, PDO::PARAM_STR);
		$stmt->execute();
		
		$isDuplicate = $stmt->fetchColumn();
		$con = null;
		
// 		OLD (bugged):
// 		return (strTemp != '');
//		NEW:

		if ($isDuplicate == '')
		{
			return false;
		}
		else 
		{
			return true;
		}
		
	}


	/**
	 * Attempts to log in a user with the given username and password.
	 *
	 * @return boolean
	 */
	public function userLogin( )
	{
		$success = false;
		try
		{
			$con = new PDO(DB_USERS, DB_USERNAME, DB_PASSWORD);
			$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "SELECT * FROM users WHERE username = :username AND password = :password LIMIT 1";
			
			$stmt = $con->prepare($sql);
			$stmt->bindValue("username", $this->username, PDO::PARAM_STR);
			$stmt->bindValue("password", hash("sha256", $this->password . $this->salt), PDO::PARAM_STR);
			$stmt->execute();
			
			
			$userfound = $stmt->fetch();
			
			if ($userfound)
			{
				$success = true;
				$_SESSION['userid'] = $userfound['userid'];	// saved to session for later db actions (e.g. saving a test)
				$_SESSION['username'] = $userfound['username']; // saved to session to update top-right corner
			}
			
			$con = null;
			return $success;
		}
		catch (PDOException $e)
		{
			echo $e->getMessage();
			return $success;
		}
	}


	public function register( )
	{
		$correct = false;
		
		if ($this->isDuplicateUserName($this->username))
		{
			return "Registration failed user already exists";
		}
		
		try
		{
			$con = new PDO(DB_USERS, DB_USERNAME, DB_PASSWORD);
			$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			$sql = "INSERT INTO users(username, password) VALUES(:username, :password)";
			$stmt = $con->prepare($sql);
			$stmt->bindValue("username", $this->username, PDO::PARAM_STR);
			$stmt->bindValue("password", hash("sha256", $this->password . $this->salt), PDO::PARAM_STR);
			$stmt->execute();
			
			$_SESSION['registrationsuccessful'] = "Registration succesful. Please log in.";
			header('location:./loginpage.php'); 
// 			return "Registration Successful <br/> <a href='loginpage.php'>Login Now</a>";
		}
		catch (PDOException $e)
		{
			return $e->getMessage();
		}
	}
}

?>
