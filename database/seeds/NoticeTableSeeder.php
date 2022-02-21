<?php

use App\Notice;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NoticeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('notices')->delete();

        $dates = ['2017-05-02', '2017-05-04'];

        foreach ($dates as $d) {
            $data = [
                'date_start' => Carbon::parse($d),
                'date_end' => Carbon::parse($d),
                'isImportant' => false,
                'site_id' => 1,
                'fr'  => ['title' => 'Grande réservation', 'content' => 'asd-asd-asd'],
                'de' => ['title' => 'Grosse Buchung', 'content' => 'asd-asd-asd'],
            ];

            Notice::create($data);
        }
    }
}
