<?php
namespace App\Models\API_Models;

use App\Http\Controllers\Controller;

class API_Model
{
    /* Main function to execute API function using URL framed with each corresponding functions */

    public function ExecuteAPI($url){
        /* Frame headers which are mandatory to execute  */
        $headers = [
            'Accept: application/json',
            'X-CSCAPI-KEY: MUQzMEptNEE3bXZTNVhSQUVtNEVBNk9ZakgzRk9wcUdFYnJjT0EwNQ=='
        ];
        
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => $headers,
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return $response;
    }

    public function GetCountriesAPI()
    {
        /* Frame URL */
        $Url = "https://api.countrystatecity.in/v1/countries";

        $APIResponse = $this->ExecuteAPI($Url);

        return $APIResponse;

    }

    public function GetCountriesUsingCisoAPI($ciso){
        /* Frame URL */
        $apiURL = "https://api.countrystatecity.in/v1/countries/";

        $API_Url = $apiURL.$ciso;

        $APIResponse = $this->ExecuteAPI($API_Url);

        return $APIResponse;
    }

    public function GetStatesUsingCisoAPI($ciso){
        /* Frame URL */
        $apiURL = "https://api.countrystatecity.in/v1/countries/";
        $API_Url = $apiURL.$ciso."/states";

        $APIResponse = $this->ExecuteAPI($API_Url);

        return $APIResponse;
    }

    public function GetcitiessUsingCisoAPI($ciso){
        /* Frame URL */
        $apiURL = "https://api.countrystatecity.in/v1/countries/";
        $API_Url = $apiURL.$ciso."/cities";

        $APIResponse = $this->ExecuteAPI($API_Url);

        return $APIResponse;
    }
    
    public function GetCitiessUsingSisoAPI($ciso,$siso){
        /* Frame URL */
        $apiURL = "https://api.countrystatecity.in/v1/countries/";

        $API_Url = $apiURL.$ciso."/states/".$siso."/cities" ;
      
        $APIResponse = $this->ExecuteAPI($API_Url);

        return $APIResponse;
        
    }

    public function GetStatesAPI(){
        /* Frame URL */
        $Url = "https://api.countrystatecity.in/v1/states";

        $APIResponse = $this->ExecuteAPI($Url);

        return $APIResponse;

    }

    public function GetStatesUsingSisoAPI($ciso,$siso){
        /* Frame URL */
        $apiURL = "https://api.countrystatecity.in/v1/countries/";

        $API_Url = $apiURL.$ciso."/states/".$siso ;
      
        $APIResponse = $this->ExecuteAPI($API_Url);

        return $APIResponse;
        
    }
    
}