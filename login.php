<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome-free-5.0.1/css/fontawesome-all.css">
</head>

    <body>


<?php
if(isset($_POST['login'])){
    $password=$_POST['password'];
    $email=$_POST['email'];
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
    if(empty($errors)){
    //connect with database
    $conn=mysqli_connect('localhost','root','','tasktwo');
    //check email is verified 
    $query="select * from verifyemail where email='$email'";
    $result=mysqli_query($conn,$query);
    if(mysqli_num_rows($result)==0){
        die("Email not found in database");
    }
    $user=mysqli_fetch_object($result);//return current row
    if(!password_verify($password,$user->password)){//compare password after encrypt hash
die("password is not correct");
    }
    if($user->email_verified_at=='0000-00-00 00:00:00'){
die("please verify your email <a href='email_verification.php?email=".$email."'>from here</a>");
    }
    echo "<p>your login logic here</p>";
    exit();
}

else{
            
?>
    
 <div class="container py-5">
         <div class="row">
 
             <div class="col-md-6 offset-md-3">
              
                 
                     
                     <?php  foreach($errors as $err){?>
     <li class="alert alert-danger"><?= $err?></li>
                    <?php }?>
  
     
     
     </div>
     </div>
     </div>

    <?php unset($errors);}
                     }?>



<div class="container py-5">
        <div class="row">

            <div class="col-md-6 offset-md-3">
                
                <div class="card">
                    <div class="card-body p-5">
<form method = "post">

 <div class="form-group">
<label>Email</label>
<input type="email" name="email" placeholder="EnterEmail"class="form-control" required/>
 </div>
<div class="form-group">
<label>Password</label>
<input type="password" name="password" placeholder="EnterPassword" class="form-control"required/>
 </div>
 
 <input type="submit" name="login" class="btn btn-primary"value="LogIn"/>

 <div class="form-group">


 </div>

</form>  

</div>
</div>
</div>
</div>
</div>




