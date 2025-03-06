<?php 
ob_start(); // Start output buffering

include('partials-front/menu.php'); 

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if food_id is provided
if (isset($_GET['food_id'])) {
    $food_id = $_GET['food_id'];

    // Get food details
    $sql = "SELECT * FROM tbl_food WHERE id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $food_id); // 'i' for integer
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $title = $row['title'];
        $price = $row['price'];
        $image_name = $row['image_name'];
    } else {
        echo "<div class='alert alert-danger text-center'>Food not found.</div>";
        exit;
    }
} else {
    echo "<div class='alert alert-warning text-center'>No food selected. Please go to the menu and select an item.</div>";
    exit;
}
?>

<section class="food-search">
<style>
    .custom-bg {
        background-color: rgba(255, 255, 255, 0.7);
        border-radius: 15px;
        padding: 5px 15px;
        display: inline-block;
        margin: 0 auto;
        text-align: center;
    }
    .required-input {
        border: 2px solid red;
    }
    .required-input:focus {
        border-color: darkred;
        outline: none;
    }
    .required-indicator {
        color: red;
    }
</style>

<div class="text-center">
    <h4 class="my-3 custom-bg text-secondary">Fresh food, fast delivery – Fill in your details below!</h4>
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <form action="" method="POST" class="border p-4 rounded shadow bg-white needs-validation" novalidate>
                <!-- Selected Food Section -->
                <div class="mb-4 text-center">
                    <h4 class="fw-bold"><?php echo htmlspecialchars($title ?? 'N/A'); ?></h4>
                    <input type="hidden" name="food" value="<?php echo htmlspecialchars($title); ?>">
                    <p class="lead text-secondary fw-bold">Price: Rs.<?php echo htmlspecialchars($price ?? '0'); ?></p>
                    <input type="hidden" name="price" value="<?php echo htmlspecialchars($price); ?>">
                    
                    <?php if (!empty($image_name)) { ?>
                        <img src="<?php echo SITEURL; ?>images/food/<?php echo htmlspecialchars($image_name); ?>" class="img-fluid rounded" style="max-width: 250px;">
                    <?php } else { ?>
                        <p class="text-muted">Image not available.</p>
                    <?php } ?>
                </div>

                <!-- Quantity -->
                <div class="mb-3">
                    <label for="qty" class="form-label fw-bold">Quantity</label>
                    <input type="number" name="qty" id="qty" class="form-control" value="1" required>
                </div>

                <!-- Delivery Details -->
                <h5 class="text-secondary mb-3">Delivery Details</h5>

                <div class="form-floating mb-3">
                    <input type="text" name="full-name" class="form-control required-input" id="full-name" placeholder="Full Name" required>
                    <label for="full-name">Full Name <span class="required-indicator">*</span></label>
                </div>

                <div class="form-floating mb-3">
                    <input type="tel" name="contact" class="form-control required-input" id="contact" placeholder="Phone Number" required>
                    <label for="contact">Phone Number <span class="required-indicator">*</span></label>
                </div>

                <div class="form-floating mb-3">
                    <input type="email" name="email" class="form-control required-input" id="email" placeholder="Email" required>
                    <label for="email">Email <span class="required-indicator">*</span></label>
                </div>

                <div class="form-floating mb-4">
                    <textarea name="address" class="form-control" id="address" placeholder="Address" style="height: 100px;" required></textarea>
                    <label for="address">Address <span class="required-indicator">*</span></label>
                </div>

                <button type="submit" name="submit" class="btn btn-primary w-100">Confirm Order</button>
            </form>
        </div>
    </div>

    <?php
    if (isset($_POST['submit'])) {
        $food = $_POST['food'];
        $price = $_POST['price'];
        $qty = $_POST['qty'];
        $total = $price * $qty;
        $order_date = date("Y-m-d H:i:s"); // Use 24-hour format
        $status = "Ordered";

        // Sanitize user inputs
        $customer_name = htmlspecialchars($_POST['full-name']);
        $customer_contact = htmlspecialchars($_POST['contact']);
        $customer_email = htmlspecialchars($_POST['email']);
        $customer_address = htmlspecialchars($_POST['address']);

        // Prepare the INSERT statement
        $sql2 = "INSERT INTO tbl_order (food, price, qty, total, order_date, status, customer_name, customer_contact, customer_email, customer_address) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt2 = mysqli_prepare($conn, $sql2);

        // Bind the parameters
        mysqli_stmt_bind_param($stmt2, 'sdiissssss', $food, $price, $qty, $total, $order_date, $status, $customer_name, $customer_contact, $customer_email, $customer_address);
        
        if (mysqli_stmt_execute($stmt2)) {
            $_SESSION['order'] = "<div class='alert alert-success text-center'>Food ordered successfully.</div>";
            header('location:' . SITEURL);
            exit;
        } else {
            $_SESSION['order'] = "<div class='alert alert-danger text-center'>Failed to order food.</div>";
            header('location:' . SITEURL);
            exit;
        }
    }
    ?>
</div>
</section>

<?php include('partials-front/footer.php'); ?>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Form Validation -->
<script>
    (function () {
        'use strict';
        var forms = document.querySelectorAll('.needs-validation');
        Array.prototype.slice.call(forms).forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    })();
</script>

<?php 
ob_end_flush(); // Flush the output buffer and turn off output buffering
?>
