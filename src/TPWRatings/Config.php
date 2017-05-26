<?php

/**
 * Class TPWRatings_Config - stores the config settings for TPW Ratings plugin
 *
 * @author Weblab.nl  - Maarten Kooiker
 */
class TPWRatings_Config {

    /**
     * The cache path
     */
    const CACHE_PATH = 'ratings.cache';

    /**
     * The time before we want to refresh the cache
     */
    const CACHING_TIME = 3600;

    /**
     * The time before we want to refresh the cache
     */
    const API_URL = 'https://weblapi.theperfectwedding.nl/companies/widget/%s?variant=%s';

    /**
     * The number of times we want to try to obtain the data before timing out
     */
    const CURL_TIMEOUT = 3;
}
