<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>

        <br><br>
        <?php
            
            if(isset($_SESSION['add']))
            {
                echo $_SESSION['add'];
                unset ($_SESSION['add']);
            }

            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset ($_SESSION['upload']);
            }
            ?>
            <br><br>

        <!-- Add category form -->
         <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" placeholder="Category Title">
                    </td>
                </tr>

                <tr>
                    <td>Select Image</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio" name="featured" value="Yes"> Yes
                        <input type="radio" name="featured" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" name="active" value="Yes"> Yes
                        <input type="radio" name="active" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add category" class="btn-primary">
                    </td>
                </tr>
            </table>

         </form>
         <!-- Add category Ends here -->

         <?php
        //  check whether the submit btn is clicked or not
        if(isset($_POST['submit']))
        {
            // echo "clicked";

            // 1.get the value fro form
            $title = $_POST['title'];


            // for radio input type , we need to check whether the btn is cliked or not
            if(isset($_POST['featured']))
            {
                // get the value from form
                $featured =$_POST['featured'];
            }
            else
            {
                // set the deafult value
                $featured = "No";
            }
            if(isset($_POST['active']))
            {
                $active = $_POST['active'];
            }
            else
            {
                $active = "No";
            }

            // check whether the image is selected or not d set the value for image name accordingly
            // print_r($_FILES['image']);

            // die(); //break the code here

            if(isset($_FILES['image']['name']))
            {
                // Upload the image
                // to upload the image as we need image name, source path nd destination path
                $image_name = $_FILES['image']['name'];

                // Upload the img only if img is selected
                if($image_name != "")
                {
             
                        // Auto rename our img
                        // get the extension of our img(jpg,png,gif,) eg. "food1.jpg"
                        $ext = end(explode('.', $image_name));

                        // rename the img
                        $image_name = "Food_Category_".rand(000, 999).'.'.$ext; //e.g. Food_Category_834.jpg
                        

                        $source_path = $_FILES['image']['tmp_name'];

                        $destination_path = "../images/category/".$image_name;

                        // finally upload the img
                        $upload = move_uploaded_file($source_path, $destination_path);

                        // check whether img is uploaded or nbot
                        // nd if the i,mg is not upld then we will stop the process nd redirect with error msgh
                        if($upload==false)
                        {
                            // set msg
                            $_SESSION['upload'] = "<div class='error'>Failed to Upload Image.</div>";
                            // redirect to manage category page
                            header('location:'.SITEURL.'admin/add-category.php');
                            // stop the proces
                            die();
                        }
              }
            }
            else
            {
                // dont upload img and set the image_name value as blank
                $image_name = "";
            }
                // 2.create sql qwuery to insert category into DB
                $sql = "INSERT INTO tbl_category SET
                    title='$title',
                    image_name='$image_name',
                    featured='$featured',
                    active='$active'
                    ";
                // 3. Execute the query and save in DB
                $res = mysqli_query($conn, $sql);

                // check whether the query executed or not and data added or not 
                if($res==true)
                {
                    // query executed nd category added
                    $_SESSION['add'] = "<div class='success'>Category Added Successfully.</div>";
                    // redirect to manage category page
                    header('location:'.SITEURL.'admin/manage-category.php');
                }
                else
                {
                    //Failed to Add category
                    $_SESSION['add'] = "<div class='error'>Failed to Add Category.</div>";
                    // redirect to manage category page
                    header('location:'.SITEURL.'admin/add-category.php');
                }
        }
         ?>
        
    </div>
</div>

<?php include('partials/footer.php'); ?>