<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Faq::create([
            'category' => 'Healthy',
            'question' => "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quae, asperiores.",
            'answer' => "Lorem, ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis ducimus ipsum porro, incidunt rerum laboriosam id voluptatem itaque doloribus, perferendis illo, quisquam beatae? Fuga optio dolorum quam adipisci, dicta aliquam."
        ]);
    }
}
