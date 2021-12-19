<?php
session_start();
include('includes/config.php');
include('includes/inputval.php');
if(isset($_POST['login']))
{
  if ($_POST["verficationcode"] != $_SESSION["vercode"] OR $_SESSION["vercode"]=='')
    {
    echo "<script>alert('Incorrect captcha');</script>" ;
    }
    else
		{
  $email=Input::email($_POST['emailid']);
  $password=Input::str($_POST['loginpassword']);
  if (!empty($_POST['$email']) && !empty($_POST['$password']))
    {
	             $password = trim(htmlspecialchars($_POST['password']));
	              $email = trim(htmlspecialchars($_POST['email']));}
  $query=mysqli_query($con,"select id,FirstName, EmailId, UserPassword from tblusers where EmailId='$email'");
$num = mysqli_fetch_array($query);
$hashpass = $num["UserPassword"];
$ret=$num["id"];
$verify=password_verify($password,$hashpass);
if($verify)
{
$_SESSION['uid']=$num['id'];
$_SESSION['last_login_timestmp']= time();
$_SESSION['fname']=$num['FirstName'];
$str=rand();
            $result = md5($str);
            $cookie_name=$result;
            $cookie_value= $num["id"];
            setcookie($cookie_name, $cookie_value);
            setcookie($cookie_name, $cookie_value, time() + 3600,"/");
  //          $ip=$_SERVER['REMOTE_ADDR'];
//$geopluginURL='http://www.geoplugin.net/php.gp?ip='.$ip;
//$addrDetailsArr = unserialize(file_get_contents($geopluginURL));
//$city = $addrDetailsArr['geoplugin_city'];
//$country = $addrDetailsArr['geoplugin_countryName'];
//$log="insert into userLog(userId,userEmail,userIp,city,country) values('$num','$email','$ip','$city','$country')";
//$mysqli->query($log);
header("location:welcome.php");
}
else
{
echo "<script>alert('Invalid  login details');</script>";
}
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>User Management System in PHP Using Stored Procedure</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                    </div>
                                    <form class="user" method="post">
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Enter Email Address..." name="emailid" required="true">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                id="exampleInputPassword" placeholder="Password" name="loginpassword" required="true">
                                        </div>
                                <!--Cpatcha Image -->     <div class="form-group">
                             <input type="text"   name="verficationcode" maxlength="5" autocomplete="off" required  style="width: 200px;"  placeholder="Enter Captcha" autofocus />&nbsp;

                             <img src="captcha.php">
                           </div>   <!--Cpatcha Image -->
                                        <button type="submit" name="login" class="btn btn-primary btn-user btn-block">
                                            Login
                                        </button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="password-recovery.php">Forgot Password?</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="signup.php">Create an Account!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>
