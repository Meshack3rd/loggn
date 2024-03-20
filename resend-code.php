<?php 
session_start();
include('dbcon.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

function resend_email_verify($name,$email,$verify_token)
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
    $mail->Subject = "Resend - Email Verfication from Funda of web IT";

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

if(isset($_POST['resend_email_verify_btn']))
{
    if(isset($_POST['resend_email_verify_btn']))
    {
        if(!empty(trim($_POST['email'])))
        {
            $email = mysqli_real_escape_string($con, $_POST['email']);

            $checkemail_query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
            $checkemail_query_run = mysqli_query($con, $checkemail_query);

            if(mysqli_num_rows($checkemail_query_run) > 0)
            {
                $row = mysqli_fetch_array($checkemail_query_run);
                if($row['verify_status'] == "0")
                {
                    $name = $row['name'];
                    $email = $row['email'];
                    $verify_token = $row['verify_token'];

                    resend_email_verify($name,$email,$verify_token);
                    $_SESSION['status'] = "Verification Email Link has been sent to your email address.!";
                    header("Location: login.php");
                    exit(0);

                }
                else
                {
                    $_SESSION['status'] = "Email alredy verified. Please Login";
                    header("Location: resend-email-verification.php");
                    exit(0);
                }

            }
            else
            {
                $_SESSION['status'] = "Email is not registered. Please Register now.!";
                header("Location: register.php");
                exit(0);

            }

        }
        else
        {
            $_SESSION['status'] = "Please enter the email field";
            header("Location: resend-email-verification.php");
            exit(0);
        }

    }
}


?>