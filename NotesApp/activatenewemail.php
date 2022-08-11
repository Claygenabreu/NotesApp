<?php
//The user is redirected to this file after clicking the link received by email and aiming at proving they own the new email address.
// link contains three GET parameters: email, newemail and activation key
session_start();
include('connection.php');

  ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New Email Activation</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
    <link href="css/bootstrap.min.css"
rel="stylesheet">
       <style>
           h1{
               color: purple;
           }
         .contactForm{
          border: 1px solid #7c73f6; 
           margin-top: 50px;
           border-radius: 15px;
         }


          </style>
      </head>
      <body>
  <div class="container-fluid">
  <div class="row">
     <div class="col-sm-offset-1 col-sm-10 contactForm">
       <h1>Email Activation</h1>
       
 <?php
       //If email, newemail or activation key is missing show an error
if(!isset($_GET['email']) || !isset($_GET['newemail']) || !isset($_GET['key'])){
  echo '<div class="alert alert-danger">There was an error. Please click on the link you received by email.</div>'; exit; 
}
//else
//  Store them in two variables
$email = $_GET['email'];
$newemail = $_GET['newemail'];
$key = $_GET['key'];
//  Prepare variables for the query
$email = mysqli_real_escape_string($link, $email);
$newemail = mysqli_real_escape_string($link, $newemail);
$key = mysqli_real_escape_string($link, $key);
//  Run query: update email
$sql = "UPDATE users SET email='$newemail', activation2='0' WHERE (email='$email' AND activation2='$key') LIMIT 1";
$result = mysqli_query($link, $sql);
// If query is successful, show success messge 
  if(mysqli_affected_rows($link) == 1){
    session_destroy();
    setcookie("rememberme", "", time()-3600);
  echo '<div class="alert alert-success">Your email has been activated.</div>'; 
  echo '<a href="index.php" type="button" class="btn-md btn-success">Log in</a>';   
  }else{
    //  show error message
    echo '<div class="alert alert-danger">Your email could not be updated. Please try again later.</div>'; 
      echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>'; 
  }



       ?>
       
      
    </div>
    </div>
  
        
            
    </div>
        <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
           
      </body>
    </html>