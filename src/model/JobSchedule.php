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
        preg_match_all("/[[a-z]\s=>((\s||)([a-z]||\s))/", $this->unorderedListOfJobs, $filteredListOfJobs);

        // loop over the jobsToSchedule in the $filteredListOfJobs

        foreach ($filteredListOfJobs[0] as $jobsToSchedule) {

            // remove additional characters to shorten the length of the string to just the job character.
            $jobsToSchedule = str_replace(" =>", "", $jobsToSchedule);
            $jobsToSchedule = preg_replace("/\s+/", "", $jobsToSchedule);

            // check string length to establish if job has dependencies
            if (strlen($jobsToSchedule) > 1) {
                //add the job it depends on ahead of the first job char in the string
                $this->schedule[] = $jobsToSchedule[1];
                $this->schedule[] = $jobsToSchedule[0];
            } else {
                // else if job has no dependencies and isn't in the schedule then add it to the schedule
                if (!in_array($jobsToSchedule, $this->schedule)) {
                    $this->schedule[] = $jobsToSchedule;
                }
            }
        }

        return;

    }


}