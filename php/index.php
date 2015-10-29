<html>
<head>
    <script>
        function showRSS(str) {
            if (str.length == 0) {
                document.getElementById("rssOutput").innerHTML = "";
                return;
            }
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else {  // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("rssOutput").innerHTML = xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET", "getrss.php?q=" + str, true);
            xmlhttp.send();
        }
    </script>
</head>
<body>
<h1>ssh -L 8080:localhost:9057 2038011y@sibu.dcs.gla.ac.uk "ssh -L 9057:130.209.67.145:8080 roma"</h1>
<form>
    <select onchange="showRSS(this.value)">
        <option value="">Select a feed:</option>
<!--        <option value="Google">Google News</option>-->
<!--        <option value="NBC">NBC News</option>-->
        <option value="TrainDelays">Train Delays</option>
        <option value="Venues">Busy Venues</option>
        <option value="Twitter">Twitter Hashtag</option>
        <option value="TrainStations">Train Stations</option>
    </select>
</form>
<br>

<div id="rssOutput">RSS-feed will be listed here...</div>
</body>
</html>