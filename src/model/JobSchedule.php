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

        // use regex to separate job letter from the string and add to the array $filteredListOfJobs
        $filteredListOfJobs = array();
        preg_match_all("/[a-z]\s=>\s([a-z]||\s)/", $this->unorderedListOfJobs, $filteredListOfJobs);

        // remove additional characters to shorten the length of the string to just the job character.
        $filteredListOfJobs[0][0] = str_replace(" =>", "", $filteredListOfJobs[0][0]);
        $filteredListOfJobs[0][0] = preg_replace("/\s+/", "", $filteredListOfJobs[0][0]);

        // add to array and return
        $this->schedule[] = $filteredListOfJobs[0][0];

        return;
    }


}