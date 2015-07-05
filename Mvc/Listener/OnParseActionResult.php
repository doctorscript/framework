<?php
namespace DoctorScript\Mvc\Listener;

use DoctorScript\EventManager\EventInterface;
use DoctorScript\Mvc\View\View;
use DoctorScript\Mvc\View\ViewInterface;
use DoctorScript\Format\FormatInterface;
use DoctorScript\Http\Response\ResponseInterface;

class OnParseActionResult
{
    /**
     * Action result parse listener
     *
     * Triggering for parsing value wich returned by controller action
     * Listener can parse four value: ResponseInterface, FormatInterface, ViewInterface, Array
     * When value instanceOf ResponseInterface, it checks HTTP status code of response. 
     * If first number of status code equal to 4 or 5, get root view and set error template otherwise get response content
     * When returns array, force create view instance and use array data for populate view with them
     * When returns FormatInterface, just retrieve format data and set appropriate content type 
     * If data returned by action instance of ViewInterface, it joins to root view as child if is not terminated
     *
     * @param  EventInterface $e
     * @throws \RuntimeException if action returns unexpected data  
    */
    public function __invoke(EventInterface $e)
    {
        $actionResult = $e->getParam('actionResult');

        if ($actionResult instanceOf ResponseInterface) {
            if (in_array(substr($actionResult->getStatusCode(), 0, 1), [4,5])) {
                $view = $e->getView();
                $view->setTemplate('error/'.$actionResult->getStatusCode());
            } else {
                $responseContent = $actionResult->getContent();
            }
        } else if ($actionResult instanceOf FormatInterface) {
            $responseContent = $actionResult->renderFormat();
            $e->getResponse()->addHeader('Content-Type', $actionResult::FORMAT_CONTENT_TYPE);
        } else if ($actionResult instanceOf ViewInterface) {
            if ($actionResult->getTemplate() == '') {
                $actionResult->setTemplate($this->createDefaultTemplatePath($e));
            }
            if (!$actionResult->isTerminated()) {
                $view = $e->getView();
                $view->addChild($actionResult);
            } else {
                $view = $actionResult;
            }
        } else if (is_array($actionResult)) {
            $forceView = new View($actionResult);
            $forceView->setTemplate($this->createDefaultTemplatePath($e));
            $view = $e->getView();
            $view->addChild($forceView);
        } else {
            throw new \RuntimeException(sprintf(
                'Action must return one of next: ResponseInterface|FormatInterface|ViewInterface|Array, %s returned', 
                is_object($actionResult) ? get_class($actionResult) : gettype($actionResult)
            ));
        }
        
        if (isset($view)) {
            $decorator          = $e->getApplication()->getServiceManager()->get('DoctorScript\Mvc\View\ViewDecorator');
            $responseContent = $decorator->render($view);
        }

        $e->setParam('responseContent', $responseContent);
    }
    
    /**
     * Create default template path if it not set
     *
     * @param  MvcEventInterface $e
     * @return string path to default view file
    */
    public function createDefaultTemplatePath(MvcEventInterface $e)
    {
        $routeMatch     = $e->getRouteMatch();
        $rController = new \ReflectionClass($routeMatch->getParam('controller'));

        $modulePath = str_replace([$rController->getName(), '.php'], '', $rController->getFileName());
        $moduleNS   = str_replace('\Controller', '', $rController->getNamespaceName());
        $moduleName    = str_replace('Controller', '', $rController->getShortName());

        return $modulePath . 
               $moduleNS . 
               DIRECTORY_SEPARATOR . 
               'views' . 
               DIRECTORY_SEPARATOR . 
               $moduleName . 
               DIRECTORY_SEPARATOR . 
               $routeMatch->getParam('action').'.php';
    }
}
