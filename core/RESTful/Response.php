<?php
namespace RESTful;
use PHPRocks\EventHandler;
use RESTful\Exception\Response\CanNotSwapResponseType;
use RESTful\Exception\Response\InvalidResponseType;

/**
 * RESTful - Standalone RESTful server library
 * @author: Daniel Aranda (https://github.com/daniel-aranda/)
 *
 */
final class Response {

    use EventHandler;

    const JSON = 'application/json';
    const TEXT = 'text/plain';
    const HTML = 'text/html';

    public static $types = [
        self::JSON,
        self::HTML,
        self::TEXT
    ];

    private $response_type = self::JSON;

    private $header_set = false;

    private $response = null;

    const OUTPUT_EVENT = 'output_event';

    const HEADER_ADDED_EVENT = 'added_event';

    private function validateHeaders(){
        if( $this->header_set ) {
            return null;
        }
        $this->header_set = true;

        $this->validateOutputHeaders();
    }

    private function validateOutputHeaders(){
        $header = 'Content-Type: ';

        $header .= $this->response_type;
        $this->addHeader($header);
    }

    public function addHeader($header){
        $this->trigger(self::HEADER_ADDED_EVENT, [$this, $header]);
    }

    public function setResponse($response){
        $this->response = $response;
    }

    public function getResponse(){
        return $this->response;
    }

    public function render(){
        $this->validateHeaders();

        if( $this->isJSON() ){
            $this->response = json_encode($this->response);
        }

        $this->trigger(self::OUTPUT_EVENT, [$this]);

    }

    public function isJSON(){
        return $this->response_type === self::JSON;
    }

    public function isText(){
        return $this->response_type === self::TEXT;
    }

    public function isHtml(){
        return $this->response_type === self::HTML;
    }

    public static function isValidResponseType($response_type){
        return in_array($response_type, static::$types);
    }

    /**
     * @return string
     */
    public function getResponseType() {
        return $this->response_type;
    }

    /**
     * @param string $response_type
     */
    public function setResponseType($response_type) {
        if( $this->header_set ){
            throw new CanNotSwapResponseType();
        }
        if( !static::isValidResponseType($response_type) ){
            throw new InvalidResponseType($response_type);
        }
        $this->response_type = $response_type;
    }



}