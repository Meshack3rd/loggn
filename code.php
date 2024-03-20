<?php 
session_start();

include('dbcon.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


require 'vendor/autoload.php';

function sendemail_verify($name,$email,$verify_token)
{
    $mail = new PHPMailer(true);
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
    $mail->isSMTP(); 
    $mail->SMTPAuth   = true; 

    $mail->Host       = "smtp.gmail.com";                                                      
    $mail->Username   = "nyambanemeshack05@gmail.com";                  
    $mail->Password   = "kaxl gbcb fomo iauy"; 

    $mail->SMTPSecure = "ssl";           
    $mail->Port       = 465;  
    
    $mail->setFrom("nyambanemeshack05@gmail.com");
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = "Email Verfication from Funda of web IT";

    $email_template="
       <h2>You have Registered with Funda of web IT</h2>
       <h5>Verify your email address to login with the below given link</h5>
       <br/><br/>
       <a href='http://localhost/loggn/verify-email.php?token=$verify_token'> Click Me </a>
       ";

       $mail->Body = $email_template;
       $mail->send();
       //echo 'Message has been sent';
    
}

if(isset($_POST['register_btn']))
{
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $registration = $_POST['registration'];
    $verify_token = md5(rand());

  

    $check_email_query = "SELECT email FROM users WHERE email='$email' LIMIT 1";
    $check_email_query_run = mysqli_query($con, $check_email_query);

    if(mysqli_num_rows($check_email_query_run) > 0)
    {
       $_SESSION['status'] = "Email id already Exists";
       header("Location: register.php");

    }
    else
    {
        $query = "INSERT INTO users(name,phone,email,password,registration,verify_token	) VALUES ('$name','$phone','$email','$password','$registration','$verify_token')";
        $query_run = mysqli_query($con, $query);

        if($query_run)
        {
            sendemail_verify("$name","$email","$verify_token");

            $_SESSION['status'] = "Registration Successfull. Please verify your Email Address";
            header("Location: register.php");

        }
        else
        {
            $_SESSION['status'] = "Registration Failed";
            header("Location: register.php");
        }

    }
}
?>