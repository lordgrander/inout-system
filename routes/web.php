<?php

use Illuminate\Support\Facades\Route;   
use App\Http\Controllers\EnterController;
use App\Http\Controllers\SeeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AddController;
use App\Http\Controllers\Sandbox;
use App\Http\Controllers\QuotarCon;
use App\Http\Controllers\QuotarController;
use App\Http\Controllers\ZoneTwoCon;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\FilePurgeController;
use App\Http\Controllers\ExpiredController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\InsuranceController;
use App\Http\Controllers\AdminInsuranceController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\CancelValueController; 
use App\Http\Controllers\MarkDownController;
use App\Http\Controllers\RemarkController;
use Carbon\Carbon;

session();
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
 
Route::get('/', function () {
    return redirect()->route('login'); 
});


Route::get('/markdown', [MarkDownController::class, 'index'])->name('markdown.index');
Route::post('/markdown/store', [MarkDownController::class, 'store_markdown'])->name('markdown.store');
Route::DELETE('/markdown/delete', [MarkDownController::class, 'delete_markdown'])->name('markdown.delete');
Route::post('/markdown/update', [MarkDownController::class, 'update_markdown'])->name('markdown.update');


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    if (auth()->user()->is_admin == 1) {
        return redirect()->route('Enter'); 
    } elseif (auth()->user()->is_admin == 2) {
        return redirect()->route('seeEnterWaiting'); 
    } elseif (auth()->user()->is_admin == 3) {
        return redirect()->route('seeEnterPointing'); 
    } elseif (in_array(auth()->user()->is_admin, [4, 5])) {
        $input = "command";
        $value = "on";
        if (!session()->has($input)) {
            // Create the session with the default value if it doesn't exist
            
            session([$input => $value]);
        } else {
            // Check if today has passed to the next day
            $now = Carbon::now();
            $tomorrow = Carbon::tomorrow();
            if ($now >= $tomorrow) {
                // Destroy the session if today has passed to the next day
                session()->forget($input);
            } else {
                // Update the value of the session
                if (session($input) == 'off') {
                    session([$input => 'on']);
                } else {
                    session([$input => 'off']);
                }
            }
        }
        
        return redirect()->route('seeEnterSigning'); 
    }
    elseif (auth()->user()->is_admin == 7)
    {
        return redirect()->route('seeZoneTwo'); 
    } 
    elseif (auth()->user()->is_admin == 8)
    {
        return redirect()->route('seeZoneTwo'); 
    } 
    elseif (auth()->user()->is_admin == 16)
    {
        return redirect()->route('see_insurance_tell_waiting'); 
        // return redirect()->route('seeEnterall');
        // user 16 is for insurance tell, redirect to insurance tell list page, not the all enter list page.
    } 
    elseif (auth()->user()->is_admin == 0)
    {
        return redirect()->route('seeEnterall'); 
    } 
    else {
        return view('dashboard');
    }
})->name('dashboard');


Route::post('/session_set', function () {
    $input = "command";
    $value = "off";

    if (in_array(auth()->user()->is_admin, [4, 5])) {
        // Check if the session exists
        if (!session()->has($input)) {
            // Create the session with the default value if it doesn't exist
            session([$input => $value]);
        } else {
            // Check if today has passed to the next day
            $now = Carbon::now();
            $tomorrow = Carbon::tomorrow();
            if ($now >= $tomorrow) {
                // Destroy the session if today has passed to the next day
                session()->forget($input);
            } else {
                // Update the value of the session
                if (session($input) == 'off') {
                    session([$input => 'on']);
                } else {
                    session([$input => 'off']);
                }
            }
        }
           
    } else {
        
    } 
    return response()->json(['success' => true,'message'=>session('command')]);

});

    Route::get('/verified/check/{slug}',[ExpiredController::class, 'verified_check'])->name('verified_check');  


