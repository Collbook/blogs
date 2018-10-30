<?php

use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $title = 'Hosted Metrics and Notifications';
        $body = 'What exactly does that mean? Think of it as a simple version of sentry.io or rollbar.com. Consisting of a series of watchers keeping an eye on model changes, log entries, and route requests, Larametrics alerts you through email or Slack when one of your notification triggers is met.';

        $title2 = 'Larametrics is an open-source self-hosted';
        $body2 = 'Larametrics is an open-source self-hosted metrics and notifications platform for Laravel apps created by Andrew Schmelyun. It’s simple to get started and only takes a few minutes to get started. The official Getting Started documentation describes Larametrics as follows';

        $title3 = 'Lighthouse is a PHP package that allows';
        $body3 = 'Lighthouse is a PHP package that allows you to serve a GraphQL endpoint from your Laravel application. It aims to reduce boilerplate code around creating a schema and integrates well with your existing Laravel application.';

        $title4 = 'Check out the complete list of Directives';
        $body4 = 'Check out the complete list of Directives that ship with Lighthouse if you’re already familiar with GraphQL and you want to dive into schema development. It will help you to be familiar with GraphQL before starting to work with Lighthouse, but it seems to be like an excellent package for integrating GraphQL in Laravel';

        $title5 = 'If you are not familiar with GraphQL';
        $body5 = 'If you are not familiar with GraphQL, check out the official GraphQL website for a complete overview. Wes Bos recently released Fullstack Advanced React and GraphQL which teaches you advanced React patterns, but also covers using GraphQL on the server and client-side.';
        
        $title6 = 'To learn more about Lighthouse and start integrating';
        $body6 = 'To learn more about Lighthouse and start integrating it as a GraphQL server for your Laravel apps, check out the Lighthouse documentation and the Lighthouse GraphQL Server code on GitHub which teaches you advanced React patterns, but also covers using GraphQL on the server and client-side';


        DB::table('posts')->insert([
            'user_id' => '1',
            'title'    => $title,
            'slug' =>  str_slug($title),
            'image'    => 'default.jpg',
            'body' => $body,
            'view_count' => '1',
            'status'    => '1',
            'is_approved' => '1',
            'created_at'  => '2018-10-30 16:58:11',
            'updated_at'  => '2018-10-30 18:58:11'
        ]);

        DB::table('posts')->insert([
            'user_id' => '2',
            'title'    => $title2,
            'slug' =>  str_slug($title2),
            'image'    => 'default.jpg',
            'body' => $body2,
            'view_count' => '1',
            'status'    => '1',
            'is_approved' => '1',
            'created_at'  => '2018-10-30 16:58:11',
            'updated_at'  => '2018-10-30 18:58:11'
        ]);

        DB::table('posts')->insert([
            'user_id' => '1',
            'title'    => $title3,
            'slug' =>  str_slug($title3),
            'image'    => 'default.jpg',
            'body' => $body3,
            'view_count' => '1',
            'status'    => '1',
            'is_approved' => '1',
            'created_at'  => '2018-10-30 16:58:11',
            'updated_at'  => '2018-10-30 18:58:11'
        ]);
        DB::table('posts')->insert([
            'user_id' => '2',
            'title'    => $title4,
            'slug' =>  str_slug($title4),
            'image'    => 'default.jpg',
            'body' => $body4,
            'view_count' => '1',
            'status'    => '1',
            'is_approved' => '1',
            'created_at'  => '2018-10-30 16:58:11',
            'updated_at'  => '2018-10-30 18:58:11'
        ]);
        DB::table('posts')->insert([
            'user_id' => '1',
            'title'    => $title5,
            'slug' =>  str_slug($title5),
            'image'    => 'default.jpg',
            'body' => $body5,
            'view_count' => '1',
            'status'    => '1',
            'is_approved' => '1',
            'created_at'  => '2018-10-30 16:58:11',
            'updated_at'  => '2018-10-30 18:58:11'
        ]);
        DB::table('posts')->insert([
            'user_id' => '2',
            'title'    => $title6,
            'slug' =>  str_slug($title6),
            'image'    => 'default.jpg',
            'body' => $body6,
            'view_count' => '1',
            'status'    => '1',
            'is_approved' => '1',
            'created_at'  => '2018-10-30 16:58:11',
            'updated_at'  => '2018-10-30 18:58:11'
        ]);
    }
}
