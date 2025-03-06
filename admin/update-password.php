<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Change Password</h1>
        <br><br>

<?php
if(isset($_GET['id']))
{
    $id=$_GET['id'];
}

?>

        <form action="" method="POST">

        <table class="tbl-30">
            <tr>
                <td>Current password</td>
                <td>
                    <input type="password" name="current_password" placeholder="Current Password">
                </td>
            </tr>

            <tr>
                <td>New password</td>
                <td>
                    <input type="password" name="new_password" placeholder="New Password">
                </td>
            </tr>
            <tr>
                <td>Confirm Password: </td>
                <td>
                    <input type="password" name="confirm_password" placeholder="Confirm Password">
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="submit" name="submit" value="Change Password" class="btn-primary">
                </td>
            </tr>
        </table>

        </form>
    </div>
</div>

<?php
    // check whether the submit is ckicked or not
    if(isset($_POST['submit']))
    {
        // echo "clicked";

        // 1. get the data from form
        $id=$_POST['id'];
        $current_password = md5($_POST['current_password']);
        $new_password = md5($_POST['new_password']);
        $confirm_password = md5($_POST['confirm_password']);

        // 2. check whether the user with current ID and current pass exist or nt
        $sql = "SELECT * FROM tbl_admin WHERE id=$id AND password='$current_password'";
        
    //    execute the query
        $res = mysqli_query($conn, $sql);

        if($res==true)
        {
            // check whether data is avai or not
            $count = mysqli_num_rows($res);

            if($count==1)
            {
                // user exist nd pass can be changed
                // echo "User found";

                // check whether the new pass nd confirm pass match
                if($new_password==$confirm_password)
                {
                    // update the password
                    $sql2 = "UPDATE tbl_admin SET
                    password = '$new_password'
                    WHERE id = $id
                    ";

                    // execute the query
                    $res2 = mysqli_query($conn, $sql2);

                    // chevck whether query executed or not
                    if($res2==true)
                    {
                        // display success msg
                         // redirect to manage admin page with error msg
                    $_SESSION['change-pwd'] = "<div class='success'>Password Change successfully. </div>";
                    // redirect
                    header('location:'.SITEURL.'admin/manage-admin.php');
                    }
                    else
                    {
                        // display error msg
                          // redirect to manage admin page with error msg
                    $_SESSION['change-pwd'] = "<div class='error'>Failed to Change password. </div>";
                    // redirect
                    header('location:'.SITEURL.'admin/manage-admin.php');
                    }
                   
                }
                else
                {
                    // redirect to manage admin page with error msg
                    $_SESSION['pwd-not-match'] = "<div class='error'>Password Did not match. </div>";
                    // redirect
                    header('location:'.SITEURL.'admin/manage-admin.php');
                }
            }
            else
            {
                // user not exist set msg and redirect
                $_SESSION['user-not-found'] = "<div class='error'>User Not Found. </div>";
                // redirect
                header('location:'.SITEURL.'admin/manage-admin.php');
            }
        }
 // 3. check whether the new pass and confirm pass match or nt
        // 4. change pass if all above is true
    }
?>


<?php include('partials/footer.php'); ?>