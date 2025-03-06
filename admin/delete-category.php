<?php

// Include constants file
include('../config/constants.php');

// Check whether the id and image_name values are set or not
if(isset($_GET['id']) AND isset($_GET['image_name']))
{
    // Get the values
    $id = $_GET['id'];
    $image_name = $_GET['image_name'];

    // Remove the physical image file if available
    if($image_name != "")
    {
        // Corrected file path (added "/")
        $path = "../images/category/" . $image_name;

        // Check if file exists before deleting
        if(file_exists($path))
        {
            $remove = unlink($path);
            
            // If failed to remove image, add an error message and stop the process
            if($remove == false)
            {
                $_SESSION['remove'] = "<div class='error'>Failed to Remove Category Image.</div>";
                header('location:'.SITEURL.'admin/manage-category.php');
                die(); // Stop the process
            }
        }
    }

    // Delete data from database
    $sql = "DELETE FROM tbl_category WHERE id=$id";

    // Execute query
    $res = mysqli_query($conn, $sql);

    // Check whether the data is deleted from the database or not
    if($res == true)
    {
        // Set success message and redirect
        $_SESSION['delete'] = "<div class='success'>Category Deleted Successfully.</div>";
        header('location:'.SITEURL.'admin/manage-category.php');
    }
    else
    {
        // Set failure message and redirect
        $_SESSION['delete'] = "<div class='error'>Failed to Delete Category.</div>";
        header('location:'.SITEURL.'admin/manage-category.php');
    }
}
else
{
    // Redirect to manage category page
    header('location:'.SITEURL.'admin/manage-category.php');
}

?>
