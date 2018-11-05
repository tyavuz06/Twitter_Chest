<?php
/**
* get_tweets.php
* Collect tweets from the Twitter streaming API
* This must be run as a continuous background process
* Latest copy of this code: http://140dev.com/free-twitter-api-source-code-library/
* @author Adam Green <140dev@gmail.com>
* @license GNU Public License
* @version BETA 0.30
*/
require_once('140dev_config.php');

require_once('../libraries/phirehose/Phirehose.php');
require_once('../libraries/phirehose/OauthPhirehose.php');
class Consumer extends OauthPhirehose
{
  // A database connection is established at launch and kept open permanently
  public $oDB;
  public function db_connect() {
    require_once('db_lib.php');
    $this->oDB = new db;
  }
	
  // This function is called automatically by the Phirehose class
  // when a new tweet is received with the JSON data in $status
  public function enqueueStatus($status) {
    $tweet_object = json_decode($status);
		
		// Ignore tweets without a properly formed tweet id value
    if (!(isset($tweet_object->id_str))) { return;}
		
    $tweet_id = $tweet_object->id_str;

    // If there's a ", ', :, or ; in object elements, serialize() gets corrupted 
    // You should also use base64_encode() before saving this
    $raw_tweet = base64_encode(serialize($tweet_object));
		
    $field_values = 'raw_tweet = "' . $raw_tweet . '", ' .
      'tweet_id = ' . $tweet_id;
    $this->oDB->insert('json_cache',$field_values);
  }
}

// Open a persistent connection to the Twitter streaming API
$stream = new Consumer(OAUTH_TOKEN, OAUTH_SECRET, Phirehose::METHOD_FILTER);

// Establish a MySQL database connection
$stream->db_connect();

// The keywords for tweet collection are entered here as an array
// More keywords can be added as array elements
// For example: array('recipe','food','cook','restaurant','great meal')
	  $stream->setTrack(array(
		'AKP','akp','Ak Parti','AkParti',
		'MHP','mhp','Milliyetçi Hareket Partisi','Milliyetci Hareket Partisi','MilliyetciHareketPartisi',
		'CHP','chp','Cumhuriyet Halk Partisi','CumhuriyetHalkPartisi',
		'HDP','hdp','Halkarın Demokratik Partisi','Halklarin Demokratik Partisi','HalklarinDemokratikPartisi','HalklarınDemokratikPartisi',
	
	  ));	
	
	 
	
	//$stream->setLocations(array(
     //array(445.07,206.98l-1,1.29l-1.19,5.33l-0.91,2.23l-0.88,1.49l-1.5,1.21l-0.55,0.81l0.2,0.53l2.09,0.32l0.95,0.81l-0.24,1l-1.76,1.56l-0.8,1.41l0.26,1.03l1.8,2.29l0.43,2.09l-0.18,1.5l-0.98,2.1l-2.89,2.9l0,0l-1.31,0.3l-4.18,2.51l-2.15,3.22l-1.29,4.13l-0.47,4.38l0.44,3.09l1.52,4.45l0.38,3.03l-1.24,9.1l0,0l-1.39,1.2l-0.84,1.44l-0.18,1.19l0.43,1.39l0,0l-2.15,2.17l-1.38,0.85l-1.01,1.84l-1.87,1.45l-0.3,0.75l-2.27,1.53l-1.47,-0.19l-1.72,0.58l-0.59,-0.45l-1.21,0.01l-1.64,1.05l-0.84,1.74l0.91,-0.42l-0.22,0.47l0.23,0.71l0.52,-1.15l0,-0.31l-0.48,-0.03l0.23,-0.38l0.78,-0.18l0.03,0.51l0.25,0.14l-0.16,0.87l1.81,-0.22l0.2,-0.21l-0.42,-0.16v-0.37l1.08,0.75l-3.2,2.23l-0.46,0.78l-0.31,2.37l-0.69,0.64l-1.37,0.56l-0.48,0.77l-0.42,0.14l-0.5,-0.44l-1.84,-0.49l-2.79,-0.34l-1.03,0.32v0.63l-2.8,1.72l-0.22,-0.62l-1.08,-0.7l-12.54,-7.43l-1.87,-0.65l-2.25,0.03l0,0l1,-0.91l0,0l-0.02,-0.25l0.27,0.21l0,0l0.41,-0.32l0.13,0.32l0.35,-0.1l0.16,-0.96l0.2,0.42l0.81,-0.44l0.49,0.03l0.53,0.47l-0.28,-0.69l0.19,-0.13l0.8,0.57l0.02,-1.1l0.31,0.02l0.38,0.66l1.29,-1.71l0.82,0.75l1.27,-0.45l0.29,0.06l0.17,0.51l0.29,-0.13l-0.21,-0.27l0.79,-0.46l0.23,-0.82l-0.67,-3.38l-0.01,-3.39l-0.88,-3.1l0.1,-2.1l-0.57,-0.79l-0.6,-0.57l-2.41,-1.2l-1.69,-0.01l-0.29,-1.3l-0.63,-1.02l-0.99,-0.63l-0.86,-0.14l-0.34,-0.5l0.02,-1.54l0.53,-0.84l1.49,-1.05l-0.08,-1.23l-1.15,-1.89l-1.6,-1.36l0.2,-0.51l-1.31,-0.29l-2.23,-3.07l0.14,-2.21l-0.84,-1.45l0,0l0.05,-0.49l2.58,-1.6l-0.76,-1.45l1,-1.36l0.77,-3.56l0.04,-2.24l0.75,-1.26l1.5,-0.35l2.29,1.04l1.27,-0.08l0.83,-0.71l2.45,-4.29l1.31,-1.13l3.23,-1.58l0,0l4.93,1.27l0.51,0.63l1.32,-0.34l0.48,0.27l0.43,1.17l0.36,0.24l1.1,-0.25l4.33,0.72l1.71,-0.04l1.23,-2.07l-0.22,-1.66l0.67,-2.1l0.84,-5.59l0.67,-0.42l1.5,-0.26l1.1,-0.74l0.89,-0.85l1.19,-1.89l1.13,-0.44l1.15,-1.51l5.24,-1.63l1.34,-0.85l1.37,-2.25l1.15,-4.28l2,-1.95l1.65,-3.03l3.83,-1.42l1.29,-0.08l2.7,2.06l1.68,2.64L445.07,206.98z) // adana
     //array(-122.75, 36.8, -121.75, 37.8)
	//array(41.02, 40.52, 42.02, 41.52), //rize 
	//array(28.97, 41.00, 29.97, 42.00), //istanbul
	//array(32.85, 39.92, 33.85, 40.92) //ankara
	//array(30.52, 39.78, 31.52, 40.78), //Eskişehir
	//array(32.62, 41.21, 33.62, 42.21) //Karabük
	 //array(27.13, 38.42, 28.13, 39.42)  //İzmir
		
   // )); 
// Start collecting tweets
// Automatically call enqueueStatus($status) with each tweet's JSON data
$stream->consume();

?>