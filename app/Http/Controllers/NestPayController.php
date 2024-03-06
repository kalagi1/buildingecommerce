<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\NestPayService; 
use Illuminate\Support\Facades\Http;


class NestPayController extends Controller
{
    protected $nestPayService;

    public function __construct(NestPayService $nestPayService)
    {
        $this->nestPayService = $nestPayService;
    }
   

    public function index(){
        return view('nestpay.index');
    }

    public function processPayment(Request $request)
    {
         // Formdan gelen verileri alın
         $formData = $request->all();
        
         // Guzzle istemcisini oluşturun
         $client = new \GuzzleHttp\Client();
    
         // POST isteği gönderin
         $response = $client->post('https://entegrasyon.asseco-see.com.tr/fim/est3dgate', [
             'form_params' => $formData,
         ]);
    
                    // İsteğin yanıtını alın ve içeriğini alın
            $responseBody = $response->getBody()->getContents();

            dd($responseBody);

            // Yanıtı döndürün
            return view('nestpay.success', ['responseData' => $responseData]);
    }
    
    
    public function success(Request $request)
    {
        $requestData = $request->all();

        return view('nestpay.success', ['requestData' => $requestData]);
    }

    public function fail(Request $request)
    {
        $requestData = $request->all();

        return view('nestpay.fail', ['requestData' => $requestData]);
            
    }


    public function callback(Request $request)
    {
      

        $requestData = $request->all();

        return view('nestpay.callback', ['requestData' => $requestData]);
    }

}
