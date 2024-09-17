<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:admin_login.php');
    exit();
}

if (isset($_POST['update'])) {
    $pid = $_POST['pid'];
    $pid = filter_var($pid, FILTER_SANITIZE_STRING);
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);

    $price_1 = isset($_POST['price_1']) ? filter_var($_POST['price_1'], FILTER_SANITIZE_STRING) : NULL;
    $price_2 = isset($_POST['price_2']) ? filter_var($_POST['price_2'], FILTER_SANITIZE_STRING) : NULL;
    $price_3 = isset($_POST['price_3']) ? filter_var($_POST['price_3'], FILTER_SANITIZE_STRING) : NULL;

    $category = $_POST['category'];
    $category = filter_var($category, FILTER_SANITIZE_STRING);
    $description = $_POST['description'];
    $description = filter_var($description, FILTER_SANITIZE_STRING);

    // Update product including prices
    $update_product = $conn->prepare("UPDATE `products` SET name = ?, category_id = ?, price_1 = ?, price_2 = ?, price_3 = ?, description = ? WHERE id = ?");
    $update_product->execute([$name, $category, $price_1, $price_2, $price_3, $description, $pid]);

    $message[] = 'Product updated!';

    // Handle image upload
    $old_image = $_POST['old_image'];
    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../uploaded_img/' . $image;

    if (!empty($image)) {
        if ($image_size > 2000000) {
            $message[] = 'Image size is too large!';
        } else {
            $update_image = $conn->prepare("UPDATE `products` SET image = ? WHERE id = ?");
            $update_image->execute([$image, $pid]);
            move_uploaded_file($image_tmp_name, $image_folder);
            unlink('../uploaded_img/' . $old_image);
            $message[] = 'Image updated!';
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>

    <!-- Font Awesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- Custom CSS File Link -->
    <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>

<!-- Update Product Section Starts -->
<section class="update-product">
    <h1 class="heading">Update Product</h1>

    <?php
    $update_id = $_GET['update'];
    $show_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
    $show_products->execute([$update_id]);
    if ($show_products->rowCount() > 0) {
        while ($fetch_products = $show_products->fetch(PDO::FETCH_ASSOC)) {
    ?>
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
        <input type="hidden" name="old_image" value="<?= $fetch_products['image']; ?>">
        <img src="../uploaded_img/<?= $fetch_products['image']; ?>" alt="">
        
        <span>Update Name</span>
        <input type="text" required placeholder="Enter product name" name="name" maxlength="100" class="box" value="<?= $fetch_products['name']; ?>">
        
        <span>Update Price 1</span>
        <input type="number" min="0" step="0.01" placeholder="Enter price 1" name="price_1" class="box" value="<?= $fetch_products['price_1']; ?>">
        
        <span>Update Price 2</span>
        <input type="number" min="0" step="0.01" placeholder="Enter price 2" name="price_2" class="box" value="<?= $fetch_products['price_2']; ?>">
        
        <span>Update Price 3</span>
        <input type="number" min="0" step="0.01" placeholder="Enter price 3" name="price_3" class="box" value="<?= $fetch_products['price_3']; ?>">
        
        <span>Update Category</span>
        <select name="category" class="box" required>
            <option selected value="<?= $fetch_products['category_id']; ?>">
                <?php
                $category_id = $fetch_products['category_id'];
                $category_query = $conn->prepare("SELECT name FROM `categories` WHERE id = ?");
                $category_query->execute([$category_id]);
                $category_name = $category_query->fetchColumn();
                echo $category_name;
                ?>
            </option>
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
        
        <span>Update Description</span>
        <textarea name="description" rows="4" placeholder="Enter product description" class="box"><?= $fetch_products['description']; ?></textarea>
        
        <span>Update Image</span>
        <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png, image/webp">
        
        <div class="flex-btn">
            <input type="submit" value="Update" class="btn" name="update">
            <a href="products.php" class="option-btn">Go Back</a>
        </div>
    </form>
    <?php
        }
    } else {
        echo '<p class="empty">No products added yet!</p>';
    }
    ?>
</section>

<!-- Update Product Section Ends -->

<!-- Custom JS File Link -->
<script src="../js/admin_script.js"></script>

</body>
</html>
