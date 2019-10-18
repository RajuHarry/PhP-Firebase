<?php
include("includes/db.php");

    
if(isset($_POST['signup'])){
    
    $email = $_POST['emailSignup'];
    $pass = $_POST['passSignup'];

    $auth = $firebase->getAuth();
    $user = $auth->createUserWithEmailAndPassword($email,$pass);
    header("Location:index.php");
}
else{
    
    $email = $_POST['emailSignin'];
    $pass = $_POST['passSignin'];

    $auth = $firebase->getAuth();
    //$user = $auth->getUserWithEmailAndPassword($email,$pass);
	$user = $auth->getUserByEmail($email);
	var_dump($user);exit;
    if($user){
        session_start();
        $_SESSION['user'] = true;
        header("Location:home.php");
    }
}

?>