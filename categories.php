<?php include('partials-front/menu.php'); ?>

<!-- CATEGORIES Section Starts Here -->
<section class="categories py-5 bg-light">
    <div class="container">
        <h2 class="text-center fw-bold mb-4">Explore Foods</h2>

        <div class="row justify-content-center">
            <?php
            // Fetch all active categories
            $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
            $res = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($res);

            if ($count > 0) {
                while ($row = mysqli_fetch_assoc($res)) {
                    $id = $row['id'];
                    $title = $row['title'];
                    $image_name = $row['image_name'];
            ?>
                    <div class="col-md-4 col-sm-6 col-12 mb-4">
                        <a href="<?php echo SITEURL; ?>category-foods.php?category_id=<?php echo $id; ?>" class="category-link">
                            <div class="category-box position-relative">
                                <?php
                                if ($image_name == "") {
                                    echo "<div class='error text-center'>Image not found</div>";
                                } else {
                                    echo '<img src="'.SITEURL.'images/category/'.$image_name.'" alt="'.$title.'" class="img-fluid category-img">';
                                }
                                ?>
                                <div class="category-overlay">
                                    <h3 class="text-white"><?php echo $title; ?></h3>
                                </div>
                            </div>
                        </a>
                    </div>
            <?php
                }
            } else {
                echo "<div class='error text-center'>Category not found.</div>";
            }
            ?>
        </div>
    </div>
</section>
<!-- CATEGORIES Section Ends Here -->

<?php include('partials-front/footer.php'); ?>

<style>
    /* General Styles */
    .categories {
        padding: 4% 0;
    }

    .category-box {
        overflow: hidden;
        border-radius: 15px;
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        position: relative;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    }

    .category-box:hover {
        transform: scale(1.05);
        box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.2);
    }

    /* Category Image */
    .category-img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 15px;
        transition: transform 0.3s ease-in-out;
    }

    /* Image Hover Effect */
    .category-box:hover .category-img {
        transform: scale(1.1);
    }

    /* Overlay Text */
    .category-overlay {
        position: absolute;
        bottom: 30%;
        left: 0;
        width: 100%;
        background: rgba(79, 79, 79, 0.4);
        padding: 10px;
        text-align: center;
        border-radius: 0 0 15px 15px;
    }

    .category-overlay h3 {
        font-size: 1.2rem;
        margin: 0;
    }

    /* Link Styling */
    .category-link {
        text-decoration: none;
    }

    /* Responsive Layout */
    @media (max-width: 768px) {
        .category-img {
            height: 180px;
        }
    }

    @media (max-width: 576px) {
        .category-img {
            height: 150px;
        }
    }
</style>
