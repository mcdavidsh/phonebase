<?php


require '../vendor/autoload.php';

use Mcdavidsh\Lib\GSMAPI;

$gsm = new GSMAPI\Gsm();
$gsm->siteInstall();
$folder = $_SERVER['REQUEST_URI'];
$rm_folder = str_replace('/install','', $folder);
$url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$rm_folder"
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <title>App Installation - Welcome</title>
    <link href="../core/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../core/assets/images/logo.png" rel="icon" type="icon/x-image">
    <link href="../core/assets/images/logo.png" rel="apple-touch-icon" type="icon/x-image">
</head>
<body class="bg-light">
<div class="container">

    <div class="row justify-content-center py-5 align-items-center h-100">
        <div class="col-md-6">
            <form method="post">
                <div class="card ">
                    <div class="card-header">
                        <div class="text-center">
                            <h3 class=""><img src="../core/assets/images/logo.png" class="img-fluid" width="50">Welcome to
                                Phonebase</h3>
                        </div>
                        <p class="text-center">Thank you for purchasing this app, Complete setup to start using app.</p>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Enter Application Name</label>
                            <input type="text" placeholder="PhoneBase" class="form-control" value="" id="sitename"
                                   name="sitename">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Enter Application Tagline</label>
                            <input type="text" placeholder="Mobile Specification Database" class="form-control" value=""
                                   id="sitetag" name="sitetag">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Enter Application Url</label>
                            <input readonly type="url" placeholder="https://" class="form-control"
                                   value="<?php echo $url; ?>" id="siteurl" name="siteurl">
                            <div id="urlHelp" class="form-text text-danger">You cannot modify installation Url.</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Enter Your Email Address</label>
                            <input type="email"  placeholder="example@example.com" class="form-control" value="" id="subemail" name="subemail">
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="form-group form-check my-3">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1" value="no" name="newsletter" hidden>
                            <input type="checkbox" class="form-check-input" id="exampleCheck1" value="yes" name="newsletter">
                            <label class="form-check-label" for="exampleCheck1">Opt-in for weekly newsletter and blog updates from <a href="https://mysofthood.com" class="">Softhood Technologies</a></label>
                        </div>
                        <button type="submit" class="btn" style="background: #7dc855 !important; border: 1px solid #7dc855; color: #ffffff;" id="sbturl" name="subscribe">Continue</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
</body>
</html>
