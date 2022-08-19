<?php
//Start session
 session_start();
 include('connection.php');

//Check user inputs
//Define error messages
$missingUsername='<p><strong>Please enter a username!</strong></p>';
$missingEmail='<p><strong>Please enter your email address!</strong></p>';
$invalidEmail='<p><strong>Please enter a valid email address!</strong></p>';
$missingPassword='<p><strong>Please enter a password!</strong></p>';
$invalidPassword='<p><strong>Your password should be atleast 6 characters long and include one capital letter and one number!</strong></p>';
$differentPassword='<p><strong>Passwords don\'t match!</strong></p>';
$missingPassword2='<p><strong>Please confirm your password!</strong></p>';
// Get username, email, password, password2
 //  get username 
  if(empty($_POST["username"])){
    $errors .= $missingUsername;
  }else{
    $username = filter_var($_POST["username"], FILTER_SANITIZE_STRING);
  }
// get email 
  if(empty($_POST["email"])){
    $errors .= $missingEmail;
  }else{
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
      $errors .= $invalidEmail;
    }
  }
  // get passwords
  if(empty($_POST["password"])){
    $errors .= $missingPassword;
  }elseif(!(strlen($_POST["password"])>6 
            and preg_match('/[A-Z]/', $_POST["password"]) 
            and preg_match('/[0-9]/', $_POST["password"]))){
         $errors .= $invalidPassword;
  }else{
    $password = filter_var($_POST["password"], FILTER_SANITIZE_STRING);
    if(empty($_POST["password2"])){
       $errors .= $missingPassword2;
    }else{
      $password2 = filter_var($_POST["password2"], FILTER_SANITIZE_STRING);
      if($password !== $password2){
        $errors .= $differentPassword;
      }
    }
  }
//If there are any errors, print error
if($errors){
  $resultMessage = '<div class="alert alert-danger">' . $errors .'</div>';
echo $resultMessage;
  exit;
  }


//NO errors
//  Prepare variables for the queries
$username = mysqli_real_escape_string($link, $username);
$email = mysqli_real_escape_string($link, $email);
$password = mysqli_real_escape_string($link, $password);
//$password = md5($password);
$password = hash('sha256', $password);

//output of md5 is 128bits long -> 32characters
//output of sha256 is 256bits long -> 64characters
//If the username exists in the users table print error
$sql = "SELECT * FROM users WHERE username = '$username'";
$result = mysqli_query($link, $sql);
if(!$result){
 echo '<div class="alert alert-danger">Error running the query</div>'; exit;
}
$results = mysqli_num_rows($result);
if($results){
  echo '<div class="alert alert-danger">That username is already registered. Do you want to log in?</div>'; exit;
}

//   If email exists in the users table print error
$sql = "SELECT * FROM users WHERE email = '$email'";
$result = mysqli_query($link, $sql);
if(!$result){
 echo '<div class="alert alert-danger">Error running the query</div>'; 
   //echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>'; 
  exit;
}
$results = mysqli_num_rows($result);
if($results){
  echo '<div class="alert alert-danger">That email is already registered. Do you want to log in?</div>'; exit;
}

//  else
//    Create a unique activation code
$activationKey = bin2hex(openssl_random_pseudo_bytes(16));

//unit of data = 8 bits (8 binary digits long)
  //bit is smallest unit of data (0 or 1)
  //16 bytes = 8 * 16 = 128 bits
//2*2*2*2*2* ...2*2 (this is with base 2(either 0 or 1))
//for activationkey, convert the above base 2 to hexadecimal/base16
//16*16*16*  (128*16)/4=>hexadecimal

//  Insert user details and activation code in the users table
$sql = "INSERT INTO users (`username`, `email`, `password`, `activation`, `activation2`) VALUES ('$username', '$email', '$password', '$activationKey', '')";
$result = mysqli_query($link, $sql);
if(!$result){
  echo '<div class="alert alert-danger">There was an error inserting the user details in the database</div>'; exit;
}
//   Send the user an email with a link to activate.php with their email and activation code
$message = "Please click on this link to activate your account:\n\n";
$message .= "https://claygenabreu.in/NotesApp/activate.php?email=" . urlencode($email) . "&key=$activationKey";
if(mail($email, 'Confirm your registration', $message, 'From:'.'claygenabreu@gmail.com')){
   echo "<div class='alert alert-success'>Thank you for your registration! A confirmation email has been sent to $email. Please click on the activation link to activate your account.</div>"; 
   
}

?>
