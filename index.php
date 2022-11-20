<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="assets/style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <title>LogIn</title>
    </head>
    <body>
    <div class="message" id = "loginM"></div>
    <!-- <div class="message" id = "registerM"></div> -->
    <div class="main">
    <div class="flex space-between col w-max loginDiv padT10rem alignCenter">
        <div class="box1 bgs2 flex">
            <div class = "login-logo pad2rem flex alignCenter justifyCenter" id="logo">
                <h1>Fuel Task</h1>
            </div>
            <div>
                <div class="loginBox alignCenter flex justifyCenter pad5rem" id ="loginBox">
                    <div class = "gap1 alignCenter flex col">
                        <h1>Login</h1>
                        <div class="flex col">
                            <label for="Username">Username:</label>
                            <input type="text" id = "username">
                        </div>
                        <div class="flex col">
                            <label for="Pass">Password:</label>
                            <input type="password" id = "password">
                        </div> 
                        <button class = "btn" onclick="loginAjax()">LogIn</button>
                        <p id = "register">Register</p>
                    </div>
                </div>
                <div class="registerBox alignCenter flex justifyCenter padL5rem padT5rem padR5rem padB2rem none" id ="registerBox">
                    <div class = "gap1 alignCenter flex col">
                        <h1>Register</h1>
                        <div class="flex col">
                            <label for="Username">Username:</label>
                            <input type="text" id = "usernameR">
                        </div>
                        <div class="flex col">
                            <label for="Pass">Password:</label>
                            <input type="password" id = "passwordR">
                        </div>
                        <div class="flex col">
                            <label for="Confirm">Confirm password:</label>
                            <input type="password" id = "confirm">
                        </div> 
                        <button class = "btn" onclick="registerAjax()">Register</button>
                        <p id = "login">Login</p>
                    </div>
                </div>
            </div>
        </div>  
    </div>
    <script src = "assets/script.js"></script>
    </body>
</html>