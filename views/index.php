<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Sign In</title>
    <link rel="stylesheet" href="css/loginpage.css">
</head>
<body>
    <!-- mao ni saiyahang login maam human moadtu sya sa login_action para e identify niya ang username na imong e login if success mapadung sya user_dashboard  -->
    
    <div class="form-box">
    <div class="center-icon">
        <img src="uploads/logopic.png" alt="423062764-1342544113808335-7405620093325838006-n-removebg-preview">
        </div>

        <form action="login_action.php" method="POST" id="login" class="input-group">
            <br><br>
            <div class="input-container">
                <i class="fas fa-user-circle"></i>
                <input type="text" class="input-field" placeholder="Username" name="username">
            </div>
            <div class="input-container">
                <i class="fas fa-lock"></i>
                <input type="password" class="input-field" placeholder="Password" name="password">
                <i class="far fa-eye show-hide-password" onclick="togglePassword(this, 'password')"></i>
            </div>
            <button type="submit" class="submit" value="Login">Login</button>
            <p class="message">Don't have any account? <a href="registerpage.php" style="color: darkgreen;">Register</a></p>
        </form> 
    </div>
    <script src="js/togglepassword.js">
       
    </script>
</body>
</html>