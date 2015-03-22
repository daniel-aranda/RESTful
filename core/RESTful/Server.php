<?php
namespace RESTful;
use PHPRocks\EventHandler;
use RESTful\Exception\Server\MethodNotSupported;
use RESTful\Exception\Server\ServiceNotFound;
use RESTful\Base\Service;
use PHPRocks\Util\String;

/**
 * RESTful - Standalone RESTful server library
 * @author: Daniel Aranda (https://github.com/daniel-aranda/)
 *
 */

final class Server{

    use EventHandler;

    const VERSION = '0.2.0';

    const BEFORE_EXECUTE_SERVICE = 'before_execute_service';
    const AFTER_EXECUTE_SERVICE = 'after_execute_service';
    const REQUEST_COMPLETE = 'request_complete';

    private $service_prefix;

    /**
     * @var \RESTful\Response
     */
    private $response;

    /**
     * @param string $service_prefix
     * @param Response $response
     */
    public function __construct(
        Response $response
    ) {

        $this->setServicePrefix('\RESTful\Service\\');

        $this->response = $response;
    }

    public function execute(Request $request){

        $this->trigger(self::BEFORE_EXECUTE_SERVICE, [$request]);

        $class_name = String::underscoreToCamelCase( $request->getService() );
        $group_name = $request->getGroup() ? String::underscoreToCamelCase( $request->getGroup() ). '\\' : '';
        $service_class = $this->getServicePrefix() . $group_name . $class_name;
        $this->validateClass( $service_class );

        $reflector = new \ReflectionClass($service_class);
        $service = $reflector->newInstanceArgs([
            $request->getData(),
            $this->response
        ]);

        $this->trigger(self::AFTER_EXECUTE_SERVICE, [$request]);

        $this->routeRequest($request, $service);
        $this->response->render();

        $this->trigger(self::REQUEST_COMPLETE, [$request]);
    }

    private function routeRequest(
        Request $request,
        Service $service
    ){

        $desired_method =  String::underscoreToCamelCase( $request->getMethod() );

        $requested_method = $request->getRequestMethod() . $desired_method;
        $method = $requested_method;
        $arguments = $request->getArguments();

        if ( !method_exists($service, $method) ){
            $method = $request->getRequestMethod() . 'Router';
            if( !method_exists($service, $method) ){
                throw new MethodNotSupported($request->getService(), $requested_method);
            }
            array_splice( $arguments, 0, 0, array($request->getMethod()) );
        }
        $output = call_user_func_array(array($service, $method), $arguments);

        $this->response->setResponse($output);
    }

    /**
     * Verify if class exists, other way throw an exception. Using @ to prevent php warning trying to include invalid file.
     *
     * We do not require to extend autoload because all the services classes should follow a defined format. Autoload could be
     * insecure as classes are loaded using the request url
     *
     */
    public function validateClass($service_class) {
        if( !@class_exists( $service_class ) ){
            throw new ServiceNotFound($service_class);
        }
    }

    /**
     * @return string
     */
    public function getServicePrefix() {
        return $this->service_prefix;
    }

    /**
     * @param string $service_prefix
     */
    public function setServicePrefix($service_prefix) {
        $this->service_prefix = $service_prefix;
    }

    /**
     * @return Response
     */
    public function getResponse() {
        return $this->response;
    }

}