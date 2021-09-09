<?php
$filename = 'config.json';
$temp_page ='install.html';
if(isset($_POST['submit'])){
    $site_name = $_POST['sitename'];
    $site_url = $_POST['siteurl'];
    $site_tag = $_POST['sitetag'];

    $arr = array('sitename'=> $site_name,'tagline'=>$site_tag, 'siteurl'=>$site_url);

    $json_arr = json_encode($arr);
    if (file_put_contents($filename, $json_arr)){
        $msg = 'Site Information, updated successfully.. Redirecting..';
        unlink($temp_page);
        echo '<script>

window.location.reload();
</script>';
    }

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <title>Welcome - Phonebase</title>
    <link href="core/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="core/assets/images/phonebaselogo.png" rel="icon" type="icon/x-image">
    <link href="core/assets/images/phonebaselogo.png" rel="apple-touch-icon" type="icon/x-image">
</head>
<body>
<div class="container">
    <div class="text-center">
        <h1 class="display-4"><img src="core/assets/images/phonebaselogo.png" class="img-fluid" width="30">Welcome to Phonebase</h1>
    </div>
    <p class="text-center text-capitalize">Complete setup to begin use of this app.</p>
<div class="row justify-content-center py-5 align-items-center h-100">
    <div class="col-md-6">
        <form method="post">
        <div class="card ">
            <div class="card-body">
                <?php if (isset($msg)){
?><div class="card-header">
    <span class="alert alert-success" role="alert">
        <?php
        echo  $msg
        ?>

    </span>
</div>
                <?php
                }
                ?>
                    <div class="mb-3">
                        <label class="form-label">Enter Site Name</label>
                        <input type="text" placeholder="PhoneBase"  class="form-control" value="" id="sitename"  name="sitename">
                    </div>
                <div class="mb-3">
                    <label class="form-label">Enter Site Tagline</label>
                    <input type="text" placeholder="Mobile Specification Database"  class="form-control" value="" id="sitetag"  name="sitetag">
                </div>
                    <div class="mb-3">
                        <label class="form-label">Enter Site Url</label>
                        <input type="url" placeholder="http://"  class="form-control" value="" id="siteurl" name="siteurl">
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
<footer>
    <div class="container">
        <div class="row text-center">
            <div class="copyright">
                <p>©
                    <span id="footerDate"></span>
                    Phonebase. All Right Reserve
                </p>
            </div>
        </div>
    </div>
</footer>

<!--<script src="core/controllers/lib/main.js" type="text/javascript"></script>-->
</body>
</html>
