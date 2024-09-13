<?php
// Include database connection
include 'components/connect.php'; // Update with the correct path to your database connection file

// Get the category ID from the URL
$category_id = isset($_GET['category_id']) ? intval($_GET['category_id']) : 0;

// Fetch the category name from the database
$fetch_category = $conn->prepare("SELECT name FROM `categories` WHERE `id` = ?");
$fetch_category->execute([$category_id]);
$category_name = $fetch_category->fetchColumn();

// Fetch products from the database for the selected category
$fetch_products = $conn->prepare("SELECT * FROM `products` WHERE `category_id` = ?");
$fetch_products->execute([$category_id]);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Section</title>
    <link rel="icon" href="./images/tam.png">
    <link rel="stylesheet" href="./CSS/style.css">
    <link rel="stylesheet" href="./CSS/media.css">
    <link rel="stylesheet" href="./CSS/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;700;800&display=swap" rel="stylesheet">
</head>
<style>
    .almarai-light {
        font-family: "Almarai", sans-serif;
        font-weight: 300;
        font-style: normal;
    }

    .almarai-regular {
        font-family: "Almarai", sans-serif;
        font-weight: 400;
        font-style: normal;
    }

    .almarai-bold {
        font-family: "Almarai", sans-serif;
        font-weight: 700;
        font-style: normal;
    }

    .almarai-extrabold {
        font-family: "Almarai", sans-serif;
        font-weight: 800;
        font-style: normal;
    }

    body {
    font-family: "Almarai", sans-serif;
    font-feature-settings: "cv02","cv03","cv04","cv11";
}

</style>

<body>
    <section id="menu" >
        <div class="container">
            <div class="title">
                <h2><?= htmlspecialchars($category_name); // Display the real category name ?></h2>
            </div>
            <div class="menu-items ">
                <div class="menu-items-left">
                    <?php
                    if ($fetch_products->rowCount() > 0) {
                        while ($product = $fetch_products->fetch(PDO::FETCH_ASSOC)) {
                            $product_image = $product['image'] ? 'uploaded_img/' . $product['image'] : 'images/default-prod.png';
                            $product_name = htmlspecialchars($product['name']);
                            $product_price = htmlspecialchars($product['price']);
                            $product_description = htmlspecialchars($product['description']); // Fetch description
                            ?>
                            <div class="menu-item almarai-light">
                                <img src="<?= $product_image; ?>" alt="<?= $product_name; ?>">
                                <div>
                                    <h4 class="almarai-light"><?= $product_name; ?></h4>
                                    <p><?= $product_description; // Display the product description ?></p>
                                    <span class="primary-text"> <?= $product_price; ?> LE</span>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        echo '<div class="col-12 text-center"><span class="badge rounded-pill text-bg-danger">No products available in this category</span></div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>
</body>

</html>