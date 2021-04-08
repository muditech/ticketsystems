<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\TicketPriority;
use App\Models\Ticket;
use \App\Models\User;
use App\Models\TicketStatus;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        try {

            TicketStatus::insert([
                ['name' => 'Open'],
                ['name' => 'Closed'],
            ]);

            TicketPriority::insert([
                ['name' => 'Low'],
                ['name' => 'Medium'],
                ['name' => 'High'],
            ]);

            Artisan::call('ticketsystems:get_countries');

            User::factory()
                ->count(5)
                ->has(
                    Ticket::factory()
                        ->count(7)
                        ->state(new Sequence(
                            fn () => ['status_id' => TicketStatus::all('id')->random()],
                        ))
                        ->state(new Sequence(
                            fn () => ['priority_id' => TicketPriority::all('id')->random()],
                        ))
                        ->state(new Sequence(
                            fn () => ['country_id' => Country::all('id')->random()],
                        )),
                    'tickets'
                )
                ->create();

        } catch (\Exception $e) {
            echo $e->getMessage().PHP_EOL;
        }

    }
}
