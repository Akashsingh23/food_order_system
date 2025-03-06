<?php include('partials-front/menu.php'); ?>

<?php
if (isset($_POST['submit'])) {
    // Retrieve the search keyword from the POST data
    $search = mysqli_real_escape_string($conn, $_POST['search']);

    // SQL query to get the food based on search keyword
    $sql = "SELECT * FROM tbl_food WHERE title LIKE '%$search%' OR description LIKE '%$search%'";
    // Execute the query
    $res = mysqli_query($conn, $sql);
    // Count rows
    $count = mysqli_num_rows($res);
}
?>

<!-- fOOD sEARCH Section Starts Here -->
<section class="food-search text-center py-5">
    <div class="container">
        <?php if (isset($search)): ?>
            <h2>Foods on Your Search <a href="#" class="text-white" style="text-decoration: none; font-weight: bold; text-transform: capitalize;"><?php echo $search; ?></a></h2>
        <?php endif; ?>
    </div>
</section>
<!-- fOOD sEARCH Section Ends Here -->

<!-- fOOD Menu Section Starts Here -->
<section class="food-menu py-5">
    <h2 class="text-center">Food Menu</h2>
    <div class="container">
        <div class="row justify-content-center">
            <?php
            // Check whether food is available or not
            if (isset($count) && $count > 0) {
                while ($row = mysqli_fetch_assoc($res)) {
                    // Get the details
                    $id = $row['id'];
                    $title = $row['title'];
                    $price = $row['price'];
                    $description = $row['description'];
                    $image_name = $row['image_name'];
            ?>
                    <div class="col-md-4 col-sm-6 col-12 mb-4">
                        <div class="food-menu-box">
                            <div class="food-menu-img">
                                <?php
                                // Check whether the image is available or not
                                if ($image_name == "") {
                                    // Image not available
                                    echo "<div class='error'>Image not Available.</div>";
                                } else {
                                    // Image available
                                    ?>
                                    <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="<?php echo $title; ?>" class="img-responsive img-curve">
                                    <?php
                                }
                                ?>
                            </div>

                            <div class="food-menu-desc text-center">
                                <h4><?php echo $title; ?></h4>
                                <p class="food-price">Rs.<?php echo $price; ?></p>
                                <p class="food-detail"><?php echo $description; ?></p>
                                <br>
                                <a href="#" class="btn btn-outline-primary">Order Now</a>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
                // Food not available
                echo "<div class='error text-center'>Food not found.</div>";
            }
            ?>
        </div>
    </div>
</section>
<!-- fOOD Menu Section Ends Here -->

<?php include('partials-front/footer.php'); ?>

<style>
    /* Add some custom styles for better responsiveness */
    .food-menu-box {
        border: 1px solid #e7e7e7;
        border-radius: 10px;
        padding: 20px;
        transition: transform 0.3s ease-in-out;
    }

    .food-menu-box:hover {
        transform: scale(1.05);
    }

    .food-menu-img {
        width: 100%;
        height: 200px; /* Fixed height for images */
        display: flex;
        justify-content: center;
        align-items: center;
        overflow: hidden;
    }

    .food-menu-img img {
        width: 100%;
        height: 100%;
        object-fit: cover; /* Maintain aspect ratio */
    }
</style>
