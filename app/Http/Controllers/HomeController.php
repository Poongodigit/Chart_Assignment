<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Data_1;
use App\Models\Data_2;
use App\Models\Data_3;
use App\Models\Data_1_Calculation;
use App\Models\Data_2_Calculation;
use App\Models\Data_3_Calculation;
use App\Models\Master_Tables;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;
use App\Models\Chart;
use DB;
use Schema;

class HomeController extends Controller
{
    /**
     * Instantiate a new HomeController instance.
     */

    public function dataCalculation(){

        $insertData1 =array();
        $insertData2 =array();
        $insertData3 =array();

        /* Truncate old data to insert new data */

        Data_1_Calculation::truncate();
        Data_2_Calculation::truncate();
        Data_3_Calculation::truncate();

        /* We can process the data in iteration too */
        /* Data calculation for Table 1 */

        $Details1 = Data_1::all();
        
        $count1 = 0;

        echo "<br> Preparing  Data for Table 1....";
        
        foreach($Details1 as $data1)
        {  
            $dataCount1 = $count1 - 1;
            $roundValue = 0;

            if($count1!==0 && $Details1[$count1]['DailyMainsPosKWh'] > $Details1[$dataCount1]['DailyMainsPosKWh']){
                $roundValue = round($Details1[$count1]['DailyMainsPosKWh'] - $Details1[$dataCount1]['DailyMainsPosKWh'],2);
            }
            
            $date1 = date('m/d/Y', $data1['Timestamp']);

            $insertData1[] = array('MainsRCurr'    => $data1['MainsRCurr'],
            'MainsPosKWh'   =>$data1['MainsPosKWh'],
            'DailyMainsPosKWh'  => $data1['DailyMainsPosKWh'],
            'Timestamp' =>$data1['Timestamp'],
            'from_unixtime' =>date('m/d/Y H:i', $data1['Timestamp']),
            'date'  =>$date1,
            'week'  =>date("W", strtotime($date1)),
            'diff'  =>($count1!== 0) ? $roundValue : 0);
            
            $count1++;
        }

        Data_1_Calculation::insert($insertData1);

        echo "<br> Data has inserted in Table 1";

        // /* Data calculation for Table 2 */

        $Details2 = Data_2::all();
    
        $count2 = 0;

        echo "<br> Preparing Data for Table 2....";
        foreach($Details2 as $data2)
        {  
            $dataCount2 = $count2 - 1;
            $roundValue = 0;

            if($count2!==0 && $Details2[$count2]['DailyMainsPosKWh'] > $Details2[$dataCount2]['DailyMainsPosKWh']){
                $roundValue = round($Details2[$count2]['DailyMainsPosKWh'] - $Details2[$dataCount2]['DailyMainsPosKWh'],2);
            }
            $date2 = date('m/d/Y', $data2['Timestamp']);

            $insertData2[] = array(
                'MainsRCurr'    => $data2['MainsRCurr'],
                'MainsPosKWh'   =>$data2['MainsPosKWh'],
                'DailyMainsPosKWh'  => $data2['DailyMainsPosKWh'],
                'Timestamp' =>$data2['Timestamp'],
                'from_unixtime' =>date('m/d/Y H:i', $data2['Timestamp']),
                'date'  =>$date2,
                'week'  =>date("W", strtotime($date2)),
                'diff'  =>($count2!== 0) ? $roundValue : 0,
                );
                
                $count2++;
        }

        Data_2_Calculation::insert($insertData2);

        echo "<br> Data has inserted in Table 2"; 

        /* Data calculation for Table 3 */

        $Details3 = Data_3::all()->toArray();

        $count3 = 0;

        echo "<br> Preparing Data for Table 3....";
       
        /* Table 3 has up to 25k values so can use array chunk to speed up the performance */

        if(count($Details3) >= 5000)
        {
            $chunks = array_chunk($Details3,'5000');
        
            foreach($chunks as $chunk)
            {
                $insertData3 = array();
                foreach($chunk as $data3)
                {  
                    $dataCount3 = $count3 - 1;
                    $roundValue = 0;

                    if($count3!==0 && $Details3[$count3]['DailyMainsPosKWh'] > $Details3[$dataCount3]['DailyMainsPosKWh']){
                        $roundValue = round($Details3[$count3]['DailyMainsPosKWh'] - $Details3[$dataCount3]['DailyMainsPosKWh'],3);
                    }
                    $date3 = date('m/d/Y', $data3['Timestamp']);

                    $insertData3[] = array(
                    'MainsRCurr'    => $data3['MainsRCurr'],
                    'MainsPosKWh'   =>$data3['MainsPosKWh'],
                    'DailyMainsPosKWh'  => $data3['DailyMainsPosKWh'],
                    'Timestamp' =>$data3['Timestamp'],
                    'from_unixtime' =>date('m/d/Y H:i', $data3['Timestamp']),
                    'date'  =>$date3,
                    'week'  =>date("W", strtotime($date3)),
                    'diff'  =>($count3!== 0) ? $roundValue : 0
                    );
                        
                    $count3++;
                }
                Data_3_Calculation::insert($insertData3);
            }
        }
        echo "<br> Data has inserted in Table 3";  die();

    }

