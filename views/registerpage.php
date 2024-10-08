<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/loginpage.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Sign Up</title>

  </head>
  <body>
    <!-- mao ni saiyahang register maam inig human nimo fill in  maam moadtu sya sa register_action para iyahang e process padulong sa database para e Post sa register ang ID user then directly na sya mo proceed sa user_dashboard -->
    
    <div class="form-box">
        <div class="center-icon">
       <img src="uploads/logopic.PNG" alt="423062764-1342544113808335-7405620093325838006-n-removebg-preview">
     
      <form action="register_action.php" method="POST" id="register" class="input" style="width: 300px; margin: 0 auto;">
        <div class="input-container">
          <i class="fas fa-user-circle"></i>
          <input type="text" class="input-field" placeholder="Username" name="username">
        </div>
     
        <div class="input-container">
          <i class="fas fa-envelope"></i>
          <input type="email" class="input-field" placeholder="Email" name="email">
        </div>
       
        <div class="input-container">
          <i class="fas fa-lock"></i>
          <input type="password" class="input-field" placeholder="Password" name="password">
          <i class="far fa-eye show-hide-password" onclick="togglePassword(this, 'password')"></i>
        </div>
      
        <div class="input-container">
          <i class="fas fa-lock"></i>
          <input type="password" class="input-field" placeholder="Confirm Password" name="confirm_password">
          <i class="far fa-eye show-hide-password" onclick="togglePassword(this, 'confirm_password')"></i>
        </div>
      
          <button type="submit" class="submit">Register</button>
          
          <p class="message">Already have an account? <a href="index.php" style="color: darkgreen;">Login</a>
          </p>
      </form>
    </div>
 
       <script src="js/togglepassword.js">
</script>
  </body>
</html>