<?php include 'components/user_header.php'; ?>

<!-- header body -->
<div
	class="overflow-hidden py-9 py-xl-10 position-relative rounded-bottom-3 rounded-sm-4 rounded-xl-5 m-0 m-sm-2 m-xl-3 shadow">
	<img src="project_images/place.jpg" class="position-absolute z-n1 top-0 h-100 w-100 object-fit-cover" alt="Meeting">

	<div class="position-absolute z-n1 top-0 h-100 w-100 bg-dark"
		style="opacity: 0.85; mix-blend-mode: multiply; filter: contrast(1.15) brightness(0.85);">
	</div>

	<div class="position-absolute z-0 top-0 h-100 w-100">
		<div class="container h-100 d-flex align-items-center">
			<div class="max-w-2xl mx-auto text-center">
				<h1 class="m-0 mt-7 text-white tracking-tight text-7xl fw-bold  aref-ruqaa-ink-bold" data-aos-delay="0"
					data-aos="fade" data-aos-duration="3000">
					الطعم الاصلي
				</h1>
			</div>
		</div>
	</div>
</div>

<div class="container my-5">
	<div class="row justify-content-center">
		<?php
		// Fetch categories from the database
		if ($fetch_categories->rowCount() > 0) {
			while ($category = $fetch_categories->fetch(PDO::FETCH_ASSOC)) {
				$category_image = $category['image'] ? 'uploaded_img/' . $category['image'] : 'images/default-cat.png';
				$category_name = htmlspecialchars($category['name']);
				$category_id = intval($category['id']);
				?>
				<div class="col-md-4 mb-4 ">
					<a href="category_products.php?category_id=<?= $category_id; ?>" class="text-decoration-none">
						<div class="card shadow-lg w-75 mx-auto "> <!-- Using w-50 for width and mx-auto for centering -->
							<img src="<?= $category_image; ?>" class="card-img-top img-fluid" alt="<?= $category_name; ?>">
							<!-- img-fluid for responsive image -->
							<div class="card-body text-center">
								<p class="card-text"><?= $category_name; ?></p>
							</div>
						</div>
					</a>
				</div>

				<?php
			}
		} else {
			echo '<div class="col-12 text-center"><span class="badge rounded-pill text-bg-danger">No categories available</span></div>';
		}
		?>
	</div>
</div>







<div>
	<div class="container">
		<div class="my-5 position-relative rounded-2 shadow bg-body-tertiary">
			<span
				class="badge position-absolute translate-middle-y top-0 start-0 text-bg-success px-3 py-2 rounded-4 ms-5">
				لطلبات التوصيل</span>

			<div class="px-4 pb-5 d-flex flex-wrap justify-content-between">
					<!-- Facebook -->

			</div>

		</div>
	</div>
</div>



<?php include 'components/footer.php'; ?>