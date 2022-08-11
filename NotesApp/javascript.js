//Ajax Call for the sign up form
//once the form is submitted
$("#signupform").submit(function(event){
 //prevent default php processing
 event.preventDefault();
  //collect user inputs
  var datatopost = $(this).serializeArray();
  //console.log(datatopost);
  //send them to signup.php using Ajax
  $.ajax({
    url: "signup.php",
    type: "POST",
    data: datatopost,
    success: function(data){
      if($.trim(data)){
       $("#signupmessage").html(data); 
      }
    },
    error: function(){
       $("#signupmessage").html("<div class='alert alert-danger'>There was an error with the Ajax call. Please try again later.</div>"); 
    }
  });
});
 
  
//Ajax Call for the login form
//once the form is submitted
$("#loginform").submit(function(event){
 //prevent default php processing
 event.preventDefault();
  //collect user inputs
  var datatopost = $(this).serializeArray();
  console.log(datatopost);
  //send them to login.php using Ajax
  $.ajax({
    url: "login.php",
    type: "POST",
    data: datatopost,
    success: function(data){
       if($.trim(data) == "success"){
          window.location= "mainpageloggedin.php";      
      }else{
        $("#loginmessage").html(data);
      }
    },
    error: function(){
       $("#loginmessage").html("<div class='alert alert-danger'>There was an error with the Ajax call. Please try again later.</div>"); 
    }
  });
});


//Ajax Call for the forgot password form
//once the form is submitted
  //prevent default php processing
  //collect user inputs
  //send them to login.php using Ajax
    //Ajax Call successful: show error or success message
    //Ajax call fails: show Ajax call error
//Ajax Call for the login form
//once the form is submitted

$("#forgotpasswordform").submit(function(event){
 //prevent default php processing
 event.preventDefault();
  //collect user inputs
  var datatopost = $(this).serializeArray();
  //console.log(datatopost);
  //send them to signup.php using Ajax
  $.ajax({
    url: "forgot-password.php",
    type: "POST",
    data: datatopost,
    success: function(data){
       $('#forgotpasswordmessage').html(data);
    },
    error: function(){
       $("#forgotpasswordmessage").html("<div class='alert alert-danger'>There was an error with the Ajax call. Please try again later.</div>"); 
    }
  });
});
