<?php
session_start();
include('connection.php');

  ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Password Reset</title>

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
       <h1>Reset Password</h1>
       <div id="resultmessage"></div>
 <?php
       //If user_id or activation key is missing 
if(!isset($_GET['user_id']) || !isset($_GET['key'])){
  echo '<div class="alert alert-danger">There was an error. Please click on the link you received by email.</div>'; exit; 
}
//else
//  Store them in two variables
$user_id = $_GET['user_id'];
$key = $_GET['key'];
$time = time() - 86400; 
//  Prepare variables for the query
$user_id = mysqli_real_escape_string($link, $user_id);
$key = mysqli_real_escape_string($link, $key);
//  Run query: check combination of user_id and key exists and less than 24h old
$sql = "SELECT user_id FROM forgotpassword WHERE key1='$key' AND user_id='$user_id' AND time > '$time' AND status='pending'";
$result = mysqli_query($link, $sql);

 if(!$result){
 echo '<div class="alert alert-danger">Error running the query</div>'; 
  exit;
}
 //if combination doesnt exists
 //show error message
  $count = mysqli_num_rows($result);
if($count !== 1){
 echo '<div class="alert alert-danger">Please try again.</div>';
 exit;
}   
       //print reset password form with hidden uer_id and key fields
  echo "
  <form method=post id='passwordreset'>
  <input type=hidden name=key value=$key>
    <input type=hidden name=user_id value=$user_id>
  <div class='form-group'>
  <label for='password'>Enter your new Password:</label>
  <input type='password' name='password' id='password' placeholder='Enter Password' class='form-control'>
  </div>
  
  <div class='form-group'>
  <label for='password2'>Re-enter Password:</label>
  <input type='password' name='password2' id='password2' placeholder='Re-enter Password' class='form-control'>
  
  </div>
  <input type='submit' name='resetpassword' class='btn btn-success btn-lg' value='Reset Password'>
  </form>
  ";


       ?>
       
      
    </div>
    </div>
  
        
            
    </div>
        <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
           <script>
             //script for Ajax call to storeresetpassword.php which processes form data
            //once the form is submitted
             
    $("#passwordreset").submit(function(event){
 //prevent default php processing
 event.preventDefault();
  //collect user inputs
  var datatopost = $(this).serializeArray();
  //console.log(datatopost);
  //send them to signup.php using Ajax
  $.ajax({
    url: "storeresetpassword.php",
    type: "POST",
    data: datatopost,
    success: function(data){
       $('#resultmessage').html(data);
    },
    error: function(){
       $("#resultmessage").html("<div class='alert alert-danger'>There was an error with the Ajax call. Please try again later.</div>"); 
    }
  });
});

        </script>
      </body>
    </html>