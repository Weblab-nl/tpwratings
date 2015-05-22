<div class="widget_tpw_rating_wrap" itemscope itemtype="http://schema.org/LocalBusiness">
    {#WIDGET_CODE#}
    <?php if ($ratingsCount > 0) { ?>
    <p>
        <small>
            <span itemprop="name">{#COMPANY_NAME#}</span>
                <span itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
                    <meta itemprop="sameAs" content="{#PROFILE_URL#}" />
                    <meta itemprop="worstRating" content="1">
                    <meta itemprop="bestRating" content="10">
                    <span itemprop="ratingValue">{#AVERAGE_RATING#}</span>
                    uit
                    <span itemprop="ratingCount">{#RATE_COUNT#}</span>
                    ervaringen
                </span>
        </small>
    </p>
    <?php } ?>
</div>


<div class="widget_tpw_rating_wrap" itemscope="" itemtype="http://schema.org/LocalBusiness">
    <span itemprop="name" class="hide">{#COMPANY_NAME#}</span>
    <a itemprop="aggregateRating" itemscope="" itemtype="http://schema.org/AggregateRating" href="http://www.theperfectwedding.nl/bedrijven/{#COMPANY_ID#}/{#COMPANY_SLUG#}" class="widget_tpw_rating_inner" target="_blank">
        <span itemprop="sameAs" class="hide">http://www.theperfectwedding.nl/bedrijven/{#COMPANY_ID#}/{#COMPANY_SLUG#}</span>
        <p class="tpw_rating">
            <meta itemprop="worstRating" content="1">
			<span class="tpw_rating_number" itemprop="ratingValue">{#AVERAGE_RATING#}</span>
            <meta itemprop="bestRating" content="10">
			<span class="tpw_rating_info">
				<span class="tpw_rating_info_stars">{#STAR_SNIPPET#}</span>
				<span>uit <span itemprop="ratingCount">{#RATE_COUNT#}</span> ervaringen</span>
			</span>
        </p>
        <div class="tpw_info">
            <img src="tpwratingswidget/widget/../assets/tpw-logo.png" alt="ThePerfectWedding.nl">
        </div>
    </a>
</div>