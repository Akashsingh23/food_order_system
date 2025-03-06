<?php include('partials-front/menu.php'); ?>

<!-- FOOD SEARCH Section Starts Here -->
<section class="food-search text-center py-4">
    <div class="container">
        <form action="<?php echo SITEURL; ?>food-search.php" method="POST">
            <input type="search" name="search" placeholder="Search for Food.." required class="search-input">
            <input type="submit" name="submit" value="Search" class="btn btn-primary">
        </form>
    </div>
</section>
<!-- FOOD SEARCH Section Ends Here -->

<!-- FOOD MENU Section Starts Here -->
<section class="food-menu py-5 bg-light">
    <div class="container">
        <h2 class="text-center fw-bold">Food Menu</h2>

        <div class="row justify-content-center mt-4">
            <?php
            $sql = "SELECT * FROM tbl_food WHERE active='Yes'";
            $res = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($res);

            if ($count > 0) {
                while ($row = mysqli_fetch_assoc($res)) {
                    $id = $row['id'];
                    $title = $row['title'];
                    $description = $row['description'];
                    $price = $row['price'];
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
                echo "<div class='error text-center'>No food items available.</div>";
            }
            ?>
        </div>
    </div>

    <p class="text-center mt-3">
        <a href="<?php echo SITEURL; ?>foods.php" class="text-decoration-none">See All Foods</a>
    </p>
</section>
<!-- FOOD MENU Section Ends Here -->

<?php include('partials-front/footer.php'); ?>

<style>
    /* General Styles */
    .food-menu {
        padding: 4% 0;
        background-color:rgb(155, 78, 78);
    }

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

    /* Search Input */
    .search-input {
        width: 60%;
        padding: 8px;
        border-radius: 5px;
        border: 1px solid #ccc;
        margin-right: 10px;
    }

    @media (max-width: 576px) {
        .search-input {
            width: 80%;
        }
    }
</style>
