<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Symfony\Component\HttpFoundation\JsonResponse;

class GenerateController extends Controller
{
    public function generate1200()
    {
        $response=[];
        $str = file_get_contents(resource_path('rsspart.json'));
        $json = json_decode($str, true);
        for ($i=0; $i<3000;$i++){
            array_push($response, $json['response']['docs'][$i]);
        }
        $str = null;
        $json = null;
        $str2 = file_get_contents(resource_path('twitter.json'));
        $json2 = json_decode($str2, true);
        for ($i=0; $i<3000;$i++){
            array_push($response, $json2['response']['docs'][$i]);
        }
        $str2 = null;
        $json2 = null;
        $str3 = file_get_contents(resource_path('news.json'));
        $json3 = json_decode($str3, true);
        for ($i=0; $i<6000;$i++){
            array_push($response, $json3['response']['docs'][$i]);
        }
        $str3 = null;
        $json3 = null;
        $fp = fopen(resource_path('results.json'), 'w');
        fwrite($fp, json_encode($response));
        fclose($fp);
    }

    public function generatebulks()
    {
        $str = file_get_contents(resource_path('results.json'));
        $json = json_decode($str, true);

        $start = 0;
        for ($j=0; $j<24; $j++) {
            $response=[];
            for ($i = $j * 500; $i < ($j*500+500); $i++) {
                array_push($response, $json[$i]);
            }
            $fp = fopen(resource_path('bulks\results' . ($j+1) . '.json'), 'w');
            fwrite($fp, json_encode($response));
            fclose($fp);
        }

    }

    public function generatesort()
    {
        $str = file_get_contents(resource_path('results.json'));
        $json = json_decode($str, true);
        $array1 = [];
        $array2 = [];
        $array3 = [];
        $array4 = [];
        $array5 = [];
        $array6 = [];
        $array7 = [];
        $array8 = [];
        for ($i = 0; $i< count($json); $i++) {
            $coords = explode(",", $json[$i]['allLocations'][0]);
            $y = $coords[0];
            $x = $coords[1];
                if ($y <= floatval(56) && $x > floatval(6) && $y > floatval(52)) {
                    array_push($array1, $json[$i]);
            }
            if ($y <= floatval(52) && $x > floatval(6) && $y > floatval(51)) {
                array_push($array1, $json[$i]);
            }
            if ($y <= floatval(51) && $x > floatval(6) && $y > floatval(50)) {
                array_push($array1, $json[$i]);
            }
            if ($y <= floatval(50) && $x > floatval(6) && $y > floatval(49)) {
                array_push($array1, $json[$i]);
            }
            if ($y <= floatval(49) && $x > floatval(6) && $y > floatval(48)) {
                array_push($array1, $json[$i]);
            }
            if ($y <= floatval(48) && $x > floatval(6) && $y > floatval(47)) {
                array_push($array1, $json[$i]);
            }
            if ($y <= floatval(47) && $x > floatval(6) && $y > floatval(46)) {
                array_push($array1, $json[$i]);
            }
            if ($y <= floatval(46) && $x > floatval(6)) {
                array_push($array1, $json[$i]);
            }
        }
        for ($i = 0; $i < 9; $i++){
            $fp = fopen(resource_path('sorted\results.json'), 'w');
            fwrite($fp, json_encode($array1));
            fclose($fp);
        }
    }
    
