<?php
// Include database connection
include 'components/connect.php'; // Update with the correct path to your database connection file

// Fetch categories from the database
$fetch_categories = $conn->prepare("SELECT * FROM `categories`");
$fetch_categories->execute();
?>


<!doctype html>


<html lang="en" dir="rtl" data-bs-theme="auto">

<head>

    <!-- Include JavaScript for color modes -->
    <script src="./assets/js/color-modes.js"></script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Update the 'content' attribute to reflect the actual content description -->
    <meta name="description" content="your_description_goes_here">

    <!-- Modify the 'content' attribute to include appropriate keywords -->
    <meta name="keywords" content="your_keywords_goes_here">

    <meta name="author" content="tigmatemplate">
    <meta name="generator" content="Bootstrap">

    <!-- Change the text within the <title> tag to match the webpage's content -->
    <title> Tam-Tam </title>

    <!-- 
        Set the website's favicon and Apple touch icon using the files in the assets/logo folder. You can change these files to your own icons by replacing them with the same names and sizes.

        Be careful if you change the site.webmanifest file, as you need to update the src attribute of the icons array to match the new path of your icon files. Otherwise, your icons may not display correctly on some devices. 
    -->
    <link rel="apple-touch-icon" sizes="180x180" href="./assets/logo/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="./assets/logo/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="./assets/logo/favicon-16x16.png">
    <link rel="icon" type="image/x-icon" href="./assets/logo/favicon.ico">
    <link rel="manifest" href="./assets/logo/site.webmanifest">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="./assets/libraries/aos/aos.css">
    <link rel="stylesheet" href="./assets/css/main.min.rtl.css">
    <link rel="stylesheet" href="./assets/css/style.css">

    <!-- Open Graph Meta Tags for Social Sharing -->
    <!-- Update the 'title' and 'description' content below to enhance social sharing -->
    <meta property="og:title" content="your_title_goes_here">
    <meta property="og:description" content="your_description_goes_here">
    <!-- Update with actual absolute image URL like: https://example.com/main.jpg -->
    <meta property="og:image" content="your_absolute_image_url_goes_here">
    <!-- Update with the absolute URL of the content like: https://example.com/index.html -->
    <meta property="og:url" content="your_absolute_content_url_goes_here">
    <!-- Update with the type of object you’re sharing. (e.g., article, website, etc.) -->
    <meta property="og:type" content="website">
    <!-- Defines the content language -->
    <meta property="og:locale" content="en_US">


    <!-- X/Twitter Card Meta Tags for Social Sharing -->
    <meta name="twitter:card" content="summary_large_image">
    <!-- Update with your X/Twitter handle -->
    <meta name="twitter:site" content="@yourtwitterhandle">
    <!-- Update the 'title' and 'description' content below to enhance social sharing -->
    <meta name="twitter:title" content="your_title_goes_here">
    <meta name="twitter:description" content="your_description_goes_here">
    <!-- Update with actual absolute image URL like: https://example.com/main.jpg -->
    <meta name="twitter:image" content="your_absolute_image_url_goes_here">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Aref+Ruqaa+Ink:wght@400;700&display=swap" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- 
        The following line specifies the canonical URL for this page.
        Replace your_canonical_url_goes_here with the actual canonical URL if needed like: https://example.com/index.html
        Or just remove it!!!!
    -->
    <link rel="canonical" href="your_canonical_url_goes_here">

    <style>
        .alexandria-navbar {
            font-family: "Alexandria", sans-serif;
            font-weight: 400;
        }

        /* Custom CSS for new design */
        .card {
            border: 0;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .card img {
            max-height: 200px;
            object-fit: cover;
        }

        .card-body {

            padding: 1.5rem;
            border-top: 1px solid #e9ecef;
        }

        .card-text {
            font-size: 1.5rem;
            font-weight: bold;
        }

        /* Additional styles for responsiveness */
        @media (max-width: 767px) {
            .card {
                margin-bottom: 2rem;
            }
        }

        .aref-ruqaa-ink-regular {
            font-family: "Aref Ruqaa Ink", serif;
            font-weight: 400;
            font-style: normal;
        }

        .aref-ruqaa-ink-bold {
            font-family: "Aref Ruqaa Ink", serif;
            font-weight: 700;
            font-style: normal;
        }
    </style>

</head>

<body>


    <!-- loader-wrapper -->



    <!-- header top -->
    <header class="position-absolute z-3 mt-1 w-100" data-bs-theme="dark">
        <nav class="navbar navbar-expand-xl" aria-label="Offcanvas navbar large">
            <div class="container py-1">
                <a href="./index.php" class="navbar-brand">
                    <img src="./assets/logo/logo.png" height="120" alt="logo">
                </a>

                <div class="dropdown ms-3 order-last">
                    <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
                        <symbol id="check2" viewBox="0 0 16 16">
                            <path
                                d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z" />
                        </symbol>
                        <symbol id="circle-half" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 0 8 1v14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z" />
                        </symbol>
                        <symbol id="moon-stars-fill" viewBox="0 0 16 16">
                            <path
                                d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278z" />
                            <path
                                d="M10.794 3.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387a1.734 1.734 0 0 0-1.097 1.097l-.387 1.162a.217.217 0 0 1-.412 0l-.387-1.162A1.734 1.734 0 0 0 9.31 6.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387a1.734 1.734 0 0 0 1.097-1.097l.387-1.162zM13.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732l-.774-.258a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L13.863.1z" />
                        </symbol>
                        <symbol id="sun-fill" viewBox="0 0 16 16">
                            <path
                                d="M8 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z" />
                        </symbol>
                    </svg>

                    <button class="btn btn-primary text-white btn-sm rounded dropdown-toggle d-flex align-items-center"
                        id="bd-theme" type="button" aria-expanded="false" data-bs-toggle="dropdown"
                        aria-label="Toggle theme (auto)">
                        <svg fill="currentColor" class="bi my-1 theme-icon-active" width="1em" height="1em">
                            <use href="#circle-half"></use>
                        </svg>
                        <span class="visually-hidden" id="bd-theme-text">Toggle theme</span>
                    </button>

                    <ul class="p-1 dropdown-menu dropdown-menu-end dropdown-menu-hover end-0 rounded-3 shadow bg-body-tertiary"
                        style="--bs-dropdown-min-width: 9rem;" aria-labelledby="bd-theme-text">

                        <li style="color: var(--bs-tertiary-bg);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                class="mt-n1 d-inline-block position-absolute top-0 end-0 translate-middle"
                                viewBox="0 0 16 16">
                                <path class="carret-dropdown-path"
                                    d="m7.247 4.86-4.796 5.481c-.566.647-.106 1.659.753 1.659h9.592a1 1 0 0 0 .753-1.659l-4.796-5.48a1 1 0 0 0-1.506 0z" />
                            </svg>
                        </li>

                        <li>
                            <button type="button" class="dropdown-item d-flex align-items-center rounded-1"
                                data-bs-theme-value="light" aria-pressed="false">
                                <svg fill="currentColor" class="bi me-2 theme-icon" width="1em" height="1em">
                                    <use href="#sun-fill"></use>
                                </svg>
                                Light
                                <svg fill="currentColor" class="bi ms-auto d-none active-check" width="1em"
                                    height="1em">
                                    <use href="#check2"></use>
                                </svg>
                            </button>
                        </li>

                        <li>
                            <button type="button" class="my-1 dropdown-item d-flex align-items-center rounded-1"
                                data-bs-theme-value="dark" aria-pressed="false">
                                <svg fill="currentColor" class="bi me-2 theme-icon" width="1em" height="1em">
                                    <use href="#moon-stars-fill"></use>
                                </svg>
                                Dark
                                <svg fill="currentColor" class="bi ms-auto d-none active-check" width="1em"
                                    height="1em">
                                    <use href="#check2"></use>
                                </svg>
                            </button>
                        </li>

                        <li>
                            <button type="button" class="dropdown-item d-flex align-items-center rounded-1 active"
                                data-bs-theme-value="auto" aria-pressed="true">
                                <svg fill="currentColor" class="bi me-2 theme-icon" width="1em" height="1em">
                                    <use href="#circle-half"></use>
                                </svg>
                                Auto
                                <svg fill="currentColor" class="bi ms-auto d-none active-check" width="1em"
                                    height="1em">
                                    <use href="#check2"></use>
                                </svg>
                            </button>
                        </li>
                    </ul>
                </div>

                <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasNavbar2" aria-controls="offcanvasNavbar2" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="offcanvas offcanvas-end border-0 rounded-start-0 rounded-start-sm-4" tabindex="-1"
                    id="offcanvasNavbar2" aria-labelledby="offcanvasNavbar2Label">
                    <div class="offcanvas-header" style="padding: 2rem 2rem 1.5rem 2rem;">
                        <h5 class="offcanvas-title m-0" id="offcanvasNavbar2Label">
                            <a class="navbar-brand" href="javascript:;">
                                <img src="./assets/logo/logo.png" height="32" alt="logo">
                            </a>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>

                    <div class="offcanvas-body">
                        <ul class="navbar-nav align-items-xl-center flex-grow-1 column-gap-4 row-gap-4 row-gap-xl-2">
                            <li class="nav-item ms-xl-auto">
                                <a href="index.php"
                                    class="px-3 text-white bg-primary-hover nav-link rounded-3 text-base leading-6 fw-semibold"
                                    aria-current="page">
                                    المنيو
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="about.php"
                                    class="px-3 text-white bg-primary-hover nav-link rounded-3 text-base leading-6 fw-semibold">
                                    عننا
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="contact.php"
                                    class="px-3 text-white bg-primary-hover nav-link rounded-3 text-base leading-6 fw-semibold">
                                    للشكاوي والاقتراحات
                                </a>
                            </li>


                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>