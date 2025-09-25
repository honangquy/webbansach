<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Category;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = Category::all();
        
        $books = [
            [
                'title' => 'Đắc Nhân Tâm',
                'author' => 'Dale Carnegie',
                'category_id' => $categories->where('name', 'Tâm lý - Kỹ năng sống')->first()->id,
                'description' => 'Cuốn sách kinh điển về nghệ thuật giao tiếp và ứng xử. Đây là một trong những cuốn sách bán chạy nhất mọi thời đại.',
                'isbn' => '9786049522123',
                'pages' => 320,
                'publisher' => 'NXB Tổng hợp TPHCM',
                'publish_date' => '2018-01-15',
                'price' => 89000,
                'sale_price' => 75000,
                'stock_quantity' => 50,
                'featured' => true,
                'status' => true,
            ],
            [
                'title' => 'Nhà Giả Kim',
                'author' => 'Paulo Coelho',
                'category_id' => $categories->where('name', 'Tiểu thuyết')->first()->id,
                'description' => 'Câu chuyện về hành trình tìm kiếm kho báu của một cậu bé chăn cừu. Một tác phẩm đầy triết lý về cuộc sống.',
                'isbn' => '9786041141234',
                'pages' => 163,
                'publisher' => 'NXB Hội Nhà văn',
                'publish_date' => '2020-03-10',
                'price' => 79000,
                'sale_price' => null,
                'stock_quantity' => 30,
                'featured' => true,
                'status' => true,
            ],
            [
                'title' => 'Tư Duy Nhanh Và Chậm',
                'author' => 'Daniel Kahneman',
                'category_id' => $categories->where('name', 'Tâm lý - Kỹ năng sống')->first()->id,
                'description' => 'Cuốn sách khám phá cách thức hoạt động của tư duy con người thông qua hai hệ thống tư duy.',
                'isbn' => '9786049876543',
                'pages' => 624,
                'publisher' => 'NXB Thế Giới',
                'publish_date' => '2019-08-20',
                'price' => 299000,
                'sale_price' => 249000,
                'stock_quantity' => 15,
                'featured' => false,
                'status' => true,
            ],
            [
                'title' => 'Lập Trình Web với Laravel',
                'author' => 'Nguyễn Văn A',
                'category_id' => $categories->where('name', 'Khoa học kỹ thuật')->first()->id,
                'description' => 'Hướng dẫn chi tiết về framework Laravel từ cơ bản đến nâng cao. Phù hợp cho sinh viên và lập trình viên.',
                'isbn' => '9786012345678',
                'pages' => 450,
                'publisher' => 'NXB Khoa học kỹ thuật',
                'publish_date' => '2023-05-15',
                'price' => 189000,
                'sale_price' => 159000,
                'stock_quantity' => 25,
                'featured' => false,
                'status' => true,
            ],
            [
                'title' => 'Lịch Sử Việt Nam',
                'author' => 'Trần Trọng Kim',
                'category_id' => $categories->where('name', 'Lịch sử')->first()->id,
                'description' => 'Tổng quan về lịch sử Việt Nam từ thời cổ đại đến hiện đại. Tác phẩm kinh điển của sử học Việt Nam.',
                'isbn' => '9786098765432',
                'pages' => 580,
                'publisher' => 'NXB Sử học',
                'publish_date' => '2021-10-30',
                'price' => 149000,
                'sale_price' => null,
                'stock_quantity' => 20,
                'featured' => false,
                'status' => true,
            ],
            [
                'title' => 'Toán Cao Cấp A1',
                'author' => 'PGS. Nguyễn Đình Trí',
                'category_id' => $categories->where('name', 'Sách giáo khoa')->first()->id,
                'description' => 'Giáo trình Toán cao cấp dành cho sinh viên năm thứ nhất các trường đại học kỹ thuật.',
                'isbn' => '9786045678901',
                'pages' => 380,
                'publisher' => 'NXB Đại học Quốc gia',
                'publish_date' => '2022-08-01',
                'price' => 120000,
                'sale_price' => 99000,
                'stock_quantity' => 100,
                'featured' => false,
                'status' => true,
            ],
            [
                'title' => 'Kinh Tế Học Vi Mô',
                'author' => 'Gregory Mankiw',
                'category_id' => $categories->where('name', 'Kinh tế - Quản lý')->first()->id,
                'description' => 'Giáo trình kinh tế học vi mô được sử dụng rộng rãi trong các trường đại học trên thế giới.',
                'isbn' => '9786087654321',
                'pages' => 520,
                'publisher' => 'NXB Kinh tế',
                'publish_date' => '2023-01-20',
                'price' => 259000,
                'sale_price' => 219000,
                'stock_quantity' => 40,
                'featured' => true,
                'status' => true,
            ],
            [
                'title' => 'Truyện Kiều',
                'author' => 'Nguyễn Du',
                'category_id' => $categories->where('name', 'Văn học Việt Nam')->first()->id,
                'description' => 'Tác phẩm bất hủ của đại thi hào Nguyễn Du. Kiệt tác văn học cổ điển Việt Nam.',
                'isbn' => '9786011111111',
                'pages' => 200,
                'publisher' => 'NXB Văn học',
                'publish_date' => '2020-12-15',
                'price' => 59000,
                'sale_price' => null,
                'stock_quantity' => 60,
                'featured' => true,
                'status' => true,
            ],
            [
                'title' => 'Doraemon - Nobita Và Hành Tinh Màu Tím',
                'author' => 'Fujiko F. Fujio',
                'category_id' => $categories->where('name', 'Sách thiếu nhi')->first()->id,
                'description' => 'Cuộc phiêu lưu mới của Doraemon và Nobita trên hành tinh màu tím đầy bí ẩn.',
                'isbn' => '9786022222222',
                'pages' => 180,
                'publisher' => 'NXB Kim Đồng',
                'publish_date' => '2023-07-10',
                'price' => 45000,
                'sale_price' => 39000,
                'stock_quantity' => 80,
                'featured' => false,
                'status' => true,
            ],
            [
                'title' => 'Harry Potter và Hòn Đá Phù Thủy',
                'author' => 'J.K. Rowling',
                'category_id' => $categories->where('name', 'Tiểu thuyết')->first()->id,
                'description' => 'Cuộc phiêu lưu đầu tiên của cậu bé phù thủy Harry Potter tại trường Hogwarts.',
                'isbn' => '9786033333333',
                'pages' => 350,
                'publisher' => 'NXB Trẻ',
                'publish_date' => '2019-11-25',
                'price' => 129000,
                'sale_price' => 109000,
                'stock_quantity' => 35,
                'featured' => true,
                'status' => true,
            ]
        ];

        foreach ($books as $book) {
            Book::create($book);
        }
    }
}
