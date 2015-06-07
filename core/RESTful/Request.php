<?php
namespace RESTful;
use PHPRocks\Util\JSON;
use RESTful\Exception\Request\CanNotLocateRemoteIP;
use RESTful\Exception\Request\ParsingJSON;
use PHPRocks\Util\OptionableArray;

/**
 * RESTful - Standalone RESTful server library
 * @author: Daniel Aranda (https://github.com/daniel-aranda/)
 *
 */

final class Request {

    const APPLICATION_JSON = 'application/json';
    const FORM_DATA = 'multipart/form-data';
    const FORM_URLENCODED = 'application/x-www-form-urlencoded';

    /**
     * @var string
     */
    private $path;

    /**
     * @var OptionableArray
     */
    private $server;

    /**
     * @var OptionableArray
     */
    private $post;

    /**
     * @var OptionableArray
     */
    private $get;

    /**
     * @var string
     */
    private $php_input;

    /**
     * @var string
     */
    private $request_method;

    /**
     * @var string
     */
    private $request_url;

    /**
     * @var string
     */
    private $service;

    /**
     * @var string
     */
    private $group;

    /**
     * @var string
     */
    private $method;

    /**
     * @var array
     */
    private $arguments;

    /**
     * @var array
     */
    private $groups;

    /**
     * @var boolean
     */
    private $allowed = true;

    public static function factory(
        $path,
        array $groups = null
    ){
        $request = new Request(
            $path,
            new OptionableArray($_SERVER),
            new OptionableArray($_POST),
            new OptionableArray($_GET),
            file_get_contents("php://input"),
            $groups
        );

        return $request;
    }

    public static function getRemoteIP(array $server = null) {

        if( is_null($server) ){
            $server = $_SERVER;
        }

        $server = new OptionableArray($server);

        if( $server->get('HTTP_CLIENT_IP') ){
            $ip = $server->get('HTTP_CLIENT_IP');
        } elseif ( $server->get('HTTP_X_FORWARDED_FOR') ){
            $ip = $server->get('HTTP_X_FORWARDED_FOR');
        } else {
            $ip = $server->get('REMOTE_ADDR');
        }

        if( is_null($ip) ){
            throw new CanNotLocateRemoteIP();
        }

        return $ip;

    }

    public function __construct(
        $path,
        OptionableArray $server,
        OptionableArray $post,
        OptionableArray $get,
        $php_input,
        array $groups = null
    ){
        $this->path = $path;
        $this->server = $server;
        $this->post = $post;
        $this->get = $get;
        $this->php_input = $php_input;
        $this->groups = $groups;

        $this->invalidate();
    }

    private function invalidate(
    ){

        $path = trim($this->path, '/');

        $arguments = explode('/', $path);
        $group = null;

        if( count($this->groups) > 0 && in_array($arguments[0], $this->groups) ){
            $group = array_shift($arguments);
        }

        $service = array_shift($arguments);

        $method = 'index';

        if( count($arguments) > 0 ){
            if( is_numeric($arguments[0]) ){
                $arguments[0] = (int) $arguments[0];
            }else{
                $method = array_shift($arguments);
            }
        }

        $request_method = $this->server->get('REQUEST_METHOD');
        $this->request_url = $this->path;
        $this->request_method = is_null($request_method) ? 'get' : strtolower($request_method);
        $this->service = $service;
        $this->group = $group;
        $this->method = $method;
        $this->arguments = $arguments;

    }

    public function getData(){
        $raw_data = $this->php_input;

        $data = [];

        if( $this->server->get('HTTP_CONTENT_TYPE') === self::APPLICATION_JSON && !empty($raw_data) ){

            $data = JSON::decode($raw_data, true);

        }else if( $this->server->get('REQUEST_METHOD') === 'POST' ){
            $data = $this->post->source();
        }

        return $data;
    }

    /**
     * @return string
     */
    public function getRequestMethod(){
        return $this->request_method;
    }

    /**
     * @return string
     */
    public function getService(){
        return $this->service;
    }

    /**
     * @return string
     */
    public function getMethod(){
        return $this->method;
    }

    /**
     * @return array
     */
    public function getArguments(){
        return $this->arguments;
    }

    /**
     * @return string
     */
    public function getPath() {
        return $this->path;
    }

    /**
     * @return OptionableArray
     */
    public function getServer() {
        return $this->server;
    }

    /**
     * @return OptionableArray
     */
    public function getPost() {
        return $this->post;
    }

    /**
     * @return OptionableArray
     */
    public function getGet() {
        return $this->get;
    }

    /**
     * @return string
     */
    public function getPhpInput() {
        return $this->php_input;
    }

    /**
     * @return string
     */
    public function getRequestUrl() {
        return $this->request_url;
    }

    /**
     * @return string
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @return array
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * @return boolean
     */
    public function isAllowed()
    {
        return $this->allowed;
    }

    /**
     * @param boolean $allowed
     */
    public function setAllowed($allowed)
    {
        $this->allowed = $allowed;
    }

}