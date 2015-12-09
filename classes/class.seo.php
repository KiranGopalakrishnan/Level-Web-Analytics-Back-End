<?php
class seo{
    private $url;
    function seo($url){
        $this->url=$url;
    }
    function pagerank(){
        require_once realpath('../SEOstats/bootstrap.php');
//require_once realpath(__DIR__ . '/vendor/autoload.php');

try {
    $url = $this->url;

    // Get the Google PageRank for the given URL.
    $pagerank = \SEOstats\Services\Google::getPageRank($url);
    echo $pagerank;
}
catch (\Exception $e) {
    echo 'Caught SEOstatsException: ' .  $e->getMessage();
}
    }
    function alexaMetrics()
    {
        require_once realpath('../SEOstats/bootstrap.php');
        include'\SEOstats\Services\Alexa.php';
        use \SEOstats\Services\Alexa as Alexa;

try {
    $url = 'http://www.google.de/';

    // Create a new SEOstats instance.
    $seostats = new \SEOstats\SEOstats;

    // Bind the URL to the current SEOstats instance.
    if ($seostats->setUrl($url)) {

        echo "Alexa metrics for " . $url . PHP_EOL;

        // Get the global Alexa Traffic Rank (last 3 months).
        echo "Global Rank:      " .
            Alexa::getGlobalRank() . PHP_EOL;

        // Get the country-specific Alexa Traffic Rank.
        echo "Country Rank:     ";
        $countryRank = Alexa::getCountryRank();
        if (is_array($countryRank)) {
            echo $countryRank['rank'] . ' (in ' .
                 $countryRank['country'] . ")" . PHP_EOL;
        }
        else {
            echo "{$countryRank}\r\n";
        }
        function getAlexaBacklinks(){
        
        // Get Alexa's backlink count for the given domain.
        echo "Total Backlinks:  " .
            Alexa::getBacklinkCount() . PHP_EOL;
    
        }
        function getAlexaPageLoadTime()
        {
        // Get Alexa's page load time info for the given domain.
        echo "Page load time:   " .
            Alexa::getPageLoadTime() . PHP_EOL;
        }
    }
}
catch (\Exception $e) {
    echo 'Caught SEOstatsException: ' .  $e->getMessage();
}

    }
}
?>
