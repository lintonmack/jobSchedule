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
        preg_match_all("/([a-z]\s=>((\s||)([a-z]||\s)))/", $this->unorderedListOfJobs,
            $filteredListOfJobs);

        // loop over the jobsToSchedule in the $filteredListOfJobs

        foreach ($filteredListOfJobs[0] as $jobsToSchedule) {

            // remove additional characters to shorten the length of the string to just the job character.
            $jobsToSchedule = str_replace(" =>", "", $jobsToSchedule);
            $jobsToSchedule = preg_replace("/\s+/", "", $jobsToSchedule);

            // check string length to establish if job has dependencies
            if (strlen($jobsToSchedule) > 1) {

                // call validateJobs() to check validity of the jobsToSchedule
                $areJobsValid = $this->validateJobs($jobsToSchedule);

                // if jobs are invalid exit as soon as possible and return the error message
                if ($areJobsValid !== true) {
                    return $areJobsValid;
                }


                // check if and what jobs have been set in the schedule

                // add the job it depends on ahead of the first job char in the string
                if (!in_array($jobsToSchedule[0], $this->schedule) && !in_array($jobsToSchedule[1], $this->schedule)) {
                    $this->schedule[] = $jobsToSchedule[1];
                    $this->schedule[] = $jobsToSchedule[0];

                    // check if the first job is in the schedule, if yes  and the second job isn't in array
                } elseif (in_array($jobsToSchedule[0], $this->schedule) && !in_array($jobsToSchedule[1],
                        $this->schedule)) {
                    // get the index of the first job in the schedule
                    $lastJobPositionReferenceKey = array_search($jobsToSchedule[0], $this->schedule);
                    // pass the job to reorganiseJobsInSchedule() and the index of where in the schedule to position it
                    $this->reorganiseJobsInSchedule($lastJobPositionReferenceKey, $jobsToSchedule[1]);

                    // check if the first job is not in the schedule but the second job it depends is
                } elseif (!in_array($jobsToSchedule[0], $this->schedule) && in_array($jobsToSchedule[1],
                        $this->schedule)) {
                    // get the index of the second job in the schedule
                    $lastJobPositionReferenceKey = array_search($jobsToSchedule[1], $this->schedule);
                    // increase the index position by one as we want to schedule the job after the job it depends on
                    $lastJobPositionReferenceKey += 1;
                    // pass the job to reorganiseJobsInSchedule() and the position to add it to in the schedule
                    $this->reorganiseJobsInSchedule($lastJobPositionReferenceKey, $jobsToSchedule[0]);
                }

            } else {
                // else if job has no dependencies and isn't in the schedule then add it to the schedule
                if (!in_array($jobsToSchedule, $this->schedule)) {
                    $this->schedule[] = $jobsToSchedule;
                }
            }
        }
        return;

    }

    // function to reorganise jobs in the schedule, takes the position to add in schedule and the job to add to schedule
    private function reorganiseJobsInSchedule($lastJobPositionReferenceKey, $jobToSchedule)
    {
        $jobToReplace = $jobToSchedule;

        // loop through the schedule starting at the index of $lastJobPositionReferenceKey, replace job in that position
        for ($i = $lastJobPositionReferenceKey; $i < count($this->schedule); $i++) {
            // take a copy of the job in that position prior to replacing it
            $currentJob = $this->schedule[$i];
            // replace the job with the new job
            $this->schedule[$i] = $jobToReplace;
            // add the copy of the previous job to the $jobsToReplace for the next time the loop runs
            $jobToReplace = $currentJob;
        }

        // Add the final job to the schedule after the loop has finished running
        $this->schedule[] = $jobToReplace;

    }

    // function validateJobs() throws an error if a job sequence is invalid or returns true if is valid
    private function validateJobs($jobsToSchedule)
    {
        try {
            // check if the jobs in the sequence are equal to one another
            if ($jobsToSchedule[0] === $jobsToSchedule[1]) {
                // throw an error if they are equal
                throw new Error("Error: Jobs cannot depend on themselves");
            }

        } catch (Error $e) {
            // return the handled error to the user
            return $e->getMessage();
        }

        // return true as jobs are valid
        return true;

    }


}