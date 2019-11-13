<html>
<head>
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="HandheldFriendly" content="true">
<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css"> 
<script src="highcharts.js"></script>
<script src="wordcloud.js"></script>
<style>
    table,tr,td{
       border: 1px solid blue; 
        width: 50%;
        border-collapse: collapse;
        background-color: aqua;
    }
    table{
        margin:auto;
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
<?php
require_once('TwitterAPIExchange.php');
 
/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
$settings = array(
    'oauth_access_token' => "840589400287432706-LWVj9zs1wCCvsQ8btadLQeftfrjbg1K",
    'oauth_access_token_secret' => "qZyHe2doAAuqZbEkWAC76S13eodSrus88UFNrmcHkn9J3",
    'consumer_key' => "yfmoLm8wzme4ngYCwAv4KD7iV",
    'consumer_secret' => "KvhWsUqdGGSMyEzefF6cd9WirlOmpYEvkIotE6gaq3huETKwut"
);
$url = "https://api.twitter.com/1.1/statuses/user_timeline.json";
$requestMethod = "GET";


if (isset($_POST["user"])){
    $user=$_POST["user"];
}
else
$user  = "";
$count = 20;



$getfield = "?screen_name=$user&count=$count";
$twitter = new TwitterAPIExchange($settings);
$string = json_decode($twitter->setGetfield($getfield)
->buildOauth($url, $requestMethod)
->performRequest(),$assoc = TRUE);
if(array_key_exists("errors", $string)) {echo "<h3>Sorry, there was a problem.</h3><p>Twitter returned the following error message:</p><p><em>".$string[errors][0]["message"]."</em></p>";exit();}
foreach($string as $items)
    {   echo"<table>";
        echo "<tr><td>Time and Date of Tweet: </td><td>".$items['created_at']."</td></tr>";
        echo "<tr><td>Tweet:</td><td> ". $items['text']."</td></tr>";
		echo "<tr><td><img src='". $items['user']['profile_image_url']."'</td></tr>";
		echo "<tr><td>retweet count </td><td>".$items['retweet_count']."</td></tr>";
        echo "<tr><td>Tweeted by: </td><td>". $items['user']['name']."</td></tr>";
        echo "<tr><td>Screen name:</td><td> ". $items['user']['screen_name']."</td></tr>";
        echo "<tr><td>Followers:</td><td> ". $items['user']['followers_count']."</td></tr>";
        echo "<tr><td>Friends: </td><td>". $items['user']['friends_count']."</td></tr>";
        echo "<tr><td>Listed: </td><td>". $items['user']['listed_count']."</td></tr>";
        echo "</table>";
    }
?>



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

</body>
</html>