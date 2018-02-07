<?php
class AmpUrl
{
    private $API_URL = 'https://acceleratedmobilepageurl.googleapis.com/v1/ampUrls:batchGet';
    private $API_HEADERS = [];
    private $REQUEST_MAX_COUNT = 50;

    function __construct($api_key)
    {
        $this->setApiKey($api_key);
    }

    public function setApiKey($api_key)
    {
        $this->API_HEADERS = [
            'Content-Type: application/json',
            'X-Goog-Api-Key: ' . $api_key
        ];
    }

    public function toCdnAmpUrl($url)
    {
        $response = $this->get($url);

        if (property_exists($response, 'ampUrls')) {
            return [
                'status' => true,
                'url' => $response->ampUrls[0]->cdnAmpUrl
            ];
        }

        return [
            'status' => false,
            'message' => $response->urlErrors[0]->errorMessage
        ];
    }

    public function get($urls)
    {
        if (!is_array($urls)) {
            $urls = [$urls];
        }

        $urls_group = array_chunk($urls, $this->REQUEST_MAX_COUNT);
        $response = new stdClass();

        foreach ($urls_group as $self_urls) {
            $self_response = $this->_request(
                $this->API_URL,
                $this->API_HEADERS,
                [
                    'urls' => $self_urls
                ]
            );

            foreach ($self_response as $key => $value) {
                if (!property_exists($response, $key)) {
                    $response->$key = [];
                }

                $response->$key = array_merge($response->$key, $value);
            }
        }

        return $response;
    }

    private function _request($url = '', $headers = [], $body = [])
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($body),
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false
        ]);

        $response = curl_exec($curl);

        curl_close($curl);

        return json_decode($response);
    }
}
?>