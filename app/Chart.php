<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Object_;

class Chart extends Model
{
    public function getData()
    {
//        You could select data source from one of the following:
//        If you want to use database just run the migration and then uncomment Analytic (comment using csv line)

//        $data = new DataJson(); // json data
//        $data = new Analytic(); // using database
        $data = new DataCSV(); // using csv
        return $data->loadData();
    }

    public function sortWeeklyData(){
        $data = $this->getData();
        $collection  = collect($data);
        $weeks = [];
        $days = [];
        $daily_data = $collection->groupBy('created_at')->toArray();
        $is_init = 1;
        $week_number = 1;
//        dd($daily_data);
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
//        dd($week_with_data);
        return $week_with_data;
    }

    public function getXAxis(){
//        return [0, 20,40,50,70,90,99,100 ];
        return [0, 35,40,45,50,55,60,65,90,95,99,100 ];
//        return [0, 20 , 30, 35,40,45,50,55,60,65,90,95,99,100 ];
    }

    public function getWeeklyData($weeks = 10, $offset = 1){
        $data = $this->sortWeeklyData();


        try{
            $data = array_slice($data,($offset-1),$weeks);
            $chart_data = [];
            foreach ($data as $key =>$record){
                $chart_data[] =[
                    'name'=> 'WEEK '.($key+$offset),
                    'data'=> $this->calculateData($record['onboarding_perentage'],$record['total'])
                ];

            }

            return $chart_data;
        }catch (\Exception $exception){

//            when requested data exceed the current data or there is no data available
            return [];
        }

    }

    public function calculateData($import_array,$total){
//        $temp_data[0]=$total;
        $degree = 100/ $total;
//        $temp_data[]=$total*$degree;
        $value = $total;
        $temp_data = $this->getXAxis();
        foreach ($temp_data as $key =>$step){
            if($key != 0 && !empty($import_array[$step])) {
                $value = $value - count($import_array[$step]);
            }
            $temp_data[$key]= $value*$degree;
        }
//        foreach ($import_array as $key => $meta){
//            $value = $value - count($meta);
////            $temp_data[$key]=$value;
//            $temp_data[]=$value*$degree;
//        }
        return $temp_data;
    }

    public function calculateDataReverse($import_array,$total){
//        $temp_data[0]=$total;
        $degree = 100/ $total;
//        $temp_data[]=$total*$degree;
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
}
