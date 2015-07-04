<?php
namespace DoctorScript\Mvc\View\Resolver;

interface ResolverInterface
{
    /**
     * Set template map
     *
     * @param  array $templateMap
     * @return void
    */
    public function setTemplateMap(array $templateMap);
    
    /**
     * Get template map
     *
     * @return array
    */
    public function getTemplateMap();
    
    /**
     * Check if template exists
     *
     * @param  string $aliasOrTemplate
     * @return bool true if template exists or false otherwise
    */
    public function hasTemplate($aliasOrTemplatePath);
    
    /**
     * Resolve and get template
     * 
     * @param  string $template
     * @return string
     * @throws \RuntimeException if cannot resolve template
    */
    public function resolve($aliasOrTemplate);
}