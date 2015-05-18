<?php

/**
 * Class TPWRatings_Ratings fetches the ratings from API and calls the template to display the widget
 * @author Weblab.nl - Zainescu Traian
 */

class TPWRatings_Ratings {

    /**
     * @int The company id
     */
    private $companyId;

    /**
     * @tpwCache The cache manager
     */
    private $cacheManager;


    /**
     * Constructor - init the cache manager and reads the companyId from App Config
     */
    public function __construct ($companyKey) {
        $this->cacheManager = new TPWRatings_Cache();
        $this->companyId = TPWRatings_Helpers::getCompanyIdFromKey($companyKey);
    }


    /**
     * Query the TPW API service in order to get the ratings data
     * @return array|bool|mixed
     */
    private function getCompanyRatings() {

        //try returning data from cache
        $cachedData = $this->cacheManager->readFromCache();
        if ($cachedData){
            return $cachedData;
        }

        //read data from API
        $apiUrl = "https://api.theperfectwedding.nl/companies/$this->companyId?fields=id,average_rating,rating_count,name,slug";
        $apiResponse = TPWRatings_Helpers::curlGet($apiUrl);

        if (!$apiResponse){
            return false;
        }

        //try to decode API response
        $decodedApiResponse = json_decode ($apiResponse);

        //if we can not decode the API response return false
        if (!$decodedApiResponse){
            return false;
        }

        //write fetched data to cache
        $this->cacheManager->writeCache($apiResponse);

        return $decodedApiResponse;
    }


    /**
     * Call the method to retrieve
     * @return bool
     */
    public function retrieveRatings (){

        //fetch company ratings
        $ratingsData = $this->getCompanyRatings();

        //if failed fetching company ratings return false
        if (!$ratingsData){
            return false;
        }

        //extract the average rating and the ratingsCount
        $response= new stdClass();
        $response->averageRating = $ratingsData->companies[0]->average_rating;
        $response->ratingsCount = $ratingsData->companies[0]->rating_count;
        $response->companyName = $ratingsData->companies[0]->name;
        $response->companyId = $ratingsData->companies[0]->id;
        $response->slug = $ratingsData->companies[0]->slug;

        return $response;


    }

}