<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CaptchaController;


//captha code 21022024
Route::get('/captcha', [CaptchaController::class,'generateCaptcha'])->name('captcha');

Route::get('/', function () { return view('landing.home'); });
Route::get('/application',function () { return view('landing.application'); });
Route::get('/lop',function () { return view('landing.lop'); });
Route::get('/guidelines',function () { return view('landing.guidelines'); });
Route::get('/contact-us', function () { return view('landing.contact-us'); });
Route::get('/copyright-policy', function () {return view('landing.copyright-policy');})->name('copyright-policy');
Route::get('/privacy-policy', function () {return view('landing.privacy-policy');})->name('privacy-policy');
Route::get('/hyperlink-policy', function () {return view('landing.hyperlink-policy');})->name('hyperlink-policy');

Auth::routes(['verify' => true]);
Auth::routes(['register' => false]);

/*** Open AJAX Routes ***/
Route::get('/segments/{data}', 'User\AjaxController@getSegments');

Route::group(['middleware' => ['verified', 'IsApproved']], function () {
    Route::get('/verifymobile', 'Auth\OtpController@verifyMobileForm')->name('verifyMobileForm');
    Route::post('/verifymobile', 'Auth\OtpController@verifyMobile')->name('verifyMobile');
    Route::get('/getotp', 'Auth\OtpController@getLoginOTP')->name('getLoginOTP');
    Route::post('/verifyotp', 'Auth\OtpController@verifyLoginOTP')->name('verifyLoginOTP');
});

Route::group(['middleware' => ['role:Approved-Applicants|Applicant|Admin', 'verified', 'TwoFA', 'IsApproved']], function () {
    Route::get('/cities/{state}', 'User\AjaxController@getCity');
    Route::get('/pincodes/{city}', 'User\AjaxController@getPincode');
    
});

Route::group(['middleware' => ['verified', 'TwoFA', 'IsApproved']], function () {
   Route::get('/verifyuser', 'HomeController@verifyUser')->name('verifyUser');
});

Route::group(['middleware' => ['role:ActiveUser','verified', 'TwoFA', 'IsApproved']], function () {
    Route::get('/home', 'HomeController@index')->name('home');
});

Route::group(['middleware' => ['role:Applicant', 'verified', 'TwoFA', 'IsApproved']], function () {
    Route::resource('applications', 'User\App\AppMastController', ['except' => 'create']);
});

//Developing by Ajaharuddin Ansari
Route::group(['middleware' => ['role:Applicant', 'verified', 'TwoFA', 'IsApproved']], function () {
    Route::get('bgtrackerp/show', 'User\BgTracker\BgTrackerController@show')->name('bgtrackerp.show');
});


