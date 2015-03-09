<?php
namespace RESTful;
use RESTful\Exception\Response\CanNotSwapResponseType;
use RESTful\Exception\Response\InvalidResponseType;

/**
 * RESTful - Standalone RESTful server library
 * @author: Daniel Aranda (https://github.com/daniel-aranda/)
 *
 */
final class Response {

    const JSON = 'json';
    const TEXT = 'text';
    const HTML = 'html';

    public static $types = [
        self::JSON,
        self::HTML,
        self::TEXT
    ];

    private $response_type = self::JSON;

    private $header_set = false;

    private $response = null;

    public $outputHandler = null;

    public $addHeaderHandler = null;

    private function validateHeaders(){
        if( $this->header_set ) {
            return null;
        }
        $this->header_set = true;

        $this->validateOutputHeaders();
    }

    private function validateOutputHeaders(){
        $header = 'Content-Type: ';

        switch ($this->response_type) {
            case self::JSON:
                $header .= 'application/json';
                break;
            case self::TEXT:
                $header .= 'text/plain';
                break;
            case self::HTML:
                $header .= 'text/html';
                break;
        }
        $this->addHeader($header);
    }

    public function addHeader($header){
        if( is_callable($this->addHeaderHandler) ){
            $this->addHeaderHandler->__invoke($this, $header);
        }
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

        if( is_callable($this->outputHandler) ){
            $this->outputHandler->__invoke($this);
        }

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