<?php

namespace App\Http\Controllers;

use App\Chart;
use App\Data\DataCSV;
use Illuminate\Http\Request;

class ChartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $chart = new Chart([],new DataCSV());
//        dd($chart->getData());
        //        dd($data);
        $chart1 = \Chart::title(['text' => 'Temper Chart',])
            ->chart(['type' => 'line', 'renderTo' => 'chart1',])
            ->subtitle(['text' => '',])
            ->colors(['#0c2959'])
            ->xaxis(['categories' => $chart->getXAxis()])
            ->yaxis(['text' => 'This Y Axis',])
//            ->legend([  ])
            ->series( $chart->getWeeklyData())
            ->display();

        return view('analytic', ['chart1' => $chart1,]);
//        return view('analytic',['data'=>$chart->getData()]);
    }
    public function paging($page=10,$offset=1)
    {

        $chart = new Chart();

        $chart1 = \Chart::title(['text' => 'Temper Chart',])
            ->chart(['type' => 'line', 'renderTo' => 'chart1',])
            ->subtitle(['text' => '',])
            ->colors(['#0c2959'])
            ->xaxis(['categories' => $chart->getXAxis()])
            ->yaxis(['text' => 'This Y Axis',])
            ->series( $chart->getWeeklyData($page,$offset))
            ->display();

        return view('analytic', ['chart1' => $chart1,]);
//        return view('analytic',['data'=>$chart->getData()]);
    }


    public function any() {
        return view('app');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Chart $chart
     * @return \Illuminate\Http\Response
     */
    public function show(Chart $chart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Chart $chart
     * @return \Illuminate\Http\Response
     */
    public function edit(Chart $chart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Chart $chart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Chart $chart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Chart $chart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Chart $chart)
    {
        //
    }
}
