<?php

//include library files
require_once 'TPWRatings/Config.php';
require_once 'TPWRatings/Ratings.php';
require_once 'TPWRatings/Helpers.php';
require_once 'TPWRatings/Cache.php';



class TPWRatings {

    private $valid = false;
    private $averageRating;
    private $ratingCount;
    private $template;


    /**
     * Constructor loads the ratings and the default template
     * @param $key
     */
    public function __construct ($key){

        //read template
        $this->template = file_get_contents(dirname(__FILE__).'/defaultTemplate.tpl');

        //load ratings
        $tpwRatings = new TPWRatings_Ratings($key);
        $ratingsData = $tpwRatings->retrieveRatings();

        if (!$ratingsData){
            return;
        }

        $this->averageRating = $ratingsData->averageRating;
        $this->ratingCount = $ratingsData->ratingsCount;
        $this->companyName = $ratingsData->companyName;
        $this->companyId = $ratingsData->companyId;
        $this->slug = $ratingsData->slug;
        $this->valid = true;
    }


    /**
     * Method to override the default template
     * @param $template     String containing template data
     */
    public function setTemplate($template){
        $this->template = $template;
    }

    /**
     * To string magic method renders the ratings
     */
    public function __toString() {

        //replace the placeholders with the values
        $widget = str_replace ("{#AVERAGE_RATING#}",$this->averageRating,$this->template);
        $widget = str_replace ("{#RATE_COUNT#}",$this->ratingCount,$widget);
        $widget = str_replace ("{#COMPANY_NAME#}",$this->companyName,$widget);
        $widget = str_replace ("{#COMPANY_ID#}",$this->companyId,$widget);
        $widget = str_replace ("{#COMPANY_SLUG#}",$this->slug,$widget);
        return $widget;
    }

}




?>