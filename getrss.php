<?php
//get the q parameter from URL
$q = $_GET["q"];
//find out which feed was selected
if ($q == "Google") {
    $xml = ("http://news.google.com/news?ned=us&topic=h&output=rss");
} elseif ($q == "NBC") {
    $xml = ("http://rss.msnbc.msn.com/id/3032091/device/rss/rss.xml");
} elseif ($q == "TrainDelays") {
    $postData = array(
        "request" => array(
            "tiploc" => "GLGQHL",
            "shortDate" => "2015-04-01",
            "minimumDelay" => "5"
        )
    );

    $ch = curl_init('http://localhost:8080/ubdc-web/getDelayedServices.action');

} elseif ($q == "TrainStations") {
    $postData = array(
        "request" => array(
            "lat" => 55.8580,
            "lon" => -4.2590,
            "radius" => 1.0
        )
    );
    $ch = curl_init('http://localhost:8080/ubdc-web/getTrainStations.action');
} elseif ($q == "Venues") {
    $postData = array(
        "request" => array(
            "lat" => 55.8748,
            "lon" => -4.2929,
            "radius" => 0.005,
            "timestamp" => "2015-09-01 19:00:00"
        )
    );
    $ch = curl_init('http://localhost:8080/ubdc-web/getBusyVenues.action');
} elseif ($q == "Twitter") {
    $postData = array(
        "request" => array(
            "query" => "yesscotland",
            "date" => "2014-08-25"
        )
    );
    $ch = curl_init('http://localhost:8080/ubdc-web/getTweetStats.action');
}


curl_setopt_array($ch, array(
    CURLOPT_POST => TRUE,
    CURLOPT_RETURNTRANSFER => TRUE,
    CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json'
    ),
    CURLOPT_POSTFIELDS => json_encode($postData)
));

// Send the request
$response = curl_exec($ch);

// Check for errors
if($response === FALSE){
    echo "<p>fail</p>";
    die(curl_error($ch));
}

// Decode the response
$responseData = json_decode($response, TRUE);

// Print the date from the response
//    echo var_dump($responseData);
if ($q == "TrainDelays") {
    //echo $responseData['response']['jsonResponse'];
    var_dump($responseData['response']['jsonResponse']);
} elseif ($q == "TrainStations") {
    var_dump($responseData['response']['trainStations']);
//    echo $responseData['response'];
} elseif ($q == "Venues") {
    var_dump($responseData['response']['results']);
} elseif ($q == "Twitter") {
    echo $response;
}


//$xmlDoc = new DOMDocument();
//$xmlDoc->load($xml);
//
////get elements from "<channel>"
//$channel = $xmlDoc->getElementsByTagName('channel')->item(0);
//$channel_title = $channel->getElementsByTagName('title')
//    ->item(0)->childNodes->item(0)->nodeValue;
//$channel_link = $channel->getElementsByTagName('link')
//    ->item(0)->childNodes->item(0)->nodeValue;
//$channel_desc = $channel->getElementsByTagName('description')
//    ->item(0)->childNodes->item(0)->nodeValue;
//
////output elements from "<channel>"
//echo("<p><a href='" . $channel_link
//    . "'>" . $channel_title . "</a>");
//echo("<br>");
//echo($channel_desc . "</p>");
//
////get and output "<item>" elements
//$x = $xmlDoc->getElementsByTagName('item');
//for ($i = 0; $i <= 2; $i++) {
//    $item_title = $x->item($i)->getElementsByTagName('title')
//        ->item(0)->childNodes->item(0)->nodeValue;
//    $item_link = $x->item($i)->getElementsByTagName('link')
//        ->item(0)->childNodes->item(0)->nodeValue;
//    $item_desc = $x->item($i)->getElementsByTagName('description')
//        ->item(0)->childNodes->item(0)->nodeValue;
//    echo("<p><a href='" . $item_link
//        . "'>" . $item_title . "</a>");
//    echo("<br>");
//    echo($item_desc . "</p>");
//}
?>