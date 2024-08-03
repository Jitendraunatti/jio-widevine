<?php

// Determine HTTP or HTTPS
if (array_key_exists('HTTPS', $_SERVER) && $_SERVER["HTTPS"] == "on") {
    $HTTP = "https";
} else {
    $HTTP = "http";
}

$Host_Url = $HTTP . "://" . $_SERVER['HTTP_HOST'] . str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['PHP_SELF']);

// Check if Channel.json file exists
if (file_exists('Channel.json')) {
    $channel_Json = json_decode(@file_get_contents('Channel.json', true));

    $print_data = '#EXTM3U' . PHP_EOL;
    foreach ($channel_Json as $for_js) {
        $print_data .= '#KODIPROP:inputstream.adaptive.license_type=com.widevine.alpha' . PHP_EOL;
        $print_data .= '#KODIPROP:inputstream.adaptive.license_key=' . $Host_Url . 'widevine.php?id=' . $for_js->id . PHP_EOL;
        $print_data .= '#EXTVLCOPT:http-user-agent=plaYtv/7.1.5 (Linux;Android 13) ExoPlayerLib/2.11.7' . PHP_EOL;
        $print_data .= '#EXTINF:-1 tvg-id="' . $for_js->id . '" tvg-logo="' . $for_js->logo . '" group-title="JITENDRAUNATTI' . $for_js->genre . '",' . $for_js->title . PHP_EOL;
        $print_data .= $Host_Url . 'mpd.php?id=' . $for_js->id . PHP_EOL;
    }

    print($print_data);
} else {
    exit('Channel Missing');
}
?>
