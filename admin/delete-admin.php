<?php

// include constants.php file here
include('../config/constants.php');

// 1. get the ID of Admin to be deleted
 $id = $_GET['id'];

// 2. Create SQlo query to del Admin
$sql = "DELETE FROM tbl_admin WHERE id=$id";

// executer the query
$res = mysqli_query($conn, $sql);

// check whether the query executed succesfully or not
if($res==true)
{
    // query excuted successfulyy nd admin deleted
    // echo "Admin deleted";
    // create session var to display msg
    $_SESSION['delete'] = "<div class='success'>Admin deleted successfully.</div>";
    // reidrect to manage admin page
    header('location:'.SITEURL.'admin/manage-admin.php');
}
else
{
    // failed to delete admin
    // echo "Failed to delete admin";
    $_SESSION['delete'] = "<div class='error'>Failed to delete admin. try Again later.</div>";
    header('location:'.SITEURL.'admin/manage-admin.php');
}

// 3. Redriect to manage admin page with msg (success/error


?>
