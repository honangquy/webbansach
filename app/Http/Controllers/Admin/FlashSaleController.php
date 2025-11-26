<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FlashSale;
use App\Models\FlashSaleItem;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FlashSaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $flashSales = FlashSale::withCount('items')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('admin.flash-sales.index', compact('flashSales'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $books = Book::where('status', true)
            ->orderBy('title')
            ->get();
            
        return view('admin.flash-sales.create', compact('books'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'status' => 'required|boolean',
            'books' => 'required|array|min:1',
            'books.*.book_id' => 'required|exists:books,id',
            'books.*.flash_price' => 'required|numeric|min:0',
            'books.*.stock_quantity' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $flashSale = FlashSale::create([
                'title' => $request->title,
                'description' => $request->description,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'status' => $request->status,
            ]);

            foreach ($request->books as $bookData) {
                FlashSaleItem::create([
                    'flash_sale_id' => $flashSale->id,
                    'book_id' => $bookData['book_id'],
                    'flash_price' => $bookData['flash_price'],
                    'stock_quantity' => $bookData['stock_quantity'],
                ]);
            }

            DB::commit();
            return redirect()->route('admin.flash-sales.index')
                ->with('success', 'Flash Sale đã được tạo thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $flashSale = FlashSale::with(['items.book'])->findOrFail($id);
        return view('admin.flash-sales.show', compact('flashSale'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $flashSale = FlashSale::with('items')->findOrFail($id);
        $books = Book::where('status', true)
            ->orderBy('title')
            ->get();
            
        return view('admin.flash-sales.edit', compact('flashSale', 'books'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $flashSale = FlashSale::findOrFail($id);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'status' => 'required|boolean',
            'books' => 'required|array|min:1',
            'books.*.book_id' => 'required|exists:books,id',
            'books.*.flash_price' => 'required|numeric|min:0',
            'books.*.stock_quantity' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $flashSale->update([
                'title' => $request->title,
                'description' => $request->description,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'status' => $request->status,
            ]);

            // Delete old items and create new ones
            $flashSale->items()->delete();
            
            foreach ($request->books as $bookData) {
                FlashSaleItem::create([
                    'flash_sale_id' => $flashSale->id,
                    'book_id' => $bookData['book_id'],
                    'flash_price' => $bookData['flash_price'],
                    'stock_quantity' => $bookData['stock_quantity'],
                ]);
            }

            DB::commit();
            return redirect()->route('admin.flash-sales.index')
                ->with('success', 'Flash Sale đã được cập nhật thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $flashSale = FlashSale::findOrFail($id);
            $flashSale->delete();
            
            return redirect()->route('admin.flash-sales.index')
                ->with('success', 'Flash Sale đã được xóa thành công!');
        } catch (\Exception $e) {
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
    
    /**
     * Toggle status of flash sale
     */
    public function toggleStatus($id)
    {
        $flashSale = FlashSale::findOrFail($id);
        $flashSale->status = !$flashSale->status;
        $flashSale->save();
        
        return back()->with('success', 'Trạng thái đã được cập nhật!');
    }
}
