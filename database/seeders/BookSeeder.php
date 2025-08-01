<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $books = [
            [
                'title' => 'Atomic Habits',
                'author' => 'James Clear',
                'description' => 'A guide to building good habits and breaking bad ones.',
                'publisher' => 'Avery',
                'year' => '2018',
                'isbn' => '9780735211292',
                'category_id' => 1,
                'rental_price' => 15000.00,
                'stock' => 5,
                'cover_image' => 'atomic_habits.jpg',
            ],
            [
                'title' => 'Clean Code',
                'author' => 'Robert C. Martin',
                'description' => 'A handbook of agile software craftsmanship.',
                'publisher' => 'Prentice Hall',
                'year' => '2008',
                'isbn' => '9780132350884',
                'category_id' => 2,
                'rental_price' => 20000.00,
                'stock' => 3,
                'cover_image' => 'clean_code.jpg',
            ],
            [
                'title' => 'The Pragmatic Programmer',
                'author' => 'Andrew Hunt & David Thomas',
                'description' => 'Your journey to mastery in software development.',
                'publisher' => 'Addison-Wesley',
                'year' => '1999',
                'isbn' => '9780201616224',
                'category_id' => 2,
                'rental_price' => 18000.00,
                'stock' => 4,
                'cover_image' => 'pragmatic_programmer.jpg',
            ],
            [
                'title' => 'Deep Work',
                'author' => 'Cal Newport',
                'description' => 'Rules for focused success in a distracted world.',
                'publisher' => 'Grand Central Publishing',
                'year' => '2016',
                'isbn' => '9781455586691',
                'category_id' => 1,
                'rental_price' => 16000.00,
                'stock' => 6,
                'cover_image' => 'deep_work.jpg',
            ],
            [
                'title' => 'Thinking, Fast and Slow',
                'author' => 'Daniel Kahneman',
                'description' => 'A groundbreaking tour of the mind.',
                'publisher' => 'Farrar, Straus and Giroux',
                'year' => '2011',
                'isbn' => '9780374533557',
                'category_id' => 1,
                'rental_price' => 17000.00,
                'stock' => 2,
                'cover_image' => 'thinking_fast_and_slow.jpg',
            ],
            [
                'title' => 'The Clean Coder',
                'author' => 'Robert C. Martin',
                'description' => 'A code of conduct for professional programmers.',
                'publisher' => 'Prentice Hall',
                'year' => '2011',
                'isbn' => '9780137081073',
                'category_id' => 2,
                'rental_price' => 19500.00,
                'stock' => 3,
                'cover_image' => 'the_clean_coder.jpg',
            ],
            [
                'title' => 'Refactoring',
                'author' => 'Martin Fowler',
                'description' => 'Improving the design of existing code.',
                'publisher' => 'Addison-Wesley',
                'year' => '1999',
                'isbn' => '9780201485677',
                'category_id' => 2,
                'rental_price' => 18500.00,
                'stock' => 4,
                'cover_image' => 'refactoring.jpg',
            ],
            [
                'title' => 'Design Patterns',
                'author' => 'Erich Gamma, et al.',
                'description' => 'Elements of reusable object-oriented software.',
                'publisher' => 'Addison-Wesley',
                'year' => '1994',
                'isbn' => '9780201633610',
                'category_id' => 2,
                'rental_price' => 22000.00,
                'stock' => 2,
                'cover_image' => 'design_patterns.jpg',
            ],
            [
                'title' => 'Don’t Make Me Think',
                'author' => 'Steve Krug',
                'description' => 'A common sense approach to web usability.',
                'publisher' => 'New Riders Publishing',
                'year' => '2000',
                'isbn' => '9780789723109',
                'category_id' => 3,
                'rental_price' => 16000.00,
                'stock' => 5,
                'cover_image' => 'dont_make_me_think.jpg',
            ],
            [
                'title' => 'Zero to One',
                'author' => 'Peter Thiel',
                'description' => 'Notes on startups and how to build the future.',
                'publisher' => 'Crown Business',
                'year' => '2014',
                'isbn' => '9780804139298',
                'category_id' => 1,
                'rental_price' => 15000.00,
                'stock' => 6,
                'cover_image' => 'zero_to_one.jpg',
            ],
        ];

        foreach ($books as $book) {
            DB::table('books')->updateOrInsert(
                ['isbn' => $book['isbn']],
                array_merge($book, [
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ])
            );
        }
    }
}
