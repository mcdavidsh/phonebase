<?php
require 'vendor/autoload.php';
use Mcdavidsh\Lib\GSMAPI;

$gsm = new GSMAPI\Gsm();

$gsm->checkInstall();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta content="android, samsung, iphone, infinix, mobile specification, iphone 12, iphone 11,google,ios,phone specification app, phone specfication" name="keyword">
    <meta content="Softhood Technologies" name="author">
    <meta content="Softhood Technologies" name="publisher">
    <meta content="Softhood Technologies" name="copyright">
    <meta content="A comprehensive database of over 100+ mobile device specifications API" name="description">
    <meta content="Technology" name="page-topic">
    <meta content="website" name="page-type">
    <meta content="Everyone" name="audience">
    <meta content="index, follow" name="robots">
    <link href="core/assets/images/logo.png" rel="icon" type="icon/x-image">
    <link href="core/assets/images/logo.png" rel="apple-touch-icon" type="icon/x-image">
    <?php $gsm->header(); ?>
    <!-- CSS -->
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic'
          rel='stylesheet' type='text/css'>

    <link href="core/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="core/assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="core/assets/css/main.css" rel="stylesheet">
    <link href="core/assets/css/aps-styles.css" rel="stylesheet">
    <!--vendor-->
    <link href="core/assets/vendor/jquery-ui/jquery-ui.min.css" rel="stylesheet" type="text/css">
    <link href="core/assets/vendor/select2/css/select2.min.css" rel="stylesheet" type="text/css">
    <link href="core/assets/vendor/select2/theme/select2-bootstrap-5-theme.min.css" rel="stylesheet" type="text/css">
    <link href="core/assets/vendor/notiflix/notiflix-2.7.0.min.css" rel="stylesheet" type="text/css">
    <link href="core/assets/fontawesome/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="core/assets/vendor/fancybox/fancybox.min.css" rel="stylesheet" type="text/css">

</head>
<body>

<!-- Header -->
<header class="hero overlay" id="hero">
    <div class="masthead text-center">
        <div class="container">
            <div class="row ph-row">
                <div class="col-lg-10">
                    <h1 id="site-title"></h1>
                    <p class="lead text-muted">A comprehensive database of over 100+ mobile device specifications API.</p>
                    <div class="search-form">
                        <input autofocus class="search-field" id="phonebrand"
                               placeholder="Search Phone Manufacturer ... "
                               type="text"/>


                        <select aria-label="" class="form-select js-example-responsive disabled search-field d-none"
                                id="phonemodel"></select>
                        <button class="btn btn-light btn-lg d-none" id="searchphone" style=""
                                type="button"><i class="fa fa-search"></i>
                            View
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex d-none justify-content-center fixed-top py-2 ph-close position-sticky" id="up-angle">
        <i class="fa fa-angle-up fa-3x icon-up"
           style="cursor:pointer;color: #7dc855 !important; box-shadow:rgb(0 0 0 / 10%) 0 12px 24px 0 ;"></i>
    </div>
