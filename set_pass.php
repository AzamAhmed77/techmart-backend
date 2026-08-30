<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

$u = User::where('email', 'awyhawys@gmail.com')->first();
if ($u) {
    $u->password = Hash::make('123456');
    $u->save();
    echo "USER_FOUND_AND_PASSWORD_SET_TO_123456\n";
    echo "HASH_CHECK: " . (Hash::check('123456', $u->password) ? 'TRUE' : 'FALSE') . "\n";
} else {
    echo "USER_NOT_FOUND\n";
}
