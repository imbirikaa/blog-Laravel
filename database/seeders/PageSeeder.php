<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\str;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = ['Hakkımızda', 'Kariyer', 'Vizyonumuz', 'Misyonumuz'];
        $count = 0;
        foreach ($pages as $page) {
            $count++;
            DB::table('pages')->insert([
                'title' => $page,
                'slug' => str::slug($page),
                'image' => 'https://online.hbs.edu/Style%20Library/api/resize.aspx?imgpath=/PublishingImages/overhead-view-of-business-strategy-meeting.jpg&w=1200&h=630',
                'order' => $count,
                'content' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. 
            Doloremque ipsum provident pariatur aliquam repellat facere porro quae 
            accusantium? Obcaecati reprehenderit quas velit ducimus quam mollitia 
            repudiandae fugiat nam pariatur maxime!",
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
