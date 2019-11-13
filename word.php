<?php
$newarray=array();
require_once('TwitterAPIExchange.php');
 
/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
$settings = array(
    'oauth_access_token' => "840589400287432706-LWVj9zs1wCCvsQ8btadLQeftfrjbg1K",
    'oauth_access_token_secret' => "qZyHe2doAAuqZbEkWAC76S13eodSrus88UFNrmcHkn9J3",
    'consumer_key' => "yfmoLm8wzme4ngYCwAv4KD7iV",
    'consumer_secret' => "KvhWsUqdGGSMyEzefF6cd9WirlOmpYEvkIotE6gaq3huETKwut"
);
$url = 'https://api.twitter.com/1.1/trends/place.json';

$requestMethod = "GET";
$getfield = '?id=2282863';
$twitter = new TwitterAPIExchange($settings);


$string = json_decode($twitter->setGetfield($getfield)
->buildOauth($url, $requestMethod)
->performRequest(),$assoc = TRUE);
if(array_key_exists("errors", $string)) {echo "<h3>Sorry, there was a problem.</h3><p>Twitter returned the following error message:</p><p><em>".$string[errors][0]["message"]."</em></p>";exit();}
/**
foreach($string as $items)
    {
		for($i=0;$i<=10;$i++){
        echo $items['trends'][$i]['name']."<br />";
		echo $items['trends'][$i]['tweet_volume']."<br />";
		}
	}
	
	/**
$string = json_decode($twitter->setGetfield($getfield)
->buildOauth($url, $requestMethod)
->performRequest(),$assoc = TRUE);
if(array_key_exists("errors", $string)) {echo "<h3>Sorry, there was a problem.</h3><p>Twitter returned the following error message:</p><p><em>".$string[errors][0]["message"]."</em></p>";exit();}
echo "<pre>";
print_r($string);
echo "</pre>";
?>
 **/
?>

<html>
<head>
<script src="highcharts.js"></script>
<script src="wordcloud.js">
</script>
<style>
#container {
	min-width: 310px;
	max-width: 1000px;
	margin: 0 auto
}
</style>
</head>
<body>
<?php foreach($string as $items) {

		for($i=0;$i<=40;$i++){
			$item= $items['trends'][$i]['name'];
			//echo $item."<br />";
			array_push($newarray, $item);
		}
	}
?>
<div id="container" style="width=100%;border:1px solid black;"></div>
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
        text: 'Trending Topics'
    }
});
 
</script>
</body>
</html>