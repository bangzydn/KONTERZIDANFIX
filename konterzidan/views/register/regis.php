<!DOCTYPE html>
<!-- Created By CodingLab - www.codinglabweb.com -->
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title>Registration Form</title>
    <link rel="stylesheet" href="stylereg.css">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
   </head>
<body>
  <div class="container">
    <div class="title">Registration</div>
    <div class="content">
      <form id="sample_form">
        <div class="user-details">
          <div class="input-box">
            <span value="fullname">Full Name</span>
            <input type="text" placeholder="Enter your name" id="fullname">
          </div>
          <div class="input-box">
            <span value="email">Email</span>
            <input type="text" placeholder="Enter your email" id="email">
          </div>
          <div class="input-box">
            <span value="pw">Password</span>
            <input type="password" placeholder="Enter your password" id="pw">
          </div>
        </div>
        <div class="button">
          <input type="submit" value="Register" id="action_button">
        </div>
      </form>
    </div>
  </div>
    <script>
      $(document).ready(function() {
        $('#sample_form').on('submit', function(event){
          event.preventDefault();
          var formData = {
          'fullname' : $('#fullname').val(),
          'email' : $('#email').val(),
          'pw' : $('#pw').val(),
          'rolee' : $('#rolee').val()
          }
          $.ajax({
            url:"http://localhost:8080/konterzidan/api/auth/register.php",
            method:"POST",
            data: JSON.stringify(formData),
            success:function(data){
              $('#action_button').attr('disabled', false);
              $('#message').html('<div class="alert alert-success">'+data.message+'</div>');
              window.location.href = 'http://localhost:8080/konterzidan/views/login/login.php';
            },
            error: function(err) {
              console.log(err);
            }
          });
        });
      });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>
</html>