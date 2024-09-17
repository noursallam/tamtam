<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:admin_login.php');
    exit();
}

// Handle deleting a product
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];

    // Fetch the product details to delete associated image from the folder
    $select_product = $conn->prepare("SELECT image FROM `products` WHERE id = ?");
    $select_product->execute([$delete_id]);
    $fetch_product = $select_product->fetch(PDO::FETCH_ASSOC);

    // Check if product exists
    if ($fetch_product) {
        // Delete image from folder if it exists
        $image_path = '../uploaded_img/' . $fetch_product['image'];
        if (file_exists($image_path)) {
            unlink($image_path);  // Delete the image file from the server
        }

        // Delete the product from the database
        $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");
        $delete_product->execute([$delete_id]);

        if ($delete_product) {
            $message[] = 'Product deleted successfully!';
        } else {
            $message[] = 'Failed to delete the product!';
        }
    } else {
        $message[] = 'Product not found!';
    }

    header('location:products.php');  // Redirect after deletion
    exit();
}

// Handle adding a new product
if (isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $category_id = $_POST['category'];
    $description = $_POST['description'];
    $description = filter_var($description, FILTER_SANITIZE_STRING);
    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../uploaded_img/' . $image;

    // Prices based on the number of prices selected
    $number_of_prices = $_POST['number_of_prices'];
    $prices = [];
    for ($i = 1; $i <= $number_of_prices; $i++) {
        $prices[] = isset($_POST['price_' . $i]) ? $_POST['price_' . $i] : null;
    }

    $select_products = $conn->prepare("SELECT * FROM `products` WHERE name = ?");
    $select_products->execute([$name]);

    if ($select_products->rowCount() > 0) {
        $message[] = 'Product name already exists!';
    } else {
        if ($image_size > 2000000) {
            $message[] = 'Image size is too large';
        } else {
            move_uploaded_file($image_tmp_name, $image_folder);

            // Prepare the SQL query
            $price_columns = [];
            for ($i = 1; $i <= $number_of_prices; $i++) {
                $price_columns[] = "price_$i";
            }
            $placeholders = implode(',', array_fill(0, $number_of_prices, '?'));
            $sql = "INSERT INTO `products` (name, category_id, " . implode(',', $price_columns) . ", image, description) VALUES (?, ?, $placeholders, ?, ?)";

            // Execute the SQL query
            $insert_product = $conn->prepare($sql);
            $insert_product->execute(array_merge([$name, $category_id], $prices, [$image, $description]));

            $message[] = 'New product added!';
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
    <title>Products</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="../css/admin_style.css">

</head>

<body>

    <?php include '../components/admin_header.php' ?>

    <!-- Add products section starts  -->

    <section class="add-products">

        <form action="" method="POST" enctype="multipart/form-data">
            <h3>Add Product</h3>
            <input type="text" required placeholder="Enter product name" name="name" maxlength="100" class="box">

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

            <!-- Number of prices -->
            <h4>Select Number of Prices:</h4>
            <select name="number_of_prices" id="number_of_prices" class="box" onchange="updatePriceFields(this.value)">
                <option value="1">1 Price</option>
                <option value="2">2 Prices</option>
                <option value="3">3 Prices</option>
            </select>

            <!-- Price inputs -->
            <div id="price_fields">
                <input type="number" step="0.01" name="price_1" class="box" placeholder="Enter price 1">
            </div>

            <input type="submit" value="Add Product" name="add_product" class="btn">
        </form>

    </section>

    <!-- Add products section ends -->

    <!-- Show products section starts  -->

    <section class="show-products" style="padding-top: 0;">

        <div class="box-container">

            <?php
            $show_products = $conn->prepare("SELECT p.*, c.name AS category_name FROM `products` p JOIN `categories` c ON p.category_id = c.id");
            $show_products->execute();
            if ($show_products->rowCount() > 0) {
                while ($fetch_products = $show_products->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    <div class="box">
                        <img src="../uploaded_img/<?= $fetch_products['image']; ?>" alt="">
                        <div class="category mb-2">
                            <strong>Category: </strong><?= $fetch_products['category_name']; ?>
                        </div>

                        <div>
                            <?php
                            for ($i = 1; $i <= 3; $i++) {
                                if (!empty($fetch_products["price_$i"])) {
                                    echo '<div class="price"><span>Price ' . $i . ': $</span>' . $fetch_products["price_$i"] . '<span>/-</span></div>';
                                }
                            }
                            ?>
                        </div>

                        <div class="name"><?= $fetch_products['name']; ?></div>
                        <div class="description"><?= $fetch_products['description']; ?></div>
                        <div class="flex-btn">
                            <a href="update_product.php?update=<?= $fetch_products['id']; ?>" class="option-btn">Update</a>
                            <a href="products.php?delete=<?= $fetch_products['id']; ?>" class="delete-btn"
                                onclick="return confirm('Delete this product?');">Delete</a>
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

    <script>
        // Function to dynamically update price fields based on the number selected
        function updatePriceFields(numberOfPrices) {
            var priceFieldsContainer = document.getElementById('price_fields');
            priceFieldsContainer.innerHTML = '';

            for (var i = 1; i <= numberOfPrices; i++) {
                var input = document.createElement('input');
                input.type = 'number';
                input.step = '0.01';
                input.name = 'price_' + i;
                input.className = 'box';
                input.placeholder = 'Enter price ' + i;
                priceFieldsContainer.appendChild(input);
            }
        }

        // Initialize with 1 price field
        updatePriceFields(document.getElementById('number_of_prices').value);
    </script>

</body>

</html>