<?php

use App\Http\Controllers\Admin\AjaxController;
use App\Http\Controllers\Admin\FormController;
use App\Http\Controllers\Admin\NavigationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\FileManagerController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;


Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('lang/{locale}', function ($locale) {
    app()->setLocale($locale);
    session()->put('locale', $locale);
    return redirect()->back();
})->name('lang.switcher');


Route::get('cacheclear', function () {
    Artisan::call('view:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('optimize:clear');
    return 'Cache is cleared';
});

Route::get('cachesystem', function () {
    Artisan::call('route:cache');
    Artisan::call('config:cache');
    Artisan::call('view:cache');
    Artisan::call('optimize');
    return 'Cache is done';
});



Route::get('/getfiles', [App\Http\Controllers\FileController::class, 'getfiles'])->name('getFiles')->middleware('auth');
Route::post('/uploadfile', [App\Http\Controllers\FileController::class, 'uploadfile'])->name('uploadfile')->middleware('auth');
Route::get('/downloadfile/{path}', [App\Http\Controllers\FileController::class, 'downloadfile'])->name('downloadfile');


Route::group(['middleware' => ['auth'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/panel', [App\Http\Controllers\Admin\PanelController::class, 'index'])->name('panel');
    Route::get('/blank', [App\Http\Controllers\Admin\PanelController::class, 'blank'])->name('blank');
    Route::post('/search', [App\Http\Controllers\Admin\PanelController::class, 'search'])->name('search');
    Route::get('/contact', [App\Http\Controllers\Admin\ContactController::class, 'index'])->name('Contact.index');
    Route::get('/contact/delete/{id}', [App\Http\Controllers\Admin\ContactController::class, 'delete'])->name('Contact.delete');

    Route::get('/ContactCarbon', [App\Http\Controllers\Admin\ContactController::class, 'ContactCarbon'])->name('ContactCarbon');
    Route::get('/ContactCarbon/delete/{id}', [App\Http\Controllers\Admin\ContactController::class, 'deleteCarbon'])->name('ContactCarbon.delete');


    Route::group(['prefix' => 'setting', 'as' => 'setting.','namespace' => 'Admin'], function () {
        Route::get('/index', [SettingController::class, 'index'])->name('index');
        Route::get('/basic/{code}', [SettingController::class, 'basicEdit'])->name('edit');
        Route::post('/update', [SettingController::class, 'update'])->name('update');
        Route::get('/cacheStats', [SettingController::class, 'cacheStats'])->name('cacheStats');
        Route::get('/translate', [SettingController::class, 'translate'])->name('translate');
        Route::post('/translateUpdate', [SettingController::class, 'translateUpdate'])->name('language.update');
    });

    Route::group(['prefix' => 'user', 'as' => 'user.','namespace' => 'Admin'], function () {
        Route::get('/index', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('edit');
        Route::post('/store', [UserController::class, 'store'])->name('store');
        Route::post('/update/{id}', [UserController::class, 'update'])->name('update');
        Route::any('/delete/{id}', [UserController::class, 'delete'])->name('delete');
        Route::post('/updatePW/{userid}', [UserController::class, 'updatePW'])->name('update.password');

    });

    Route::group(['prefix' => 'filemanager', 'as' => 'filemanager.','namespace' => 'Admin'], function () {
        Route::get('/index', [FileManagerController::class, 'index'])->name('index');
        Route::post('/update', [FileManagerController::class, 'update'])->name('update');
    });




    Route::group(['prefix' => 'page', 'as' => 'page.','namespace' => 'Admin'], function () {
        Route::get('/index/{parent?}', [PageController::class, 'index'])->name('index');
        Route::get('/create/{parent_id?}', [PageController::class, 'create'])->name('create');
        Route::get('/edit/{id}', [PageController::class, 'edit'])->name('edit');
        Route::post('/store', [PageController::class, 'store'])->name('store');
        Route::post('/update', [PageController::class, 'update'])->name('update');
        Route::any('/delete/{id}', [PageController::class, 'delete'])->name('delete');
        Route::post('/fetch', [PageController::class, 'fetch'])->name('fetch');
        Route::post('/updateStatus', [PageController::class, 'updateStatus'])->name('updateStatus');
        Route::get('/developerSetting/{id}', [PageController::class, 'developerSetting'])->name('developerSetting');
        Route::post('/clonepage', [PageController::class, 'clonepage'])->name('clonepage');
        Route::post('/updateOrder', [PageController::class, 'updateOrder'])->name('updateOrder');
    });

    Route::group(['prefix' => 'navigation', 'as' => 'navigation.','namespace' => 'Admin'], function () {
        Route::get('/index', [NavigationController::class, 'index'])->name('index');
        Route::get('/edit/{id}/{locale?}', [NavigationController::class, 'edit'])->name('edit');
        Route::post('/store', [NavigationController::class, 'store'])->name('store');
        Route::post('/update', [NavigationController::class, 'update'])->name('update');
        Route::get('/getPageList', [NavigationController::class, 'getPageList'])->name('getPageList');
        Route::get('/delete/{id}', [NavigationController::class, 'delete'])->name('delete');
    });

    Route::group(['prefix' => 'component', 'as' => 'component.','namespace' => 'Admin'], function () {
        Route::get('/index', [PageController::class, 'componentList'])->name('index');
    });

    Route::group(['prefix' => 'form', 'as' => 'form.','namespace' => 'Admin'], function () {
        Route::get('/index', [FormController::class, 'index'])->name('index');
        Route::get('/create', [FormController::class, 'create'])->name('create');
        Route::get('/edit/{id}', [FormController::class, 'edit'])->name('edit');
        Route::post('/store', [FormController::class, 'store'])->name('store');
        Route::post('/update', [FormController::class, 'update'])->name('update');
        Route::any('/delete/{id}', [FormController::class, 'delete'])->name('delete');
        Route::get('/submissions/{id}', [FormController::class, 'submissions'])->name('submissions');
        Route::get('/submission/{id}', [FormController::class, 'submission'])->name('submission');
        Route::get('/submission/{id}/delete', [FormController::class, 'submissionDelete'])->name('submissionDelete');
    });

});

Route::get('/carbon', [App\Http\Controllers\CarbonController::class, 'index'])->name('index');
Route::post('/SubmitForm', [App\Http\Controllers\CarbonController::class, 'SubmitForm'])->name('SubmitForm');
Route::get('/generatePdf', [App\Http\Controllers\CarbonController::class, 'generatePdf'])->name('generatePdf');
Route::get('/CarbonReports', [App\Http\Controllers\CarbonController::class, 'CarbonReports'])->name('CarbonReports');

Route::get('/CarbonReport', [App\Http\Controllers\CarboninvidualController::class, 'CarbonReport'])->name('CarbonReport');
Route::get('/CertificatePdf', [App\Http\Controllers\CarboninvidualController::class, 'CertificatePdf'])->name('CertificatePdf');

Route::post('/CarbonSubmit', [App\Http\Controllers\CarboninvidualController::class, 'Carboninvidual'])->name('CarbonSubmit');
Route::get('/Carboninvidual', [App\Http\Controllers\CarboninvidualController::class, 'index'])->name('Carboninvidual');

Route::get('/contact', [App\Http\Controllers\ContactController::class, 'index'])->name('contact');
Route::post('/contact/send', [App\Http\Controllers\ContactController::class, 'send'])->name('contact.send');

Route::get('/cities', [App\Http\Controllers\HomeController::class, 'cities'])->name('cities');

Route::get('/logout', function(){
    Auth::logout();
    return Redirect::to('/login');
});
Route::get('/panel', function(){
    return Redirect::to('/login');
});
Route::get('search', [App\Http\Controllers\PageController::class, 'search'])->name('search');
Route::post('search', [App\Http\Controllers\PageController::class, 'search_fetch'])->name('search_fetch');
Route::post('formSubmit/{formid}', [App\Http\Controllers\FormController::class, 'submit'])->name('form.submit');
Route::get('{slug}', [App\Http\Controllers\PageController::class, 'index'])->name('page')->where('slug', '.+');
