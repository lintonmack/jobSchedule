<?php

// include the JobSchedule class
require "../src/model/JobSchedule.php";

//create a new test class for Job schedule

class JobScheduleTest extends \PHPUnit\Framework\TestCase
{
    //private $jobSchedule;

    //ToDO
    // 3. Test Pass in 3 jobs that do not rely on another job in a sequence and expect 3 to be returned
    // 4. Test Pass in 3 jobs: a => , b => c, c => and expect 3 jobs to be returned in the sequence a, c, b
    // 5. Test Pass in 6 jobs: a => , b => c, c => f, d => a, e => b, f => and expect f before c, c before b, b before
    //      e and a before d
    // 6. Test Pass in 3 jobs: a => , b => , c => c and expect an error to be thrown as a job can't rely on the sane job
    // 7. Test Pass in 6 jobs: a => , b => c, c => f, d => a, e => , f => b and expect an error to be thrown as a
    //      job cannot rely on circular dependencies.

    // test to check an empty string returns empty job sequence
    public function testEmptyStringReturnsEmptySequence()
    {
        //create new instance of jobSchedule and pass in an empty string
        $jobSchedule = new JobSchedule("");

        //call the method organiseJobSchedule() and pass in the empty string
        $jobSchedule->organiseJobSchedule();

        //retrieve the schedule and add to $actualJobSchedule variable.
        $actualJobSchedule = $jobSchedule->getSchedule();

        //assertEquals changed to assertEmpty as the return would be an empty array, which shows an empty sequence
        $this->assertEmpty($actualJobSchedule, "array should be <empty>");

    }

    // test to check a single job can be added to the jobSchedule
    public function testSingleJobIsAddedToJobSchedule()
    {
        $jobSchedule = new JobSchedule("a => ");
        $jobSchedule->organiseJobSchedule();
        $actualJobSchedule = $jobSchedule->getSchedule();

        // the schedule should be an array with 1 element, which should be "a"
        $this->assertIsArray($actualJobSchedule, "data structure should be <array>");
        $this->assertEquals(1, count($actualJobSchedule), "array should have <1 element>");
        $this->assertEquals("a", $actualJobSchedule[0], "Job in schedule should be <a>");

    }

    // test to check 3 jobs that have zero dependency on one another can be added to the schedule.
    public function testAddingThreeJobsToJobSchedule()
    {
        $testString = "a => 
                       b =>
                       c =>";

        $jobSchedule = new JobSchedule($testString);
        $jobSchedule->organiseJobSchedule();
        $actualJobSchedule = $jobSchedule->getSchedule();

        // check three elements are returned in the array.
        $this->assertEquals(3, count($actualJobSchedule), "array should have <3 elements>");

        // check the value of the results
        $this->assertEquals("a", $actualJobSchedule[0], "Job in schedule should be <a>");
        $this->assertEquals("b", $actualJobSchedule[1], "Job in schedule should be <b>");
        $this->assertEquals("c", $actualJobSchedule[2], "Job in schedule should be <c>");

    }
}