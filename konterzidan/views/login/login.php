<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="stylelogin.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css" rel="stylesheet">  
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <title>Login Page</title>
</head>

<body>
<div class="wrapper">
         <div class="title">
            Login Form
         </div>
         <form id="sample_form">
            <div class="field">
               <input type="text" id="email" required>
               <label>Email Address</label>
            </div>
            <div class="field">
               <input type="password" id="pw" required>
               <label>Password</label>
            </div>
            <div class="content">
               <div class="checkbox">
                  <input type="checkbox" id="remember-me">
                  <label for="remember-me">Remember me</label>
               </div>
               <div class="pass-link">
                  <a href="#">Forgot password?</a>
               </div>
            </div>
            <div class="field">
               <input type="submit" value="Login" id="action_button">
            </div>
            <div class="signup-link">
               Not a member? <a href="../register/regis.php">Signup now</a>
            </div>
         </form>
      </div>        
    <script>
       $(document).ready(function() {
          $('#sample_form').on('submit', function(event){
              event.preventDefault();              
              var formData = {
              'email' : $('#email').val(),
              'pw' : $('#pw').val()
              }
              $.ajax({
                  url:"http://localhost:8080/konterzidan/api/auth/login.php",
                  method:"POST",
                  data: JSON.stringify(formData),
                  success:function(data){
                      $('#action_button').attr('disabled', false);
                      window.location.href = 'http://localhost:8080/konterzidan/views/dashboard/index.php';
                  },
                  error: function(err) {                        
                      console.log(err);   
                      $('#message').html('<div class="alert alert-danger">'+err.responseJSON+'</div>');   
                  }
              });
          });
      });    
    </script>
     <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
  </body>
</html>