<?php 

global $whmcs_bridge_enabled;

if( function_exists('cc_whmcs_bridge_home')){
    $whmcs_bridge_enabled = true;
}

/**
 *
 * WHMCS Bridge Page URL
 *
 */
if(!function_exists('void_ewhmcse_whmcs_bridge_url')){
function void_ewhmcse_whmcs_bridge_url() {
  return cc_whmcs_bridge_home($home,$pid);
}
}


//Metod 1
// function void_ewhmcse_ajax_domain_function(){  
//     $json = file_get_contents('http://api.bulkwhoisapi.com/whoisAPI.php?domain='.$_POST["domain"].'&type=whois&token=7d3f08b98ab9f69ae15060a5b58ef1ee');
//     //$json = json_decode($json,true);
//     $json = json_decode($json);
//     $json = json_encode( $json->response_code );
//     echo $json;
//     wp_die(); 
// }
//function to get the remote data
function void_ewhmcse_url_get_contents ($url) {
    if (function_exists('curl_exec')){ 
        $conn = curl_init($url);
        curl_setopt($conn, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($conn, CURLOPT_FRESH_CONNECT,  true);
        curl_setopt($conn, CURLOPT_RETURNTRANSFER, 1);
        $url_get_contents_data = (curl_exec($conn));
        curl_close($conn);
    }elseif(function_exists('file_get_contents')){
        $url_get_contents_data = file_get_contents($url);
    }elseif(function_exists('fopen') && function_exists('stream_get_contents')){
        $handle = fopen ($url, "r");
        $url_get_contents_data = stream_get_contents($handle);
    }else{
        $url_get_contents_data = false;
    }
return $url_get_contents_data;
} 
//Metod 2
function void_ewhmcse_ajax_domain_function(){  
    $json = void_ewhmcse_url_get_contents('http://whoiz.herokuapp.com/lookup.json?url='.$_POST['domain']);
    $json = json_decode(json_encode($json),true);
    echo $json;
    wp_die(); 
}
add_action( 'wp_ajax_void_ewhmcse_ajax_domain_function', 'void_ewhmcse_ajax_domain_function' );
add_action( 'wp_ajax_nopriv_void_ewhmcse_ajax_domain_function', 'void_ewhmcse_ajax_domain_function' );
