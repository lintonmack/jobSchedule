# Job Schedule

## Table of contents
* [General info](#general-info)
* [Technologies](#technologies)
* [Setup](#setup)

## General info
The purpose of this project was to create a function to organise jobs into a schedule, each job in the string to sort was represented by a single alphabetical character e.g. ```"a"```.

Some of the jobs may have dependencies, and there for require another job to come before it in the sequence. for example 
```"a => b"```, would require job b to come before job a in the sequence as job a relies on job b. Other jobs have no dependencies, this would be shown as ```"a => "```.

The project used Test Driven Development (TDD) find a solution to the problem, a copy of the tests can be found in the
directory ```/test/JobScheduleTest.php``` and the Job Schedule Class can be found in ```/src/model/JobSchedule.php```
	
## Technologies
* PHP 7.2
* PHPUnit version 8
* Composer package Manager

## Setup
You will need to have installed on your system:
* PHP 7.2 - Information on how to install PHP (https://www.php.net/manual/en/install.php)
* PHPUnit version 8 - Information on how to install PHPUnit (https://phpunit.de/manual/6.5/en/installation.html)

Once you have these installed, download / clone this repository from the github menu. There is currently no composer package.

### Running Sample Tests

You can run the existing test functions from ```JobScheduleTest.php``` by navigfating to ```/test/``` directory in the terminal / command line  and running the command ```phpunit JobScheduleTest.php```

### Using the organiseJobSchedule() function

* ```require``` JobSchedule.php into your script (e.g. ```require "./src/model/JobSchedule.php";```
* create a new instance of JobSchedule and pass in your string of jobs to schedule ```$jobSchedule = new JobSchedule("a => b");```
* call the function ```$jobSchedule->organiseJobSchedule();```
