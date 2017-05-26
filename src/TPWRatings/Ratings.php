<?php

/**
 * Class TPWRatings_Ratings fetches the ratings from API and calls the template to display the widget
 *
 * @author Weblab.nl - Maarten Kooiker
 */
class TPWRatings_Ratings {

    /**
     * The company widget identifier hash string
     *
     * @var string              The company id hash string
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
    public function __construct($companyKey, $variants = 'light') {
        // set the class that handles the caching
        $this->cacheManager = new TPWRatings_Cache();

        // set the companyId STRING
        $this->companyId = $companyKey;

        // set the variant requested (light if not given)
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
    public function getCompanyRatings() {
        // get the data from the cache if exists
        $cachedData = $this->cacheManager->readFromCache();
        
        // if cached data was returned, return this data, we're done here
        if ($cachedData){
            return $cachedData;
        }

        // set the url to obtain the rating information from the weblapi
        $apiUrl = sprintf(TPWRatings_Config::API_URL, $this->companyId, $this->variant);

        // get the widget data from TPW
        $apiResponse = TPWRatings_Helpers::curlGet($apiUrl);

        // write fetched data to cache
        $this->cacheManager->writeCache($apiResponse);

        // done, return the response
        return $this->decodedApiResponse($apiResponse);
    }

    /**
     * Function to decode the apiResponse
     *
     * @param  json                 json encoded api response
     * @return                      json decoded api response | null
     */
    private function decodedApiResponse($apiResponse) {
        // if there is no response, return null
        if (is_null($apiResponse)) {
            return null;
        }

        // try to decode API response
        $decodedApiResponse = json_decode($apiResponse);

        // if we can not decode the API response return null
        if (!$decodedApiResponse){
            return null;
        }

        // done, return the decoded response
        return $decodedApiResponse;
    }

}