Route::group(['middleware' => ['role:Applicant', 'verified', 'TwoFA', 'IsApproved' , 'BlockApplication']], function () {
     /*** AJAX Routes ***/
    Route::get('/subsegments/{id}', 'User\App\AjaxController@getSubSegment');
    // Route::get('/cities/{state}', 'User\AjaxController@getCity');
    // Route::get('/pincodes/{city}', 'User\AjaxController@getPincode');
    /*** Application Routes ***/
    Route::get('applications/create/{id}', 'User\App\AppMastController@create')->name('applications.create');
    Route::get('applications/preview/{id}', 'User\App\AppMastController@preview')->name('applications.preview');
    Route::resource('companydetails', 'User\App\CompanyDetailsController', ['except' => 'create']);
    Route::get('companydetails/create/{id}', 'User\App\CompanyDetailsController@create')->name('companydetails.create');
    Route::resource('eligibility', 'User\App\EligibilityController', ['except' => 'create']);
    Route::get('eligibility/create/{id}', 'User\App\EligibilityController@create')->name('eligibility.create');
    Route::resource('financials', 'User\App\FinancialsController', ['except' => 'create']);
    Route::get('financials/create/{id}', 'User\App\FinancialsController@create')->name('financials.create');
    Route::resource('undertakings', 'User\App\UndertakingsController', ['except' => 'create']);
    Route::get('undertakings/create/{id}', 'User\App\UndertakingsController@create')->name('undertakings.create');
    Route::resource('proposal', 'User\App\ProposalController', ['except' => 'create']);
    Route::get('proposal/create/{id}', 'User\App\ProposalController@create')->name('proposal.create');
    Route::resource('evaluations', 'User\App\EvaluationsController', ['except' => 'create']);
    Route::get('evaluations/create/{id}', 'User\App\EvaluationsController@create')->name('evaluations.create');
    Route::resource('projections', 'User\App\ProjectionsController', ['except' => 'create']);
    Route::get('projections/create/{id}', 'User\App\ProjectionsController@create')->name('projections.create');
    Route::resource('dva', 'User\App\DvaController', ['except' => 'create']);
    Route::get('dva/create/{id}', 'User\App\DvaController@create')->name('dva.create');
    Route::get('/app/preview/{id}','User\App\AppMastController@preview')->name('app.preview');
    Route::get('/app/submit/{id}','User\App\AppMastController@submit')->name('app.submit');
    // Route::get('/app/oldshow/{id}','User\App\AppMastController@oldshow')->name('app.show');

    /*** Delete Add Row Routes***/
    Route::get('/app/edit/promoter/{id}', 'User\App\CompanyDetailsController@deletePromoter')->name('promoter.delete');
    Route::get('/app/edit/others/{id}', 'User\App\CompanyDetailsController@deleteOther')->name('other.delete');
    Route::get('/app/edit/gstins/{id}', 'User\App\CompanyDetailsController@deleteGstin')->name('gstin.delete');
    Route::get('/app/edit/auditors/{id}', 'User\App\CompanyDetailsController@deleteAuditor')->name('auditor.delete');
    Route::get('/app/edit/ratings/{id}', 'User\App\CompanyDetailsController@deleteRating')->name('rating.delete');
    Route::get('/app/edit/profiles/{id}', 'User\App\CompanyDetailsController@deleteProfile')->name('profile.delete');
    Route::get('/app/edit/kmps/{id}', 'User\App\CompanyDetailsController@deleteKmp')->name('kmp.delete');
    Route::get('/app/edit/group/{id}', 'User\App\EligibilityController@deleteGroup')->name('group.delete');



});


Route::name('admin.')->prefix('admin')->middleware(['role:Developer', 'IsApproved'])->group(function(){
    Route::get('logs', 'DeveloperController@getErrorLogs')->name('logs');
 });


