<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/loginpage.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Sign In</title>
    <link rel="stylesheet" href="css/loginpage.php">
</head>
<body>
    <div class="form-box">
    <center><div class="center-icon">
        <img src="uploads/logopic.png" alt="423062764-1342544113808335-7405620093325838006-n-removebg-preview" style="width:300px; height:130px; margin-bottom: 10px;">
        </div>

        <form action="login_action.php" method="POST" id="login" class="input-group">
            <br><br>
            <div class="input-container">
                <i class="fas fa-user-circle"></i>
                <input type="text" class="input-field" placeholder="Username" name="username">
            </div><br><br><br>
            <div class="input-container">
                <i class="fas fa-lock"></i>
                <input type="password" class="input-field" placeholder="Password" name="password">
                <i class="far fa-eye show-hide-password" onclick="togglePassword(this, 'password')"></i>
            </div>
            <a href="#" class="forgot-password">Forgot password?</a><br><br><br>
            <center><button type="submit" class="submit" value="Login" style="width: 110px;font-size:17px; height: 40px; background-color: maroon; color: #fff; border: none; border-radius: 3px;">Login</button>
            <br><br><br><br>
            <center><p class="message">Don't have any account? <a href="registerpage.php" style="color:maroon;">Register</a></p>
        </form> 
    </div>
    
    <script src="js/togglepassword.js">
       
    </script>
</body>
</html>