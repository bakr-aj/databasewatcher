<?php

namespace bakraj\DataBaseWatcher;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class DataBaseWatcher 
{
    protected $path;

    public function __construct()
    {
        $this->path = $path = storage_path("logs\databasewatcher.log");
    }

    public function overall()
    {
        $overall  = array();

        $files = Storage::disk('databasewatcher')->files('\logs\query');
        
        foreach($files as $file)
        {
            $match;
            $lines = file(storage_path($file));
            preg_match("/\d{4}-\d{2}-\d{2}/",$file,$match);
            $match = array_first($match);
            $overall [$match] = array_first($this->analyzerCore($lines))['total'];
        }

        return response()->json([
            'stats' => $overall
        ]);

    }

    public function dates()
    {
        $files = Storage::disk('databasewatcher')->files('\logs\query');

        $matches;

        foreach($files as $file)
        {
            preg_match("/\d{4}-\d{2}-\d{2}/",$file,$matches[]);
        }

        $matches = array_flatten($matches);

        return response()->json([
            "dates" => $matches
        ]);
    }

    public function analyze($date)
    {
        $path = storage_path("\logs\query\laravel-".$date.".query");
        try{
            $lines = file($path);
            $dayStats = $this->analyzerCore($lines);
        }catch(\Exception $e){
            $dayStats = [];
        }
        return response()->json([
            'stats' => $dayStats
        ]);
    }

    public function analyzerCore($lines)
    {
        if(!$lines)
        {   
            return 0;
        }
        $dateTime ;
        $match;

        foreach ($lines as $index => $line)
        {
            preg_match("/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/",$line,$match);
            $date = new Carbon(array_first($match));
            $dateTime[] = $date->hour;
        }
        $dayStats[$date->toDateString()]['hour_request'] = array_count_values($dateTime);
        $dayStats[$date->toDateString()]['total'] = count($dateTime);

        return $dayStats;
    }
    
    public function stats($date = null)
    {
        $date = is_null($date) ? now()->toDateString() : $date;
        $data['date'] = json_decode($this->analyze($date)->content());
        $data['overall'] = json_decode($this->overall()->content()) ;
        $data['dates'] = json_decode($this->dates()->content());
        return view('bakraj::databasewatcher')->with(['date'=>$date,'data' => $data]);
    }

    public static function log()
    {
        $statsFile = Storage::disk('databasewatcher')->exists("\logs\databasewatcher.log") ? file_get_contents($this->path) : null ;
        
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