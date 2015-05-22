<?php

//include library files
require_once 'TPWRatings/Config.php';
require_once 'TPWRatings/Ratings.php';
require_once 'TPWRatings/Helpers.php';
require_once 'TPWRatings/Cache.php';

/**
 * Class representation of the TPW rating widget
 *
 * @author Weblab.nl - Zainescu Traian
 */
class TPWRatings {

    /**
     * The TPW rating widget template
     *
     * @var string
     */
    private $template;

    /**
     * The rating data from the api
     *
     * @var \stdClass|null
     */
    private $ratingData;

    /**
     * Constructor loads the ratings and the default template
     *
     * @param string                    The TPW widget key
     * @param string                    The variant of the widget (light or dark)
     */
    public function __construct ($key, $type = 'light'){
        //read template
        $this->template = file_get_contents(dirname(__FILE__).'/defaultTemplate.tpl');

        //load ratings
        $tpwRatings = new TPWRatings_Ratings($key, $type);

        // set the ratings data
        $this->ratingsData = $tpwRatings->retrieveRatings();
    }


    /**
     * Method to override the default template
     *
     * @param string     String containing template data
     */
    public function setTemplate($template){
        $this->template = $template;
    }

    /**
     * To string magic method renders the ratings
     *
     * @return  string                      The string representation of the TPWRating widget
     */
    public function __toString() {
        // return an empty string, if there is no rating data
        if (is_null($this->ratingData) || (!is_null($this->ratingData) && $this->ratingData->ratingCount < 1)) {
            return '';
        }

        //replace the placeholders with the values
        $widget = str_replace ("{#AVERAGE_RATING#}",$this->ratingData->averageRating, $this->template);
        $widget = str_replace ("{#RATE_COUNT#}",$this->ratingData->ratingCount,$widget);
        $widget = str_replace ("{#COMPANY_NAME#}",$this->ratingData->companyName,$widget);
        $widget = str_replace ("{#WIDGET_CODE#}",$this->ratingData->widget_code,$widget);

        // done, return the string representation of the TPW widget
        return $widget;
    }

}




?>