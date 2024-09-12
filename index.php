<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <title>| Mainpage |</title>
</head>
<body>
    <style>
        #splash-screen {
    background-color: maroon;
    color: #fff;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 9999;
    transition: opacity 1s ease;
}

#content {
    display: none;
}
#splash-screen {
    /* Existing styles */
    transition: opacity 3s ease; /* Increase the duration to 3 seconds */
}
    </style>
    <div id="splash-screen">
<h1 class="futuristic-heading">Welcome to Grocery List</h1>
    </div>
    <div class="banner">
        <div class="navbar">
        </div>
    <div class="content">
        <h1>Food is Always<br>a good idea.</h1>
        <p>Eating healthy starts at the grocery store.<br>Choose the best food for you.</p>
        <div>
            <button type="button" onclick="switchPage()" id="start"><span></span>Start to taste</button>
        </div>
    </div>
    <script>document.addEventListener("DOMContentLoaded", function() {
    // Simulate loading time
    setTimeout(function() {
        // Hide the splash screen gradually
        document.getElementById("splash-screen").style.opacity = 0;

        // Show the content after the splash screen fades out
        setTimeout(function() {
            document.getElementById("content").style.display = "block";
        }, 2000); // Wait for 3 seconds before showing the content

        // After fading out, remove the splash screen from the DOM
        setTimeout(function() {
            document.getElementById("splash-screen").remove();
        }, 3000); // Remove the splash screen after 6 seconds
    }, 1000); // Adjust the timeout as needed (3000ms = 3s)
});
</script>
    <script>
        function switchPage(){
            // Fade out the content
            document.querySelector('.content').classList.add('fade-out');
            // Delay the redirection to see the transition effect
            setTimeout(function() {
                window.location.href = 'loginpage.php';
            }, 200); // Adjust the timeout as needed (500ms = 0.5s)
        }
    </script>
</body>
</html>
