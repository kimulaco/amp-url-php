# amp-url-php

Accelerated Mobile Pages (AMP) URL API PHP library.  
It is necessary to enable API on [Google Cloud Platform](https://cloud.google.com/) and obtain API key.

## Use

```php
$amp_url = new AmpUrl(GOOGLE_API_KEY);

$cdn_amp_url = $amp_url->toCdnAmpUrl('https://example.com/01.html');

// 'https://example-com.cdn.ampproject.org/c/s/example.com/amp/01.html'
```

## Method

### toCdnAmpUrl($url)

- $url `string` - Target URL.

```php
$amp_url = new AmpUrl(GOOGLE_API_KEY);

$cdnAmpUrl = $amp_url->toCdnAmpUrl('https://example.com/01.html');

// 'https://example-com.cdn.ampproject.org/c/s/example.com/amp/01.html'
```

### get($urls)

- $urls `array|string` - Target URL.

```php
$amp_url = new AmpUrl(GOOGLE_API_KEY);

$result = $amp_url->get([
    'https://example.com/01.html',
    'https://example.com/02.html',
    'https://example.com/03.html'
]);

/*
$result

object(stdClass)#2 (2) {
  ["ampUrls"]=>
  array(1) {
    [0]=>
    object(stdClass)#3 (3) {
      ["originalUrl"]=>
      string "https://example.com/01.html"
      ["ampUrl"]=>
      string "https://example.com/amp/01.html"
      ["cdnAmpUrl"]=>
      string "https://example-com.cdn.ampproject.org/c/s/example.com/amp/01.html"
    }
  }
  ["urlErrors"]=>
  array(2) {
    [0]=>
    object(stdClass)#5 (3) {
      ["errorCode"]=>
      string(10) "NO_AMP_URL"
      ["errorMessage"]=>
      string(31) "No AMP URL for the request URL."
      ["originalUrl"]=>
      string "https://example.com/02.html"
    }
    [1]=>
    object(stdClass)#6 (3) {
      ["errorCode"]=>
      string(10) "NO_AMP_URL"
      ["errorMessage"]=>
      string(31) "No AMP URL for the request URL."
      ["originalUrl"]=>
      string "https://example.com/03.html"
    }
  }
}
*/
```

## License

[MIT License.](https://github.com/kmrk/amp-url-php/blob/master/LICENSE)
