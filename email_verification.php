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
//print_r($_GET);
if(isset($_POST['verify_email'])){
    $email=$_POST['email'];
    $verification_code=$_POST['verification_code'];
    //connect with database
    $conn=mysqli_connect('localhost','root','','tasktwo');
    //update email to verified email
    $query="update verifyemail set email_verified_at=NOW()where email ='$email' And verfication_code='$verification_code'";
    $result=mysqli_query($conn,$query);
    if(mysqli_affected_rows($conn)==0){
die("verification code");
    }
}

?>
<div class="container py-5">
        <div class="row">

            <div class="col-md-6 offset-md-3">
                
                <div class="card">
                    <div class="card-body p-5">
<form method = "post">
<div class="form-group">

<input type="hidden" name="email" value="<?=  $_GET['email'];?>" />
 </div>
 <div class="form-group">
 <label>verification_code</label>
 <input type="text" name="verification_code" placeholder="Enter Verification code" required/>
 </div>
 <div class="form-group">

<input type="submit" name="verify_email"class="btn btn-primary" value="Verify Email"/>
 </div>

</form>   </div>
    </div>
    </div>
    </div>
    </div>