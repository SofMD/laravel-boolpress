<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Posts;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        for($i = 0; $i < 3; $i++){
            $new_post = new Posts();

            $new_post->title = 'Post title' . ($i + 1);
            $new_post->slug = Str::slug($new_post->title, '-');
            $new_post->content = 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Possimus, natus, illo consequuntur molestiae est illum minus vel repudiandae reiciendis optio fugiat itaque odio minima facilis numquam perspiciatis. Id, tenetur voluptates?';

            $new_post->save();
        }
    }
}
