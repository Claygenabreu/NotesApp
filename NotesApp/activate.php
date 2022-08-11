<?php
//The user is redirected to this file after clicking the activation link
//Signup link contains two GET parameters: email and activation key
session_start();
include('connection.php');

  ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Account Activation</title>

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
       <h1>Account Activation</h1>
       
 <?php
       //If email or activation key is missing show an error
if(!isset($_GET['email']) || !isset($_GET['key'])){
  echo '<div class="alert alert-danger">There was an error. Please click on the activation link you received by email.</div>'; exit; 
}
//else
//  Store them in two variables
$email = $_GET['email'];
$key = $_GET['key'];
//  Prepare variables for the query
$email = mysqli_real_escape_string($link, $email);
$key = mysqli_real_escape_string($link, $key);
//  Run query: set activation fiel to "activated" for the provided email
$sql = "UPDATE users SET activation='activated' WHERE (email='$email' AND activation='$key') LIMIT 1";
$result = mysqli_query($link, $sql);
// If query is successful, show success messge and invite user to login
  if(mysqli_affected_rows($link) == 1){
  echo '<div class="alert alert-success">Your account has been activated.</div>'; 
  echo '<a href="index.php" type="button" class="btn-md btn-success">Log in</a>';   
  }else{
    //  show error message
    echo '<div class="alert alert-danger">Your account could not be activated. Please try again later.</div>'; 
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