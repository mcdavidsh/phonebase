<?php
// JSON
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');


require '../../../vendor/autoload.php';

use Mcdavidsh\Lib\GSMAPI\Gsm;

// Create objek
$gsm = new gsm();
// Return ARRAY
if (!empty($_GET['query'])) {
    $data = $gsm->search($_GET['query']);
} elseif (!empty($_GET['slug'])) {
    $data = $gsm->detail($_GET['slug']);
} elseif (!empty($_GET['brands'])) {
    $data = $gsm->getBrands();
}elseif (isset($_POST['saveImage'])){
    $data = $gsm->saveImg();
}
else {
    $data['status'] = 'error';
}


// Convert ARRAY to JSON
echo json_encode($data, JSON_PRETTY_PRINT);
