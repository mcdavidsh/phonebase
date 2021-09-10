<?php

namespace Mcdavidsh\Lib\GSMAPI;


class Gsm
{
    public $base_url = 'https://www.gsmarena.com/';
    private $post_api = 'http://127.0.0.1/projects/active/shcentral/sh-license-key-manager/';

    public function __construct()
    {
        // Include library simple html dom
        require_once("simple_html_dom.php");
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        // Fix bug slug symbol
        $this->simbol = array("&", "+");
        $this->kata = array("_and_", "_plus_");
    }

    ####################### END cURL ##########################

    public function search($q = "")
    {
        $result = array();
        $brands = $this->getBrands();
        $nameArray = array_column($brands['data'], 'title');
        $nameArray = array_map('strtolower', $nameArray);
        $key = array_search(strtolower($q), $nameArray);
        if ($key) {
            $url = $this->base_url . $brands['data'][$key]['href'];
            $pages = $this->getNavigators($url);
            $pages = array_column($pages['data'], 'href');
            array_unshift($pages, $url);
            $products = $this->getProducts($pages);
            return $products;
        } else {
            $url = 'https://www.gsmarena.com/results.php3?sQuickSearch=yes&sName=' . urlencode($q);
            $ngecurl = $this->mycurl($url);
            if ($ngecurl == 'offline') {
                $result["status"] = "error";
                $result["data"] = array();
            } else {
                $html = str_get_html($ngecurl);
                $div = $html->find('div[class=makers]', 0);
                if ($div->find('li', 0)) {
                    $result["status"] = "success";
                    foreach ($div->find('li') as $li) {
                        $grid = $li->find('a', 0);
                        $title = $grid->find('span', 0);
                        $slug = str_replace(".php", "", $grid->href);
                        $result["data"][] = array(
                            "title" => str_replace('<br>', ' ', $title->innertext),
                            "slug" => str_replace($this->simbol, $this->kata, $slug)
                        );
                    }
                } else {
                    $result["status"] = "error";
                    $result["data"] = array();
                }
            }
        }
        return $result;
    }

    public function getBrands()
    {
        $result = array();
        $url = 'https://www.gsmarena.com/makers.php3';
        $ngecurl = $this->mycurl($url);
        if ($ngecurl == 'offline') {
            $result["status"] = "error";
            $result["data"] = array();
        } else {
            $html = str_get_html($ngecurl);
            $div = $html->find('div[class=st-text] table', 0);
            if (!empty($div->find('tr', 0))) {
                $result["status"] = "success";
                foreach ($div->find('tr') as $tr) {
                    foreach ($tr->find('td') as $td) {
                        $grid = $td->find('a', 0);
                        $href = $grid->href;
                        $str = preg_replace('~<span(.*?)</span>~Usi', "", $grid->innertext);
                        $title = strip_tags($str);
                        $count = $grid->find('span', 0);
                        $count = explode(' ', $count)[0];
                        $result["data"][] = array(
                            "title" => $title,
                            "count" => strip_tags($count),
                            "href" => $href,
                        );
                    }
                }
            } else {
                $result["status"] = "error";
                $result["data"] = array();
            }
        }

        return $result;
    }

