<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'name' => 'Tiểu thuyết',
                'description' => 'Sách tiểu thuyết trong nước và nước ngoài'
            ],
            [
                'name' => 'Sách giáo khoa',
                'description' => 'Sách giáo khoa các cấp học'
            ],
            [
                'name' => 'Kinh tế - Quản lý',
                'description' => 'Sách về kinh tế, quản lý doanh nghiệp'
            ],
            [
                'name' => 'Khoa học kỹ thuật',
                'description' => 'Sách về khoa học, công nghệ, kỹ thuật'
            ],
            [
                'name' => 'Văn học Việt Nam',
                'description' => 'Tác phẩm văn học của các tác giả Việt Nam'
            ],
            [
                'name' => 'Sách thiếu nhi',
                'description' => 'Sách dành cho trẻ em và thiếu niên'
            ],
            [
                'name' => 'Tâm lý - Kỹ năng sống',
                'description' => 'Sách về tâm lý học và kỹ năng sống'
            ],
            [
                'name' => 'Lịch sử',
                'description' => 'Sách về lịch sử Việt Nam và thế giới'
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
