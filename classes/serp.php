<?php
class GOOGLEPR
{ 
 CONST SOURCE = 'http://toolbarqueries.google.com/';

 public function __construct()
    {  }

    /**
   * Function for set domain for search
   *
   * return Bool
 */
 static function getPageRank($page)
    {
  //Get hash with  terms of service google.
  $hash = "Mining PageRank is AGAINST GOOGLE'S TERMS OF SERVICE. Yes, I'm talking to you, scammer.";
  $c = 16909125;
  $length = strlen($page);
  $hashpieces = str_split($hash);
  $urlpieces = str_split($page);
  for($d = 0; $d<$length; $d++){ 
   $c = $c ^ (ord($hashpieces[$d]) ^ ord($urlpieces[$d]));
   $c = (($c >> 23) & 0x1ff) | $c << 9;
   }
   $c = -(~($c & 4294967295) + 1);
   $prHash = '8' . dechex($c);
  $prUrl = self::SOURCE.'tbr?client=navclient-auto&ch=' . $prHash . '&features=Rank&q=info:' . urlencode($page);
  $out = file_get_contents($prUrl);
  if(strlen($out) > 0) {
   return trim(substr(strrchr($out, ':'), 1));
  } else {
   return 0;
  } 
    }
}

?>
