
<?php
$link = mysqli_connect("localhost", "claygenh_notes", "notes", "claygenh_onlinenotes");
if(mysqli_connect_error()){
 die("ERROR: Unable to connect" . mysqli_connect_error()); 
}
?>