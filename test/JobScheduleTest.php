<?php

// include the JobSchedule class
require "../src/model/JobSchedule.php";

//create a new test class for Job schedule

class JobScheduleTest extends \PHPUnit\Framework\TestCase
{
    //ToDO
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

    // test to check 3 jobs can be added to the schedule and arrange them according to their dependencies
    public function testArrangingThreeJobsInJobSchedule()
    {
        $testString = "a => 
                       b => c
                       c =>";

        $jobSchedule = new JobSchedule($testString);
        $jobSchedule->organiseJobSchedule();
        $actualJobSchedule = $jobSchedule->getSchedule();

        // check the value of the results and that "c" comes before "b" in the schedule index
        $this->assertEquals("a", $actualJobSchedule[0], "Job in schedule should be <a>");
        $this->assertEquals("c", $actualJobSchedule[1], "Job in schedule should be <c>");
        $this->assertEquals("b", $actualJobSchedule[2], "Job in schedule should be <b>");

    }

    // test to check 6 jobs with dependencies are added to schedule in a,d ,f, c, b, e order in index
    public function testAddAndArrangeSixJobsInJobSchedule()
    {
        $testString = "a =>
                       b => c
                       c => f
                       d => a
                       e => b
                       f => ";

        $jobSchedule = new JobSchedule($testString);
        $jobSchedule->organiseJobSchedule();
        $actualJobSchedule = $jobSchedule->getSchedule();

        // check values: a, d, f, c, b, e returned in this order
        $this->assertEquals("a", $actualJobSchedule[0], "Job in schedule should be <a>");
        $this->assertEquals("d", $actualJobSchedule[1], "Job in schedule should be <d>");
        $this->assertEquals("f", $actualJobSchedule[2], "Job in schedule should be <f>");
        $this->assertEquals("c", $actualJobSchedule[3], "Job in schedule should be <c>");
        $this->assertEquals("b", $actualJobSchedule[4], "Job in schedule should be <b>");
        $this->assertEquals("e", $actualJobSchedule[5], "Job in schedule should be <e>");

    }

    // test to check a job cannot depend on itself e.g. "c => c" cannot be allowed
    public function testAJobCantDependOnItself()
    {
        $testString = "a =>
                       b => 
                       c => c";

        $jobSchedule = new JobSchedule($testString);

        $throwsError = $jobSchedule->organiseJobSchedule();

        // checks for the text "Error: Jobs cannot depend on themselves"
        $this->assertEquals("Error: Jobs cannot depend on themselves", $throwsError,
            "Message should be returned <Error: Jobs cannot depend on themselves>");

    }
}