Route::name('admin.')->prefix('admin')->middleware(['role:Admin|Admin-Ministry', 'IsApproved','TwoFA',])->group( function () {
//for activate QRR [By Ajaharuddin Ansari]
    Route::get('qrr/qrractivedash', 'Admin\QRRController@qrractivedash')->name('qrr.qrractivedash');
    Route::post('qrr/qrractivation', 'Admin\QRRController@qrractivation')->name('qrr.qrractivation');
    Route::get('home', 'Admin\HomeController@index')->name('home');
    Route::get('users/export', 'Admin\UsersController@usersExport')->name('users.export');
	//change by aastha
    Route::get('users/exportR1', 'Admin\UsersController@usersExportRound1')->name('users.exportR1');
    Route::resource('users','Admin\UsersController');
    Route::get('apps/export', 'Admin\AppsController@appsExport')->name('applications.export');
    Route::get('emp/export', 'Admin\AppsController@empsExport')->name('emp.export');
    Route::resource('apps', 'Admin\AppsController');
	Route::resource('report', 'Admin\ReportController');

	Route::get('/apps/preview/{id}', 'Admin\AppsController@preview')->name('applications.preview');
    	Route::get('/apps/print/{id}', 'Admin\AppsController@print')->name('applications.print');

	Route::get('acknowledgement', 'Admin\AcknowledgementController@index')->name('acknowledgement.index');
    	Route::get('show/{id}', 'Admin\AcknowledgementController@show')->name('acknowledgement.show');
    	Route::get('print/{id}', 'Admin\AcknowledgementController@print')->name('acknowledgement.print');

// Dashboard Apps Filter
    Route::get('/targets/{name}','Admin\AppsController@getTp');
	Route::get('/appproducts/products/{product_id}/{target}','Admin\AppsController@getProductApps');

//qrr routes changes by Aastha
    Route::get('qrr/{qtr}', 'Admin\QRRController@qrrDash')->name('qrr.dash');
    Route::get('qrr/view/{id}/{qtr}', 'Admin\QRRController@qrrView')->name('qrr.view');
    Route::get('qrr/export/{id}/{qtr}', 'Admin\QRRController@qrrExport')->name('qrr.export');
    
//Route::get('qrr/export/{qtr}', 'Admin\QRRController@qrrExportAll')->name('qrr.exportall');
Route::get('qrr/exportall/{qtr}/{type}', 'Admin\QRRController@qrrExportAll')->name('qrr.exportall');  
  Route::get('qrr/editmode/{id}/{qtr}', 'Admin\QRRController@qrrOpenEdit')->name('qrr.editmode');
    Route::get('qrr/closeeditmode/{id}/{qtr}', 'Admin\QRRController@qrrCloseEdit')->name('qrr.closeeditmode');

    Route::resource('qrr_location', 'Admin\QrrLocationController');
    Route::get('qrr_location/{id}/{qtr_id}', 'Admin\QrrLocationController@edit')->name('qrr_location');
    

//for Non-submission mail for QRR[By Ajaharuddin Ansari]
   Route::get('qrr/pendingQrrMail/{qtr}', 'Admin\QRRController@pendingQrrMail')->name('qrr.pendingQrrMail');
   Route::get('qrr/QrrMailLog/{today}', 'Admin\QRRController@QrrMailLog')->name('qrr.QrrMailLog');



// Developing BG Tracker by Ajaharuddin Ansari
    Route::get('bgtracker/bgExport', 'Admin\BgTrackerController@bgExport')->name('bgtracker.bgExport');
    Route::resource('bgtracker', 'Admin\BgTrackerController', ['except' => 'create']);
    Route::get('bgtracker/create/{id}', 'Admin\BgTrackerController@create')->name('bgtracker.create');
    Route::get('bgtracker/show/{app_id}/{bg_id}', 'Admin\BgTrackerController@show')->name('bgtracker.show');
    // Route::get('bgtracker/Expshow/{id}', 'Admin\BgTrackerController@Expshow')->name('bgtracker.Expshow');
    Route::get('bgtracker/edit/{bg_id}/{doc_id}', 'Admin\BgTrackerController@edit')->name('bgtracker.edit');

    // AppStatus Flag..... Ajaharuddin Ansari
    Route::get('appstatus/appstatusExport', 'Admin\ApplicationStatusController@appstatusExport')->name('appstatus.appstatusExport');
    Route::resource('appstatus', 'Admin\ApplicationStatusController', ['except' => 'create', 'show','edit']);
    Route::get('appstatus/create/{id}', 'Admin\ApplicationStatusController@create')->name('appstatus.create');
    Route::get('appstatus/show/{id}', 'Admin\ApplicationStatusController@show')->name('appstatus.show');
    Route::get('appstatus/edit/{id}', 'Admin\ApplicationStatusController@edit')->name('appstatus.edit');

//Dashboard -- Ajaharuddin Ansari
    Route::get('dashboard', 'Admin\DashboardController@index')->name('dashboard.dashboard');
    Route::get('dashboard/projection', 'Admin\DashboardController@target_chart')->name('dashboard.projection');

//Additonal Details
    Route::get('additionaldetail/appdetailsedit/{id}/{taskid_id}', 'Admin\AdditionalsdetailController@appdetailsedit')->name('additionaldetail.appdetailsedit');
    Route::get('additionaldetail/edit/{id}/{task_id}', 'Admin\AdditionalsdetailController@edit')->name('additionaldetail.edit');
    Route::resource('additionaldetail', 'Admin\AdditionalsdetailController', ['except' => 'edit']);
    Route::get('additionaldetail/create/{id}', 'Admin\AdditionalsdetailController@create')->name('additionaldetail.create');

// MIS

    Route::get('main/{fy}', 'Admin\MISController@qrr');
    // Route::resource('MIS', 'Admin\MISController', ['except' => 'create']);
    Route::get('MIS/{qtr}', 'Admin\MISController@index')->name('MIS.index');
    Route::get('MIS/{qtr}/{data}', 'Admin\MISController@MISExport')->name('MIS.MISExport');
    Route::post('Prayas', 'Admin\PrayasController@index')->name('Prayas'); 
    Route::post('praysdetail', 'Admin\PrayasController@show')->name('praysdetail');
    Route::get('praysdetaileedit/{user_id}/{qtr}', 'Admin\PrayasController@edit')->name('praysdetailedit');
    Route::get('/prayas/getcods/{project_id}', 'Admin\PrayasController@getcodes');
    Route::get('prayas/getdata','Admin\PrayasController@getdata')->name('prayas.getdata');
    Route::post('prayas/data','Admin\PrayasController@data')->name('prayas.data');
    Route::post('prayas/excel_data','Admin\PrayasController@excel_data')->name('prayas.excel_data');
    Route::get('prayas/dash/{qtr}/{project_code}','Admin\PrayasController@dash')->name('prayas.dash');
    Route::get('prayas/fixdata/{qtr}/{project_code}/{date}','Admin\PrayasController@fixdata')->name('prayas.fixdata');
    Route::get('prayas/pushdata/{project_code}/{date}','Admin\PrayasController@finalpushdata')->name('prayas.pushdata');
//Claim
    Route::get('claim', 'Admin\ClaimController@claimdashboard')->name('claim.claimdashboard');

Route::post('claimyearwise', 'Admin\ClaimController@claimyearwise')->name('claimyearwise');

    Route::get('claim/editmode/{id}', 'Admin\ClaimController@claim_edit')->name('claim.editmode');
     Route::resource('login', 'Admin\LoginIDController');
    Route::get('create_id', 'Admin\LoginIDController@index')->name('create_id');
    Route::get('login/create', 'Admin\LoginIDController@create')->name('login.create');
	Route::get('login/{status}/{id}', 'Admin\LoginIDController@update_status')->name('login');

Route::get('users/edit_authorised_signatory/{id}','Admin\UsersController@EditAuthorisedSignatory')->name('users.edit_authorised_signatory'); 
    Route::post('users/update_auth/{id}','Admin\UsersController@UpdateAuthorization')->name('users.update_auth');
    Route::get('users/downloadAuthorizationLetter/{id}','Admin\UsersController@DownloadAuthorizationLetter')->name('users.downloadAuthorizationLetter');
Route::get('claims/twenty_percentage_incentive_editmode/{id}', 'Admin\ClaimController@twenty_per_incentive_edit')->name('claim.twenty_percentage_incentive_editmode');
});

