<?php
namespace DoctorScript\Mvc\View;

interface ViewInterface
{
    /**
     * Set view name
     *
     * @param  string $name
     * @return void
    */
    public function setName($name);
    
    /**
     * Get view name
     *
     * @return string view name
    */
    public function getName();
    
    /**
     * Processing render view
     * If $template not null, assuming variable contains string value of path or template alias(if template resolver provided)
     *
     * @param  null|string $template
     * @param  array $variables
     * @return string
    */
    public function render($template = null, array $variables = []);

    /**
     * Set view variables
     *
     * @param  array $variables
     * @return void
    */
    public function setVariables(array $variables);

    /**
     * Get view variables
     *
     * @return array
    */
    public function getVariables();

    /**
     * Set view template name
     *
     * @param  string $template
     * @return void
    */
    public function setTemplate($template);
    
    /**
     * Get view template name
     *
     * @return string
    */
    public function getTemplate();
}