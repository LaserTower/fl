<?php


namespace App\Http\Controllers;


use App\FNS\Inn;
use Illuminate\Http\Request;

class CheckInnController extends Controller
{
    public function check(Request $request)
    {
        $inn = new Inn();
        $error = false;
        $success = false;
        
        $number = $request->get('inn');
        
        if(!$inn->validate($number)){
            return [
                'success' => false,
                'error' => 'не корректный номер'
            ];
        }
        
        try {
            $res = $inn->check($number);
            if ($res->status) {
                $success = $res->message;
            } else {
                $error = $res->message;
            }

            return [
                'success' => $success,
                'error' => $error
            ];

        } catch (\GuzzleHttp\Exception\ServerException | \GuzzleHttp\Exception\ClientException $e) {
            return [
                'success' => null,
                'error' => $e->getCode() . ' ' . $e->getMessage()
            ];
        }
    }
}