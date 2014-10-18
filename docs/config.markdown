Configuration
=============

How to use the Config object
----------------------------

To change the default parameters, you have to use the Config class.
Create a new instance and pass it to the Reader object like that:

```php
use PicoFeed\Reader;
use PicoFeed\Config;

$config = new Config;
$config->setClientUserAgent('My custom RSS Reader')
       ->setProxyHostname('127.0.0.1')
       ->setProxyPort(8118);

$reader = new Reader($config);
...
```

HTTP Client parameters
----------------------

### Connection timeout

- Method name: `setClientTimeout()`
- Default value: 10 seconds
- Argument value: number of seconds (integer)

```php
$config->setClientTimeout(20); // 20 seconds
```

### User Agent

- Method name: `setClientUserAgent()`
- Default value: `PicoFeed (https://github.com/fguillot/picoFeed)`
- Argument value: string

```php
$config->setClientUserAgent('My RSS reader');
```

### Maximum HTTP redirections

- Method name: `setMaxRedirections()`
- Default value: 5
- Argument value: integer

```php
$config->setMaxRedirections(10);
```

### Maximum HTTP body response size

- Method name: `setMaxBodySize()`
- Default value: 2097152 (2MB)
- Argument value: value in bytes (integer)

```php
$config->setMaxBodySize(10485760); // 10MB
```

### Proxy hostname

- Method name: `setProxyHostname()`
- Default value: empty
- Argument value: string

```php
$config->setProxyHostname('proxy.example.org');
```

### Proxy port

- Method name: `setProxyPort()`
- Default value: 3128
- Argument value: port number (integer)

```php
$config->getProxyPort(8118);
```

### Proxy username

- Method name: `setProxyUsername()`
- Default value: empty
- Argument value: string

```php
$config->setProxyUsername('myuser');
```

### Proxy password

- Method name: `setProxyPassword()`
- Default value: empty
- Argument value: string

```php
$config->setProxyPassword('mysecret');
```

Content grabber
---------------

### Connection timeout

- Method name: `setGrabberTimeout()`
- Default value: 10 seconds
- Argument value: number of seconds (integer)

```php
$config->setGrabberTimeout(20); // 20 seconds
```

### User Agent

- Method name: `setGrabberUserAgent()`
- Default value: `PicoFeed (https://github.com/fguillot/picoFeed)`
- Argument value: string

```php
$config->setGrabberUserAgent('My content scraper');
```

Parser
------

### Hash algorithm used for item id generation

- Method name: `setParserHashAlgo()`
- Default value: `crc32b`
- Argument value: any value returned by the function `hash_algos()` (string)
- See: http://php.net/hash_algos

```php
$config->setParserHashAlgo('sha1');
```

### Set a custom filter

- Method name: `setContentFilteringCallback()`
- Default value: null
- Argument value: callable
- Note: if the callback return nothing, the default filtering is applied

```php
$config->setContentFilteringCallback(function($item_content, $item_url) {

    // Do something here...

    return $filtered_content;
});
```

### Timezone

- Method name: `setTimezone()`
- Default value: UTC
- Argument value: See https://php.net/manual/en/timezones.php (string)
- Note: define the timezone for items/feeds

```php
$config->setTimezone('Europe/Paris');
```

Logging
-------

### Timezone

- Method name: `setTimezone()`
- Default value: UTC
- Argument value: See https://php.net/manual/en/timezones.php (string)
- Note: define the timezone for the logging class

```php
$config->setTimezone('Europe/Paris');
```

Filter
------

### Set the iframe whitelist (allowed iframe sources)

- Method name: `setFilterIframeWhitelist()`
- Default value: See the Filter class source code
- Argument value: array

```php
$config->setFilterIframeWhitelist(['http://www.youtube.com', 'http://www.vimeo.com']);
```

### Define HTML integer attributes

- Method name: `setFilterIntegerAttributes()`
- Default value: See the Filter class source code
- Argument value: array

```php
$config->setFilterIntegerAttributes(['width', 'height']);
```

### Add HTML attributes automatically

- Method name: `setFilterAttributeOverrides()`
- Default value: See the Filter class source code
- Argument value: array

```php
$config->setFilterAttributeOverrides(['a' => ['target' => '_blank']);
```

### Set the list of required attributes for tags

- Method name: `setFilterRequiredAttributes()`
- Default value: See the Filter class source code
- Argument value: array
- Note: If the required attributes are not there, the tag is stripped

```php
$config->setFilterRequiredAttributes(['a' => 'href', 'img' => 'src']);
```

### Set the resource blacklist (Ads blocker)

- Method name: `setFilterMediaBlacklist()`
- Default value: See the Filter class source code
- Argument value: array
- Note: Tags are stripped if they have those URLs

```php
$config->setFilterMediaBlacklist(['feeds.feedburner.com', 'share.feedsportal.com']);
```

### Define which attributes are used for external resources

- Method name: `setFilterMediaAttributes()`
- Default value: See the Filter class source code
- Argument value: array

```php
$config->setFilterMediaAttributes(['src', 'href']);
```

### Define the scheme whitelist

- Method name: `setFilterSchemeWhitelist()`
- Default value: See the Filter class source code
- Argument value: array
- See: http://en.wikipedia.org/wiki/URI_scheme

```php
$config->setFilterSchemeWhitelist(['http://', 'ftp://']);
```

### Define the tags and attributes whitelist

- Method name: `setFilterWhitelistedTags()`
- Default value: See the Filter class source code
- Argument value: array
- Note: Only those tags are allowed everything else is stripped

```php
$config->setFilterWhitelistedTags(['a' => ['href'], 'img' => ['src', 'title']]);
```
