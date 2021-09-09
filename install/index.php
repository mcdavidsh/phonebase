<?php


require '../vendor/autoload.php';

use Mcdavidsh\Lib\GSMAPI;

$gsm = new GSMAPI\Gsm();
$gsm->siteInstall();


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
    <div class="text-center">
        <h1 class="display-4"><img src="../core/assets/images/phonebaselogo.png" class="img-fluid" width="50">Welcome to
            Phonebase</h1>
    </div>
    <p class="text-center text-capitalize">Complete setup to begin use of this app.</p>
    <div class="row justify-content-center py-5 align-items-center h-100">
        <div class="col-md-6">
            <form method="post">
                <div class="card ">
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
                            <input type="url" placeholder="http://" class="form-control"
                                   value="<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]" ?>"
                                   id="siteurl" name="siteurl">
                        </div>


                    </div>
                    <div class="card-footer">

                        <button type="submit" class="btn btn-success" id="sbturl" name="submit">Continue</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
</body>
</html>
