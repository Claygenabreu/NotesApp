<?php
session_start();
include('connection.php');
session_start();
if(!isset($_SESSION['user_id'])){
  header("location: index.php"); 
}
$user_id = $_SESSION['user_id'];

//get username and email
$sql = "SELECT * FROM users WHERE user_id='$user_id'";
$result = mysqli_query($link, $sql);
$count = mysqli_num_rows($result);
if($count == 1){
 $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
  $username = $row['username'];
}else{
 echo "There was an error retrieving the username and email from the database"; 
}
//remember me
include('rememberme.php');
//logout
include('logout.php');

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Online Notes</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
      <link href="styling.css" rel="stylesheet">
      <link href='https://fonts.googleapis.com/css?family=Arvo' rel='stylesheet' type='text/css'>
  </head>
  <body>
    <!--Navigation Bar-->  
      <nav role="navigation" class="navbar navbar-custom navbar-fixed-top">
      
          <div class="container-fluid">
            
              <div class="navbar-header">
              
                  <a class="navbar-brand">Online Notes App</a>
                  <button type="button" class="navbar-toggle" data-target="#navbarCollapse" data-toggle="collapse">
                      <span class="sr-only">Toggle navigation</span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                  
                  </button>
              </div>
              <div class="navbar-collapse collapse" id="navbarCollapse">
                  <ul class="nav navbar-nav">
                    <li><a href="profile.php">Profile</a></li>
                    <li class="active"><a href="about.php">About us</a></li>
                    <li><a href="mainpageloggedin.php">My Notes</a></li>
                  </ul>
                  <ul class="nav navbar-nav navbar-right">
            <li><a href="#">Logged in as <b><?php echo $username; ?></b></a></li>
            <li><a href="index.php?logout=1">Logout</a></li>
           
          </ul>
              
              </div>
          </div>
      
      </nav>
    
    <!--Jumbotron with Sign up Button-->
      <div class="jumbotron" id="myContainer">
          <h1>Online Notes App</h1>
          <h2>Your Notes with you wherever you go. Easy to use, protects all your notes!</h2>
          <h4>We the <i>'Creative work imparts beauty'</i> has come together to build this app to make easier the life of our clients or whoever accesses this app when it comes to store their notes in a safe place like this and access them whenever they want! We appreciate and thank you for being part of us and do enjoy using this App! </h4>
      </div>

      
    <!-- Footer-->
      <div class="footer">
          <div class="container">
              <p>Creative work imparts beauty. Copyright &copy; 2021-<?php $today = date("Y"); echo $today?>.</p>
          </div>
      </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script src="javascript.js"></script>
  </body>
</html>