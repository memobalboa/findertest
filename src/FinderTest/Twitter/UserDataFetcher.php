<?php
namespace FinderTest\Twitter;
/**
 * @author guillermo
 */
class UserDataFetcher {

    private $configFilepath;
    
    private $screenName;
    
    private $twitterApi;

    /**
     * 
     * @param type $configFilepath
     *   Contains the file path to the configuration file which contains the required
     *   credentials to query the twitter API. 
     */
    public function __construct($configFilepath)
    {
        $this->configFilepath = $configFilepath;
    }

    public function fetchDataForUser($screenName)
    {
        if(!$this->twitterApi) {
            $this->initTwitterApi();
        }
        $this->screenName = $screenName;
     
        $latestTweets = $this->getLatestTweets();
        $latestTweetsText = array();
        if($latestTweets) { 
            // If there are latest tweets, obtain the user information that is already there
            // to avoid having to do a second request
            foreach($latestTweets as $tweet) { 
                $latestTweetsText[] = $tweet['text'];
            }
            $user = $latestTweets[0]['user'];
        } else {
            // Otherwise, there are no tweets and user information can't be fetched
            // from them, so a different request is made in this case.
            $user = $this->lookupUser();
        }


        $userDetails = $this->obtainUserDetailsFrom($user);
        $userDetails['latestTweets'] = $latestTweetsText;        
        
        return $userDetails;
        
    }
    
    
    private function obtainUserDetailsFrom($userData)
    {
        return array(
            'followers' => $userData['followers_count'],
            'following' => $userData['friends_count'],
            'tweets' => $userData['statuses_count']
        );
    }
    
    private function lookupUser()
    {
        $url = 'https://api.twitter.com/1.1/users/lookup.json';
        $getfield = '?screen_name=' . $this->screenName;
        $requestMethod = 'GET';
        $result = $this->twitterApi
            ->setGetfield($getfield)
            ->buildOauth($url, $requestMethod)
            ->performRequest();        
        return reset(json_decode($result, TRUE));
        
    }
    
    private function getLatestTweets()
    {
        $url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
        $getfield = '?screen_name=' . $this->screenName;
        $getfield.= '&count=5';
        $requestMethod = 'GET';
        $result = $this->twitterApi
            ->setGetfield($getfield)
            ->buildOauth($url, $requestMethod)
            ->performRequest();        
        return json_decode($result, TRUE);
    }

    
    public function initTwitterApi()
    {
        $configFile = \Symfony\Component\Yaml\Yaml::parse($this->configFilepath);
        $configProcessor = new \Symfony\Component\Config\Definition\Processor();
        $twitterConfiguration = new \FinderTest\Config\TwitterConfiguration();
        $finalConfiguration = $configProcessor->processConfiguration($twitterConfiguration, $configFile);

        $apiSettings = array(
            'consumer_key' => $finalConfiguration['consumer_key'],
            'consumer_secret' => $finalConfiguration['consumer_secret'],
            'oauth_access_token' => $finalConfiguration['access_token'],
            'oauth_access_token_secret' => $finalConfiguration['access_token_secret'],
        );
        
        $this->twitterApi = new \TwitterAPIExchange($apiSettings);
    }
    
}