<?php include 'components/user_header.php'; ?>

<section class="vh-100 d-flex align-items-center justify-content-center">
    <form id="contact_form" name="contact_form" method="post" class="w-100">
        <div class="mb-5 row">
            <div class="col-12 col-md-6">
                <label for="first_name">First Name</label>
                <input type="text" required maxlength="50" class="form-control" id="first_name" name="first_name">
            </div>
            <div class="col-12 col-md-6">
                <label for="last_name">Last Name</label>
                <input type="text" required maxlength="50" class="form-control" id="last_name" name="last_name">
            </div>
        </div>
        <div class="mb-5 row">
            <div class="col-12 col-md-6">
                <label for="email_addr">Email address</label>
                <input type="email" required maxlength="50" class="form-control" id="email_addr" name="email"
                    placeholder="name@example.com">
            </div>
            <div class="col-12 col-md-6">
                <label for="phone_input">Phone</label>
                <input type="tel" required maxlength="50" class="form-control" id="phone_input" name="Phone"
                    placeholder="Phone">
            </div>
        </div>
        <div class="mb-5">
            <label for="message">Message</label>
            <textarea class="form-control" id="message" name="message" rows="5"></textarea>
        </div>
        <button type="submit" class="btn btn-primary px-4 btn-lg">Post</button>
    </form>
</section>

<?php include 'components/footer.php'; ?>
