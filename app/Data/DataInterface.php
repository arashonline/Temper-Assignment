<?php

namespace App\Data;


interface DataInterface
{
    public function setData($data);
    public function getData();
    public function loadData();
    public function sortWeeklyData();
    public function getXAxis();

    public function cleanData($import_array,$total);
}
