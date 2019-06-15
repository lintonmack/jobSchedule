<?php


class JobSchedule
{

    // Instance variables declared
    //$schedule is the final ordered list of jobs. $unorderedListOfJobs is the unsorted string of jobs.

    private $schedule = array();
    private $unorderedListOfJobs = "";

    public function __construct($unorderedListOfJobs)
    {
        $this->unorderedListOfJobs = $unorderedListOfJobs;
    }

    /**
     * @return array
     */
    public function getSchedule()
    {
        return $this->schedule;
    }

    /**
     * @param array $schedule
     */
    public function setSchedule($schedule)
    {
        $this->schedule = $schedule;
    }


    // initial declaration of organiseJobSchedule to return an empty string

    public function organiseJobSchedule()
    {
        if ($this->unorderedListOfJobs === "") {
            return;
        }

    }
}