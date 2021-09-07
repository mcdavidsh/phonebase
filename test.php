  <?php

      $siteUrl = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $shareUrl = urldecode($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
        $metaImg = 'https://fdn2.gsmarena.com/vv/bigpic/';
  $array = explode('/', rtrim($shareUrl, '/'));
  $valueDf = end($array);
  $getShareU = explode('#', $valueDf);
  var_dump($_SERVER['PHP_SELF']);


//        var getShareU=valueDf.split('#')
//        var homeTitle = ""
//        var homeMeta = ""
//        var siteTitle = "PhoneBase - Mobile Specification Database"
//        var siteDesc = "A comprehensive list of over 100+ mobile devices specification updated on basis"
//        var siteLogo = siteUrl+"core/assets/images/phonebaselogo.png"
//         if (getShareU[1]){
//
//           var newTit = getShareU[1].split('_').join(' ')
//            var newName = newTit.replace(/\b(\w)/g, s => s.toUpperCase());
//           var cleanImg = getShareU[1].split('-')
//            var stripDash = newName.split('-')
//            var resultTitle = stripDash[0]
//            homeTitle = resultTitle+" - PhoneBase"
//            //Google / Search Engine Tags
//            homeMeta+=  '    <meta itemprop="name" content="'+resultTitle+' - '+siteTitle+'">'
//            homeMeta+=   '  <meta itemprop="description" content="View '+resultTitle+' - Specification">'
//            homeMeta+=  '    <meta itemprop="image" content="'+metaImg+cleanImg[0]+'">'
//            //Facebook Meta Tags
//            homeMeta+='<meta property="og:url" content="'+siteUrl+'">'
//            homeMeta+=   '    <meta property="og:type" content="website">'
//            homeMeta+=  '    <meta property="og:title" content="'+resultTitle+' - '+siteTitle+'">'
//            homeMeta+=  '    <meta property="og:description" content="View '+resultTitle+' - Specification">'
//            homeMeta+=  '    <meta property="og:image" content="'+metaImg+cleanImg[0]+'">'
//            //Twitter Meta Tags
//            homeMeta+= ' <meta name="twitter:card" content="summary_large_image">'
//            homeMeta+=    '    <meta name="twitter:title" content="'+resultTitle+' - '+siteTitle+'">'
//            homeMeta+=   '    <meta name="twitter:description" content="View '+resultTitle+' - Specification">'
//            homeMeta+=    '    <meta name="twitter:image" content="'+metaImg+cleanImg[0]+'">'
//        }else {
//
//
//             homeTitle =  siteTitle
//             //Google / Search Engine Tags
//             homeMeta+=  '    <meta itemprop="name" content="'+siteTitle+'">'
//             homeMeta+=   '  <meta itemprop="description" content="'+siteDesc+'">'
//             homeMeta+=  '    <meta itemprop="image" content="'+siteLogo+'">'
//             //Facebook Meta Tags
//             homeMeta+='<meta property="og:url" content="'+siteUrl+'">'
//             homeMeta+=   '    <meta property="og:type" content="website">'
//             homeMeta+=  '    <meta property="og:title" content="'+siteTitle+'">'
//             homeMeta+=  '    <meta property="og:description" content="'+siteDesc+'">'
//             homeMeta+=  '    <meta property="og:image" content="'+siteLogo+'">'
//             //Twitter Meta Tags
//             homeMeta+= ' <meta name="twitter:card" content="summary_large_image">'
//             homeMeta+=    '    <meta name="twitter:title" content="'+siteTitle+'">'
//             homeMeta+=   '    <meta name="twitter:description" content="'+siteDesc+'">'
//             homeMeta+=    '    <meta name="twitter:image" content="'+siteLogo+'">'
//         }
//
//       let headInsert = document.querySelector('head')
//        headInsert.insertAdjacentHTML('afterbegin', homeMeta)
//        let $title = document.querySelector('title')
//        $title.innerText = homeTitle


    ?>

