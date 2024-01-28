<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/color',fn()=>view('color-picker'));
Route::post('/fireEvent',function (\Illuminate\Http\Request $request){
    \App\Events\PublicEvent::dispatch($request->color);
})->name('fire.public.event');



Route::get('users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');



    Route::get('private/fireEvent',function (){
        sleep(3);
        \App\Events\PrivateEvent::dispatch('Profile picture has been updated');
    }
    )->name('fire.private.event');

    Route::get('/dashboard',function (){
        $groups = \App\Models\Group::where('id',auth()->user()->group_id)->get();
        return view('dashboard',compact($groups));
    })->name('dashboard');

    Route::get('dashboard/{group}',function (\Illuminate\Http\Request $request,\App\Models\Group $group){
        abort_unless($request->user()->canJoinGroup($group->id),401);
        return view('group',compact('group'));
    })->name('group');

    Route::get('/presence/fireEvent/{message}',fn()=>\App\Events\PresenceEvent::dispatch())
        ->name('fire.presence.event');
});



require __DIR__.'/auth.php';
