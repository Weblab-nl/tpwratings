<?php


/**
 * Class TPWRatings_Cache - handles the TPW Ratings Plugin caching
 * @author Weblab.nl - Traian Zainescu
 */
class TPWRatings_Cache {

    /**
     * Check if we have cached data and if it did not expired
     *
     * @return array|bool|mixed
     */
    public function readFromCache() {

        //if cache file does not exists return false
        if (!file_exists(TPWRatings_Config::CACHE_PATH)){
            return false;
        }

        //if cache expired return false
        if (time()-filemtime(TPWRatings_Config::CACHE_PATH)>TPWRatings_Config::CACHING_TIME){
            return false;
        }

        //return cache data
        return json_decode(file_get_contents(TPWRatings_Config::CACHE_PATH));
    }

    /**
     * Helper function to write the reviews data into cache
     *
     * @param $reviewsData          JSON Representation of the reviews data
     */
    public function writeCache ($reviewsData) {
        $fCache = fopen (TPWRatings_Config::CACHE_PATH,'w');
        fputs ($fCache,$reviewsData);
        fclose ($fCache);
    }
}