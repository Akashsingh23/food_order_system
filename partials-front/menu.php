<?php include('config/constants.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Website</title>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar {
            background-color: #ffffff;
        }
        .navbar-brand {
            font-family: 'Trebuchet MS', sans-serif;
           font-weight: 700;
            color: rgb(255, 82, 0);
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);
            transition: color 0.3s ease-in-out;
        }
        .navbar-toggler {
            border-color: rgb(46, 39, 36);
        }
        .nav-item {
            margin-left: 20px;
            font-weight: bold;
            font-family: Arial, sans-serif;
        }
        .navbar-nav .nav-link {
            color: rgb(255, 82, 0);
            transition: color 0.3s;
        }
        .navbar-nav .nav-link:hover {
            color: #007bff;
        }
        .nav-item.active .nav-link {
    font-weight: bold; /* Example: Make active link bold */
    color: red;       /* Change color to red */
}

    </style>
</head>

<body>
    <!-- Navbar Section Starts Here -->
    <?php 
    $current_page = basename($_SERVER['PHP_SELF']); // Get the current page name
    ?>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand me-auto"style="color:rgb(255, 82, 0); font-size: 2rem;" href="#">Flavour Fusion</a>
            <button class="navbar-toggler navbar-light" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item <?php echo ($current_page == 'index.php') ? 'active' : ''; ?>">
                        <a class="nav-link" href="<?php echo SITEURL; ?>">Home</a>
                    </li>
                    <li class="nav-item <?php echo ($current_page == 'categories.php') ? 'active' : ''; ?>">
                        <a class="nav-link" href="<?php echo SITEURL; ?>categories.php">Categories</a>
                    </li>
                    <li class="nav-item <?php echo ($current_page == 'foods.php') ? 'active' : ''; ?>">
                        <a class="nav-link" href="<?php echo SITEURL; ?>foods.php">Foods</a>
                    </li>
                    <li class="nav-item <?php echo ($current_page == 'order.php') ? 'active' : ''; ?>">
                        <a class="nav-link" href="<?php echo SITEURL; ?>order.php">Orders</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
