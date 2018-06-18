<?php
return array(
    'grabber' => array(
        '%.*%' => array(
            'test_url' => 'https://edition.cnn.com/travel/article/longest-flight-seats/index.html',
            'body' => array(
                '//div[@class="Article__pageTop"]',
                '//div[@class="Article__wrapper"]',
            ),
            'strip' => array(
                '//div[@class="cnn_stryshrwdgtbtm"]',
                '//div[@class="cnn_strybtmcntnt"]',
                '//div[@class="cnn_strylftcntnt"]',
                '//div[contains(@class, "cnnGalleryContainer")]',
                '//div[contains(@class, "cnn_strylftcexpbx")]',
                '//div[contains(@class, "articleGalleryNavContainer")]',
                '//div[contains(@class, "cnnArticleGalleryCaptionControl")]',
                '//div[contains(@class, "cnnArticleGalleryNavPrevNextDisabled")]',
                '//div[contains(@class, "cnnArticleGalleryNavPrevNext")]',
                '//div[contains(@class, "cnn_html_media_title_new")]',
                '//div[contains(@id, "disqus")]',
            )
        ),
    ),
);
