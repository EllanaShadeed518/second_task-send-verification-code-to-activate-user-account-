<?php 
require('inc/header.php') ;?>

    
                        



<!--Install PHPMailer-->
<?php
//import PHPMailer classes into the global namespace

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
//load composer's autoloader
require ('vendor/autoload.php');

require ('PHPMailer-master/src/Exception.php');
require ('PHPMailer-master/src/PHPMailer.php');
require ('PHPMailer-master/src/SMTP.php');
if(isset($_POST['register'])){
    $name=$_POST['name'];
    $email=$_POST['email'];
    $password=$_POST['password'];
    $errors=[];
    //validation name
    if(empty($name)){
  $errors[]= "name must be requiered";
    }
    else if(is_numeric($name)){
      $errors[]= "name must be string";
    }
    else if(strlen($name)>100){
      $errors[]= "name must be less than 100";
    
  }
  //validate password
  if(empty($password)){
    $errors[]= "password must be requiered";
      }
      else if(strlen($password)>30){
        $errors[]= "name must be less than 30";
      
    }
    elseif(!preg_match("#[0-9]+#",$password)) {////password have at least one number
      $errors[] = "Your Password Must Contain At Least 1 Number!";
    }
    elseif(!preg_match("#[A-Z]+#",$password)) {////password have at least one capital letter
      $errors[] = "Your Password Must Contain At Least 1 Capital Letter!";
    }
    elseif(!preg_match("#[a-z]+#",$password)) {//password have at least one small letter
      $errors[] = "Your Password Must Contain At Least 1 Lowercase Letter!";
    }
//validation email
if(empty($email)){
    $errors[]= "email must be requiered";
      }
      else if((!filter_var($email,FILTER_VALIDATE_EMAIL))){
        $errors[]= " is not validate email";
      }
      else if(strlen($email)>100){
        $errors[]= "email must be less than 100";
      
    }

    //instantiation and passing `true` enables exceptions
    $mail= new PHPMailer();//object from class PHPMailer
    $mail->IsSMTP();
$mail->Mailer = "smtp";

    try {
        //enable verbose debug output
        $mail->SMTPDebug=1;//SMTP::DEBUG_SERVER;
        //send using SMTP
        $mail->isSMTP();
        //set the SMTP server to send through 
        $mail->Host='smtp.gmail.com';
        //enable SMTP authentication
        $mail->SMTPAuth=true;
        //SMTP username
        $mail->Username='';//Your Gmail Address(example: ex@gmail.com)
        //SMTP password
        $mail->Password='';//Your Gmail Password
        //enable TLS encryption
        
        $mail->SMTPSecure = "tls";//??
        //TCP PORT TO CONNECT TO,USE 465 FOR PHPMailer::ENCRYPTION_STARTTLS
$mail->Port = 587;
        //Recipients
        $mail->setFrom('from@gmail.com','from');//FROM WHO 
        //add a recipient
        $mail->addAddress($email,$name);//WHERE SEND??
        //set email format to HTML
        $mail->isHtml(true);
        



        $verification_code=substr(number_format(time()*rand(),0,'',''),0,6);//rand()->generate random integer//The time() function returns the current time in the number of seconds since (return number integer of current time)//number_format()->format iteger number in grouped and have 4 parameter
        $mail->Subject='Email verfication';
        $mail->Body ='<p>Your verification code is:<b style="font-size: 30px;">'.
        $verification_code .'</b></p>';
        $mail->send();
        //echo message has been sent ;
        $encrypted_password=password_hash($password,PASSWORD_DEFAULT);
        //connect with database
        $conn=mysqli_connect('localhost','root','','tasktwo');
        //insert data
        if(empty($errors)){
        $query="INSERT INTO verifyemail (`name`,`email`,`password`,`verfication_code`,`email_verified_at`)
        VALUES('$name','$email','$encrypted_password','$verification_code','Null')";
        mysqli_query($conn,$query);
        header("location: email_verification.php?email=".$email);}
        else{
            

   ?>
<div class="container py-5">
        <div class="row">

            <div class="col-md-6 offset-md-3">
                <h3 class="mb-3">Add user</h3>
                <div class="card">
                    <div class="card-body p-5">
                    <?php  foreach($errors as $err){?>
    <li class="alert alert-danger"><?= $err?></li>
                   <?php }?>
                   <form method = "post">
<div class="form-group">
<label>Name</label>
<input type="text" name="name" placeholder="EnterName"class="form-control" />
 </div>
 <div class="form-group">
<label>Email</label>
<input type="email" name="email" placeholder="EnterEmail"class="form-control" />
 </div>
<div class="form-group">
<label>Password</label>
<input type="password" name="password" placeholder="EnterPassword" class="form-control"/>
 </div>
 
 

 <div class="form-group">

<input type="submit" name="register"class="btn btn-primary" value="Register"/>
 </div>

</form> 
    </div>
    </div>
    </div>
    </div>
    </div>
 <?php     
   }


unset($errors);
exit();

       
}
    catch(Exception $e){
        echo "message could not be sent. Mailer Error:{$mail->ErrorInfo}";
    }

}
?>
<div class="container py-5">
        <div class="row">

            <div class="col-md-6 offset-md-3">
                <h3 class="mb-3">Add user</h3>
                <div class="card">
                    <div class="card-body p-5">
<form method = "post">
<div class="form-group">
<label>Name</label>
<input type="text" name="name" placeholder="EnterName"class="form-control" required/>
 </div>
 <div class="form-group">
<label>Email</label>
<input type="email" name="email" placeholder="EnterEmail"class="form-control" required/>
 </div>
<div class="form-group">
<label>Password</label>
<input type="password" name="password" placeholder="EnterPassword" class="form-control"required/>
 </div>
 
 

 <div class="form-group">

<input type="submit" name="register"class="btn btn-primary" value="Register"/>
 </div>

</form>  

</div>
</div>
</div>
</div>
</div>

  <?php require_once('inc/footer.php') ;?>
