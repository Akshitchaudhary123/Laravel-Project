<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Book::truncate();
        $data = [
            // mathematics
            ['class'=>'10th','subject'=>'Mathematics','chapter'=>'Chapter 1','chapter_name'=>'Real Numbers','url'=>'https://res.cloudinary.com/dlpxw0zdc/image/upload/v1712772291/Books/sw8onw3t0xadzwqyrql1.pdf','branch'=>null],
            ['class'=>'10th','subject'=>'Mathematics','chapter'=>'Chapter 2','chapter_name'=>'Polynomials','url'=>'','branch'=>null],
            ['class'=>'10th','subject'=>'Mathematics','chapter'=>'Chapter 3','chapter_name'=>'Pair of Linear Equations in Two Variables','url'=>'','branch'=>null],
            ['class'=>'10th','subject'=>'Mathematics','chapter'=>'Chapter 4','chapter_name'=>'Quadratic Equations','url'=>'','branch'=>null],
            ['class'=>'10th','subject'=>'Mathematics','chapter'=>'Chapter 5','chapter_name'=>'Arithmetic Progressions','url'=>'','branch'=>null],
            ['class'=>'10th','subject'=>'Mathematics','chapter'=>'Chapter 6','chapter_name'=>'Triangles','url'=>'','branch'=>null],
            ['class'=>'10th','subject'=>'Mathematics','chapter'=>'Chapter 7','chapter_name'=>'Coordinate Geometry','url'=>'','branch'=>null],
            ['class'=>'10th','subject'=>'Mathematics','chapter'=>'Chapter 8','chapter_name'=>'Introduction to Trigonometry','url'=>'','branch'=>null],
            ['class'=>'10th','subject'=>'Mathematics','chapter'=>'Chapter 9','chapter_name'=>'Some Applications of Trigonometry','url'=>'','branch'=>null],
            ['class'=>'10th','subject'=>'Mathematics','chapter'=>'Chapter 10','chapter_name'=>'Circles','url'=>'','branch'=>null],
            ['class'=>'10th','subject'=>'Mathematics','chapter'=>'Chapter 11','chapter_name'=>'Constructions','url'=>'','branch'=>null],
            ['class'=>'10th','subject'=>'Mathematics','chapter'=>'Chapter 12','chapter_name'=>'Areas Related to Circles','url'=>'','branch'=>null],
            ['class'=>'10th','subject'=>'Mathematics','chapter'=>'Chapter 13','chapter_name'=>'Surface Areas and Volumes','url'=>'','branch'=>null],
            ['class'=>'10th','subject'=>'Mathematics','chapter'=>'Chapter 14','chapter_name'=>'Statistics','url'=>'','branch'=>null],
            ['class'=>'10th','subject'=>'Mathematics','chapter'=>'Chapter 15','chapter_name'=>'Probability','url'=>'','branch'=>null],
            // physic
            ['class'=>'10th','subject'=>'Science','chapter'=>'Chapter 1','chapter_name'=>'Light - Reflection and Refraction','url'=>'','branch'=>null],
            ['class'=>'10th','subject'=>'Science','chapter'=>'Chapter 1','chapter_name'=>'Human Eye and Colourful World','url'=>'','branch'=>null],
            ['class'=>'10th','subject'=>'Science','chapter'=>'Chapter 1','chapter_name'=>'Electricity','url'=>'','branch'=>null],
            ['class'=>'10th','subject'=>'Science','chapter'=>'Chapter 1','chapter_name'=>'Magnetic Effects of Electric Current','url'=>'','branch'=>null],
            // chemistry
            ['class'=>'10th','subject'=>'Science','chapter'=>'Chapter 1','chapter_name'=>'Chemical Reactions and Equations','url'=>'','branch'=>null],
            ['class'=>'10th','subject'=>'Science','chapter'=>'Chapter 1','chapter_name'=>'Acids, Bases, and Salts','url'=>'','branch'=>null],
            ['class'=>'10th','subject'=>'Science','chapter'=>'Chapter 1','chapter_name'=>'Metals and Non-Metals','url'=>'','branch'=>null],
            ['class'=>'10th','subject'=>'Science','chapter'=>'Chapter 1','chapter_name'=>'Carbon and its Compounds','url'=>'','branch'=>null],
            // biology
            ['class'=>'10th','subject'=>'Science','chapter'=>'Chapter 1','chapter_name'=>'Life Processes','url'=>'','branch'=>null],
            ['class'=>'10th','subject'=>'Science','chapter'=>'Chapter 1','chapter_name'=>'Control and Coordination','url'=>'','branch'=>null],
            ['class'=>'10th','subject'=>'Science','chapter'=>'Chapter 1','chapter_name'=>'How do Organisms Reproduce?','url'=>'','branch'=>null],
            ['class'=>'10th','subject'=>'Science','chapter'=>'Chapter 1','chapter_name'=>'Heredity and Evolution','url'=>'','branch'=>null],
            ['class'=>'10th','subject'=>'Science','chapter'=>'Chapter 1','chapter_name'=>'Our Environment','url'=>'','branch'=>null],
            ['class'=>'10th','subject'=>'Science','chapter'=>'Chapter 1','chapter_name'=>'Management of Natural Resources','url'=>'','branch'=>null],
            
            
            
            // ['class'=>'12th','subject'=>'Mathematics','chapter'=>'Chapter 1','chapter_name'=>'','url'=>'','branch'=>'Science'],
            
            



            
            // ['class'=>'12th','subject'=>'Mathematics','chapter'=>'Chapter 1','chapter_name'=>'','url'=>'','branch'=>'Commerce'],
        ];
        DB::table('books')->insert($data);
    }
}
