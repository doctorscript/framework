<?php
namespace DoctorScript\Mvc\View\Resolver;

class TemplateResolver implements ResolverInterface
{
    /**
     * @var array
    */
    private $templateMap = [];

    /**
     * Set template map
     *
     * @param  array $templateMap
     * @return void
    */
    public function setTemplateMap(array $templateMap)
    {
        $this->templateMap = $templateMap;
    }
    
    /**
     * Get template map
     *
     * @return array
    */
    public function getTemplateMap()
    {
        return $this->templateMap;
    }
    
    /**
     * Check if template exists
     *
     * @param  string $aliasOrTemplatePath
     * @return bool true if template exists or false otherwise
    */
    public function hasTemplate($aliasOrTemplatePath)
    {
        if (!array_key_exists($aliasOrTemplatePath, $this->templateMap) && !is_file($aliasOrTemplatePath)) {
            return false;
        }
        
        return true;
    }
    
    /**
     * Resolve and get template
     * 
     * @param  string $template
     * @return string
     * @throws \RuntimeException if cannot resolve template
    */
    public function resolve($aliasOrTemplatePath)
    {    
        if (!$this->hasTemplate($aliasOrTemplatePath)) {
            throw new \RuntimeException(sprintf(
                'Cannot resolve template %s', $aliasOrTemplatePath
            ));
        }

        return isset($this->templateMap[$aliasOrTemplatePath]) ? $this->templateMap[$aliasOrTemplatePath] : $aliasOrTemplatePath;
    }
}
