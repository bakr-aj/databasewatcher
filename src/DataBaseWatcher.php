<?php

namespace bakraj\DataBaseWatcher;

use Carbon\Carbon;

class DataBaseWatcher 
{
    protected $path;

    public function __construct()
    {
        $this->path = $path = storage_path("logs\databasewatcher.log");
    }

    public function overall()
    {
        $stats = file_exists($this->path) ?  json_decode(file_get_contents($this->path),true) : [];

        return response()->json([
            'stats' => $stats
        ]);

    }

    public function dates()
    {
        $stats = file_exists($this->path) ?  json_decode(file_get_contents($this->path),true) : [];

        return response()->json([
            "dates" => array_keys($stats)
        ]);
    }

    public function analyze($date)
    {
        $stats = file_exists($this->path) ?  json_decode(file_get_contents($this->path),true) : [];

        $dayStats = isset($stats[$date]) ? $stats[$date] : [];

        return response()->json([
            'stats' => $dayStats
        ]);
    }

    
    public function stats($date = null)
    {
        $date = is_null($date) ? now()->toDateString() : $date;
        $data['date'] = json_decode($this->analyze($date)->content());
        $data['overall'] = json_decode($this->overall()->content()) ;
        $data['dates'] = json_decode($this->dates()->content());
        return view('bakraj::databasewatcher')->with(['date'=>$date,'data' => $data]);
    }

    public function log()
    {
        $statsFile = file_exists($this->path) ? file_get_contents($this->path) : null ;
        
        $stats = json_decode($statsFile, true);
        
        $timeStamp = now();

        if(!isset($stats[$timeStamp->toDateString()]["total"]))
        {
            $stats[$timeStamp->toDateString()]["total"] = 0; 
        }
        

        if(!isset($stats[$timeStamp->toDateString()]["hour_request"][$timeStamp->hour]))
        {
            $stats[$timeStamp->toDateString()]["hour_request"][$timeStamp->hour] = 1; 
            $stats[$timeStamp->toDateString()]["total"] += 1; 
            $data = json_encode($stats);
            file_put_contents($this->path,$data);
        }
        else
        {
            $stats[$timeStamp->toDateString()]["hour_request"][$timeStamp->hour] +=1;
            $stats[$timeStamp->toDateString()]["total"] += 1; 
            $data = json_encode($stats);
            file_put_contents($this->path,$data);
        }
    }

}