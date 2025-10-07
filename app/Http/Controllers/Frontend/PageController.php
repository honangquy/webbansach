<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PageController extends Controller
{
    /**
     * Display the about page.
     */
    public function about()
    {
        return view('frontend.pages.about');
    }

    /**
     * Display the contact page.
     */
    public function contact()
    {
        return view('frontend.pages.contact');
    }

    /**
     * Send contact form.
     */
    public function sendContact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
        ], [
            'name.required' => 'Vui lòng nhập họ tên',
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không hợp lệ',
            'subject.required' => 'Vui lòng nhập tiêu đề',
            'message.required' => 'Vui lòng nhập nội dung',
            'message.min' => 'Nội dung phải có ít nhất 10 ký tự',
        ]);

        // Here you can send email or save to database
        // For now, we'll just return success message
        
        return redirect()->route('contact')->with('success', 'Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi trong thời gian sớm nhất.');
    }
}
