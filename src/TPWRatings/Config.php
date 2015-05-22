<?php

/**
 * Class TPWRatings_Config - stores the config settings for TPW Ratings plugin
 *
 * @author Weblab.nl  - Traian Zainescu
 */
class TPWRatings_Config {

    const CACHE_PATH = 'ratings.cache';                             //path to store the cache
    const CACHING_TIME = 3600;                                      //caching time in seconds
    const CURL_TIMEOUT = 3;                                         //timeout for the remote curl request
}