<?php include('partials/menu.php'); ?>
<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>
<br>
<?php
        if(isset($_SESSION['add']))  //checking whether the session is set or not
        {
          echo $_SESSION['add'];   //  msg
          unset($_SESSION['add']); //Removing session msg
        }
        ?>
        <form action="" method="POST">

        <table class="tbl-30">
            <tr>
                <td>Full Name: </td>
                <td><input type="text" name="full_name" placeholder="Enter your Name"></td>
            </tr>

            <tr>
                <td>Username: </td>
                <td><input type="text" name="username" placeholder="Your Username"></td>
            </tr>
            <tr>
                <td>Password: </td>
                <td><input type="password" name="password" placeholder="Your Password"></td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="submit" name="submit" value="Add Admin" class="btn-primary">
                </td>
            </tr>
        </table>
            

        </form>
    </div>
</div>

<?php include('partials/footer.php'); ?>

<?php
// Process the value from form and save it in database
// Check whether the submit button is clicked or not

if(isset($_POST['submit']))
{
    // echo "Button clicked";

    //1. get the data from form
     $full_name = $_POST['full_name'];
     $username = $_POST['username'];
     $password = md5($_POST['password']);   // password encrypted wit using m5

    //2.  SQL query to save the data into DB
    $sql = "INSERT INTO tbl_admin SET
        full_name= '$full_name',
        username= '$username',
        password= '$password'
        ";
   

// 3.excuting query and saivng data int DB
    $res = mysqli_query($conn, $sql) or die(mysqli_error());

    // 4.check whether the (query is executed) data 8is inserted or not and display appropriate msg
    if($res==TRUE) 
    {
        // Data Inserted
        // echo " Inserted data";
        // create a session variable to display msg
        $_SESSION['add'] = "Admin Added Successfully";
        // Redirect page
        header("location:".SITEURL.'admin/manage-admin.php');
    }
    else
    {
        // failed to insert data
        // echo "data not inserted";
         // create a session variable to display msg
         $_SESSION['add'] = "Failed to add admin";
         // Redirect page to add admin
         header("location:".SITEURL.'admin/add-admin.php');
    }
}

?>