    private function mycurl($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERAGENT, "Googlebot/2.1 (http://www.googlebot.com/bot.html)");
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);

        // Gagal ngecURL
        if (!$site = curl_exec($ch)) {
            return 'offline';
        } // Sukses ngecURL
        else {
            return $site;
        }
    }

    public function getNavigators($url)
    {
        $result = array();
        $ngecurl = $this->mycurl($url);
        if ($ngecurl == 'offline') {
            $result["status"] = "error";
            $result["data"] = array();
        } else {
            $html = str_get_html($ngecurl);
            $div = $html->find('div[class=nav-pages]', 0);
            if ($div && $div->find('a', 0)) {
                $result["status"] = "success";
                foreach ($div->find('a') as $tr) {
                    $href = $this->base_url . $tr->href;
                    $result["data"][] = array(
                        "href" => $href,
                    );
                }
            } else {
                $result["status"] = "error";
                $result["data"] = array();
            }
        }
        return $result;
    }

    public function getProducts($pages)
    {
        $products = array(
            'data' => array(),
            'status' => null,
        );
        foreach ($pages as $page) {
            $result = array();
            $ngecurl = $this->mycurl($page);
            if ($ngecurl == 'offline') {
                $result["status"] = "error";
                $result["data"] = array();
            } else {
                $html = str_get_html($ngecurl);
                $div = $html->find('div[class=makers]', 0);
                if (!empty($div->find('li', 0))) {
                    $result["status"] = "success";
                    foreach ($div->find('li') as $li) {
                        $grid = $li->find('a', 0);
                        $title = $grid->find('span', 0);
                        $slug = str_replace(".php", "", $grid->href);
                        $result["data"][] = array(
                            "title" => str_replace('<br>', ' ', $title->innertext),
                            "slug" => str_replace($this->simbol, $this->kata, $slug)
                        );
                    }
                }
            }
            $products['status'] = ($result["status"] == 'error' || $products["status"] == 'error') ? 'error' : 'success';
            $products['data'] = array_merge($products['data'], $result['data']);
        }
        return $products;
    }

    function header()
    {
        $sitelogo = "core/assets/images/phonebaselogo.png";
        $getfile = json_decode(file_get_contents('config.json'));
        $siteUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";;
        if ($getfile->siteurl == $siteUrl) {
            echo "<title>$getfile->sitename - $getfile->tagline</title>";
            echo '<link rel="canonical" href="' . $getfile->siteurl . '" />';
            //Google / Search Engine Tags
            echo '<meta itemprop="name" content="' . $getfile->sitename . '">';
            echo '<meta itemprop="description" content="' . $getfile->tagline . '">';
            echo ' <meta itemprop="image" content="' . $sitelogo . '">';
            //Facebook Meta Tags
            echo '<meta property="og:url" content="' . $getfile->siteurl . '">';
            echo '    <meta property="og:type" content="website">';
            echo '    <meta property="og:title" content="' . $getfile->sitename . '">';
            echo '    <meta property="og:description" content="' . $getfile->tagline . '">';
            echo '    <meta property="og:image" content="' . $sitelogo . '">';
            //Twitter Meta Tags
            echo ' <meta name="twitter:card" content="summary_large_image">';
            echo '    <meta name="twitter:title" content="' . $getfile->sitename . '">';
            echo '    <meta name="twitter:description" content="' . $getfile->tagline . '">';
            echo '    <meta name="twitter:image" content="' . $sitelogo . '">';

        } else {
            $urlQuery = parse_url($siteUrl);
            parse_str($urlQuery['query'], $query);
            $phonem = $query['q'];
            $newPhonem = str_replace("_", ' ', $phonem);
            $finalPm = explode("-", $newPhonem);
            $nPhM = ucwords($finalPm[0]);
            $getPhoneImg = $this->detail($phonem);
            $metaImg = $getPhoneImg->img;
            echo "<title>$nPhM - $getfile->sitename</title>";
            echo '<link rel="canonical" href="' . $getfile->siteurl . '" />';
            //Google Search Engine Tags
            echo ' <meta itemprop="name" content="' . $nPhM . ' - ' . $getfile->sitename . '">';
            echo '  <meta itemprop="description" content="View ' . $nPhM . ' - Specification">';
            echo '    <meta itemprop="image" content="' . $metaImg . '">';
            //Facebook Meta Tags
            echo '<meta property="og:url" content="' . $getfile->siteurl . '">';
            echo '    <meta property="og:type" content="website">';
            echo '    <meta property="og:title" content="' . $nPhM . ' - ' . $getfile->sitename . '">';
            echo '    <meta property="og:description" content="View ' . $nPhM . ' - Specification">';
            echo '    <meta property="og:image" content="' . $metaImg . '">';
            //Twitter Meta Tags
            echo ' <meta name="twitter:card" content="summary_large_image">';
            echo '    <meta name="twitter:title" content="' . $nPhM . ' - ' . $getfile->sitename . '">';
            echo '    <meta name="twitter:description" content="View ' . $nPhM . ' - Specification">';
            echo '    <meta name="twitter:image" content="' . $metaImg . '">';


        }
    }

    public function detail($slug = "")
    {

        // Initial ARRAY untuk output
        $result = array();

        // Run cURL
        $url = 'https://www.gsmarena.com/' . str_replace($this->kata, $this->simbol, $slug) . '.php';
        $ngecurl = $this->mycurl($url);

        // Jika situs yang di cURL lagi offline/maintenance maka akan menampilkan error message
        if ($ngecurl == 'offline') {
            $result["status"] = "error";
            $result["data"] = array();
        } else {
            $html = str_get_html($ngecurl);
            if ($html->find('title', 0)->innertext == '404 Not Found') {
                $result["status"] = "error";
                $result["data"] = array();
            } else {
                $result["status"] = "success";
                $result["title"] = $html->find('h1[class=specs-phone-name-title]', 0)->innertext;

                $img_div = $html->find('div[class=specs-photo-main]', 0);
                $result["img"] = $img_div->find('img', 0)->src;

                // Manipulasi DOM menggunakan library simple html dom. Find div dengan nama class specs-list
                $div = $html->find('div[id=specs-list]', 0);

                foreach ($div->find('table') as $table) {
                    $th = $table->find('th', 0);
                    // Membuat array. Find tr from table
                    foreach ($table->find('tr') as $tr) {
                        ($tr->find('td', 0) == "&nbsp;" ? $ttl = "empty" : $ttl = $tr->find('td', 0));
                        $search = array(".", ",", "&", "-", " ");
                        $replace = array("", "", "", "_", "_");
                        $ttl = strtolower(str_replace($search, $replace, $ttl));
                        $nfo = $tr->find('td', 1);
                        $result["data"][strtolower($th->innertext)][] = array(
                            strip_tags($ttl) => strip_tags($nfo)
                        );
                    }
                }
                $search = array("},{", "[", "]", '","nbsp;":"', "nbsp;", " - ");
                $replace = array(",", "", "", "<br>", "", "<br>- ");
                $newjson = str_replace($search, $replace, json_encode($result));
                $result = json_decode($newjson);
            }
        }
        return $result;
    }

    function checkInstall()
    {
        $filename = 'config.json';
        if (empty(file_get_contents($filename))) {
            $temp_page = 'install/';
            header("location:$temp_page");
        }
    }

    function siteInstall()
    {
        try {
            $filename = '../config.json';
            $home = 'index.html';
            if (empty(file_get_contents($filename))) {

                if (isset($_POST['subscribe'])) {
                    $site_name = $this->validate($_POST['sitename']);
                    $site_url = $this->validate($_POST['siteurl']);
                    $site_tag = $this->validate($_POST['sitetag']);
                    $sub_email = $this->validate($_POST['subemail']);
                    $newsletter = isset($_POST['newsletter']);

                    if ($newsletter == 'yes') {
                        $ans = 1;
                    } else {
                        $ans = 0;
                    }


                    if (empty($site_name)) {
                        echo '<script> alert("Please provide Application Name") </script>';
                    } elseif (empty($site_url)) {
                        echo '<script> alert("Please provide Application Url") </script>';
                    } elseif (empty($site_tag)) {
                        echo '<script> alert("Please provide Application Tagline") </script>';
                    } else {

                        $arr = array('sitename' => $site_name, 'tagline' => $site_tag, 'siteurl' => $site_url);

                        $json_arr = json_encode($arr);
                        $post_data = array(
                            'subemail' => $sub_email,
                            'newsletter' => $ans
                        );

                        $client = curl_init($this->post_api);
                        curl_setopt($client, CURLOPT_POST, true);
                        curl_setopt($client, CURLOPT_POSTFIELDS, $post_data);
                        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
                        $response = curl_exec($client);
                        curl_close($client);

                        $result = json_decode($response);
                        $status = $result->status;
                        if ($status == 'empty') {
                            echo '<script> alert("Please Provide Email") </script>';
                        } elseif ($status == 'exists') {
                            echo '<script> alert("Email has already subscribed to receive updates, please provide another email.") </script>';
                        }elseif ($status == "invalid") {
                            echo '<script> alert("Invalid Email, please check and try again.") </script>';
                        }
                        else {
                            if ($status == 'success') {

                                if (file_put_contents($filename, $json_arr) && !empty(file_get_contents($filename))) {

                                    echo '<script> alert("Application ready to use... Redirecting..") </script>';
                                    header("refresh:5; url:$home");
                                } else {
                                    echo '<script> alert("Error Occured, please try again.") </script>';
                                }
                            }
                        }

                    }
                }
            } else {
                header("location:../");
            }


        } catch (\Exception $exception) {
            echo $exception->getMessage();
        }

    }

    public function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = strip_tags($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}
