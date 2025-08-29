<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\BookItem;
use App\Models\Book;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $books = [
            [
                'title' => 'The Art of Clean Code',
                'author' => 'Robert C. Martin',
                'description' => 'A comprehensive guide to writing clean, readable, and maintainable code. This book teaches developers how to write code that is easy to understand and modify.',
                'publisher' => 'Prentice Hall',
                'year' => 2008,
                'isbn' => '978-0132350884',
                'category_id' => 1, // Technology
                'rental_price' => 25000.00,
                'stock' => 4,
                'cover_image' => 'covers/clean-code.jpg',
            ],
            [
                'title' => 'JavaScript: The Good Parts',
                'author' => 'Douglas Crockford',
                'description' => 'This book focuses on the good ideas that make JavaScript an outstanding object-oriented programming language.',
                'publisher' => 'O\'Reilly Media',
                'year' => 2008,
                'isbn' => '978-0596517748',
                'category_id' => 1, // Technology
                'rental_price' => 20000.00,
                'stock' => 5,
                'cover_image' => 'covers/javascript-good-parts.jpg',
            ],
            [
                'title' => 'Atomic Habits',
                'author' => 'James Clear',
                'description' => 'An easy and proven way to build good habits and break bad ones. Learn how tiny changes can make a remarkable difference.',
                'publisher' => 'Avery',
                'year' => 2018,
                'isbn' => '978-0735211292',
                'category_id' => 2, // Health & Wellness
                'rental_price' => 15000.00,
                'stock' => 6,
                'cover_image' => 'covers/atomic-habits.jpg',
            ],
            [
                'title' => 'The Psychology of Learning',
                'author' => 'Dr. Sarah Johnson',
                'description' => 'Understanding how the brain processes and retains information. Essential reading for educators and students alike.',
                'publisher' => 'Academic Press',
                'year' => 2020,
                'isbn' => '978-0123456789',
                'category_id' => 3, // Education
                'rental_price' => 30000.00,
                'stock' => 3,
                'cover_image' => 'covers/psychology-learning.jpg',
            ],
            [
                'title' => 'Peak Performance Training',
                'author' => 'Michael Thompson',
                'description' => 'Advanced training techniques for athletes looking to maximize their potential and achieve peak performance.',
                'publisher' => 'Sports Media',
                'year' => 2019,
                'isbn' => '978-0987654321',
                'category_id' => 4, // Sports & Fitness
                'rental_price' => 22000.00,
                'stock' => 4,
                'cover_image' => 'covers/peak-performance.jpg',
            ],
            [
                'title' => 'Culinary Fundamentals',
                'author' => 'Chef Maria Rodriguez',
                'description' => 'Master the basic techniques and principles that form the foundation of great cooking.',
                'publisher' => 'Culinary Institute',
                'year' => 2021,
                'isbn' => '978-0456789123',
                'category_id' => 5, // Food & Beverage
                'rental_price' => 35000.00,
                'stock' => 2,
                'cover_image' => 'covers/culinary-fundamentals.jpg',
            ],
            [
                'title' => 'Sustainable Fashion Revolution',
                'author' => 'Emma Watson',
                'description' => 'Exploring the future of fashion industry with focus on sustainability and ethical practices.',
                'publisher' => 'Green Publishing',
                'year' => 2022,
                'isbn' => '978-0789123456',
                'category_id' => 6, // Fashion
                'rental_price' => 28000.00,
                'stock' => 3,
                'cover_image' => 'covers/sustainable-fashion.jpg',
            ],
            [
                'title' => 'Hidden Gems of Southeast Asia',
                'author' => 'David Kim',
                'description' => 'Discover breathtaking destinations and cultural treasures across Southeast Asia that most tourists never see.',
                'publisher' => 'Travel World',
                'year' => 2023,
                'isbn' => '978-0321654987',
                'category_id' => 7, // Travel & Tourism
                'rental_price' => 32000.00,
                'stock' => 5,
                'cover_image' => 'covers/hidden-gems-asia.jpg',
            ],
            [
                'title' => 'The Art of Storytelling',
                'author' => 'Lisa Chen',
                'description' => 'Learn the timeless techniques used by master storytellers to captivate audiences and create memorable narratives.',
                'publisher' => 'Creative Arts Press',
                'year' => 2020,
                'isbn' => '978-0654321098',
                'category_id' => 8, // Entertainment
                'rental_price' => 18000.00,
                'stock' => 4,
                'cover_image' => 'covers/art-storytelling.jpg',
            ],
            [
                'title' => 'Entrepreneurship in Digital Age',
                'author' => 'Mark Stevens',
                'description' => 'A practical guide to building successful startups and businesses in the modern digital economy.',
                'publisher' => 'Business Weekly',
                'year' => 2021,
                'isbn' => '978-0147258369',
                'category_id' => 9, // Business
                'rental_price' => 40000.00,
                'stock' => 3,
                'cover_image' => 'covers/digital-entrepreneurship.jpg',
            ],
            [
                'title' => 'Electric Vehicle Revolution',
                'author' => 'Tom Anderson',
                'description' => 'Understanding the technology, market trends, and environmental impact of electric vehicles.',
                'publisher' => 'Auto Tech Media',
                'year' => 2022,
                'isbn' => '978-0852741963',
                'category_id' => 10, // Automotive
                'rental_price' => 27000.00,
                'stock' => 2,
                'cover_image' => 'covers/ev-revolution.jpg',
            ],
            [
                'title' => 'Real Estate Investment Guide',
                'author' => 'Jennifer Wilson',
                'description' => 'Complete handbook for beginners and experienced investors in residential and commercial real estate.',
                'publisher' => 'Property Press',
                'year' => 2023,
                'isbn' => '978-0963852741',
                'category_id' => 11, // Real Estate
                'rental_price' => 38000.00,
                'stock' => 3,
                'cover_image' => 'covers/real-estate-guide.jpg',
            ],
            [
                'title' => 'Personal Finance Mastery',
                'author' => 'Robert Brown',
                'description' => 'Learn how to manage your money, invest wisely, and build long-term wealth through proven strategies.',
                'publisher' => 'Financial Wisdom',
                'year' => 2021,
                'isbn' => '978-0741852963',
                'category_id' => 12, // Finance
                'rental_price' => 19000.00,
                'stock' => 5,
                'cover_image' => 'covers/finance-mastery.jpg',
            ],
            [
                'title' => 'Modern Art Movements',
                'author' => 'Dr. Elena Rossi',
                'description' => 'Explore the evolution of contemporary art from impressionism to digital art, understanding cultural and social influences.',
                'publisher' => 'Art History Press',
                'year' => 2020,
                'isbn' => '978-0369741852',
                'category_id' => 13, // Arts & Culture
                'rental_price' => 42000.00,
                'stock' => 2,
                'cover_image' => 'covers/modern-art-movements.jpg',
            ],
            [
                'title' => 'Game Development Fundamentals',
                'author' => 'Alex Turner',
                'description' => 'Learn the core principles of game design, programming, and development from concept to launch.',
                'publisher' => 'GameDev Studios',
                'year' => 2022,
                'isbn' => '978-0147963852',
                'category_id' => 14, // Gaming
                'rental_price' => 45000.00,
                'stock' => 4,
                'cover_image' => 'covers/game-dev-fundamentals.jpg',
            ],
            [
                'title' => 'Natural Skincare Science',
                'author' => 'Dr. Amanda Lee',
                'description' => 'Understanding skin health and natural ingredients for effective skincare routines backed by scientific research.',
                'publisher' => 'Beauty Science',
                'year' => 2023,
                'isbn' => '978-0258147369',
                'category_id' => 15, // Beauty & Skincare
                'rental_price' => 26000.00,
                'stock' => 6,
                'cover_image' => 'covers/natural-skincare.jpg',
            ],
        ];

        foreach ($books as $data) {
            $stock = $data['stock'];
            unset($data['stock']); 

            // insert books
            $book = Book::updateOrCreate(
                ['isbn' => $data['isbn']],
                array_merge($data, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );

            // insert book items 
            for ($i = 0; $i < $stock; $i++) {
                BookItem::create(
                    [
                        'book_id' => $book->id,
                        'status' => 'available',
                    ]
                );
            }
        }
    }
}