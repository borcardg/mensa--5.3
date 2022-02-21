<?php

use App\Menu;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('menus')->delete();

        $periods = [true, false];
        $dates = ['2017-05-01', '2017-05-02', '2017-05-03', '2017-05-04', '2017-05-05'];

        foreach ($periods as $p) {
            foreach ($dates as $d) {
                $data = [
                    'date_start' => Carbon::parse($d),
                    'date_end' => Carbon::parse($d),
                    'period' => $p,
                    'isMain' => true,
                    'label_id' => 3,
                    'site_id' => 1,
                    'fr'  => ['title' => 'ASDasd', 'accompaniment' => 'asd-asd-asd'],
                    'de' => ['title' => 'ASDasd', 'accompaniment' => 'asd-asd-asd'],
                ];

                Menu::create($data);
            }
        }
    }
}
