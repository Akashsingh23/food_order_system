<?php 

include('partials-front/menu.php'); 
?>

<!-- FOOD SEARCH Section -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Food Order</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        const text = "Explore Our Menu and Satisfy Your Cravings Today";
        let index = 0;

        function typeWriterEffect() {
            if (index < text.length) {
                document.getElementById("typewriter").innerHTML += text.charAt(index);
                index++;
                setTimeout(typeWriterEffect, 35);
            } else {
                animateDots();
            }
        }

        function animateDots() {
            let dotsElement = document.querySelector(".dots");
            let dots = ["", ".", "..", "..."];
            let dotIndex = 0;

            setInterval(() => {
                dotsElement.innerHTML = dots[dotIndex];
                dotIndex = (dotIndex + 1) % dots.length;
            }, 300);
        }

        window.onload = typeWriterEffect;
    </script>
    <style>
        /* Custom styles for small screen adjustments */
        @media (max-width: 768px) {
            .search-form {
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            .search-input {
                width: 75%; /* Reduce width */
            }

            .search-button {
                width: 50%; /* Smaller button */
                margin-top: 10px; /* Space between input and button */
            }
        }
    </style>
</head>
<body>

<section class="food-search text-center py-5 bg-dark text-white">
    <div class="container">
        <h2 class="homepage-heading fw-bold">
            <span id="typewriter"></span><span class="dots"></span>
        </h2>
        <form action="<?php echo SITEURL; ?>food-search.php" method="POST">
            <input type="search" name="search" placeholder="Search for Food.." required class="search-input">
            <input type="submit" name="submit" value="Search" class="btn btn-primary">
        </form>
    </div>
</section>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


<!-- food searcy sectio ends here -->

<?php
if(isset($_SESSION['order']))
{
    echo $_SESSION['order'];
    unset ($_SESSION['order']);
}
?>

<!-- CATEGORIES Section -->
<section class="categories py-5 bg-light">
    <div class="container">
        <h2 class="text-center fw-bold">Explore Foods</h2>

        <div class="row justify-content-center mt-4">
            <?php
            $sql = "SELECT * FROM tbl_category WHERE active='Yes' AND featured='Yes' LIMIT 3";
            $res = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($res);

            if ($count > 0) {
                while ($row = mysqli_fetch_assoc($res)) {
                    $id = $row['id'];
                    $title = $row['title'];
                    $image_name = $row['image_name'];
            ?>
                    <div class="col-md-4 col-12 mb-4">
                        <a href="<?php echo SITEURL; ?>category-foods.php?category_id=<?php echo $id; ?>" class="text-decoration-none">
                            <div class="box-3">
                                <?php
                                if ($image_name == "") {
                                    echo "<div class='error text-center'>Image not Available</div>";
                                } else {
                                    echo '<img src="'.SITEURL.'images/category/'.$image_name.'" alt="'.$title.'" class="img-fluid img-curve">';
                                }
                                ?>
                                <h3 class="float-text text-white"><?php echo $title; ?></h3>
                            </div>
                        </a>
                    </div>
            <?php
                }
            } else {
                echo "<div class='error text-center'>No Categories Found</div>";
            }
            ?>
        </div>
    </div>
</section>

<!-- FOOD MENU Section -->
<section class="food-menu py-5 bg-light">
    <div class="container">
        <h2 class="text-center fw-bold">Food Menu</h2>

        <div class="row justify-content-center mt-4">
            <?php
            $sql2 = "SELECT * FROM tbl_food WHERE active='Yes' AND featured='Yes' LIMIT 6";
            $res2 = mysqli_query($conn, $sql2);
            $count2 = mysqli_num_rows($res2);

            if ($count2 > 0) {
                while ($row = mysqli_fetch_assoc($res2)) {
                    $id = $row['id'];
                    $title = $row['title'];
                    $price = $row['price'];
                    $description = $row['description'];
                    $image_name = $row['image_name'];
            ?>
                    <div class="col-md-4 col-12 mb-4">
                        <div class="food-menu-box">
                            <div class="food-menu-img">
                                <?php
                                if ($image_name == "") {
                                    echo "<div class='error text-center'>Image not Available</div>";
                                } else {
                                    echo '<img src="'.SITEURL.'images/food/'.$image_name.'" alt="'.$title.'" class="img-fluid img-curve">';
                                }
                                ?>
                            </div>

                            <div class="food-menu-desc">
                                <h4><?php echo $title; ?></h4>
                                <p class="food-price">Rs.<?php echo number_format($price, 2); ?></p>
                                <p class="food-detail"><?php echo $description; ?></p>
                                <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $id; ?>" class="btn btn-outline-primary">Order Now</a>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo "<div class='error text-center'>Food not Available</div>";
            }
            ?>
        </div>
    </div>

    <p class="text-center mt-3">
        <a href="<?php echo SITEURL; ?>foods.php" class="text-decoration-none">See All Foods</a>
    </p>
</section>

<style>
    .food-menu {
        padding: 4% 0;
        background-color: #ececec;
    }

    /* Food Menu Box */
    .food-menu-box {
        background-color: white;
        border-radius: 15px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        padding: 2%;
        height: 100%;
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        position: relative;
        padding-bottom: 60px; /* Space for button */
    }

    /* Hover Effect */
    .food-menu-box:hover {
        transform: scale(1.05);
        box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.2);
    }

    /* Food Image */
    .food-menu-img {
        width: 150px;
        height: 150px;
        display: flex;
        justify-content: center;
        align-items: center;
        overflow: hidden;
        border-radius: 10px;
    }

    .food-menu-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 10px;
        transition: transform 0.3s ease-in-out;
    }

    /* Image Hover Zoom */
    .food-menu-box:hover .food-menu-img img {
        transform: scale(1.1);
    }

    /* Food Description */
    .food-menu-desc {
        width: 100%;
        padding: 10px;
    }

    /* Title */
    .food-menu-desc h4 {
        font-size: 1.2rem;
        font-weight: bold;
    }

    /* Price */
    .food-price {
        font-size: 1rem;
        margin: 5px 0;
        font-weight: bold;
        color: #007bff;
    }

    /* Description */
    .food-detail {
        font-size: 1rem;
        color: #747d8c;
    }

    /* Order Now Button */
    .food-menu-desc .btn-outline-primary {
        position: absolute;
        bottom: 10px;
        left: 50%;
        transform: translateX(-50%);
        width: 50%;
        text-align: center;
        border: 2px solid #007bff;
        color: #007bff;
        padding: 5px 10px;
        font-size: 1rem;
        border-radius: 5px;
        transition: all 0.3s ease-in-out;
    }

    /* Button Hover Effect */
    .food-menu-box:hover .btn-outline-primary {
        background-color: #007bff;
        color: white;
        border-color: #007bff;
        box-shadow: 0px 0px 10px rgba(0, 123, 255, 0.6);
    }

    /* Responsive Layout */
    @media (max-width: 768px) {
        .food-menu .row {
            flex-direction: column;
            align-items: center;
        }

        .food-menu-box {
            width: 100%;
        }

        .food-menu-img {
            width: 120px;
            height: 120px;
        }

        .food-menu-desc .btn-outline-primary {
            width: 60%;
        }
    }
</style>


<?php include('partials-front/footer.php'); ?>
