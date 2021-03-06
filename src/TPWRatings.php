<?php

//include library files
require_once 'TPWRatings/Config.php';
require_once 'TPWRatings/Ratings.php';
require_once 'TPWRatings/Helpers.php';
require_once 'TPWRatings/Cache.php';

/**
 * Class representation of the TPW rating widget
 *
 * @author Weblab.nl - Maarten Kooiker
 */
class TPWRatings {

    /**
     * The TPW rating widget template
     *
     * @var string
     */
    private $template;

    /**
     * The TPW rating widget snippet template
     *
     * @var string
     */
    private $snippetTemplate;

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
    public function __construct($key, $type = 'light'){
        //read template
        $this->template = file_get_contents(dirname(__FILE__) . '/defaultTemplate.tpl');

        // read the snippet template
        $this->snippetTemplate = file_get_contents(dirname(__FILE__) . '/snippetTemplate.tpl');

        //load ratings
        $tpwRatings = new TPWRatings_Ratings($key, $type);

        // set the ratings data
        $this->ratingData = $tpwRatings->getCompanyRatings();
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
        if (is_null($this->ratingData)) {
            return '';
        }

        // load the widget code into the template
        $widget = str_replace("{#WIDGET_CODE#}", $this->ratingData->widget_code, $this->template);


        // add the rich snippet code to the widget
        $widget = str_replace("{#RICH_SNIPPET#}", $this->ratingData->rich_snippet_code, $widget);

        // if there are no ratings, just return the base widget
        if ($this->ratingData->rating_count < 1) {
            $widget = str_replace("{#INFORMATION#}", '', $widget);

            // done, return
            return $widget;
        }

        // replace the placeholders with the values
        $snippet = str_replace("{#AVERAGE_RATING#}", $this->ratingData->average_rating, $this->snippetTemplate);
        $snippet = str_replace("{#RATE_COUNT#}", $this->ratingData->rating_count, $snippet);
        $snippet = str_replace("{#COMPANY_NAME#}", $this->ratingData->name, $snippet);

        // add the snippet to the widget
        $widget = str_replace("{#INFORMATION#}", $snippet, $widget);

        // done, return the string representation of the TPW widget
        return $widget;
    }

}
