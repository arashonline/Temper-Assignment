<?php

namespace App;

use App\Data\DataCSV;
use App\Data\DataInterface;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Object_;

class Chart extends Model
{
    private $data;

    public function __construct(array $attributes = [],DataInterface $data)
    {
        parent::__construct($attributes);

        $this->data = $data;
    }

    public function getData()
    {
        return $this->data->getData();
    }

    public function getXAxis(){
        return $this->data->getXAxis();
    }

    public function getWeeklyData($weeks = 10, $offset = 1){
        return $this->data->getWeeklyData($weeks,$offset);
    }


}
