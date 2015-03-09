<?php
namespace RESTful;

/**
 * RESTful - Standalone RESTful server library
 * @author: Daniel Aranda (https://github.com/daniel-aranda/)
 *
 */

final class Configuration{

    /**
     * @var array
     */
    private $data;

    /**
     * @var \RESTful\Environment
     */
    private $environment;

    /**
     * @return self
     */
    public static function factory(
        $path = null,
        Environment $environment = null
    ){

        if( is_null($path) ){
            $path = RESTful_PATH . 'restful_configuration.json';
        }

        if( is_null($environment) ){
            $environment = Environment::factory();
        }

        $file_content = file_get_contents($path);

        $data = new Configuration(
            json_decode($file_content, true),
            $environment
        );

        return $data;
    }

    public function __construct(
        array $data,
        Environment $environment
    ){
        $this->data = $data;
        $this->environment = $environment;
    }

    public function environment(){
        $environment = $this->findEnvironment($this->environment->domain());
        return $environment;
    }

    private function findEnvironment($domain){

        if( empty($this->data['environments']) ){
            throw new RESTful_Exception_Config_ValueNotSet('environments');
        }

        foreach($this->data['environments'] as $environment => $environments){

            if( in_array($domain, $environments) ){

                if( !Environment::isValid($environment) ){
                    throw new RESTful_Exception_Config_InvalidEnvironment($environment);
                }

                return $environment;
            }

        }

        throw new RESTful_Exception_Config_EnvironmentNotFound($domain);

    }

    public function get($key){

        $keys = explode('.', $key);
        $child = $this->data;

        foreach($keys as $current_key){
            if( !isset($child[$current_key]) ){
                throw new RESTful_Exception_Config_ValueNotSet($key);
            }
            $child = $child[$current_key];
        }

        return $child;

    }

    public function set($key, $value){
        $keys = explode('.', $key);
        $child = &$this->data;

        foreach($keys as $index => $current_key){
            if( $index === count($keys) - 1 ){
                $child[$current_key] = $value;
            }else{
                if( !isset($child[$current_key]) ){
                    $child[$current_key] = [];
                }
                $child = &$child[$current_key];
            }
        }

        return true;
    }

    public function get_per_environment($key, $environment = null){

        if( is_null($environment) ){
            $environment = $this->environment();
        }

        try{
            $value = $this->get($key . '.' . $environment);
        }catch(RESTful_Exception_Config_ValueNotSet $e){
            $value = $this->get($key . '.default');
        }

        return $value;
    }

}