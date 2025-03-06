<?php
// include constants page
include('../config/constants.php');

    // echo "Delete thefood page";

    if(isset($_GET['id']) && isset($_GET['image_name']))
    {
        // process to del
        // echo "Process to del";

        // 1.get id nd image name
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        // 2.remove the img if avai
        // check whether the img is avai or not nd del only ifg avai
        if($image_name != "")
        {
            // if has img nd need to remove from folder
            // get the img path
            $path = "../images/food/".$image_name;

            // remove img file from folder
            $remove = unlink($path);

            // check whether img is remove or not
            if($remove==false)
            {
                // failed to remove img
                $_SESSION['upload']= "<div class='error'>Failed to remove image file.</div>";
                // reidrect to manage food
                header('location:'.SITEURL.'admin/manage-food.php');
                // stop the process of del food
                die();
            }
        }

        // 3.delete food frm db
        $sql = "DELETE FROM tbl_food WHERE id=$id";
        // execute the query
        $res = mysqli_query($conn, $sql);

        // check whether the query executed or not nd set the sessi0n msg resp.
        
        // 4.redirect to manage food with session msg
        if($res==true)
        {
            // food deleted
            $_SESSION['delete'] = "<div class='success'>Food Deleted Successfully.</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }
        else
        {
            // failed to delete food
            $_SESSION['delete'] = "<div class='error'>Failed to Delete food.</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }

    }
    else
    {
        // redirect to manage food page
        // echo "redict ";
        $_SESSION['unauthorize'] = "<div class='error'>Unauthorized Access.</div>";
        header('location:'.SITEURL.'admin/manage-food.php');
    }

?>
