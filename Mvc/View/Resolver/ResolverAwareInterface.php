<?php
namespace DoctorScript\Mvc\View\Resolver;

interface ResolverAwareInterface
{
    /**
     * Set template resolver
     *
     * @param  ResolverInterface $resolver
     * @return void
    */
    public function setTemplateResolver(ResolverInterface $resolver);
    
    /**
     * Get template resolver
     *
     * @return ResolverInterface $resolver
    */
    public function getTemplateResolver();
}