</header>
<section class="topics px-3 py-3 d-none" id="phonefullspec">
    <input class="d-none" id="phoneSlug" type="text" value="">
    <div class="container">
        <div class="d-flex justify-content-center fixed-top py-2 ph-close position-sticky" id="closespec">
            <i class="fa fa-angle-down fa-3x icon-down"></i>
        </div>
        <div class="aps-container ">
            <div class="aps-row clearfix">
                <div class="aps-content aps-content-center">
                    <div class="aps-single-product" itemscope>
                        <h1 class="aps-main-title" id="mainTitle" itemprop="name"></h1>
                        <div class="aps-row">
                            <div class="aps-product-pic">
                                <div class="aps-main-image">
                                    <a data-fancybox="responsive" href="" id="phoneImgFancy">
                                        <img alt="" class="aps-image-zoom img-fluid img-thumbnail"
                                             data-src="" id="phoneImg" itemprop="image" src="" width="100"/>
                                    </a>
                                    <div class="aps-img-loader"><span class="aps-loader"></span></div>
                                </div>

                            </div>
                            <div class="aps-main-features">

                                <ul class="aps-features-list mt-4">
                                    <li>
                                        <div class="aps-feature-anim">
                                        <span class="aps-list-icon">
                                            <i class="fa fa-microchip"></i>
                                        </span>
                                            <div class="aps-feature-info">
                                                <strong>Processor</strong>: <span id="processor"></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="aps-feature-anim">
                                        <span class="aps-list-icon">
                                             <i class="fa fa-memory"></i>
                                        </span>
                                            <div class="aps-feature-info">
                                                <strong>RAM</strong>: <span id="ram"></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="aps-feature-anim">
                                        <span class="aps-list-icon">
                                            <i class="fa fa-sd-card"></i>
                                        </span>
                                            <div class="aps-feature-info">
                                                <strong>Storage</strong>: <span id="storage"></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="aps-feature-anim">
                                        <span class="aps-list-icon">
                                            <i class="fas fa-desktop"></i>
                                        </span>
                                            <div class="aps-feature-info">
                                                <strong>Display</strong>: <span id="display"></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="aps-feature-anim">
                                        <span class="aps-list-icon">
                                             <i class="fa fa-camera"></i>
                                        </span>
                                            <div class="aps-feature-info">
                                                <strong>Camera</strong>: <span id="camera"></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="aps-feature-anim">
                                        <span class="aps-list-icon ">
                                            <i class="fas fa-battery-three-quarters"></i>
                                        </span>
                                            <div class="aps-feature-info">
                                                <strong>Battery</strong>: <span id="battery"></span>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="aps-tab-container">
                            <div class="aps-tab-content aps-flat-content" id="aps-specs">
                                <div class="aps-column">
                                    <h2 class="aps-tab-title" id="secondtitle"></h2>
                                    <div id="ph-details"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="dropdown d-flex justify-content-end fixed-bottom py-2 position-sticky">
            <button aria-expanded="false" class="btn btn-light dropdown-toggle"
                    data-bs-toggle="dropdown"
                    id="dropdownMenuButton1"
                    style="background: #7dc855 !important; border-radius: 0; border: 1px solid #7dc855; color: #ffffff !important; box-shadow:rgb(0 0 0 / 10%) 0 12px 24px 0 ;"
                    type="button">
                <i class="fa fa-share-alt"></i> Share
            </button>
            <ul aria-labelledby="dropdownMenuButton1" class="dropdown-menu pointer-event">
                <li style="cursor: pointer"><a class="dropdown-item" id="sharefb"><i class="fab fa-facebook"
                                                                                     style=" color: #7dc855; margin-right: 5px;"></i>FACEBOOK</a>
                </li>
                <li style="cursor: pointer"><a class="dropdown-item" id="sharetw"><i class="fab fa-twitter"
                                                                                     style=" color: #7dc855; margin-right: 5px;"></i>TWITTER</a>
                </li>
                <li style="cursor: pointer"><a class="dropdown-item" id="sharewht"><i class="fab fa-whatsapp"
                                                                                      style=" color: #7dc855; margin-right: 5px;"></i>WHATSAPP</a>
                </li>
                <li style="cursor: pointer"><a class="dropdown-item" id="shareCopy"><i class="fa fa-copy"
                                                                                       style=" color: #7dc855; margin-right: 5px;"></i>COPY
                    LINK</a>
                </li>
            </ul>
        </div>

    </div>
</section>

<footer>
    <div class="container">
        <div class="row">
            <div class="copyright">
                <p>©
                    <span id="footerDate"></span>
                    <span id="footerName"></span>
                    <span id="footerCredit"></span>
                </p>
            </div>
        </div>
    </div>
</footer>

<script src="core/assets/vendor/jquery/jquery.min.js"></script>
<script src="core/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="core/assets/vendor/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<script src="core/assets/vendor/jquery-ui/jquery.ui.autocomplete.scroll.min.js" type="text/javascript"></script>
<script src="core/assets/vendor/select2/js/select2.full.min.js" type="text/javascript"></script>
<script src="core/assets/vendor/notiflix/notiflix-aio-2.7.0.min.js" type="text/javascript"></script>
<script src="core/assets/fontawesome/js/all.min.js" type="text/javascript"></script>
<script src="core/assets/vendor/fancybox/fancybox.umd.js" type="text/javascript"></script>
<script src="core/controllers/lib/main.js" type="text/javascript"></script>

</body>
</html>
