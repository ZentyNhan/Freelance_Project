<?php

defined('ABSPATH') || exit;

if ( !class_exists( 'Tried_Theme', false ) ) {
    include_once get_template_directory() . '/includes/class-tried.php';
}

if ( !function_exists( 'extentions_init' )) {
    include_once get_template_directory() . '/extentions/init.php';
}

// // include_once get_template_directory() . '/php-sdk-main/main.php';
// print_r(glob_includes(get_template_directory()));

// $curl = curl_init();
// $api_key = 'A2wG2e4a8DEyM2Hdz51jP47AQqt5Zjn4';
// $options =array(
//     CURLOPT_RETURNTRANSFER => 1,
//     CURLOPT_URL => "https://api.webscrapingapi.com/v1?url=https%3A%2F%2Fbizonc.com%2Fdownloads%2F&api_key=A2wG2e4a8DEyM2Hdz51jP47AQqt5Zjn4&device=desktop&proxy_type=datacenter&render_js=0",
//     // CURLOPT_POST => true,
//     CURLOPT_RETURNTRANSFER => true,
//     CURLOPT_ENCODING => "",
//     // CURLOPT_MAXREDIRS => 10,
//     // CURLOPT_TIMEOUT => 30,
//     CURLOPT_SSL_VERIFYPEER => false,
//     CURLOPT_SSL_VERIFYHOST => 2,
//     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//     CURLOPT_USERAGENT => "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)",
//     CURLOPT_CUSTOMREQUEST => "GET"
// );
// curl_setopt_array($curl, $options);
// // curl_setopt_array($curl, [
// //   CURLOPT_URL => "https://api.webscrapingapi.com/v1?url=https://api.ipify.org/&api_key=A2wG2e4a8DEyM2Hdz51jP47AQqt5Zjn4&device=desktop&proxy_type=datacenter&render_js=0",
// //   CURLOPT_RETURNTRANSFER => true,
// //   CURLOPT_ENCODING => "",
// //   CURLOPT_MAXREDIRS => 10,
// //   CURLOPT_TIMEOUT => 30,
// //   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
// //   CURLOPT_CUSTOMREQUEST => "GET",
// // ]);

// $response = curl_exec($curl);
// $err = curl_error($curl);

// curl_close($curl);

// if ($err) {
//   echo "cURL Error #:" . $err;
// } else {
//   echo $response;
// }


// $ch = curl_init();

// curl_setopt($ch, CURLOPT_URL, 'http://httpbin.org/get');

// curl_setopt($ch, CURLOPT_PROXY, 'http://webscrapingapi.proxy_type=datacenter.device=desktop:<YOUR_API_KEY>@proxy.webscrapingapi.com:80');

// curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

// curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

// $response = curl_exec($ch);

// if (!$response) {
//   die('Error: "'.curl_error($ch).'" - Code: '.curl_errno($ch));
// }

// echo 'HTTP Status Code: '.curl_getinfo($ch, CURLINFO_HTTP_CODE) . PHP_EOL;
// echo 'Response Body: '.$response . PHP_EOL;

// curl_close($ch);

// $command = escapeshellcmd('python3 ./python-selenium/test.py');
$command = escapeshellcmd('python3 ./python/Selenium_Test.py');
$output = shell_exec($command);
echo $output;

// $url = "http://api.scraperapi.com?api_key=02aafcc47fa2e81f66fd6edb4f88bd74&url=https://bizonc.com/downloads"; 
// $ch = curl_init(); curl_setopt($ch, CURLOPT_URL, $url); curl_setopt($ch, CURLOPT_RETURNTRANSFER,
// TRUE); curl_setopt($ch, CURLOPT_HEADER,
// FALSE); curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,
// 0); curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,
// 0); $response = curl_exec($ch); curl_close($ch); print_r($response);


if ( isset( $_GET['user'] ) && !empty( $_GET['user'] ) ) {

        // $url = "http://api.scraperapi.com?api_key=02aafcc47fa2e81f66fd6edb4f88bd74&url=https://bizonc.com/downloads"; 
        // $ch = curl_init(); curl_setopt($ch, CURLOPT_URL, $url); curl_setopt($ch, CURLOPT_RETURNTRANSFER,
        // TRUE); curl_setopt($ch, CURLOPT_HEADER,
        // FALSE); curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,
        // 0); curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,
        // 0); $response = curl_exec($ch); curl_close($ch); print_r($response);



// $curl = curl_init();
// $api_key = 'A2wG2e4a8DEyM2Hdz51jP47AQqt5Zjn4';
// $options =array(
//     CURLOPT_RETURNTRANSFER => 1,
//     CURLOPT_URL => "https://api.webscrapingapi.com/v1?url=https%3A%2F%2Fbizonc.com%2Fdownloads%2F&api_key=A2wG2e4a8DEyM2Hdz51jP47AQqt5Zjn4&device=desktop&proxy_type=datacenter&render_js=0&country=tr",
//     // CURLOPT_URL => "https://bizonc.com/downloads",
//     // CURLOPT_PROXY => 'http://webscrapingapi.proxy_type=datacenter.device=desktop:A2wG2e4a8DEyM2Hdz51jP47AQqt5Zjn4@proxy.webscrapingapi.com:80',
//     // CURLOPT_POST => true,
//     CURLOPT_RETURNTRANSFER => true,
//     CURLOPT_ENCODING => "",
//     // CURLOPT_MAXREDIRS => 10,
//     // CURLOPT_TIMEOUT => 30,
//     CURLOPT_SSL_VERIFYPEER => false,
//     CURLOPT_SSL_VERIFYHOST => 2,
//     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//     CURLOPT_USERAGENT => "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)",
//     CURLOPT_CUSTOMREQUEST => "GET"
// );
// curl_setopt_array($curl, $options);
// curl_setopt_array($curl, [
//   CURLOPT_URL => "https://api.webscrapingapi.com/v1?url=https://api.ipify.org/&api_key=A2wG2e4a8DEyM2Hdz51jP47AQqt5Zjn4&device=desktop&proxy_type=datacenter&render_js=0",
//   CURLOPT_RETURNTRANSFER => true,
//   CURLOPT_ENCODING => "",
//   CURLOPT_MAXREDIRS => 10,
//   CURLOPT_TIMEOUT => 30,
//   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//   CURLOPT_CUSTOMREQUEST => "GET",
// ]);

// $response = curl_exec($curl);
// $err = curl_error($curl);

// curl_close($curl);

// if ($err) {
//   echo "cURL Error #:" . $err;
// } else {
//   echo $response;
// }



    // wp_send_json(array(
    //     'code' => '200',
    //     'response' => $_GET['user']
    // ));
}