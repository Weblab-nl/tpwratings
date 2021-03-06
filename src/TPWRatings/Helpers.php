<?php


/**
 * Class TPWRatings_Helpers - helper functions for the TPW Ratings plugin
 *
 * @author Weblab.nl - Maarten Kooiker
 */
class TPWRatings_Helpers {

    /**
     * Helper function to query the remote API service using CURL library
     *
     * @param  $url              $url to fetch data from
     * @return mixed             false upon failure or the widget information upon success
     */
    public static function curlGet ($url) {

        // create SSL enabled CURL  object and get the URL
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, TPWRatings_Config::CURL_TIMEOUT);

        // fetch the data from the api and close the connection
        $result = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);

        // if CURL Fails return false
        if (!$result){
            return null;
        }

        // if API replies with code different than 200 success return false
        if ($info['http_code']!='200'){
            return null;
        }

        //everything went fine - return result
        return $result;
    }

}