Route::group(['middleware' => ['role:ActiveUser','role:Approved-Applicants', 'verified', 'TwoFA', 'IsApproved']], function () {
    Route::resource('qpr', 'User\QRR\QRRController');
    Route::get('qpr/create/{id}/{qrrName}','User\QRR\QRRController@create')->name('qpr.create');

    Route::get('qpr/submit/{id}','User\QRR\QRRController@submit')->name('qpr.submit');
    Route::resource('revenue', 'User\QRR\RevenueController');
    Route::get('revenue/create/{id}/{qrr}','User\QRR\RevenueController@create')->name('revenue.create');
    Route::get('revenue/delete/{id}','User\QRR\RevenueController@deleteMatPrev')->name('revenue.deleteMatPrev');
    Route::get('revenue/deleteMat/{id}','User\QRR\RevenueController@deleteMat')->name('revenue.deleteMat');
    Route::get('revenue/deleteSerPrev/{id}','User\QRR\RevenueController@deleteSerPrev')->name('revenue.deleteSerPrev');
    Route::get('revenue/deleteSer/{id}','User\QRR\RevenueController@deleteSer')->name('revenue.deleteSer');
    Route::resource('projectprogress', 'User\QRR\ProjectProgressController');
    Route::get('projectprogress/create/{id}/{qrr}','User\QRR\ProjectProgressController@create')->name('projectprogress.create');
    Route::resource('uploads', 'User\QRR\UploadsController');
    Route::get('uploads/create/{id}/{qrr}','User\QRR\UploadsController@create')->name('uploads.create');
    Route::resource('manuaddress', 'User\QRR\ManuFactAddressController');
    Route::get('manuaddress/delete/{id}', 'User\QRR\ManuFactAddressController@delete')->name('manuaddress.delete');
    Route::get('manuaddress/deleteProduct/{id}', 'User\QRR\ManuFactAddressController@deleteProduct')->name('manuaddress.deleteProduct');
    Route::get('manuaddress/create/{id}/{qtr}/{type}','User\QRR\ManuFactAddressController@create')->name('manuaddress.create');
    Route::get('manuaddress/edit/{id}/{qtr}/{type}','User\QRR\ManuFactAddressController@edit')->name('manuaddress.edit');
    // Route::get('/qpr/revenue', 'User\QRR\QRRController@createRevenue')->name('qpr.createRevenue');
	Route::get('qpr/getByName/{id}','User\QRR\QRRController@getQrrByName')->name('qpr.byname');
    Route::get('qrradditionalinfo/create/{id}/{qrrid}','User\QRR\QrrAdditionalInfoController@create')->name('qrradditionalinfo.create');
    Route::resource('qrradditionalinfo', 'User\QRR\QrrAdditionalInfoController', ['except' => 'create']);
    Route::get('qrradditionalinfo/deleteapproval/{id}','User\QRR\QrrAdditionalInfoController@deleteapproval')->name('qrradditionalinfo.deleteapproval');
Route::resource('grievance', 'User\Grievance\GrievanceController');



   


 });

 Route::group(['middleware' => ['role:Approved-Applicants', 'verified', 'TwoFA', 'IsApproved']], function () {
    
    Route::resource('claims', 'User\Claims\ClaimController');
    // Route::get('claims/create/{id}','User\Claims\ClaimController@create')->name('claims.create');

Route::get('claims/create/{id}/{fy}','User\Claims\ClaimController@create')->name('claims.create');
    Route::get('claims/index/{id}','User\Claims\ClaimController@index')->name('claims.index');
    Route::get('claims/show/{id}', 'User\Claims\ClaimController@show')->name('claims.show');
    Route::get('claims/submit/{claim_id}', 'User\Claims\ClaimController@finalSubmit')->name('claims.submit');    

    Route::resource('claimsapplicantdetail', 'User\Claims\ClaimApplicantDetailController');
    Route::get('claims/claimsapplicantdetail/{id}', 'User\Claims\ClaimApplicantDetailController@create')->name('claims.claimsapplicantdetail');
    
    Route::resource('claimsalesdetail', 'User\Claims\ClaimSalesDetailController');
    Route::get('claimsalesdetail/create/{id}', 'User\Claims\ClaimSalesDetailController@create')->name('claimsalesdetail.create');
    
    Route::resource('claiminvestmentdetail', 'User\Claims\ClaimInvestmentDetailController');
    Route::get('claiminvestmentdetail/create/{id}', 'User\Claims\ClaimInvestmentDetailController@create')->name('claiminvestmentdetail.create');
    
    Route::resource('claimprojectdetail', 'User\Claims\ClaimProjectDetailController');
    Route::get('claimprojectdetail/create/{id}', 'User\Claims\ClaimProjectDetailController@create')->name('claimprojectdetail.create');

    Route::resource('relatedpartytransaction', 'User\Claims\RelatedPartyController');
    Route::get('relatedpartytransaction/create/{id}', 'User\Claims\RelatedPartyController@create')->name('relatedpartytransaction.create');

    Route::resource('claimdocumentupload', 'User\Claims\ClaimDocumentUploadController');
    Route::get('claimdocumentupload/create/{section}/{id}', 'User\Claims\ClaimDocumentUploadController@create')->name('claimdocumentupload.create');
    Route::post('claimdocumentupload/store/{section}', 'User\Claims\ClaimDocumentUploadController@store')->name('claimdocumentupload.store');
    Route::get('claimdocumentupload/edit/{id}/{section}', 'User\Claims\ClaimDocumentUploadController@edit')->name('claimdocumentupload.edit');
    Route::match(['put','patch'],'claimdocumentupload/update/{section}', 'User\Claims\ClaimDocumentUploadController@update')->name('claimdocumentupload.update');

    Route::get('claims/projectprogress', 'User\Claims\ProjectProgressController@create')->name('claims.projectprogress');
    Route::get('claims/uploads', 'User\Claims\UploadsController@create')->name('claims.uploads');;

    Route::get('doc/down/{docid}','User\Claims\ClaimController@downloadfile')->name('doc.down');
    Route::get('claims/upload', 'User\Claims\ClaimController@upload')->name('claim.upload');

	Route::resource('claims','User\Claims\ClaimController',['except' => 'index']);

    Route::get('claims/getByName/{id}','User\Claims\ClaimController@getClaimsByName')->name('claims.byname');

    
    Route::get('claimsalesdetail/claimsalesdva/{id}','User\Claims\ClaimSalesDetailController@claimsalesdva')->name('claimsalesdetail.claimsalesdva');
    Route::post('claimsalesdetail/dva_store','User\Claims\ClaimSalesDetailController@dvaStore')->name('claimsalesdetail.dva_store');
    Route::get('claimsalesdetail/dvaedit/{claim_id}','User\Claims\ClaimSalesDetailController@dvaedit')->name('claimsalesdetail.dvaedit');
    Route::PATCH('claimsalesdetail/dva_update/{id}','User\Claims\ClaimSalesDetailController@dva_update')->name('claimsalesdetail.dva_update');

//---- 13-12-2023 --- claim 20 perc link added
Route::get('claimdocumentupload/incentiveDoc/{id}', 'User\Claims\ClaimDocumentUploadController@index')->name('claimdocumentupload.incentive');
    Route::get('claimdocumentupload/Status/{id}', 'User\Claims\ClaimDocumentUploadController@incentiveDoc')->name('claimdocumentupload.status');


 });
 
 Route::name('admin.')->prefix('admin')->middleware(['role:Admin|Admin-Ministry|Applicant','IsApproved'])->group( function () {
    Route::get('authorize_signatory_list', 'AuthorisedSignatory\AuthorizeSignatoryRequestController@authorizeSignatoryList')->name('authorizeSignatoryList');
    Route::get('authorizechangelist', 'AuthorisedSignatory\AuthorizeSignatoryRequestController@authorizeChangeList')->name('users.authorizeSignatoryList');
    Route::get('authorizechangedetail/{id}', 'AuthorisedSignatory\AuthorizeSignatoryRequestController@authorizeChangeDetail')->name('users.authorizechagedetail');
    Route::get('downloadAuthorizationLetter/{id}', 'AuthorisedSignatory\AuthorizeSignatoryRequestController@downloadAuthorizationLetter')->name('users.downloadAuthorizationLetter');
    Route::post('updateAuthorization/{id}', 'AuthorisedSignatory\AuthorizeSignatoryRequestController@updateAuthorization')->name('users.updateAuthorization');
    Route::get('authorizechangelistapplicant/{id}', 'AuthorisedSignatory\AuthorizeSignatoryRequestController@authorizeChangeListApplicant')->name('users.authorizeChangeListApplicant');
// for Authorized signatory requests *********** User
    Route::get('authoriseSignatory', 'AuthorisedSignatory\AuthoriseSignatoryController@authoriseSignatory')->name('authoriseSignatory');
    Route::post('storeAuthoriseSignatory', 'AuthorisedSignatory\AuthoriseSignatoryController@storeAuthoriseSignatory')->name('storeAuthoriseSignatory');

Route::get('claims/incentive/{fy}', 'Admin\ClaimIncentiveController@claimIncentive')->name('claims.incentive');
    Route::get('claims/incentiveExport','Admin\ClaimIncentiveController@claimIncentiveExport')->name('claims.incentiveExport');
    Route::patch('claims/incentive/update/{fy_id}', 'Admin\ClaimIncentiveController@claimIncentiveUpdate')->name('claims.incentiveUpdate');
    Route::get('claims/summaryReportView','Admin\ClaimIncentiveController@claimSummaryReportView')->name('claims.summaryReportView');
	 Route::post('claims/correspondance/{claim_id}','Admin\ClaimIncentiveController@addCorrespondance')->name('claims.correspondance');
    Route::get('claims/correspondanceEdit/{claim_id}','Admin\ClaimIncentiveController@editCorrespondance')->name('claims.correspondanceEdit');
    Route::patch('claims/updateCorres/{claim_id}', 'Admin\ClaimIncentiveController@updateCorres')->name('claims.updateCorres');
Route::get('claims/correspondanceView/{claim_id}','Admin\ClaimIncentiveController@correspondanceView')->name('claims.correspondanceView');

Route::get('grievances/list', 'Admin\Grievances\GrievancesController@index')->name('grievances_list');
Route::get('grievances/respond/{id}', 'Admin\Grievances\GrievancesController@respond')->name('grievances_respond');
Route::post('grievances/respond/store', 'Admin\Grievances\GrievancesController@respondStore')->name('grievances_respond_store');
Route::get('com_doc/{id}', 'Admin\Grievances\GrievancesController@downloadFile')->name('com_doc_down');
Route::get('grievances/respond/view/{id}','Admin\Grievances\GrievancesController@view')->name('grievances_respond_view');


});

