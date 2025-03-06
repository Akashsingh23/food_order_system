<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Category</h1>

        <br><br>
       <?php
        // chk whether id is set or not
        if(isset($_GET['id']))
        {
            // set the ID nd all other details
            // echo "gettinf the data";
            $id = $_GET['id'];
            // create sql query to getr all other details
            $sql = "SELECT * FROM tbl_category WHERE id=$id";

            // execute the query
            $res = mysqli_query($conn, $sql);

            // count the rows to chk wherther the id is  valid or not
            $count = mysqli_num_rows($res);

            if($count==1)
            {
                // get all the data
                $row = mysqli_fetch_assoc($res);
                $title = $row['title'];
                $current_image = $row['image_name'];
                $featured = $row['featured'];
                $active = $row['active'];
                
            }
            else
            {
                // redirect to manage category with session msg
                $_SESSION['no-category-found'] = "<div class='error'>Category Not Found.</div>";
                header('location:'.SITEURL.'admin/manage-category.php');
            }
        }
        else
        {
            // redirect to manage category
            header('location:'.SITEURL.'admin/manage-category.php');
        }

       ?> 

        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Current Image: </td>
                    <td>
                        <?php
                        if($current_image != "")
                        {
                            // dislay the img
                            ?>
                            <img src="<?php echo SITEURL; ?>images/category/<?php echo $current_image; ?>" width="100px" >

                            <?php
                        }
                        else
                        {
                            // display msg
                            echo "<div class='error'>Image Not Added.</div>";
                        }
                          ?>
                    </td>
                </tr>

                <tr>
                    <td>New Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Featured: </td>
                    <td>
                        <input <?php if($featured=="Yes"){echo "checked";} ?> type="radio" name="featured" value="Yes"> Yes
                        <input <?php if($featured=="No"){echo "checked";} ?>  type="radio" name="featured" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td>Active: </td>
                    <td>
                    <input <?php if($active=="Yes"){echo "checked";} ?>  type="radio" name="active" value="Yes"> Yes
                    <input <?php if($active=="No"){echo "checked";} ?>  type="radio" name="active" value="No"> No
                    </td>
                </tr>

                <tr>
                   <td>
                    <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update category" class="btn-primary">
                   </td>
                </tr>

            </table>
        </form>

        <?php
            if(isset($_POST['submit']))
            {
                // echo "Clicked";
                // 1.get all the values from form
                $id = $_POST['id'];
                $title = $_POST['title'];
                $current_image = $_POST['current_image'];
                $featured = $_POST['featured'];
                $active = $_POST['active'];

                // 2. updating new img if selected
                // check whether  the img is selected or not
                if(isset($_FILES['image']['name']))
                {
                    // get the img details
                    $image_name = $_FILES['image']['name'];
                    
                    // check whether the img is avai or not
                    if($image_name !="")
                    {
                        // img avai
                        // A.upload new img
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
                            header('location:'.SITEURL.'admin/manage-category.php');
                            // stop the proces
                            die();
                        }
                        //B. remove curnt img if avai
                        if($current_image!="")
                        {
                            
                            $remove_path = "../images/category/".$current_image;

                            $remove = unlink($remove_path);

                            // check whether the img is remove or not 
                            // if fialed to remove then display msg nd stop the process
                            if($remove==false)
                            {
                            // failed to remove img
                            $_SESSION['failed-remove'] = "<div class='error'>Failed to remove current Image.</div>";
                            header('location:'.SITEURL.'admin/manage-category.php');
                            die(); //stop the process
                            }
                        }

                    }
                    else
                    {
                        $image_name = $current_image;
                    }
                }
                else
                {
                    $image_name = $current_image;
                }

                // 3.update the DB
                $sql2 = "UPDATE tbl_category SET
                    title = '$title',
                    image_name = '$image_name',
                    featured = '$featured',
                    active = '$active'
                    WHERE id=$id
                    ";

                    // execute the query
                    $res2 = mysqli_query($conn, $sql2);

                // 4. redirct to manabge category with msg
                // check whether excueted or npt
                if($res2==true)
                {
                    // categpory updated
                    $_SESSION['update'] = "<div class='success'>Category Successfully Updated.</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                }
                else
                {
                    // failed to update category
                    $_SESSION['update'] = "<div class='error'>Failed to update category.</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                }

                
            }

        ?>

                </div>
            </div>
<?php include('partials/footer.php'); ?>