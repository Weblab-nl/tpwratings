<?php

/**
 * Class TPWRatings_Ratings fetches the ratings from API and calls the template to display the widget
 *
 * @author Weblab.nl - Zainescu Traian
 */
class TPWRatings_Ratings {

    /**
     * The company widget identifier
     *
     * @var string              The company id
     */
    private $companyId;

    /**
     * The cache manager
     *
     * @var TPWRatings_Cache
     */
    private $cacheManager;

    /**
     * The type of widget to load (dark or light)
     *
     * @var string
     */
    private $variant = 'light';

    /**
     * The allowed widget variants
     *
     * @var array
     */
    private $variants = array('light', 'dark');

    /**
     * Constructor - init the cache manager and reads the companyId from App Config
     */
    public function __construct ($companyKey, $variants = 'light') {
        $this->cacheManager = new TPWRatings_Cache();
        $this->companyId = $companyKey;
        $this->setVariant($variants);
    }

    /**
     * Set the variant
     *
     * @param   string                      The variant to set
     * @return  TPWRatings_Rating           The instance of this, to make chaining possible
     */
    public function setVariant($variant) {
        // return out, if the set type is not an allowed type
        if (!in_array($this->variant, $this->variants)) {
            return $this;
        }

        // set the new variant
        $this->variant = $variant;

        // return the instance of this, to make chaining possible
        return $this;
    }

    /**
     * Query the TPW API service in order to get the ratings data
     *
     * @return array|null|mixed
     */
    private function getCompanyRatings() {
        //try returning data from cache
        $cachedData = $this->cacheManager->readFromCache();
        if ($cachedData){
            return $cachedData;
        }

        //read data from API
        $apiUrl = "https://api.theperfectwedding.nl/companies/widget/$this->companyId?type=$this->variant";

        $apiResponse = TPWRatings_Helpers::curlGet($apiUrl);

        // if there is no response, return null
        if (!$apiResponse){
            return null;
        }

        //try to decode API response
        $decodedApiResponse = json_decode ($apiResponse);

        //if we can not decode the API response return null
        if (!$decodedApiResponse){
            return null;
        }

        //write fetched data to cache
        $this->cacheManager->writeCache($apiResponse);

        // done, return the response
        return $decodedApiResponse;
    }

    /**
     * Call the method to retrieve
     *
     * @return stdClass|null
     */
    public function retrieveRatings (){
        //fetch company ratings
        $ratingsData = $this->getCompanyRatings();
        
        //if failed fetching company ratings return false
        if (!$ratingsData){
            return null;
        }

        //extract the average rating and the ratingsCount
        $response= new stdClass();
        $response->averageRating = $ratingsData->companies_widget[0]->average_rating;
        $response->ratingsCount = $ratingsData->companies_widget[0]->rating_count;
        $response->companyName = $ratingsData->companies_widget[0]->name;
        $response->widget_code = $ratingsData->companies_widget[0]->widget_code;
        $response->profile_url = $ratingsData->companies_widget[0]->profile_url;

        // done, return the response
        return $response;
    }

}