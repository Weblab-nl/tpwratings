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
     * @param   string              JSON Representation of the reviews data
     * @param   boolean             Whether it was possible to write to the cache file
     */
    public function writeCache ($reviewsData) {
        // open the cache file if possible
        $fCache = fopen(TPWRatings_Config::CACHE_PATH, 'w');

        // if it was not possible to open the cache file, return out
        if ($fCache === false) {
            return false;
        }

        // write the widget information to the cache and close the cache file again
        fputs ($fCache,$reviewsData);
        return fclose ($fCache);
    }
}
