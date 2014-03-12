<?php


class TaskSorter
{

    public function __construct()
    {

    }

    /**
     * $dateOrderedTaskList must already be ordered by start date
     *
     * @param <Array> $dateOrderedTaskList
     */
    public function groupTaskListByMonthYear($dateOrderedTaskList)
    {
	$sortedArray = array();

	$dateUtility = new DateUtility();

	for($i = 0; $i < count($dateOrderedTaskList); $i++)
	{
	    $workStartDate = $dateOrderedTaskList[$i]['start_date'];
	    $workPhpStartDate = $dateUtility->convertMySqlDateTimeToPhpTimestamp($workStartDate);
	    $workMonth = date("n", $workPhpStartDate);
	    $workYear = date("Y", $workPhpStartDate);

	    $indexCount = count($sortedArray[$workYear][$workMonth]);

	    $sortedArray[$workYear]['year'] = $workYear;
	    $sortedArray[$workYear][$workMonth]['month'] = $workMonth;
	    $sortedArray[$workYear][$workMonth][$indexCount] = $dateOrderedTaskList[$i];
	}

	return $sortedArray;
    }
}

?>