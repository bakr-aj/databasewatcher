<?php

namespace bakraj\DataBaseWatcher;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DataBaseWatcher 
{

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
            $dateTime[] = (new Carbon(array_first($match)))->hour;
        }
        $dayStats[array_first($match)]['hour_request'] = array_count_values($dateTime);
        $dayStats[array_first($match)]['total'] = count($dateTime);

        return $dayStats;
    }
    
    public function day($date)
    {
        $data['date'] = json_decode($this->analyze($date)->content());
        $data['overall'] = json_decode($this->overall()->content()) ;
        $data['dates'] = json_decode($this->dates()->content());
        return view('bakraj::databasewatcher')->with(['date'=>$date,'data' => $data]);
    }

    public function stats($date = null)
    {
        $date = is_null($date) ? now()->toDateString() : $date;
        return $this->day($date);
    }

}