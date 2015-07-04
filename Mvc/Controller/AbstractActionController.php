<?php
namespace DoctorScript\Mvc\Controller;

use DoctorScript\ServiceManager\Plugin\AbstractPluginProvider;
use DoctorScript\Http\Request\RequestInterface;
use DoctorScript\Http\Response\ResponseInterface;
use DoctorScript\Mvc\InjectApplicationEventInterface;
use DoctorScript\EventManager\EventInterface;

abstract class AbstractActionController extends AbstractPluginProvider implements InjectApplicationEventInterface
{
    /**
     * @var RequestInterface
    */
    private $request;
    
    /**
     * @var ResponseInterface
    */
    private $response;
    
    /**
     * @var EventInterface
    */
    private $event;
    
    /**
     * Set request
     *
     * @param  RequestInterface
     * @return void
    */
    public function setRequest(RequestInterface $request)
    {
        $this->request = $request;
    }

    /**
     * Get request
     *
     * @return RequestInterface
    */
    public function getRequest()
    {
        return $this->request;
    }
    
    /**
     * Set response 
     *
     * @param  ResponseInterface
     * @return void
    */
    public function setResponse(ResponseInterface $response)
    {
        $this->response = $response;
    }
    
    /**
     * Get response 
     *
     * @return ResponseInterface
    */
    public function getResponse()
    {
        return $this->response;
    }
    
    /**
     * Set application event
     *
     * @param  EventInterface $e
     * @return void
    */
    public function setEvent(EventInterface $e)
    {
        $this->event = $e;
    }
    
    /**
     * Get application event
     *
     * @param  EventInterface $e
     * @return void
    */
    public function getEvent()
    {
        return $this->event;
    }
}