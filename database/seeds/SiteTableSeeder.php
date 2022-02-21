<?php

use App\Site;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SiteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sites')->delete();

        $data = [
            'isCafet' => false,
            'fr'  => ['name' => 'Mensa Miséricorde', 'address' => 'Ici l\'adresse'],
            'de' => ['name' => 'Mensa Miséricorde', 'address' => 'Hier die Adresse'],
        ];

        Site::create($data);
    }
}