// Preview or admin and users Claim
Route::group(['middleware' => ['role:Approved-Applicants|Admin', 'verified', 'TwoFA']], function () {
    Route::get('claims/claimpreveiw/{id}', 'User\Claims\ClaimPreviewController@claimpreveiw')->name('claims.claimpreveiw');
    Route::get('doc/download/{docid}','User\Claims\ClaimPreviewController@downloadfile')->name('doc.download');
//Route::get('doc/download/{docid}','User\Claims\ClaimPreviewController@downloadfile')->name('doc.down');
Route::get('claimdocumentupload/show/{claim_id}', 'User\Claims\ClaimDocumentUploadController@show')->name('claimdocumentupload.show');
});


Route::group(['middleware' => ['role:Approved-Applicants|Admin-Ministry|Admin|Developer','IsApproved','TwoFA']], function () {
    Route::get('newcorrespondence', 'new_correspondence\RequestController@index')->name('newcorrespondence.index');
    Route::resource('reqcreate', 'new_correspondence\RequestController');
    Route::get('correspondence/usersList/{user_type}', 'new_correspondence\RequestController@usersList');
    Route::get('correspondence/applicationNumberList/{applicant_id}', 'new_correspondence\RequestController@applicationNumberList');
    Route::get('reqcreate/edit/{id}','new_correspondence\RequestController@edit')->name('reqcreate.edit');
    Route::post('raisecomp', 'new_correspondence\RequestController@raisecomp')->name('raisecomp');
    Route::get('category/{catid}','new_correspondence\RequestSubtypeController@getSubtype');
    Route::get('reqtype/{catid}/{subtype}','new_correspondence\RequestSubtypeController@getReqType');
    Route::get('req_download/{id}', 'new_correspondence\RequestController@reqDownload')->name('req_download');
    Route::get('checksts/{req_id}/{checkid}', 'new_correspondence\RequestController@statuscheck')->name('checksts');
    Route::get('visiblecom/{req_id}/{checkid}', 'new_correspondence\RequestController@statuscm')->name('visiblecom');
});

