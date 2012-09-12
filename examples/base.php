<?php

function hr() {
    echo '<hr />';
}

/**
 * Echoes a pre tag with a message
 * @param string $message
 * @param string $class
 */
function pre($message, $class='') {
    echo "<pre class='$class'>$message</pre>";
}

/**
 * @param string $error
 */
function error($error) {
    include('includes/error.php');
    exit();
}

/**
 * Clase base para ejemplos
 */
class BaseExample {

    /**
     * @var SmsApi
     */
    var $api;

    /**
     * @var string
     */
    var $title;

    /**
     * @param $api_key
     * @param $api_secret_key
     * @param $api_url
     */
    public function __construct($api_key, $api_secret_key, $api_url) {
        if (empty($api_key) || empty($api_secret_key) || empty($api_url)) {
            error('Por favor configure el API_KEY, API_SECRET_KEY y API_URL');
        }
        $this->api = new SmsApi($api_key, $api_secret_key, $api_url);
        $title = $this->title;
        include('includes/header.php');
        $this->run();
        include('includes/footer.php');
    }

    protected function run() {}

}