<?php
namespace DoctorScript\Mvc;

use DoctorScript\EventManager\EventInterface;

interface InjectApplicationEventInterface
{
    /**
     * Set event
     *
     * @param  EventInterface $e
     * @return void
    */
    public function setEvent(EventInterface $e);

    /**
     * Get event
     *
     * @return EventInterface
    */
    public function getEvent();
}