    public function generatesortbulks()
    {
        $str = file_get_contents(resource_path('results.json'));
        $json = json_decode($str, true);
        $array1 = [];
        $array2 = [];
        $array3 = [];
        $array4 = [];
        $array5 = [];
        $array6 = [];
        $array7 = [];
        $array8 = [];
        for ($i = 0; $i< count($json); $i++) {
            $coords = explode(",", $json[$i]['allLocations'][0]);
            $y = $coords[0];
            $x = $coords[1];
            if ($y <= floatval(56) && $x > floatval(6) && $y > floatval(52)) {
                array_push($array1, $json[$i]);
            }
            if ($y <= floatval(52) && $x > floatval(6) && $y > floatval(51)) {
                array_push($array2, $json[$i]);
            }
            if ($y <= floatval(51) && $x > floatval(6) && $y > floatval(50)) {
                array_push($array3, $json[$i]);
            }
            if ($y <= floatval(50) && $x > floatval(6) && $y > floatval(49)) {
                array_push($array4, $json[$i]);
            }
            if ($y <= floatval(49) && $x > floatval(6) && $y > floatval(48)) {
                array_push($array5, $json[$i]);
            }
            if ($y <= floatval(48) && $x > floatval(6) && $y > floatval(47)) {
                array_push($array6, $json[$i]);
            }
        }
        $arr = [$array1, $array2, $array3, $array4, $array5, $array6];
        for ($j = 0; $j < 6; $j++){
            $fp = fopen(resource_path('sorted\results' . ($j+1) . '.json'), 'w');
            fwrite($fp, json_encode($arr[$j]));
            fclose($fp);
        }
    }

    public function generateeventtyp()
    {
        $str = file_get_contents(resource_path('results.json'));
        $json = json_decode($str, true);
        $behinderungen = [];
        $stau = [];
        $schienenersatzverkehr = [];
        $verzoegerung = [];
        $unfall = [];
        $wetter = [];
        for ($i = 0; $i < count($json); $i++) {
            switch($json[$i]['eventType'][0]){
                case "Behinderungen": array_push($behinderungen, $json[$i]);
                    break;
                case "Stau": array_push($stau, $json[$i]);
                    break;
                case "Schienenersatzverkehr": array_push($schienenersatzverkehr, $json[$i]);
                    break;
                case "Verzoegerung": array_push($verzoegerung, $json[$i]);
                    break;
                case "Unfall": array_push($unfall, $json[$i]);
                    break;
                default: array_push($wetter, $json[$i]);;
            }
        }
        $arr = [$behinderungen, $verzoegerung, $schienenersatzverkehr, $unfall, $stau, $wetter];
        for ($j = 0; $j < 6; $j++){
            $fp = fopen(resource_path('eventtypes\results' . ($j+1) . '.json'), 'w');
            fwrite($fp, json_encode($arr[$j]));
            fclose($fp);
        }
    }

    public function count(){
        $str = file_get_contents(resource_path('results.json'));
        $json = json_decode($str, true);
        $behinderungen = [];
        $stau = [];
        $schienenersatzverkehr = [];
        $verzoegerung = [];
        $unfall = [];
        $wetter = [];
        for ($i = 0; $i < count($json); $i++) {
            switch($json[$i]['eventType'][0]){
                case "Behinderungen": array_push($behinderungen, $json[$i]);
                    break;
                case "Stau": array_push($stau, $json[$i]);
                    break;
                case "Schienenersatzverkehr": array_push($schienenersatzverkehr, $json[$i]);
                    break;
                case "Verzoegerung": array_push($verzoegerung, $json[$i]);
                    break;
                case "Unfall": array_push($unfall, $json[$i]);
                    break;
                default: array_push($wetter, $json[$i]);;
            }
        }
        echo("Behinderungen: " . count($behinderungen) . "<br>");
        echo("Staus: " . count($stau) . "<br>");
        echo("Schienenersatzverkehr: " . count($schienenersatzverkehr) . "<br>");
        echo("Verzögerungen: " . count($verzoegerung) . "<br>");
        echo("Unfälle: " . count($unfall) . "<br>");
        echo("Wetter: " . count($wetter) . "<br>");
        echo("Gesamt: " . (count($behinderungen)+count($stau)+count($schienenersatzverkehr)+count($verzoegerung)+count($unfall)+count($wetter)));
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

    }

    public function news(){
        $str = file_get_contents(resource_path('news.json'));
        $json = json_decode($str, true);
        foreach ($json["response"]["docs"] as $value) {
            echo($value["sourceDomain"]);
            echo("<br>");
        }
    }

}
