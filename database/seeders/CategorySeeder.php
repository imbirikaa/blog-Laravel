<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\str;
class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cats=['Genel','Eğlencer','Bilişim','Gezi','Teknokoji','Sağlık','Spor','Günlük Yaşam'];
        foreach ($cats as $cat) {
        DB::table('categories')->insert([
            'name' => $cat,
            'slug' => str::slug($cat),
            'created_at' => now(),
            'updated_at' => now(),
        ]);}
    }
}
