<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $license_file = 'jitendraunatti.txt';
    $license_data = @json_decode(file_get_contents($license_file), true);
    $current_time = time();

    if (!$license_data || ($current_time - $license_data['JITENDRAUNATTI']['time']) > 3600) {
        $apixurl = 'https://jio-widevine.developed-by-doctor-strange.workers.dev/?id=' . $id;
        $apixheaders = ['user-agent: okhttp/4.10.0'];

        $xcurl = curl_init($apixurl);
        curl_setopt($xcurl, CURLOPT_ENCODING, "gzip");
        curl_setopt($xcurl, CURLOPT_HTTPHEADER, $apixheaders);
        curl_setopt($xcurl, CURLOPT_HEADER, 0);
        curl_setopt($xcurl, CURLOPT_TIMEOUT, 5);
        curl_setopt($xcurl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($xcurl, CURLOPT_FOLLOWLOCATION, 1);
        $return = curl_exec($xcurl);
        curl_close($xcurl);

        $json_data = @json_decode($return, true);
        if ($json_data['JITENDRAUNATTI']['message'] == 'success') {
            $license = $json_data['JITENDRAUNATTI']['licence'];
            $ROLEX = json_encode(array(
                "JITENDRAUNATTI" => array(
                    "licence" => $license,
                    "time" => $current_time
                )
            ));
            file_put_contents($license_file, $ROLEX);
            header("Location: " . $license, true, 307);
        }
    } else {
        $license = $license_data['JITENDRAUNATTI']['licence'];
        header("Location: " . $license, true, 307);
    }
} else {
    echo 'ID not provided.';
}
?>
