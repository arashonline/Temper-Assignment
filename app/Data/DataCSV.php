<?php

namespace App\Data;



use Illuminate\Support\LazyCollection;

class DataCSV implements DataInterface
{
    var $data;

    var $test_data;

    public function __construct()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $file = public_path('storage/export.csv');

        $records = $this->csvToArray($file,';');
        $this->setData($records);
        return $records;
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function getData()
    {
        return $this->data;
    }


    public function sortWeeklyData(){
        $data = $this->loadData();
        $collection  = collect($data);
        $weeks = [];
        $days = [];
        $daily_data = $collection->groupBy('created_at')->toArray();
        $is_init = 1;
        $week_number = 1;
        foreach ($daily_data as $key => $meta){
            if( $date_obj = \DateTime::createFromFormat('d/m/Y', $key)){

            }else{
                $date_obj = new \DateTime($key);
            }
            $initial_date = !empty($initial_date)?$initial_date:$date_obj;
            if( date_diff($date_obj,$initial_date)->days > 6){
                $week_number++;
                $is_init = 1;
            }
            if($is_init){
                $initial_date = $date_obj;
                $is_init = 0;
            }
            foreach ($meta as $record){
                if(!empty($record)){
                    $weeks[$week_number][]= $record;
                }
            }

        }
        $week_with_data = [];
        foreach ($weeks as $key =>$week){
            $week_collection = collect($week);
            $week_with_data[$key] = [
//                'records' =>$week,
                'total' =>count($week),
                'onboarding_perentage' =>$week_collection->sortBy('onboarding_perentage')->groupBy('onboarding_perentage')->toArray(),
                'count_applications' =>$week_collection->sortBy('count_applications')->groupBy('count_applications')->toArray(),
                'count_accepted_applications' => $week_collection->sortBy('count_accepted_applications')->groupBy('count_accepted_applications')->toArray(),
            ];
        }
        return $week_with_data;
    }

    public function getWeeklyData($weeks = 10, $offset = 1){
        $data = $this->sortWeeklyData();
        try{
            $data = array_slice($data,($offset-1),$weeks);
            $chart_data = [];
            foreach ($data as $key =>$record){
                $chart_data[] =[
                    'name'=> 'WEEK '.($key+$offset),
                    'data'=> $this->cleanData($record['onboarding_perentage'],$record['total'])
                ];
            }
            return $chart_data;
        }catch (\Exception $exception){
//            when requested data exceed the current data or there is no data available
            return [];
        }
    }

    public function cleanData($import_array,$total){
        $degree = 100/ $total;
        $value = $total;
        $temp_data = $this->getXAxis();
        foreach ($temp_data as $key =>$step){
            if($key != 0 && !empty($import_array[$step])) {
                $value = $value - count($import_array[$step]);
            }
            $temp_data[$key]= $value*$degree;
        }
        return $temp_data;
    }

    public function getXAxis(){
        return  array_merge([0],range(30,95,5),[99,100]);
//        return [0, 35,40,45,50,55,60,65,90,95,99,100 ];
    }

    public function calculateDataReverse($import_array,$total){
        $degree = 100/ $total;
        $value = null;
        $temp_data = array_reverse($this->getXAxis());
        foreach ($temp_data as $key =>$step){
            if(!empty($import_array[$step])) {
                $value = $value + count($import_array[$step]);
            }
            $temp_data[$key]= $value*$degree;
        }
        return array_reverse($temp_data);
    }

    function csvToArray_bac($filename = '', $delimiter = ',')
    {
        if (!file_exists($filename) || !is_readable($filename))
            return false;
//        todo use LazyCollection make perfect sense for this situation so use it
        LazyCollection::make(function ()use($filename){
            $handle = fopen($filename, 'r');
            while (($line = fgets($handle)) !== false) {
                yield $line;
            }
        });
    }

    function csvToArray($filename = '', $delimiter = ',')
    {
        if (!file_exists($filename) || !is_readable($filename))
            return false;

        $header = null;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== false)
        {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false)
            {
                if (!$header)
                    $header = $row;
                else
                    $data[] = array_combine($header, $row);
            }
            fclose($handle);
        }

        return $data;
    }

}
