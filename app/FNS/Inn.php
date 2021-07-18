<?php

namespace App\FNS;

use Carbon\Carbon;

class Inn
{
    const ENDPOINT = 'https://statusnpd.nalog.ru/api/v1/tracker/taxpayer_status';

    public function check(string $inn): DTOInn
    {
        if (\Cache::has($inn)) {
            $data = \Cache::get($inn);
            $out = new DTOInn();
            $out->message = $data['message'];
            $out->status = $data['status'];
            return $out;
        }

        $dto = $this->checkWithoutCache($inn);
        $data = [
            'message' => $dto->message,
            'status' => $dto->status
        ];

        \Cache::put($inn, $data, now()->addDay());
       
        return $dto;
    }

    private function checkWithoutCache($inn)
    {
        $client = new \GuzzleHttp\Client(['base_uri' => self::ENDPOINT]);
        $res = $client->request('POST', '', [
            'timeout' => 60,
            'headers' => ['Content-Type' => 'application/json'],
            'json' => [
                "inn" => $inn,
                "requestDate" => Carbon::now()->format('Y-m-d')
            ]
        ]);

        $res = json_decode($res->getBody()->getContents(), true);
        $out = new DTOInn();
        $out->message = $res['message'];
        $out->status = $res['status'];

        return $out;
    }

    public function validate(string $inn): bool
    {
        if (strlen($inn) === 10) {
            return $this->validate10($inn);
        }
        if (strlen($inn) === 12) {
            return $this->validate12($inn);
        }
        return false;
    }

    protected function validate10(string $inn): bool
    {
        $c = [2, 4, 10, 3, 5, 9, 4, 6, 8, 0];
        $sum = 0;
        foreach ($c as $k => $v) {
            $sum += $inn[$k] * $v;
        }
        $ks = $sum % 11 > 9 ? $sum % 10 : $sum % 11;
        return $ks == $inn[9];
    }

    protected function validate12($inn): bool
    {
        $c = [7, 2, 4, 10, 3, 5, 9, 4, 6, 8, 0];

        $sum1 = 0;
        foreach ($c as $k => $v) {
            $sum1 += $inn[$k] * $v;
        }

        $ks1 = $sum1 % 11 > 9 ? $sum1 % 10 : $sum1 % 11;
        $c = [3, 7, 2, 4, 10, 3, 5, 9, 4, 6, 8, 0];
        $sum2 = 0;
        foreach ($c as $k => $v) {
            $sum2 += $inn[$k] * $v;
        }
        $ks2 = $sum2 % 11 > 9 ? $sum2 % 10 : $sum2 % 11;
        return $ks1 == $inn[10] && $ks2 == $inn[11];
    }
}