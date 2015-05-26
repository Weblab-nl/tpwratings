ThePerfectWedding.nl Rating widget
==================================

With this library you’re able to share the reviews you gathered at http://www.theperfectwedding.nl for your company on your own website - The widget contains the right mark-up to display “review stars” in the Google search result.

To be able to display the widget on your website, you need an access key. Send an e-mail to development@theperfectwedding.nl to apply for an access key. This unique key is only shared with a company profile owner on ThePerfectWedding.nl.

Installation
------------

### Install using composer:

    composer require weblabnl/tpwratings

### Install manually:

Download the latest release from: https://github.com/Weblab-nl/tpwratings/archive/master.zip and unzip the library into your project.

Using the Library
-----------------

    <?php
    require_once 'tpwratings/src/TPWRatings.php'; //Not required with Composer
    echo new TPWRatings('WIDGET_KEY', 'light');
    ?>

There is a 'dark' and 'light' version available of the widget.