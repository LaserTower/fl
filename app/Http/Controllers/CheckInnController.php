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
        try {
            $res = $inn->check($request->get('inn'));
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