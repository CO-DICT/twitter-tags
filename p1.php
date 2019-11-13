<?php
require_once('TwitterAPIExchange.php');
 
 if (isset($_GET['id'])){
 $field=$_GET['id'];
 $getfield="?id=".$field;
 //echo $getfield;
 }
 else $getfield = '?id=2282863';


$newarray=array();
/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
$settings = array(
    'oauth_access_token' => "840589400287432706-LWVj9zs1wCCvsQ8btadLQeftfrjbg1K",
    'oauth_access_token_secret' => "qZyHe2doAAuqZbEkWAC76S13eodSrus88UFNrmcHkn9J3",
    'consumer_key' => "yfmoLm8wzme4ngYCwAv4KD7iV",
    'consumer_secret' => "KvhWsUqdGGSMyEzefF6cd9WirlOmpYEvkIotE6gaq3huETKwut"
);
$url = 'https://api.twitter.com/1.1/trends/place.json';
$requestMethod = "GET";
$twitter = new TwitterAPIExchange($settings);

$string = json_decode($twitter->setGetfield($getfield)
->buildOauth($url, $requestMethod)
->performRequest(),$assoc = TRUE);
if(array_key_exists("errors", $string)) {echo "<h3>Sorry, there was a problem.</h3><p>Twitter returned the following error message:</p><p><em>".$string[errors][0]["message"]."</em></p>";exit();}
foreach($string as $items) {

		for($i=0;$i<=40;$i++){
			if (isset($items['trends'][$i]['name'])){
			$item= $items['trends'][$i]['name'];
			//echo $item."<br />";
			array_push($newarray, $item);
			}
		}
	}


?>

<html>
<head>
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="HandheldFriendly" content="true">
<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css"> 
<script src="highcharts.js"></script>
<script src="wordcloud.js"></script>
<style>
#container {	
	position:relative;
	resize: both;
    overflow: auto;
	min-width: 300px;
	max-width: 1000px;
	float:center;
	margin:auto;
	border:1px solid black; float:center;
	border-radius:25px;
	z-index: -1;
}
.btn{
	margin:1px;
}
.stickymenu{
	width:auto;float:right;position:fixed; margin-top:50px;
}
.navbar{
	position:fixed;
	bottom: 0;
	float:center;
	margin:auto;
	right:20%;
}
</style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#"></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
          <a class="nav-link" href="admin.html"><span style="color:red"><b>Logout</b></span> <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="p1.php">Trending</a>
      </li>
      
    </ul>
    <form action="test.php" method="post" class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="topic" aria-label="Search" name="tweet_title">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
    <form action="psearch.php" method="post" class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="people" aria-label="Search" name="user">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
</nav>


<div class="stickymenu">
<div class="list-group text-center">
  <button type="button" class="btn btn btn-secondary" onclick='location.href="?id=2282863"'>INDIA</button>
  <button type="button" class="btn btn btn-secondary" onclick='location.href="?id=23424977"'>USA</button>
  <button type="button" class="btn btn btn-secondary" onclick='location.href="?id=23424975"'>UK</button>
  <button type="button" class="btn btn btn-secondary" onclick='location.href="?id=23424748"'>AUSTRALIA</button>
  <button type="button" class="btn btn btn-secondary" onclick='location.href="?id=23424775"'>CANADA</button>
  <button type="button" class="btn btn btn-secondary" onclick='location.href="?id=23424936"'>RUSSIA </button>
  <button type="button" class="btn btn btn-secondary" onclick='location.href="?id=23424957"'>SWITZERLAND</button>
  <button type="button" class="btn btn btn-secondary" onclick='location.href="?id=23424829"'>GERMANY</button>
</div>
</div>

<div class="stickymenu" style="right:0;">
<div class="list-group text-center">
  <button type="button" class="btn btn btn-secondary" onclick='location.href="?id=23424856"'>JAPAN</button>
  <button type="button" class="btn btn btn-secondary" onclick='location.href="?id=23424950"'>SPAIN</button>
  <button type="button" class="btn btn btn-secondary" onclick='location.href="?id=23424819"'>FRANCE</button>
  <button type="button" class="btn btn btn-secondary" onclick='location.href="?id=23424853"'>ITALY</button>
  <button type="button" class="btn btn btn-secondary" onclick='location.href="?id=23424738"'>UAE</button>
  <button type="button" class="btn btn btn-secondary" onclick='location.href="?id=23424954"'>SWEDEN </button>
  <button type="button" class="btn btn btn-secondary" onclick='location.href="?id=2348079"'>NEW ZEALAND</button>
  <button type="button" class="btn btn btn-secondary" onclick='location.href="?id=23424757"'>BELGIUM</button>
</div>
</div>
<div id="container"></div>
<script>
var data=[] 
var words = <?php echo '["' . implode('", "', $newarray) . '"]' ?>;
//document.write(words.length);
for(var i=0;i<=words.length;i++){
	data.push({
        name: words[words.length-i],
        weight: i+1
    });
}

Highcharts.chart('container', {
    series: [{
        type: 'wordcloud',
        data: data,
        name: ' '
    }],
	credits: {
        enabled: false
    },
	chart: {
		height: (9 / 18 * 100) + '%'
    },
    title: {
        text: 'Twitter Trending Topics'
    }
});

</script>
</body>
</html>