<?php include('../config/constants.php'); ?>

<html>
    <head>
        <title>Login - Food rder System</title>
        <link rel="stylesheet" href="../css/admin.css">
    </head>
    <body class="m">
        <div class="login">
            <h1 class="text-center">Login</h1>

        <br><br>

    <?php

    if(isset($_SESSION['login']))
    {
        echo $_SESSION['login'];
        unset ($_SESSION['login']);
    }

    if(isset($_SESSION['no-login-message']))
    {
        echo $_SESSION['no-login-message'];
        unset ($_SESSION['no-login-message']);
    }
    
    ?>
         <br>
          <!-- Login form -->
          <form action="" method="POST">
            <div class="input-box">
                <i class="fas fa-user"></i>
                <label for="username"><i class="fas fa-user"></i> Username:</label>
                <input type="text" name="username" placeholder="Enter Username" required>
            </div>

            <div class="input-box">
                <i class="fas fa-lock"></i>
                <label for="password"><i class="fas fa-lock"></i> Password:</label>
                <input type="password" name="password" placeholder="Enter Password" required>
            </div>

            <input type="submit" name="submit" value="Login">
        </form>

        <p>Created By - <a href="www.akashsingh">Akash Singh</a></p>
    </div>

    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

</body>
</html>

<?php
// check whether the submit btn is clicked or not
if(isset($_POST['submit']))
{
    // process for login
    // 1.get the data from login form
     //  $username = $_POST['username'];
    //  $password = md5($_POST['password']);
     $username = mysqli_real_escape_string($conn, $_POST['username']);
   
     $raw_password = md5($_POST['password']);
     $password = mysqli_real_escape_string($conn, $raw_password);
    
    // 2.SQL to check the user with usernme nd pass exist or not
    $sql = "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";

    // 3. Execute the query
     $res = mysqli_query($conn, $sql);

    // 4. count rows to check the user exist or not
    $count = mysqli_num_rows($res);

    if($count == 1)
    {
        // user available nd login success
        $_SESSION['login'] = "<div class='success'>Login Successful.</div>";
        $_SESSION['user'] = $username; //to check whether the user is logged in or not nd logout will unset it
        // redirect to home page/dashboard
        header('location:'.SITEURL.'admin/');
    }
    else
    {
        // user not available nd login fail
        $_SESSION['login'] = "<div class='error text-center'>Username or Password did not match.</div>";
        // redirect to home page/dashboard
        header('location:'.SITEURL.'admin/login.php');
    }
}