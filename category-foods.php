<?php include('partials-front/menu.php'); ?>

<?php 
// Check whether category ID is passed or not
if (isset($_GET['category_id'])) {
    $category_id = $_GET['category_id'];

    // Get the category title
    $sql = "SELECT title FROM tbl_category WHERE id=$category_id";
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($res);
    $category_title = $row['title'];
} else {
    // Redirect to homepage if no category is selected
    header('location:' . SITEURL);
}
?>

<!-- Food Search Section Starts Here -->
<section class="food-search text-center bg-dark py-4">
    <div class="container">
        <h2 class="text-white">
            Foods in <span class="text-warning" style="font-weight: bold; text-transform: capitalize;"><?php echo $category_title; ?></span>
        </h2>
    </div>
</section>
<!-- Food Search Section Ends Here -->

<!-- Food Menu Section Starts Here -->
<section class="food-menu py-5">
    <div class="container">
        <h2 class="text-center fw-bold mb-4">Food Menu</h2>

        <div class="row">
            <?php
            // Fetch food items for the selected category
            $sql2 = "SELECT * FROM tbl_food WHERE category_id=$category_id";
            $res2 = mysqli_query($conn, $sql2);
            $count2 = mysqli_num_rows($res2);

            if ($count2 > 0) {
                while ($row2 = mysqli_fetch_assoc($res2)) {
                    $id = $row2['id'];
                    $title = $row2['title'];
                    $price = $row2['price'];
                    $description = $row2['description'];
                    $image_name = $row2['image_name'];
            ?>
                    <div class="col-md-6 col-lg-4 col-12 mb-4">
                        <div class="food-menu-box p-3 shadow-sm rounded">
                            <div class="food-menu-img">
                                <?php if ($image_name == "") { ?>
                                    <div class="error text-center">Image not Available</div>
                                <?php } else { ?>
                                    <img src="images/food/<?php echo $image_name; ?>" alt="<?php echo $title; ?>" class="img-fluid rounded">
                                <?php } ?>
                            </div>

                            <div class="food-menu-desc mt-3">
                                <h4 class="fw-bold"><?php echo $title; ?></h4>
                                <p class="food-price text-success fw-bold">Rs. <?php echo $price; ?></p>
                                <p class="food-detail text-muted"><?php echo $description; ?></p>
                                <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $id; ?>" class="btn btn-outline-primary mt-2">Order Now</a>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo "<div class='error text-center'>Food not available.</div>";
            }
            ?>
        </div>
    </div>
</section>
<!-- Food Menu Section Ends Here -->

<?php include('partials-front/footer.php'); ?>

<style>
    /* General Styles */
    .food-menu-box {
        background: #fff;
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        border-radius: 15px;
    }

    .food-menu-box:hover {
        transform: scale(1.05);
        box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.2);
    }

    /* Food Image */
    .food-menu-img img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 10px;
    }

    /* Responsive Layout */
    @media (max-width: 768px) {
        .food-menu-box {
            padding: 15px;
        }
    }

    @media (max-width: 576px) {
        .food-menu-img img {
            height: 180px;
        }
    }
</style>
