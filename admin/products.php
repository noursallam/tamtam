<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:admin_login.php');
    exit();
}

// Handle adding a new category
if (isset($_POST['add_category'])) {
    $category_name = $_POST['category_name'];
    $category_name = filter_var($category_name, FILTER_SANITIZE_STRING);

    $category_image = $_FILES['category_image']['name'];
    $category_image = filter_var($category_image, FILTER_SANITIZE_STRING);
    $category_image_size = $_FILES['category_image']['size'];
    $category_image_tmp_name = $_FILES['category_image']['tmp_name'];
    $category_image_folder = '../uploaded_img/' . $category_image;

    // Check if the category already exists
    $select_category = $conn->prepare("SELECT * FROM `categories` WHERE name = ?");
    $select_category->execute([$category_name]);

    if ($select_category->rowCount() > 0) {
        $message[] = 'Category already exists!';
    } else {
        if ($category_image_size > 2000000) {
            $message[] = 'Category image size is too large';
        } else {
            move_uploaded_file($category_image_tmp_name, $category_image_folder);

            $insert_category = $conn->prepare("INSERT INTO `categories` (name, image) VALUES (?, ?)");
            $insert_category->execute([$category_name, $category_image]);

            $message[] = 'New category added!';
        }
    }
}

// Handle adding a new product
if (isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $price = $_POST['price'];
    $price = filter_var($price, FILTER_SANITIZE_STRING);
    $category_id = $_POST['category'];
    $description = $_POST['description'];
    $description = filter_var($description, FILTER_SANITIZE_STRING);
    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../uploaded_img/' . $image;

    $select_products = $conn->prepare("SELECT * FROM `products` WHERE name = ?");
    $select_products->execute([$name]);

    if ($select_products->rowCount() > 0) {
        $message[] = 'Product name already exists!';
    } else {
        if ($image_size > 2000000) {
            $message[] = 'Image size is too large';
        } else {
            move_uploaded_file($image_tmp_name, $image_folder);

            $insert_product = $conn->prepare("INSERT INTO `products` (name, category_id, price, image, description) VALUES (?, ?, ?, ?, ?)");
            $insert_product->execute([$name, $category_id, $price, $image, $description]);

            $message[] = 'New product added!';
        }
    }
}

// Handle deleting a product
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $delete_product_image = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
    $delete_product_image->execute([$delete_id]);
    $fetch_delete_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);
    unlink('../uploaded_img/' . $fetch_delete_image['image']);
    $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");
    $delete_product->execute([$delete_id]);
  
    header('location:products.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Products</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php' ?>

<!-- Add category section starts  -->

<section class="add-category">
   <form action="" method="POST" enctype="multipart/form-data">
      <h3>Add New Category</h3>
      <input type="text" required placeholder="Enter category name" name="category_name" maxlength="100" class="box">
      <input type="file" name="category_image" class="box" accept="image/jpg, image/jpeg, image/png, image/webp" required>
      <input type="submit" value="Add Category" name="add_category" class="btn">
   </form>
</section>

<!-- Add category section ends -->

<!-- Add products section starts  -->

<section class="add-products">

   <form action="" method="POST" enctype="multipart/form-data">
      <h3>Add Product</h3>
      <input type="text" required placeholder="Enter product name" name="name" maxlength="100" class="box">
      <input type="number" min="0" max="9999999999" required placeholder="Enter product price" name="price" onkeypress="if(this.value.length == 10) return false;" class="box">
      <select name="category" class="box" required>
         <option value="" disabled selected>Select Category --</option>
         <?php
         // Fetch categories from the database
         $select_categories = $conn->prepare("SELECT * FROM `categories`");
         $select_categories->execute();
         if ($select_categories->rowCount() > 0) {
             while ($fetch_categories = $select_categories->fetch(PDO::FETCH_ASSOC)) {
                 echo '<option value="' . $fetch_categories['id'] . '">' . $fetch_categories['name'] . '</option>';
             }
         } else {
             echo '<option value="" disabled>No categories available</option>';
         }
         ?>
      </select>
      <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png, image/webp" required>
      <textarea name="description" placeholder="Enter product description" class="box" required></textarea>
      <input type="submit" value="Add Product" name="add_product" class="btn">
   </form>

</section>

<!-- Add products section ends -->

<!-- Show products section starts  -->

<section class="show-products" style="padding-top: 0;">

   <div class="box-container">

   <?php
   $show_products = $conn->prepare("SELECT p.*, c.name AS category_name, c.image AS category_image FROM `products` p JOIN `categories` c ON p.category_id = c.id");
   $show_products->execute();
   if ($show_products->rowCount() > 0) {
       while ($fetch_products = $show_products->fetch(PDO::FETCH_ASSOC)) {
   ?>
   <div class="box">
      <img src="../uploaded_img/<?= $fetch_products['image']; ?>" alt="">
      <div class="flex">
         <div class="price"><span>$</span><?= $fetch_products['price']; ?><span>/-</span></div>
         <div class="category"><?= $fetch_products['category_name']; ?></div>
      </div>
      <div class="name"><?= $fetch_products['name']; ?></div>
      <div class="description"><?= $fetch_products['description']; ?></div>
      <div class="flex-btn">
         <a href="update_product.php?update=<?= $fetch_products['id']; ?>" class="option-btn">Update</a>
         <a href="products.php?delete=<?= $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('Delete this product?');">Delete</a>
      </div>
   </div>
   <?php
       }
   } else {
       echo '<p class="empty">No products added yet!</p>';
   }
   ?>

   </div>

</section>

<!-- Show products section ends -->

<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>
