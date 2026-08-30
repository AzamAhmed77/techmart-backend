<?php
require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Http\Kernel')->bootstrap();

use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Message;

echo "Testing SMTP connection to smtp.gmail.com:587...\n";

try {
    Mail::raw('رمز التحقق الخاص بك: 123456', function (Message $message) {
        $message->to('awyhawys@gmail.com')
                ->subject('[TECH MART] رمز التحقق');
    });
    echo "SUCCESS: Email sent!\n";
} catch (\Throwable $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
