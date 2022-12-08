<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Helpers\ConectadosApi;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $users = ConectadosApi::getRequest(['token' => env('conectadosweb_token')]);

        $contador = 5;

        foreach ($users['data'] as $user){

            $info = User::create([
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'segmentation_id' => $user['segmentation_id'],
                'program_id' => $user['program_id'],
                'birth_date' => $user['birth_date'],
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            ]);
            $contador++;

            $transactions = ConectadosApi::getRequest(['token' => env('conectadosweb_token'), 'client_id' => $user['user_id']]);

            $transactions = $transactions['data'];

            $data = [];

            if (count($transactions)) {

                foreach ($transactions as $transaction) {
                    if ($transaction['client_id']) {
                        $row['user_id'] = $info->id;
                        $row['transaction_detail'] = $transaction['transaction_detail'] ?? null;
                        $row['amount'] = $transaction['amount'] ?? null;
                        $data[] = $row;
                    }
                }
            }

            $info->transaction()->createMany($data);
        }
    }
}
