<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>

        <br><br>

        <?php
        if(isset($_SESSION['upload']))
        {
            echo $_SESSION['upload'];
            unset ($_SESSION['upload']);
        }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">

        <table class="tbl-30">
            <tr>
                <td>Title: </td>
                <td>
                    <input type="text" name="title" placeholder="Title of the food">
                </td>
            </tr>

            <tr>
                <td>Description: </td>
                <td>
                    <textarea name="description" cols="30" rows="5" placeholder="Description of the Food."></textarea>
                </td>
            </tr>

            <tr>
                <td>Price: </td>
                <td>
                    <input type="number" name="price">
                </td>
            </tr>

            <tr>
                <td>Select Image: </td>
                <td>
                    <input type="file" name="image">
                </td>
            </tr>
            
            <tr>
                <td>Category: </td>
                <td>
                    <select name="category">

                        <?php
                        // create PHP code to display cateegory fromDB
                        // 1. create sql to get all active categories frm DB
                        $sql ="SELECT * FROM tbl_category WHERE active='Yes'";
                       
                        // exectuing th query
                        $res = mysqli_query($conn, $sql);

                        // count rows to cehck whether we have categories or not
                        $count = mysqli_num_rows($res);

                        // if count is > 0 , we have ctaegories else we dont have catefories
                        if($count>0)
                        {
                            // we have categories
                            while($row=mysqli_fetch_assoc($res))
                            {
                                // get the deatiles of categories
                                $id = $row['id'];
                                $title = $row['title'];
                                ?>
                                 <option value="<?php echo $id; ?>"><?php echo $title; ?> </option>
                                <?php
                            }
                        }
                        else
                        {
                            // we do not have categoru
                            ?>
                             <option value="0">No Category Found</option>
                             <?php
                            
                        }
                        // 2. display pn dropdown
                        ?>

                </select>
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
                    <input type="submit" name="submit" value="Add Food" class="btn-primary">
                </td>
            </tr>
        </table>
        </form>

        <?php
        // check whether the btn is clicked or not
        if(isset($_POST['submit']))
        {
            // add the food inDB
            // 1.get the data from form
            $title = $_POST['title'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category = $_POST['category'];

            // check whether radio btn for  featured nd actobe are checked or not
            if(isset($_POST['featured']))
            {
                $featured = $_POST['featured'];
                
            }
            else
            {
                $featured = "No"; //setting the deault value
            }

            if(isset($_POST['active']))
            {
                $active = $_POST['active'];
                
            }
            else
            {
                $active = "No"; //setting the deault value
            }
            // 2. upload the img if selected
            // check whether the select img is clicked or not nd upload img only if the img is selected
            if(isset($_FILES['image']['name']))
            {
                // gfet the deatils of selected img
                $image_name = $_FILES['image']['name'];

                // check whether the img is selected or not nd uplod img only if selected
                if($image_name!="")
                {
                    // image is selected
                    // A. rename the img
                    // get the extention of selected img (JPEG, png, gif)
                    $ext = end(explode('.', $image_name));

                    // create new name for img
                    $image_name = "Food-Name-".rand(0000,9999).".".$ext; //new img may be "Food-Name-456.jpg"

                    // B.uplod the img
                    // get the src path nd destination path

                    // src pth is the crnt location of img 
                    $src = $_FILES['image']['tmp_name'];

                    // destination path for the img to be uploaded
                    $dst = "../images/food/".$image_name;

                    // finally upld the food img
                    $upload = move_uploaded_file($src, $dst);

                    // check whether img uploded or not
                    if($upload==false)
                    {
                        // failed to upld the img
                        // redirct to add food page with error msg
                        $_SESSION['upload'] = "<div class='error'>Failed to Upload Image.</div>";
                        header('location'.SITEURL.'admin/add-food.php');
                        // stop the process
                        die();
                    }


                }
            }
            else
            {
                $image_name = ""; //setting deafult value  as blank
            }
            // 3. insert intp Db

            // create a sql query to save or add food
            // for numrical we donot need to pass value inside quotes ' ' but for string value it is compulsory
            $sql2 = "INSERT INTO tbl_food SET
            title = '$title',
            description = '$description',
            price = $price,
            image_name = '$image_name',
            category_id = $category,
            featured = '$featured',
            active = '$active'
            ";

            // excute the query
            $res2 = mysqli_query($conn, $sql2);

            // check whether data inersted or not

            if($res2 == true)
            {
                // data inserted succesfuly
                $_SESSION['add'] = "<div class='success'>Food Added Successfully.</div>";
                header('location:'.SITEURL.'admin/manage-food.php');
            }
            else
            {
                // failed to insert data
                $_SESSION['add'] = "<div class='error'>Failed to Add Food.</div>";
                header('location:'.SITEURL.'admin/manage-food.php');
                
            }
            // 4. redirect with msg to manage food page
        }
        ?>
    </div>
</div>
<?php include('partials/footer.php'); ?>