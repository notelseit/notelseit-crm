use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['admin.key'])->group(function() {
    Route::get('/settings', [SettingsController::class, 'show']);
    Route::post('/settings', [SettingsController::class, 'update']);
    Route::get('/users', [UsersController::class, 'index']);
    Route::post('/users', [UsersController::class, 'store']);
    Route::delete('/users/{id}', [UsersController::class, 'destroy']);
    Route::post('/send-email', [EmailController::class, 'send']);
    Route::get('/emails-history', [EmailController::class, 'history']);
    Route::get('/profile', [ProfileController::class, 'show']);
});