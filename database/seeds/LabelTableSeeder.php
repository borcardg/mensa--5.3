<?php

use App\Label;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LabelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('labels')->delete();

        Label::create(['price' => '8.50',
            'fr'  => ['name' => 'Menu 1'],
            'de' => ['name' => 'Menü 1'], ]);

        Label::create(['price' => '7.50',
            'fr'  => ['name' => 'Menu 2'],
            'de' => ['name' => 'Menü 2'], ]);

        Label::create(['price' => '7.50',
            'fr'  => ['name' => 'Végératien 1'],
            'de' => ['name' => 'Vegetarier 1'], ]);
    }
}