    /*
     *
     * @return \Illuminate\Http\Response
     */

    /* function for rendering chart and table to show the calculated data */
    public function showData()
    {
        /* Have used any Server method so need to find the HTTP method */
        $method = $_SERVER['REQUEST_METHOD'];
        /* Declare all values intially to load the page using GET */  
        $period = "";
        $tableName = "";
        $showChart = 0;
        $chart = array();
        $tableData = Master_Tables::all();
        $tableRowValues ="";
        $tableHeaders ="";
        $colours = array();

        /* If the method is POST it will be retrieved the user inputs */
        if($method == 'POST' && !empty($_POST))
        {
            $period = $_POST["periodicity"];
            $tableName = $_POST["table"];
            
            if($period !== "" && $tableName !== ""){
                $finalTableName = $this->getTableName($tableName);
                $finalTableName = isset($finalTableName[0]) && $finalTableName[0] !== "" ? $finalTableName[0] : "";

                /* Define values to fetch data as per user inputs */
                if($period == 'daily'){
                    $selectValue = "date";
                }
                else if($period == 'weekly'){
                    $selectValue = "week"; 
                }

                /* Get values from table for table heders ad rows */
                $tableHeaders = DB::connection()->getSchemaBuilder()->getColumnListing($finalTableName);
                $tableRowValues = DB::table($finalTableName)->get()->toArray();

                /* Get data to load chart by using user inputs such as table name and period */
                $chartData = DB::table($finalTableName)->select($selectValue, DB::raw('count(*) as total'))
                ->groupBy($selectValue)
                ->pluck('total',$selectValue)
                ->toArray();
                
                // Generate random colours for the chartData for styling //
                for($i=0; $i<=count($chartData); $i++) 
                {
                    $colours[] = '#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6);
                }
                      
                // Prepare the data set for returning with the chart view //
                $chart = new Chart;
                $chart->labels = (array_keys($chartData));
                $chart->dataset = (array_values($chartData));
                $chart->colours = $colours;

                // If User input is empty chart and table will not be loaded//
                if($period !== "" && $tableName !== ""){
                    $showChart = 1;
                }
            }
            else {
                echo "Table Not found"; exit;
            }
        }
        
        return view('show_data',compact('chart'),['tableData' => $tableData,"period"=>$period,"tableName"=>$tableName,"showChart"=>$showChart,"tableHeaders" => $tableHeaders,"tableRowValues"=>$tableRowValues,"colours"=>$colours]);
    }


    /* This function is used to get the final data calcultaed table name from the source table name */
    public function getTableName($tableName)
    {
        $tableData = "";

        if($tableName !== NULL && $tableName !== ""){
            $tableData = Master_Tables::where('name','=',$tableName)->pluck('table_name')->toArray();
        }
        
        return $tableData;
    }

}