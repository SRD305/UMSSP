<?php
session_start();
include('includes/config.php');
include('includes/inputval.php');
if(isset($_POST['submit']))
{
$regno=Input::int($_POST['regno']);
$fname=Input::str($_POST['fname']);
$mname=Input::str($_POST['mname']);
$lname=Input::str($_POST['lname']);
$gender=$_POST['gender'];
$contactno=Input::int($_POST['contact']);
$emailid=$_POST['email'];
$password=$_POST['password'];
	$result ="SELECT count(*) FROM userRegistration WHERE email=? || regNo=?";
		$stmt = $mysqli->prepare($result);
		$stmt->bind_param('ss',$email,$regno);
		$stmt->execute();
$stmt->bind_result($count);
$stmt->fetch();
$stmt->close();
if($count>0)
{
echo"<script>alert('Registration number or email id already registered.');</script>";
}
elseif(!preg_match("/^(?=.{10,})(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%^&+]).*$/",$password))
{
echo "<script>alert('Password must contain minimum one of the following Capital letter, number, special charecter');</script>";
}
  elseif(!(strlen($password)>=10 && strlen($password)<128))
  {
                    echo "<script>alert('Lenght does not match');</script>";
  }
else
{
$password=password_hash($_POST['password'],PASSWORD_ARGON2I);
$query="insert into  userRegistration(regNo,firstName,middleName,lastName,gender,contactNo,email,password) values(?,?,?,?,?,?,?,?)";
$stmt = $mysqli->prepare($query);
$rc=$stmt->bind_param('sssssiss',$regno,$fname,$mname,$lname,$gender,$contactno,$emailid,$password);
$stmt->execute();
echo"<script>alert('Student Succssfully register');</script>";
}
}
?>
