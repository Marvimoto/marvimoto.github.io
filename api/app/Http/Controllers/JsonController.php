<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class JsonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function truncateJson($json, $start, $stop) {
        $newjson = [];
        if ($stop > count($json['response']['docs'])){
            $stop = count($json['response']['docs']);
        }
            for ($i = $start; $i < $stop; $i++) {
                array_push($newjson, $json['response']['docs'][$i]);
            }
        return $newjson;
    }

    public function index($start = null, $stop=null)
    {
        //ini_set('memory_limit', '1024M');
        $str = file_get_contents(resource_path('rsspart.json'));
        $json = json_decode($str, true);
        if ($start != null) {
            $newjson = $this->truncateJson($json, $start, $stop);
        } else{
            return response()->json($json['response']['docs']);
        }
        return response()->json($newjson);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function complete()
    {
        $str = file_get_contents(resource_path('results.json'));
        $json = json_decode($str, true);
        return response()->json($json);
    }

    /**
     * @param $number
     */
    public function bulk($number)
    {
        $str = file_get_contents(resource_path('bulks\results' . $number . '.json'));
        $json = json_decode($str, true);
        return response()->json($json);
    }
    
    public function sorted(){
        $str = file_get_contents(resource_path('sorted\results.json'));
        $json = json_decode($str, true);
        return response()->json($json);
    }
    
    public function sortedbulks($number){
        $str = file_get_contents(resource_path('sorted\results' . $number . '.json'));
        $json = json_decode($str, true);
        return response()->json($json);
    }

    public function bulkevents($number) {
        $str = file_get_contents(resource_path('eventtypes\results' . $number . '.json'));
        $json = json_decode($str, true);
        return response()->json($json);
    }
    
    
    public function geojson(){
        $str = file_get_contents(resource_path('results.json'));
        $json = json_decode($str, true);
        $newjson = [];
        $i = 0;
        $newjson["type"] = "FeatureCollection";
        foreach ($json as $value) {
            if (in_array(strtolower($value["eventType"][0]), ["wetter", "naturereignis", "behinderungen", "verzoegerung", "stau", "unfall", "schienenersatzverkehr"])) {
                $newjson["features"][$i]["type"] = "Feature";
                $newjson["features"][$i]["properties"]["icon"] = strtolower($value["eventType"][0]);
                $newjson["features"][$i]["properties"]["description"] = isset($value["title"]) ? "<strong>" . wordwrap($value["title"], 75, "<br>") . "</strong><br>" . wordwrap($value["text"], 75, "<br>") : wordwrap($value["text"], 75, "<br>");
                $newjson["features"][$i]["geometry"]["type"] = "Point";
                $ucoords = [];
                $ucoords = explode(",", $value["allLocations"][0]);
                $coords = [];
                $coords[0] = floatval($ucoords[1]);
                $coords[1] = floatval($ucoords[0]);
                $newjson["features"][$i]["geometry"]["coordinates"] = $coords;

                $i++;
            }
        }
        $fp = fopen(resource_path('newmarkers.geojson'), 'w');
        fwrite($fp, json_encode($newjson));
        fclose($fp);
        $file = file_get_contents(resource_path( 'newmarkers.geojson'));
        $json = json_decode($file, true);
        return response()->json($json);
    }
}
