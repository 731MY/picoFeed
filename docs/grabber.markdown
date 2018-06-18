Web scraper
===========

The web scraper is useful for feeds that display only a summary of articles, the scraper can download and parse the full content from the original website.

How the content grabber works?
------------------------------

1. Try with rules first (XPath queries) for the domain name (see `PicoFeed\Rules\`)
2. Try to find the text content by using common attributes for class and id
3. Finally, if nothing is found, the feed content is displayed

**The best results are obtained with XPath rules file.**

Standalone usage
----------------

Fetch remote content:

```php
<?php

use PicoFeed\Config\Config;
use PicoFeed\Scraper\Scraper;

$config = new Config;

$grabber = new Scraper($config);
$grabber->setUrl($url);
$grabber->execute();

// Get raw HTML content
echo $grabber->getRawContent();

// Get relevant content
echo $grabber->getRelevantContent();

// Get filtered relevant content
echo $grabber->getFilteredContent();

// Return true if there is relevant content
var_dump($grabber->hasRelevantContent());
```

Parse HTML content:

```php
<?php

$grabber = new Scraper($config);
$grabber->setRawContent($html);
$grabber->execute();
```

Fetch full item contents during feed parsing
--------------------------------------------

Before parsing all items, just call the method `$parser->enableContentGrabber()`:

```php
<?php

use PicoFeed\Reader\Reader;
use PicoFeed\PicoFeedException;

try {

    $reader = new Reader;

    // Return a resource
    $resource = $reader->download('http://www.egscomics.com/rss.php');

    // Return the right parser instance according to the feed format
    $parser = $reader->getParser(
        $resource->getUrl(),
        $resource->getContent(),
        $resource->getEncoding()
    );

    // Enable content grabber before parsing items
    $parser->enableContentGrabber();

    // Return a Feed object
    $feed = $parser->execute();
}
catch (PicoFeedException $e) {
    // Do Something...
}
```

When the content scraper is enabled, everything will be slower.
**For each item a new HTTP request is made** and the HTML downloaded is parsed with XML/XPath.

Configuration
-------------

### Enable content grabber for items

- Method name: `enableContentGrabber()`
- Default value: false (also fetch content if no rule file exist)
- Argument value: bool (true scrape only webpages which have a rule file)

```php
$parser->enableContentGrabber(false);
```

### Ignore item urls for the content grabber

- Method name: `setGrabberIgnoreUrls()`
- Default value: empty (fetch all item urls)
- Argument value: array (list of item urls to ignore)

```php
$parser->setGrabberIgnoreUrls(['http://foo', 'http://bar']);
```

### Set maximum of recursions (pages) for multi page articles
- Method name: `setMaxRecursions();`
- Default value: 25
- Argument value: integer

How to write a grabber rules file?
----------------------------------

Add a PHP file to the directory `PicoFeed\Rules`, the filename must be the same as the domain name:

Example with the CNN website, `edition.cnn.com.php`:

```php
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
            ),
            'callback'=>function($html){
                return preg_replace_callback(
                    '/https:\/\/dynaimage.cdn.cnn.com\/(.*?)\/(.*?)\/([-a-zA-Z0-9@:%_\+.~#?&\/\/=]*)/i',
                    function($match) {
                        return urldecode($match[3]);
                    },
                    $html);
            }
        ),
    ),
);
```
Each rule file can contain multiple rules, based so links to different website URLs can be handled differently. The first level key is a regex, which will be matched against the full path of the URL using **preg_match**, e.g. for **https://edition.cnn.com/travel/article/longest-flight-seats/index.html** the URL that would be matched is **/travel/article/longest-flight-seats/index.html**

Each rule has the following keys:
* **body**: An array of xpath expressions which will be extracted from the page
* **strip**: An array of xpath expressions which will be removed from the matched content
* **test_url**: A test url to a matching page to test the grabber
* **callback**: A function to manipulate the filtered html content

Don't forget to send a pull request or a ticket to share your contribution with everybody,

**A more complex example**:

Let's say you wanted to extract a div with the id **video** if the article points to an URL like **http://comix.com/videos/423**, **audio** if the article points to an URL like **http://comix.com/podcasts/5** and all other links to the page should instead take the div with the id **content**. The following rulefile would fit that requirement and would be stored in a file called **lib/PicoFeed/Rules/comix.com.php**:


```php
return array(
    'grabber' => array(
        '%^/videos.*%' => array(
            'test_url' => 'http://comix.com/videos/423',
            'body' => array(
                '//div[@id="video"]',
            ),
            'strip' => array()
        ),
        '%^/podcasts.*%' => array(
            'test_url' => 'http://comix.com/podcasts/5',
            'body' => array(
                '//div[@id="audio"]',
            ),
            'strip' => array()
        ),
        '%.*%' => array(
            'test_url' => 'http://comix.com/blog/1',
            'body' => array(
                '//div[@id="content"]',
            ),
            'strip' => array()
        )
    )
);
```

List of content grabber rules
-----------------------------

Rules are stored inside the directory [lib/PicoFeed/Rules](https://github.com/miniflux/picoFeed/tree/master/lib/PicoFeed/Rules)
