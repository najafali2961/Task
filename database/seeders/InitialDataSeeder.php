<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Label;
use App\Models\Priority;

class InitialDataSeeder extends Seeder
{
    public function run()
    {

        $categories = [
            ['name' => 'Billing'],
            ['name' => 'Technical Support'],
            ['name' => 'Sales'],
            ['name' => 'General Inquiry'],
            ['name' => 'Account Management'],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(['name' => $category['name']]);
        }


        $labels = [
            ['name' => 'Urgent'],
            ['name' => 'Follow-up'],
            ['name' => 'New'],
            ['name' => 'Resolved'],
            ['name' => 'Pending'],
        ];

        foreach ($labels as $label) {
            Label::firstOrCreate(['name' => $label['name']]);
        }


        $priorities = [
            ['name' => 'Low'],
            ['name' => 'Medium'],
            ['name' => 'High'],
        ];

        foreach ($priorities as $priority) {
            Priority::firstOrCreate(['name' => $priority['name']]);
        }
    }
}
