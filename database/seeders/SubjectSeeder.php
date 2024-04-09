<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Subject::truncate();
        $data = [
            ['class'=>'10th','subject'=>'Mathematics','branch'=>null],
            ['class'=>'10th','subject'=>'Science','branch'=>null],
            ['class'=>'10th','subject'=>'Social Science','branch'=>null],
            ['class'=>'10th','subject'=>'English','branch'=>null],

            ['class'=>'12th','subject'=>'Chemistry','branch'=>'Science'],
            ['class'=>'12th','subject'=>'Physics','branch'=>'Science'],
            ['class'=>'12th','subject'=>'Biology','branch'=>'Science'],
            ['class'=>'12th','subject'=>'Mathematics','branch'=>'Science'],

            ['class'=>'12th','subject'=>'Accountancy','branch'=>'Commerce'],
            ['class'=>'12th','subject'=>'Business Studies','branch'=>'Commerce'],
            ['class'=>'12th','subject'=>'Economics','branch'=>'Commerce'],
            ['class'=>'12th','subject'=>'English','branch'=>'Commerce'],
            ['class'=>'12th','subject'=>'Hindi','branch'=>'Commerce'],
        ];
        DB::table('subjects')->insert($data);
    }
}