// Terminal ::-> User Filter for Is_admin
Route::middleware(['auth:sanctum', 'verified'])->group(function(){
 
    Route::get('/enter/',[EnterController::class, 'index'])->name('Enter');  
    Route::get('/entertest/',[EnterController::class, 'index_test'])->name('Enter.test');  
    Route::post('/enter/save',          [EnterController::class, 'store'])->name('EnterSave');  
    Route::post('/enter/save-test',          [EnterController::class, 'store_test'])->name('EnterSave-test');  
    Route::post('/enter/draft',          [EnterController::class, 'draft'])->name('EnterSave');  
    Route::post('/enter/send',          [EnterController::class, 'send'])->name('EnterSave');  
    Route::post('/enter/update-session',[EnterController::class, 'updatesession'])->name('EnterSave');  
    
    Route::get('/enter/view/test',[EnterController::class, 'view_test'])->name('Enter.view.test');  
    

Route::post('/company-profile/store', [EnterController::class, 'store_company_profile'])
    ->name('company_profile.store');
    
    Route::post('/enter/update/draft/{id}', [EnterController::class, 'updatedraft']);  

    Route::get('/enter/list',[EnterController::class, 'list'])->name('EnterList');  
    Route::get('/enter/list/view/{id}', [EnterController::class, 'view']);  
    Route::get('/enter/update/{id}', [EnterController::class, 'update']);  
    Route::post('/enter/update/store/{id}', [EnterController::class, 'updatestore']);  
    Route::post('/enter/update/file/drop', [EnterController::class, 'filedrop']);  
    Route::post('/enter/cancel',          [EnterController::class, 'cancel']);  
    Route::post('/enter/delete',          [EnterController::class, 'delete']);  
    Route::get('/enter/history',          [EnterController::class, 'history'])->name('EnterHistoryList');  
    Route::get('/download-file/{file}',   [EnterController::class, 'download'])->name('download-file');;

    Route::get('/enter/insurance/tell',[InsuranceController::class, 'index'])->name('Enter.insurance.index');  
    Route::post('/enter/insurance/store',[InsuranceController::class, 'store'])->name('Enter.insurance.store');  


     Route::get('/tell-car-insurance/create', [EnterController::class, 'tell_car_insurance'])
        ->name('tell_car_insurance.create');

    Route::post('/tell-car-insurance', [EnterController::class, 'tell_car_insurance_store'])
        ->name('tell_car_insurance.store');


    Route::get('/see/enter',                                      [SeeController::class, 'index'])->name('seeEnter')->middleware('checknormal');
    Route::get('/see/enter/list/view/{id}',                       [SeeController::class, 'view'])->middleware('checknormal');
    Route::get('/see/enter/list/view/log/{id}',                   [SeeController::class, 'log'])->middleware('checknormal');
    Route::get('/see/enter/list/view/edit/{id}',                  [SeeController::class, 'edit'])->middleware('checknormal');
    Route::post('/see/enter/list/view/update/first',              [SeeController::class, 'first'])->middleware('checknormal');
    Route::post('/see/enter/list/view/update/first/back',         [SeeController::class, 'back'])->middleware('checknormal');
    Route::post('/see/enter/list/view/update/first/back/pointing',[SeeController::class, 'backFromPointing'])->middleware('checknormal');
    Route::post('/see/enter/list/view/update/first/pointing',     [SeeController::class, 'pointing'])->middleware('checknormal');
    Route::post('/see/enter/list/view/update/first/back/signing', [SeeController::class, 'backFromSigning'])->middleware('checknormal'); 
    Route::post('/see/enter/list/view/update/first/back/boss',    [SeeController::class, 'backFromBoss'])->middleware('checknormal'); 
    Route::post('/see/enter/list/view/update/first/back/boss/tosign',[SeeController::class, 'backFromBossSign'])->middleware('checknormal'); 
    Route::post('/see/enter/list/view/update/first/back/tosign',[SeeController::class, 'backToSign'])->middleware('checknormal'); 
    Route::post('/see/enter/list/view/update/first/sign',         [SeeController::class, 'sign'])->middleware('checknormal'); 
    Route::post('/see/enter/list/view/update/first/sign/company', [SeeController::class, 'signCompany'])->middleware('checknormal'); 
    Route::post('/see/enter/list/view/update/first/sign/special', [SeeController::class, 'specialsign'])->middleware('checknormal'); 
    
    
    Route::post('/see/enter/list/view/update/first/ready',        [SeeController::class, 'ready'])->middleware('checknormal'); 
    Route::post('/see/enter/list/view/update/first/ready/back',   [SeeController::class, 'readyback'])->middleware('checknormal'); 
    Route::post('/see/enter/list/view/update/first/success/back',   [SeeController::class, 'successback'])->middleware('checknormal'); 
    Route::post('/see/enter/list/view/update/first/cancel',       [SeeController::class, 'cancel'])->middleware('checknormal');
    Route::post('/see/enter/list/view/update/first/cancel/reroll',[SeeController::class, 'reroll'])->middleware('checknormal');
    Route::get('/see/enter/car/insurance/{status}',[SeeController::class, 'tell_car_insurance_store'])->middleware('checknormal')->name('see_insurance_tell');
    Route::get('/see/enter/car/i/insurance',[SeeController::class, 'tell_car_insurance_waiting'])->middleware('checknormal')->name('see_insurance_tell_waiting');

    Route::post('/tell-car-insurance/remark/update', [SeeController::class, 'updateRemark'])
  ->name('tellcarinsurance.remark.update');

  
    
     Route::post('/tell-car-insurance/{id}/waiting', [SeeController::class, 'tell_car_insurance_markWaiting'])
        ->name('tell_car_insurance.waiting');
     Route::post('/tell-car-insurance/{id}/checking', [SeeController::class, 'tell_car_insurance_markChecking'])
        ->name('tell_car_insurance.checking');
     Route::post('/tell-car-insurance/{id}/success', [SeeController::class, 'tell_car_insurance_markSuccess'])
        ->name('tell_car_insurance.success');

    // ajax: cancel with reason
    Route::post('/tell-car-insurance/{id}/cancel', [SeeController::class, 'tell_car_insurance_cancel'])
        ->name('tell_car_insurance.cancel');

    Route::get('/see/enter/print/{id}',   [ReportController::class, 'print'])->name('seePrint')->middleware('checknormal');
    Route::get('/see/enter/print/a/b/c/{enter_number}/{year}/{left}/{right}/{image_size}',   [ReportController::class, 'print_abc'])->name('seePrintabc')->middleware('checknormal');

    Route::get('/see/enter/waiting_testing', [SeeController::class, 'waiting_testing'])->name('seeEnterWaitingTesting')->middleware('checknormal');
    

    Route::get('/see/enter/waiting', [SeeController::class, 'waiting'])->name('seeEnterWaiting')->middleware('checknormal');
    Route::get('/see/enter/pointing',[SeeController::class, 'Linkpointing'])->name('seeEnterPointing')->middleware('checknormal');
    Route::get('/see/enter/signing', [SeeController::class, 'Linksigning'])->name('seeEnterSigning')->middleware('checknormal');
    Route::get('/see/enter/signed',  [SeeController::class, 'Linksigned'])->name('seeEnterSigned')->middleware('checknormal');
    Route::get('/see/enter/ready',  [SeeController::class,  'Linkready'])->name('seeEnterReady')->middleware('checknormal');
    Route::get('/see/enter/sussess', [SeeController::class, 'Linksussess'])->name('seeEnterSussess')->middleware('checknormal');
    Route::get('/see/enter/cancel',  [SeeController::class, 'Linkcancel'])->name('seeEnterCancel')->middleware('checknormal');
    Route::get('/see/enter/all',     [SeeController::class, 'Linkall'])->name('seeEnterall')->middleware('checknormal');
    Route::get('/see/enter/print/test/{id}',     [ReportController::class, 'print_test'])->name('print_test')->middleware('checknormal');

     Route::get('/see/enter/data', [SeeController::class, 'ajaxEnterData'])
    ->name('seeEnterData')
    ->middleware('checknormal');


    Route::get('/see/enter/success/search/{search}',     [SeeController::class, 'success_search'])->name('success_search')->middleware('checknormal');
    
    Route::get('/add',[AddController::class, 'index'])->name('Add')->middleware('checknormal');

    Route::get('/add/road',[AddController::class, 'road'])->name('RoadAdd')->middleware('checknormal');
    Route::post('/add/road/store',[AddController::class, 'roadStore'])->middleware('checknormal');
    Route::post('/add/road/update',[AddController::class, 'roadUpdate'])->middleware('checknormal');
    Route::post('/add/road/del',[AddController::class, 'roadDel'])->middleware('checknormal');

    Route::get('/add/wheels',[AddController::class, 'wheels'])->name('WheelsAdd')->middleware('checknormal');
    Route::post('/add/wheels/store',[AddController::class, 'wheelsStore'])->middleware('checknormal');
    Route::post('/add/wheels/update',[AddController::class, 'wheelsUpdate'])->middleware('checknormal');
    Route::post('/add/wheels/del',[AddController::class, 'wheelsDel'])->middleware('checknormal');

    Route::get('/add/mainroad',[AddController::class, 'mainroad'])->name('MainroadAdd')->middleware('checknormal');
    Route::post('/add/mainroad/store',[AddController::class, 'mainroadStore'])->middleware('checknormal');
    Route::post('/add/mainroad/update',[AddController::class, 'mainroadUpdate'])->middleware('checknormal');
    Route::post('/add/mainroad/del',[AddController::class, 'mainroadDel'])->middleware('checknormal');

    Route::get('/add/com',[AddController::class, 'com'])->name('ComAdd')->middleware('checknormal');
    Route::post('/add/com/store',[AddController::class, 'comStore'])->middleware('checknormal');
    Route::post('/add/com/update',[AddController::class, 'comUpdate'])->middleware('checknormal');
    Route::post('/add/com/del',[AddController::class, 'comDel'])->middleware('checknormal');

    Route::get('/add/com/{comid}/user',[AddController::class, 'comUser'])->middleware('checknormal');
    Route::get('/com/search',[AddController::class, 'com_search'])->name('com.search')->middleware('checknormal');

    Route::get('/com/search/json', [AddController::class, 'com_search_json'])
    ->name('com.search.json')
    ->middleware('checknormal');

    Route::post('/add/comUser/{comid}/store',[AddController::class, 'comUserStore'])->middleware('checknormal');
    Route::post('/add/comUser/{comid}/update',[AddController::class, 'comUserUpdate'])->middleware('checknormal');
    Route::post('/add/comUser/{comid}/del',[AddController::class, 'comUserDel'])->middleware('checknormal');
    Route::post('/add/com/update/quotar',[AddController::class, 'comQuotar'])->name('com.change.quotar')->middleware('checknormal');
        Route::post('/company-profile-detail/status', [AddController::class, 'updateDetailStatus'])->name('companyProfileDetail.status');

        
    Route::get('/report/index',[ReportController::class, 'index'])->name('ReportIndex')->middleware('checknormal');
    Route::get('/report/{start}/{end}',[ReportController::class, 'daily'])->middleware('checknormal');
    Route::get('/i/report/{start}/{end}',[ReportController::class, 'daily_testing'])->middleware('checknormal');
    Route::get('/report/{start}/{end}/itue/wqiu/tieowq/igdsa/{limit}/90',[ReportController::class, 'dailycs'])->middleware('checknormal');
    Route::get('/ptsd/{start}/{end}',[ReportController::class, 'ptsd'])->middleware('checknormal');
    Route::get('/i/ptsd/{start}/{end}',[ReportController::class, 'ptsd_testing'])->middleware('checknormal');
    Route::get('/ptsd/{start}/{end}/kodsa/fdsavc/zvcx/gdsa/f/{limit}/90',[ReportController::class, 'ptsdcs'])->middleware('checknormal');
    Route::get('/search/{enter_number}',[ReportController::class, 'search_enter_number'])->middleware('checknormal');
    Route::post('/fetch_search',[ReportController::class, 'fetch_search'])->middleware('checknormal');

    Route::get('/sandbox',               [Sandbox::class, 'index'])->name('sandbox');
    Route::post('/sand/clear/all',       [Sandbox::class, 'sandbox_clear'])->name('clear_all');
    Route::post('/sand/set/number',      [Sandbox::class, 'sandbox_set_number']);
    Route::post('/sand/add/all',         [Sandbox::class, 'sandbox_add']);
    Route::post('/sand/add/all/delete',  [Sandbox::class, 'sandbox_add_del']);
    Route::post('/sand/set/form',      [Sandbox::class, 'sandbox_set_form']); 
    
    Route::get('/view/quotar',      [QuotarCon::class, 'index'])->name('view.quotar')->middleware('checknormal'); 
    Route::post('/save/quotar',      [QuotarCon::class, 'save'])->name('com.save.quatar')->middleware('checknormal'); 
    Route::post('/edit/quotar',      [QuotarCon::class, 'edit'])->name('com.edit.quatar')->middleware('checknormal'); 
    Route::delete('/delete/quotar',      [QuotarCon::class, 'delete'])->name('com.delete.quatar')->middleware('checknormal'); 
    
    
    Route::get('/view/quotar/list/{com_id}',      [QuotarCon::class, 'index'])->name('view.quotar.list')->middleware('checknormal'); 

    
    Route::get('/fiods[avcxkzl/hjfdlsahjknvcmxz',      [QuotarCon::class, 'com_add'])->name('enter.product'); 
    Route::post('/fdsafdsakfldsa/req0gdsk432/{com_id}/alcpd/432rew90dksfdsa',      [QuotarCon::class, 'save'])->name('com.save.quatar.level2'); 
    Route::post('/jfipewqu8reo32432nnds/vcnxkzngj342',      [QuotarCon::class, 'edit'])->name('com.edit.quatar.level2'); 
    
    Route::get('/enter/quotar/tell',      [QuotarCon::class, 'tell'])->name('tell.product'); 
    Route::post('/enter/quotar/store',      [QuotarCon::class, 'tellStore'])->name('tell.quotar'); 
    Route::get('/enter/quotar/history',      [QuotarCon::class, 'history'])->name('quotar.history'); 
    Route::get('/enter/quotar/stock',      [QuotarCon::class, 'seeQuotar'])->name('see.quotar'); 
    Route::get('/enter/quotar',[QuotarCon::class, 'enter_quotar'])->name('EnterQuotar');  
    Route::post('/enter/quotar/process',[QuotarCon::class, 'enter_quotar_save'])->name('quotar.enter.save');  



    Route::get('/see/zone/two', [ZoneTwoCon::class, 'index'])->name('seeZoneTwo')->middleware('checknormal');
    Route::get('/see/zone/two/quotar', [ZoneTwoCon::class, 'index_quotar'])->name('seeZoneTwoQuotar')->middleware('checknormal');
    Route::post('/see/zone/set/type',      [ZoneTwoCon::class, 'setType'])->name('set.type'); 
    Route::post('/see/zone/set/pointing',      [ZoneTwoCon::class, 'quotarPoiting'])->name('quotar.pointing'); 
    Route::post('/see/zone/set/cancel',      [ZoneTwoCon::class, 'quotarCancel'])->name('quotar.cancel'); 
    
    
    Route::get('/see/zone/quotar/waiting',[ZoneTwoCon::class, 'waiting'])->name('seeEnterQuotarWaiting');  
    Route::get('/see/zone/quotar/success',[ZoneTwoCon::class, 'success'])->name('seeEnterQuotarSuccess');  
    
    Route::get('/see/zone/quotar/tell',[QuotarController::class, 'tell'])->name('quotar.tell');  
    Route::get('/see/zone/quotar/tell/search', [QuotarController::class, 'search'])->name('quotar.tell.search');

    Route::get('/see/zone/quotar/pick/{com_id}',[QuotarController::class, 'pick'])->name('quotar.pick');  
    
    
    
    Route::get('/supreme/report/{start}',[Sandbox::class, 'report'])->name('Freport'); 
    Route::get('/supreme/report/edit/{start}',[Sandbox::class, 'report_edit'])->name('Freport.edit');  
    Route::post('/supreme/report/update',[Sandbox::class, 'report_update'])->name('Freport.update');  
    Route::get('/purge/files-by-month', [FilePurgeController::class, 'destroyByMonthYear']);
    
    Route::post('/subject/list', [CompanyController::class, 'subject_list'])->name('com.subject.list');
    Route::post('/subject/add', [CompanyController::class, 'subject_add'])->name('com.subject.add');
    Route::post('/subject/delete', [CompanyController::class, 'subject_delete'])->name('com.subject.delete');
    
    Route::get('/watching', [CompanyController::class, 'watching_list'])->name('watching_list');
    Route::post('/watching/delete', [CompanyController::class, 'watching_delete'])->name('watching.delete');
    Route::post('/watching/add', [CompanyController::class, 'watching_add'])->name('watching.add');

    Route::get('/watching/profile', [CompanyController::class, 'company_profile_list'])->name('company.profile');
    Route::get('/watching/profile/filter/{status}', [CompanyController::class, 'company_profile_list_status'])->name('company.profile.status');


    Route::get('/company-profile/filter', [CompanyController::class, 'filterCompanyProfile'])
    ->name('company.profile.filter');
 

    Route::get('/expired/list', [ExpiredController::class, 'list'])->name('expired.list');
    Route::post('/expired/extend', [ExpiredController::class, 'extendEndAt'])->name('users.extend');
    Route::post('/expired/reject', [ExpiredController::class, 'reject_extend'])->name('users.reject');
 

    Route::get('/admin/insurance/index', [AdminInsuranceController::class, 'index'])->name('insurance.index');
    Route::get('/admin/document/index', [DocumentController::class, 'index'])->name('document.index');
    Route::get('/admin/document/report/{start}/{end}', [DocumentController::class, 'docreport'])->name('document.report');

    Route::get('/settings/cancel-values', [CancelValueController::class, 'index'])->name('doc.cancel.index');
Route::get('/settings/cancel-values/fetch', [CancelValueController::class, 'fetch'])->name('doc.cancel.fetch');
Route::post('/settings/cancel-values/update', [CancelValueController::class, 'update'])->name('doc.cancel.update');



    Route::get('/remark/list', [RemarkController::class, 'index'])->name('remark.index');
    Route::post('/remark/list/add', [RemarkController::class, 'add'])->name('remark.index.add');
    Route::get('/remark/list/search', [RemarkController::class, 'search'])->name('remark.index.search');

    Route::get('/remark/paper/{enter_id}/{enter_detail_id}', [RemarkController::class, 'paper'])
        ->name('remark.paper');
        

}); 


    Route::get('/cam', [TestController::class, 'test'])->name('test');
    Route::get('/cam/scan', [Sandbox::class, 'cam_scan'])->name('cam_scan');
    Route::get('/test-menu', [TestController::class, 'menu'])->name('test.menu');
    
    Route::get('/test-menu', [TestController::class, 'menu'])->name('test.menu');
