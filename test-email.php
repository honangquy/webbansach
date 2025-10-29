<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    \Illuminate\Support\Facades\Mail::raw('This is a test email from BookStore password reset system.', function($message) {
        $message->to('test@example.com')
                ->subject('Test Email - BookStore');
    });
    
    echo "✅ Email sent successfully!\n";
    echo "Check your email catcher:\n";
    echo "- Mailpit: http://localhost:8025\n";
    echo "- Mailtrap: Check your inbox\n";
    echo "- Gmail: Check your inbox\n";
} catch (\Exception $e) {
    echo "❌ Error sending email:\n";
    echo $e->getMessage() . "\n";
    echo "\nPlease check your .env mail configuration.\n";
}
