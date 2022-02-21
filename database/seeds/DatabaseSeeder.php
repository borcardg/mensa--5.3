<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Model::unguard();

        $this->call('SiteTableSeeder');
        $this->command->info('Site table seeded!');

        $this->call('LabelTableSeeder');
        $this->command->info('Label table seeded!');

        $this->call('NoticeTableSeeder');
        $this->command->info('Notice table seeded!');

        $this->call('MenuTableSeeder');
        $this->command->info('Menu table seeded!');
    }
}
