
<?php 

session_start();

$username = "";
$email = "";

$errors = array();

$db = mysql_connect('localhost','root','','project') or die("could not connect to database");

$username = mysql_real_escape_string($db,$_POST['username']);
$email = mysql_real_escape_string($db,$_POST['email']);
$password_1 = mysql_real_escape_string($db,$_POST['password_1']);
$password_2 = mysql_real_escape_string($db,$_POST['password_2']);


if(empty($username)) { array_push($errors, "username is required");}
if(empty($email)) { array_push($errors, "email is required");}
if(empty($password_1)) { array_push($errors, "password is required");}
if($password_1 != $password_2) { array_push($errors, "password do not match") ;}


$user_check_query = "SELECT * from user where username= '$username' or email = '$email' LIMIT 1";

$results = mysql_query($db, $user_check_query);
$user = mysql_fetch_assoc($result);

if($user) {

	if($user["username"] ===  $username){array_push($errors, "Username already exits");}
	if($user["email"] ===  $username){array_push($errors, "This email id already has a registered username");}

}

if(count($errors) == 0){
	 $password = md5($password_1);
	 print $password;
	 $query = "INSERT INTO user(username, email,password) VALUES ('$username' ,'$email' ,'$password')";

	 mysql_query($db, $query);
	 $_SESSION['username'] = $username;
	 $_SESSION['success'] = "You are now loged in ";

     header('location: index.php');
 }



if(isset($_POST['login_user'])){
	$username = mysql_real_escape_string($db, $_POST['username']);
	$password = mysql_real_escape_string($db, $_POST['password']);

	if(empty($username)){
		array_push($errors, "username is required");
	}

	if(empty($password)){
		array_push($errors, "password is required");
	}

	if(count($errors) == 0 )
		$password= md5($password);

	$query= "SELECT * from user  WHERE username= '$username'  AND password= '$password' ";
    $results = mysql_query($db,$query);

    if(mysql_num_rows($results))  {

    	$_SESSION['username'] = $username;
    	$_SESSION['success'] = "Logged in successfully";

    	header("location : index.php");

    } else{
    	array_push($errors, "wrong username/password combination. Please try again.");
    } 







}

?>






















?>