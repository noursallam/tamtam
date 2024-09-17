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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
    }

    .almarai-regular {
        font-family: "Almarai", sans-serif;
        font-weight: 400;
    }

    .almarai-bold {
        font-family: "Almarai", sans-serif;
        font-weight: 700;
    }

    .almarai-extrabold {
        font-family: "Almarai", sans-serif;
        font-weight: 800;
    }

    body {
        font-family: "Almarai", sans-serif;
        font-feature-settings: "cv02", "cv03", "cv04", "cv11";
    }

    .card-price {
        font-size: 18px;
        color: #333;
    }

    .card-description {
        font-size: 18px;
        color: #777;
    }

    .le {
        color: #F48F06;
    }
</style>

<body>

    <section id="menu" class="my-3">

        <div class="container">
            <div class="title text-center mb-4">
                <h2 class="almarai-bold "><?= htmlspecialchars($category_name); // Display the real category name ?>
                </h2>
            </div>
            <div class="row ">
                <?php
                if ($fetch_products->rowCount() > 0) {
                    while ($product = $fetch_products->fetch(PDO::FETCH_ASSOC)) {
                        $product_image = $product['image'] ? 'uploaded_img/' . $product['image'] : 'images/default-prod.png';
                        $product_name = htmlspecialchars($product['name']);
                        $product_description = htmlspecialchars($product['description']); // Fetch description
                        ?>
                        <div class="col-md-4 mb-4 mt-3">
                            <div class="card almarai-light"
                                style="border: 1px solid #ccc; border-radius: 6px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                <img src="<?= $product_image; ?>" class="card-img-top" alt="<?= $product_name; ?>"
                                    style="height: 200px; object-fit: cover;">
                                <div class="card-body">
                                    <h5 class="card-title"><?= $product_name; ?></h5>
                                    <p class="card-description "><?= $product_description; ?></p>
                                    <div class="d-flex flex-wrap">
                                        <?php if (!empty($product['price_1']) && $product['price_1'] > 0) { ?>
                                            <div class="card-price m-2 fw-bold"><?= htmlspecialchars($product['price_1']); ?><span
                                                    class="le"> LE</span></div>
                                        <?php } ?>
                                        <?php if (!empty($product['price_2']) && $product['price_2'] > 0) { ?>
                                            <div class="card-price m-2 fw-bold"><?= htmlspecialchars($product['price_2']); ?><span
                                                    class="le"> LE</span></div>
                                        <?php } ?>
                                        <?php if (!empty($product['price_3']) && $product['price_3'] > 0) { ?>
                                            <div class="card-price m-2 fw-bold"><?= htmlspecialchars($product['price_3']); ?><span
                                                    class="le"> LE</span></div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <?php
                    }
                } else {
                    echo '<div class="col-12 text-center"><span class="badge badge-danger">No products available in this category</span></div>';
                }
                ?>
            </div>
        </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>