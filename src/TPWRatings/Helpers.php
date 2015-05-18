<?php


/**
 * Class TPWRatings_Helpers - helper functions for the TPW Ratings plugin
 * @author Weblab.nl - Traian Zainescu
 *
 */
class TPWRatings_Helpers {

    /**
     * Helper function to query the remote API service using CURL library
     * @param $url              The url to fetch data from
     * @return mixed
     */
    public static function curlGet ($url) {

        //create SSL enabled CURL object and get the URL
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, TPWRatings_Config::CURL_TIMEOUT);
        $result = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);

        //if CURL Fails return false
        if (!$result){
            return false;
        }

        //if API replies with code different than 200 success return false
        if ($info['http_code']!='200'){
            return false;
        }

        //everything went fine - return result
        return $result;
    }

    /**
     * Calculate the company id by applying base64decode
     * and removing the characters that are not numbers from the result
     */
    public static function getCompanyIdFromKey($key) {


        //decode key using base64
        $decodedKey = base64_decode($key);

        //key contains the numeric company id obfuscated with random letters remove anything that is not a number
        $companyId = preg_replace('/[^0-9.]/','',$decodedKey);

        //return companyId
        return $companyId;
    }


    /**
     * Transform a rating into a visual star representation
     * @param $rating
     * @return string
     */
    public static function ratingToStarSnippet ($rating){
        $stars = round($rating/2);
        $snippet = "";
        for ($i=1;$i<=5;$i++){
            if ($i<=$stars){
                $snippet .= "★ ";
            } else {
                $snippet .= "☆ ";
            }
        }
        return $snippet;

    }




}