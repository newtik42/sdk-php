<?php

namespace NewTik\TempletSDKPHP\HttpClient;

interface ClientInterface {
    
    public function request($method, $url, $headers, $data);
}
