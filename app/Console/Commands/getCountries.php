<?php

namespace App\Console\Commands;

use App\Models\Country;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class getCountries extends Command
{

    private $api_url = "https://api.first.org/data/v1/countries?pretty=true&limit=9999";

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ticketsystems:get_countries';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get all countries data from api.first.org/data/v1/countries';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $apiData = $this->connectApiAndGetData();
        $countriesData = $this->parseApiData($apiData);

        if (count($countriesData)) {

            try {

                $countries = Country::all()->toArray();

                $willCreateCountries = collect($countriesData)->reject(function ($val, $key) use($countries){
                    return array_search($val['code'], array_column($countries, 'code'));
                })->toArray();

                Country::insert($willCreateCountries);

                $this->info('Done.');

            } catch (\Exception $e) {

                $this->error($e->getMessage());

            }

        }

        return false;
    }

    /**
     * @param array $data
     * @return array
     */
    private function parseApiData(Array $data) : array
    {
        $countries = [];

        if (
            (isset($data['status']) && $data['status'] == 'OK')
            &&
            (isset($data['data']) && count($data['data']))
        ) {
            foreach ($data['data'] as $country_code => $country_data) {
                $country_name = isset($country_data['country']) ? $country_data['country'] : 'NaN';
                $countries[] = [
                    'code' => $country_code,
                    'name' => $country_name
                ];
            }
        }

        return $countries;
    }

    /**
     * @return array
     */
    private function connectApiAndGetData() : array
    {
        try {

            $response = Http::get($this->api_url);

            if (!$response->failed()) {
                return $response->json();
            }

        } catch (\Exception $e) {
            //
        }

        return [];
    }
}