Route::middleware(['auth:sanctum', 'verified'])->prefix('test/core-work')->name('test.core-work.')->group(function () {
    Route::get('/{scope?}', [\App\Http\Controllers\CoreTestingController::class, 'index'])->name('index');
    Route::post('/accept', [\App\Http\Controllers\CoreTestingController::class, 'accept'])->name('accept');
    Route::post('/send-company', [\App\Http\Controllers\CoreTestingController::class, 'sendCompany'])->name('send-company');
    Route::post('/back', [\App\Http\Controllers\CoreTestingController::class, 'back'])->name('back');
    Route::post('/back-boss-sign', [\App\Http\Controllers\CoreTestingController::class, 'backBossSign'])->name('back-boss-sign');
    Route::post('/back-to-sign', [\App\Http\Controllers\CoreTestingController::class, 'backToSign'])->name('back-to-sign');
    Route::post('/pointing', [\App\Http\Controllers\CoreTestingController::class, 'pointing'])->name('pointing');
    Route::post('/back-pointing', [\App\Http\Controllers\CoreTestingController::class, 'backPointing'])->name('back-pointing');
    Route::post('/back-signing', [\App\Http\Controllers\CoreTestingController::class, 'backSigning'])->name('back-signing');
    Route::post('/sign', [\App\Http\Controllers\CoreTestingController::class, 'sign'])->name('sign');
    Route::post('/back-boss', [\App\Http\Controllers\CoreTestingController::class, 'backBoss'])->name('back-boss');
    Route::post('/ready-back', [\App\Http\Controllers\CoreTestingController::class, 'readyBack'])->name('ready-back');
    Route::post('/success-back', [\App\Http\Controllers\CoreTestingController::class, 'successBack'])->name('success-back');
    Route::post('/cancel', [\App\Http\Controllers\CoreTestingController::class, 'cancel'])->name('cancel');
    Route::post('/reroll', [\App\Http\Controllers\CoreTestingController::class, 'reroll'])->name('reroll');
    Route::post('/ready', [\App\Http\Controllers\CoreTestingController::class, 'ready'])->name('ready');
    Route::post('/update-paper', [\App\Http\Controllers\CoreTestingController::class, 'updatePaper'])->name('update-paper');

});


