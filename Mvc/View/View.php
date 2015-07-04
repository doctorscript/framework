<?php
namespace DoctorScript\Mvc\View;

use DoctorScript\Mvc\View\Resolver\ResolverInterface;
use DoctorScript\Mvc\View\Resolver\ResolverAwareInterface;
use DoctorScript\ServiceManager\Plugin\AbstractPluginProvider;

class View extends AbstractPluginProvider implements ViewInterface, ResolverAwareInterface
{
    /**
     * View instance name
     *
     * @var string
    */
    private $name = 'content';
    
    /**
     * Template alias
     *
     * @var string
    */
    private $template = '';
    
    /**
     * View variables
     *
     * @var array
    */
    private $variables = [];
    
    /**
     * View children
     *
     * @var array
    */
    private $children = [];
    
    /**
     * Terminal status
     *
     * @var boolean
    */
    private $terminal = false;
    
    /**
     * Template resolver
     *
     * @var ResolverInterface
    */
    private $resolver;
    
    /**
     * Constructor
     *
     * @param array $variables view variables
    */
    public function __construct(array $variables = [])
    {
        if (count($variables) > 0) {
            $this->setVariables($variables);
        }
    }
    
    /**
     * Set view name
     *
     * @param string $name
     * @return void
    */
    public function setName($name)
    {
        $this->name = $name;
    }
    
    /**
     * Get view name
     *
     * @return string view name
    */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * Getting view variable via magic property access
     *
     * @param string variable name
     * @return mixed
     * @throws \BadMethodCallException if variable is not exists
    */
    public function __get($name)
    {
        if (!array_key_exists($name, $this->variables)) {
            throw new \BadMethodCallException(sprintf(
                'Variable %s is not exists', $name
            ));
        }

        return $this->variables[$name];
    }
    
    /**
     * Setting view variable via magic property access
     *
     * @param string variable name
     * @param mixed variable value
     * @return void
    */
    public function __set($name, $value)
    {
        $this->variables[$name] = $value;
    }
    
    /**
     * Check if view variable exists via magic property access
     *
     * @return boolean true if variable exists false otherwise
    */
    public function __isset($name)
    {
        return isset($this->variables[$name]);
    }
    
    /**
     * Unset view variable via magic property access
     *
     * @return void
    */
    public function __unset($name)
    {
        if (array_key_exists($name, $this->variables)) {
            unset($this->variables[$name]);
        }
    }

    /**
     * Set view template name
     *
     * @param string $template
     * @return void
    */
    public function setTemplate($template)
    {
        $this->template = $template;
    }
    
    /**
     * Get view template name
     *
     * @return string template name
    */
    public function getTemplate()
    {
        return $this->template;
    }
    
    /**
     * Set view variables
     *
     * @param array $variables
     * @return void
    */
    public function setVariables(array $variables)
    {
        $this->variables = $variables;
    }
    
    /**
     * Get view variables
     *
     * @return array
    */
    public function getVariables()
    {
        return $this->variables;
    }

    /**
     * Add view variable
     *
     * @param  string $name
     * @param  mixed $value
     * @return void
    */
    public function addVariable($name, $value)
    {
        $this->variables[$name] = $value;
    }

    /**
     * Add child view object
     *
     * @param  ViewInterface $view
     * @return void
    */
    public function addChild(ViewInterface $view)
    {
        $this->children[$view->getName()] = $view;
    }
    
    /**
     * Check if view object has child
     *
     * @param string $childName
     * @return boolean
    */
    public function hasChild($childName)
    {
        return array_key_exists($childName, $this->children);
    }
    
    /**
     * Get child view object by name
     *
     * @param  string $childName
     * @return ViewInterface if child exists false otherwise
    */
    public function getChild($childName)
    {
        if (!$this->hasChild($childName)) {
            throw new \BadMethodCallException(sprintf(
                'Child %s is not exists', $childName
            ));
        }

        return $this->children[$childName];
    }
    
    /**
     * Return view object children
     *
     * @return array
    */
    public function getChildren()
    {
        return $this->children;
    }
    
    /**
     * Set view terminal
     * If view object not root and that option set to true, view object unhooks from root view
     *
     * @param  boolean $terminal
     * @return void
    */
    public function setTerminal($terminal = true)
    {
        $this->terminal = (bool)$terminal;
    }

    /**
     * Check view terminal status
     *
     * @return boolean
    */
    public function isTerminated()
    {
        return $this->terminal;
    }

    /**
     * Processing render view
     * If $template not null, assuming variable contains string value of template alias registered in config
     * and using for force creating new view instance using given variables array for render it
     *
     * @param  null|string $template
     * @param  array $variables
     * @return string
     * @throws \RuntimeException if resolver cannot resolve view template
    */
    public function render($template = null, array $variables = [])
    {
        if ($template !== null) {
            $view = new View($variables);
            $view->setTemplate($template);
            $view->setPluginManager($this->getPluginManager());
        } else {
            $view = $this;
        }

        $template = $this->getTemplateResolver()->resolve($view->getTemplate());

        extract($view->getVariables());
        ob_start();
        require $template;
        unset($view, $resolver);
        
        return ob_get_clean();
    }

    /**
     * Processing render child view object
     *
     * @param  string $childName
     * @return string
    */
    public function renderChild($childName)
    {
        $child = $this->getChild($childName);
        $child->setPluginManager($this->getPluginManager());
        $child->setTemplateResolver($this->getTemplateResolver());

        return $child->render();
    }

    /**
     * Set template resolver 
     *
     * @param ResolverInterface $resolver
    */
    public function setTemplateResolver(ResolverInterface $resolver)
    {
        $this->resolver = $resolver;
    }

    /**
     * Get template resolver
     *
     * @return ResolverInterface
    */
    public function getTemplateResolver()
    {
        return $this->resolver;
    }
}