Route::name('admin.')->prefix('admin')->middleware(['role:Admin|Admin-Ministry|Applicant','IsApproved'])->group( function () {

    Route::get('authoriseSignatorylist/admin_dash/{change_type}', 'AuthorisedSignatory\AuthorizeSignatoryRequestController@authorizeSignatoryList')->name('authoriseSignatorylist.admin_dash');
    Route::get('authorizechangelist', 'AuthorisedSignatory\AuthorizeSignatoryRequestController@authorizeChangeList')->name('users.authorizeSignatoryList');
    Route::get('authorizechangedetail/{person_id}/{type}', 'AuthorisedSignatory\AuthorizeSignatoryRequestController@authorizeChangeDetail')->name('users.authorizechangedetail');
    Route::get('authorizechangeView/{id}/{change_type}', 'AuthorisedSignatory\AuthorizeSignatoryRequestController@authorizeChangeView')->name('users.authorizeChangeView');
    Route::post('updateAuthorization/{id}/{change_type}', 'AuthorisedSignatory\AuthorizeSignatoryRequestController@updateAuthorization')->name('users.updateAuthorization');
    Route::get('authorizechangelistapplicant/{id}', 'AuthorisedSignatory\AuthorizeSignatoryRequestController@authorizeChangeListApplicant')->name('users.authorizeChangeListApplicant');
    Route::get('export_data/{id}/{type}', 'AuthorisedSignatory\AuthorizeSignatoryRequestController@AuthExport')->name('users.export_data');
    Route::get('authoriseSignatory/auth_dash', 'AuthorisedSignatory\AuthoriseSignatoryController@auth_dash')->name('authoriseSignatory.auth_dash');
    Route::get('authoriseSignatory/{change_type}/{id}', 'AuthorisedSignatory\AuthoriseSignatoryController@authoriseSignatory')->name('authoriseSignatory');
    Route::post('storeAuthoriseSignatory', 'AuthorisedSignatory\AuthoriseSignatoryController@storeAuthoriseSignatory')->name('storeAuthoriseSignatory');

    Route::get('down/{docid}','AuthorisedSignatory\AuthorizeSignatoryRequestController@downloadfile')->name('down');



// Start below code for mail schedular Fixed suit for document upload by Deepak Sharma
     Route::get('/mail/schedular','Admin\Mail\MailSchedularController@index')->name('mail.index');
     Route::post('/mail/schedular/store','Admin\Mail\MailSchedularController@store')->name('mail.schedular.store');
     Route::get('mail/schedularedit/{id}', 'Admin\Mail\MailSchedularController@edit')->name('mail/schedularedit.edit');
     Route::get('schedular/fixedmail/{id}', 'Admin\Mail\MailSchedularController@view')->name('schedular.fixedmail.view');
     Route::post('/mail/schedular/update','Admin\Mail\MailSchedularController@update')->name('mail.schedular.update');
     Route::get('/mail/schedular/finalsubmit/{id}','Admin\Mail\MailSchedularController@finalsubmit')->name('mail.schedular.finalsubmit');
     // end code for mail schedular Variable suit for document upload by Deepak Sharma
 
     // start code for variable claim schedular mail functionality by Deepak Sharma
     Route::get('claimvariable','Admin\Mail\ClaimVariableController@index')->name('claimvariable.index');
     Route::post('claimvariable/store','Admin\Mail\ClaimVariableController@store')->name('claimvariable.store');
     Route::get('claimvariable/{id}', 'Admin\Mail\ClaimVariableController@edit')->name('claimvariable.edit');
     Route::post('claimvariable/update','Admin\Mail\ClaimVariableController@update')->name('claimvariable.update');
     Route::get('claimvariable/finalsubmit/{id}','Admin\Mail\ClaimVariableController@finalsubmit')->name('claimvariable.finalsubmit');
     Route::get('claimvariable/view/{id}', 'Admin\Mail\ClaimVariableController@view')->name('claimvariable.view');
     // end code for variable claim schedular mail functionality by Deepak Sharma
 
     // Below are the Park Claim Variable routes by Deepak Sharma
     Route::get('parkclaimvariable','Admin\Mail\ParkClaimVariableController@index')->name('parkclaimvariable.index');
     Route::post('parkclaimvariable/store','Admin\Mail\ParkClaimVariableController@store')->name('parkclaimvariable.store');
     Route::get('parkclaimvariable/{id}', 'Admin\Mail\ParkClaimVariableController@edit')->name('parkclaimvariable.edit');
     Route::post('parkclaimvariable/update','Admin\Mail\ParkClaimVariableController@update')->name('parkclaimvariable.update');
     Route::get('parkclaimvariable/finalsubmit/{id}','Admin\Mail\ParkClaimVariableController@finalsubmit')->name('parkclaimvariable.finalsubmit');
     Route::get('parkclaimvariable/view/{id}', 'Admin\Mail\ParkClaimVariableController@view')->name('parkclaimvariable.view');
     // End are the Park Claim Variable routes by Deepak Sharma

});


