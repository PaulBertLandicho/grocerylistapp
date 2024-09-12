<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/loginpage.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Sign Up</title>
    <link rel="stylesheet" href="css/loginpage.php">

  </head>
  <body>
    
    <div class="form-box">
      <center>
        <div class="center-icon">
       <img src="uploads/logopic.PNG" alt="423062764-1342544113808335-7405620093325838006-n-removebg-preview" style="width:300px; height:130px; margin-bottom: 10px;">
      <br>
      <br>
      <br>
      <form action="register_action.php" method="POST" id="register" class="input" style="width: 300px; margin: 0 auto;">
        <div class="input-container">
          <i class="fas fa-user-circle"></i>
          <input type="text" class="input-field" placeholder="Username" name="username">
        </div>
        <br>
        <br>
        <div class="input-container">
          <i class="fas fa-envelope"></i>
          <input type="email" class="input-field" placeholder="Email" name="email">
        </div>
        <br>
        <br>
        <div class="input-container">
          <i class="fas fa-lock"></i>
          <input type="password" class="input-field" placeholder="Password" name="password">
          <i class="far fa-eye show-hide-password" onclick="togglePassword(this, 'password')"></i>
        </div>
        <br>
        <br>
        <div class="input-container">
          <i class="fas fa-lock"></i>
          <input type="password" class="input-field" placeholder="Confirm Password" name="confirm_password">
          <i class="far fa-eye show-hide-password" onclick="togglePassword(this, 'confirm_password')"></i>
        </div>
        <br>
        <br>
        <center>
          <button type="submit" class="submit" style="width: 110px;font-size:17px; height: 40px; background-color: maroon; color: #fff; border: none; border-radius: 3px;">Register</button>
          <br>
          <br>
          <br>
          <p class="message">Already have an account? <a href="loginpage.php" style="color:maroon;">Login</a>
          </p>
      </form>
    </div>
       <script src="js/togglepassword.js">
</script>
  </body>
</html>