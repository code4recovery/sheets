<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Http\Controllers\FeedController;
use Illuminate\Http\Request;


Route::get('/', function () {
    return Auth::check() ?
        redirect()->action([FeedController::class, 'index']) :
        view('welcome');
})->name('login');

Route::middleware('auth')->prefix('feeds')->name('feeds.')->group(function () {
    Route::get('/', [FeedController::class, 'index'])->name('index');
    Route::get('/create', [FeedController::class, 'create'])->name('create');
    Route::post('/', [FeedController::class, 'store'])->name('store');
    Route::get('/{slug}', [FeedController::class, 'show'])->name('show');
    Route::get('/{slug}/edit', [FeedController::class, 'edit'])->name('edit');
    Route::put('/{slug}', [FeedController::class, 'update'])->name('update');
    Route::delete('/{slug}', [FeedController::class, 'destroy'])->name('destroy');
    Route::get('/{slug}/refresh', [FeedController::class, 'refresh'])->name('refresh');
});

Route::post('publish', function (Request $request) {
    $filename = Str::slug($request->name);
    FeedController::generate($request->id, $filename);
    return [
        'url' => env('APP_URL') . '/storage/' . $filename,
    ];
});

Route::get('/auth/redirect', function () {
    return Socialite::driver('google')->redirect();
});

Route::get('/auth/callback', function () {

    //todo what if this fails
    $profile = Socialite::driver('google')->user();

    //create or update user info
    $user = User::firstOrNew(['email' => $profile->email]);
    $user->name = $profile->name;
    $user->avatar = $profile->avatar;
    $user->locale = $profile->user['locale'];
    $user->google_id = $profile->id;
    $user->token = $profile->token;
    //$profile->refreshToken,
    //$profile->expiresIn,
    $user->save();

    //log user in
    Auth::login($user);

    return redirect()->action([FeedController::class, 'index']);
});


Route::get('oiaa', function () {

    //fetch data
    $rows = Http::get(
        'https://sheets.googleapis.com/v4/spreadsheets/' .
            env('GOOGLE_SHEET_ID') . '/values/A1:Z10000?key=' .
            env('GOOGLE_SHEET_API_KEY')
    )['values'];

    //get columns
    $columns = array_map(function ($column) {
        return Str::slug($column, '_');
    }, array_shift($rows));
    $column_count = count($columns);

    //remove empty rows
    $rows = array_filter($rows, function ($row) {
        return strlen($row[0]);
    });

    //loop through and format rows
    $rows = array_map(function ($row) use ($columns, $column_count) {
        $row = array_map('trim', $row);
        extract(array_combine($columns, array_pad($row, $column_count, null)));
        return compact('name', 'times', 'timezone', 'url', 'phone', 'access_code', 'email', 'types', 'formats', 'notes');
    }, $rows);

    Storage::disk('public')->put('oiaa.json', json_encode($rows));

    return 'done!';
});

Route::get('aasanjose', function () {
    FeedController::generate('12Ga8uwMG4WJ8pZ_SEU7vNETp_aQZ-2yNVsYDFqIwHyE', 'aasanjose');
    return 'done!';
});
