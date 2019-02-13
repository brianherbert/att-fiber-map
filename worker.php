<?php

require_once 'db.php';

$cli_pretty_cols = 60;

while(true) {

    $res = $mysqli->query("SELECT * FROM addresses ORDER BY updated ASC, RAND() LIMIT 5");

    while ($row = $res->fetch_assoc()) {

        $time = time();

        $unit = ($row["unit"]) ? 'Unit '.$row["unit"].' ' : '';
        $address = trim($row["number"]." ".$row["street"]." ".$unit);
        $zip = $row['postcode'];
        echo $address." .....";

        $address_len = strlen($address) + 6;

        $payload = json_encode(array(
                        'customerType'          => 'consumer',
                        'mode'                  => 'fullAddress',
                        'userInputAddressLine1' => $address,
                        'userInputZip'          => $zip
                    ));

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://www.att.com/msapi/serviceavailability/v1/address');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

        $headers = array();
        $headers[] = 'Origin: https://www.att.com';
        $headers[] = 'Accept-Encoding: gzip, deflate, br';
        $headers[] = 'Accept-Language: en-US,en;q=0.9';
        $headers[] = 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.96 Safari/537.36';
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Accept: application/json';
        $headers[] = 'Referer: https://www.att.com/buy/broadband/plans';
        $headers[] = 'Authority: www.att.com';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close ($ch);

        $result = json_decode($result);

        $availabilityStatus = $result->content->availabilityStatus;
        $lightGig = ($result->content->availableServices->lightGigAvailable) ? 1 : 0;

        $time = time() - $time;

        $time_len = strlen($time) + 1;
        $num_dots = $cli_pretty_cols - $address_len - $time_len;

        echo str_repeat(".",$num_dots);

        echo " ".$time."s\n";

        $update = 'UPDATE addresses
                      SET availabilityStatus = \''.$mysqli->real_escape_string($availabilityStatus).'\', 
                          lightGig = '.$mysqli->real_escape_string($lightGig).',
                          time = '.$mysqli->real_escape_string($time).',
                          updated = NOW()
                      WHERE id = '.$mysqli->real_escape_string($row['id']).';';

        $mysqli->query($update);
    }

}
