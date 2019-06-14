<?php

//create a new test class for Job schedule

class JobScheduleTest extends \PHPUnit\Framework\TestCase
{
    private $jobSchedule;

    //ToDO
    // 1. Test Empty Test Returns An Empty Sequence
    // 2. Test Pass in a single job and expect a single job to be returned
    // 3. Test Pass in 3 jobs that do not rely on another job in a sequence and expect 3 to be returned
    // 4. Test Pass in 3 jobs: a => , b => c, c => and expect 3 jobs to be returned in the sequence a, c, b
    // 5. Test Pass in 6 jobs: a => , b => c, c => f, d => a, e => b, f => and expect f before c, c before b, b before
    //      e and a before d
    // 6. Test Pass in 3 jobs: a => , b => , c => c and expect an error to be thrown as a job can't rely on the sane job
    // 7. Test Pass in 6 jobs: a => , b => c, c => f, d => a, e => , f => b and expect an error to be thrown as a
    //      job cannot rely on circular dependencies.

    //test to check an empty string returns empty job sequence
    public function testEmptyStringReturnsEmptySequence()
    {
        //create new instance of jobSchedule and pass in an empty string
        $this->jobSchedule = new JobScheduleTest("");

        //call the method organiseJobSchedule() and pass in the empty string
        $this->jobSchedule->organiseJobSchedule();

        //retrieve the schedule and add to $actualJobSchedule variable.
        $actualJobSchedule = $this->getSchedule();

        //assertEquals used to check expected value of empty string is an empty string
        $this->assertEquals("", $actualJobSchedule->schedule[0], "string should be <empty>");

    }
}