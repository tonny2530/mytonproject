<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $message = null;
        return view('home');
    }

    public function submit(Request $request){
        $input = $request->all();
        $message = null;
        $this->validate($request, [
            'url' => 'required|url'
        ]);

        $param_url = $request->input('url');

        $client = new Client(); //GuzzleHttp\Client
        $url = "https://canssens-seo-extraction-v1.p.rapidapi.com/seo/api/";

        $headers = [
            'X-RapidAPI-Key' => '38f1187668msh85df4ad86d3cef3p1de241jsnaac0e7d5eef7'
        ];

        $data = ['url' => $param_url];

        $response = $client->request('POST', $url, [
            'multipart' => [
                [
                    'name' => 'url',
                    'contents' =>  $param_url
                ]
            ],
            'headers' => $headers,
            'verify'  => false,
        ]);

        $responseBody = json_decode($response->getBody());

        return view('home',['message' => $responseBody ]);
    }
}
