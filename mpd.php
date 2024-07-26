<?php

if (isset($_GET['id'])) {

   $apiurl = "https://tv.media.jio.com/apis/v2.0/getchannelurl/getchannelurl";

   $apipost = json_encode(array('channel_id' => $_GET['id']));
   $apiheaders = array("Content-Type: application/json");

   $process = curl_init($apiurl);
   curl_setopt($process, CURLOPT_POST, 1);
   curl_setopt($process, CURLOPT_POSTFIELDS, $apipost);
   curl_setopt($process, CURLOPT_HTTPHEADER, $apiheaders);
   curl_setopt($process, CURLOPT_HEADER, 0);
   curl_setopt($process, CURLOPT_TIMEOUT, 5);
   curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
   curl_setopt($process, CURLOPT_FOLLOWLOCATION, 1);
   $return = curl_exec($process);
   curl_close($process);

   $json_data = @json_decode($return, true);
   if ($json_data['message'] == 'Success' && isset($json_data['mpd']['result'])) {

      $mpd = $json_data['mpd']['result'];


      if (isset($mpd)) {
        header("Location: " . $mpd);
      }
   }
} else {
   echo "somwething went wrong";
}