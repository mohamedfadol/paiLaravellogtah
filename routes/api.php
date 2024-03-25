<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\RoleController;
use App\Http\Controllers\API\V1\UserController;
use App\Http\Controllers\API\V1\BoardController;
use App\Http\Controllers\API\V1\NotesController;
use App\Http\Controllers\API\V1\MemberController;
use App\Http\Controllers\API\V1\MeetingController;
use App\Http\Controllers\API\V1\MinutesController;
use App\Http\Controllers\API\V1\CriteriaController;
use App\Http\Controllers\API\V1\PositionController;
use App\Http\Controllers\API\V1\Auth\AuthController;
use App\Http\Controllers\API\V1\CommitteeController;
use App\Http\Controllers\API\V1\FinancialController;
use App\Http\Controllers\API\V1\DisclosureController;
use App\Http\Controllers\API\V1\ResolutionController;
use App\Http\Controllers\API\V1\SearchableController;
use App\Http\Controllers\API\V1\AnnualReportController;
use App\Http\Controllers\API\V1\NotificationController;
use App\Http\Controllers\API\V1\ActionTrackerController;
use App\Http\Controllers\API\V1\AnnualAuditReportController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(AuthController::class)
    ->group(function () {
        Route::post('login', 'login');
        Route::post('register', 'register');
    });


Route::middleware(['auth:sanctum'])->group(function () {

    Route::post('logout', [AuthController::class,'logout']);
    Route::controller(UserController::class)
    ->group(function () {
        // return user data to profile page
        Route::get('get-user-profile/user/{id}', 'getUserProfile');
        // return update user profile page
        Route::post('update-user-profile/user', 'updateProfile');
        Route::post('user/update/fcm', 'updataFcm');
    });
    
    // board routes for add board
    Route::controller(BoardController::class)
    ->group(function () {
        Route::post('insert-new-board', 'insertNewBoard');
        Route::get('/get-board-byId', 'getBoardById');
        Route::get('get-list-boards/{business_id}', 'getListOfBoards');
        Route::post('upload-charter', 'uploadCharter');
    }); 
    
    // committee routes for resources
    Route::controller(CommitteeController::class)
    ->group(function () { 
        Route::post('insert-new-committee', 'insertNewCommittee');
        Route::get('get-list-committees/{business_id}','getListOfCommittees');
        Route::get('get-all-committees/{business_id}','getAllOfCommittees');
    });

    Route::get('get-list-roles/{business_id}', [RoleController::class,'getListOfRoles']);

    // member routes for resources
    Route::controller(MemberController::class)
    ->group(function () {
        Route::post('insert-new-member', 'inserNewMember');
        Route::get('get-list-members/{business_id}', 'getListOfMember');

    });

    // fetch list of positions
    Route::get('get-list-positions/{business_id}', [PositionController::class,'getListOfPositions']);
        // fetch list of searchables
    Route::get('get-list-searchables/{business_id}', [SearchableController::class,'getListOfSearchables']);
    
    // meeting routes for resources
     Route::controller(MeetingController::class)
    ->group(function () {
        Route::post('insert-new-meeting',  'inserNewMeeting');
        Route::get('get-list-meetings/{business_id}', 'getListOfMeetings');
        Route::post('get-list-meetings-belongsTo-board',  'getMeetingBeLongsToBoard');
        Route::post('get-list-meetings-belongsTo-committee',  'getMeetingBeLongsToCommittee');
        Route::post('update-meeting-by-id/{id}',  'updateMeetingById');
        Route::get('get-list-agenda-by-meetingId/{meeting_id}',  'getListOfAgendaByMeetingId');
    });
    
    // resolutions routes for resources
    Route::controller(ResolutionController::class)
    ->group(function () {
        Route::post('insert-new-resolution','inserNewResolution'); 
        Route::post('get-list-committee-resolutions', 'getListOfCommitteesResolutions');
        Route::post('get-list-board-resolutions', 'getListOfBoardResolutions');
        Route::post('make-sign-resolution', 'memberMakeSignResolution');
        Route::post('delete-resolution-by-id', 'deleteResolution');
    }); 
     
    // minutes routes for resources
    Route::controller(MinutesController::class)
    ->group(function () {
        Route::post('insert-new-minute', 'inserNewMinute');
        Route::post('get-list-minutes', 'getListOfMinutes');
        Route::post('update-minutes-by-id', 'updateMinute');
        Route::post('delete-minutes-by-id', 'deleteMinute');
        Route::post('make-sign-minute', 'memberMakeSignMinute');
    });
    
    // criterias routes for resources
    Route::controller(CriteriaController::class)
    ->group(function () {
        Route::post('insert-new-criteria', 'insertNewCriteria');
        Route::get('get-list-criterias', 'getListOfCriterias');
        Route::get('get-list-criterias-by-business-id/{business_id}', 'getListOfCriteriasByBusinessId');
        Route::post('insert-new-criteria-evaluations-member', 'insertNewCriteriaEvaluationsMember');
    });

    // actions-trackers routes for resources
    Route::controller(ActionTrackerController::class)
    ->group(function () {
        Route::post('get-list-actions-trackers', 'getListOfActionTrackers');
        Route::post('edit-actions-tracker/{action_id}', 'editActionsTracker');
        Route::post('get-list-actions-trackers-where-like', 'getListOfActionTrackersWhereLike');
    });

    // financials routes for resources
    Route::controller(FinancialController::class)
    ->group(function () {
        Route::post('get-list-financials', 'getListOfFinancials');
        Route::post('create-new-financial', 'createNewFinancial');
        Route::post('delete-financial-by-id', 'deleteFinancial');
        Route::post('make-sign-financial', 'memberMakeSignFinancial');
    });
    
    // annual_reports routes for resources
    Route::controller(AnnualReportController::class)
    ->group(function () {
        Route::post('get-list-annual-reports', 'getListOfAnnualReports');
        Route::post('create-new-annual-report', 'createNewAnnualReport');
        Route::post('delete-annual-report-by-id', 'deleteAnnualReport');
        Route::post('make-sign-annual-report', 'memberMakeSignAnnualReport');
    });

    // annual audit reports routes for resources
    Route::controller(AnnualAuditReportController::class)
    ->group(function () {
        Route::post('get-list-annual-audit-reports','getListOfAnnualAuditReports');
        Route::post('create-new-annual-audit-report','createNewAnnualAuditReport');
        Route::post('delete-annual-audit-report-by-id','deleteAnnualAuditReport');
        Route::post('make-sign-annual-audit-report','memberMakeSignAnnualAuditReport');
    });
     
    // disclosures route for resource
    Route::controller(DisclosureController::class)
    ->group(function () {
        Route::post('get-list-disclosures','getListOfDisclosures');
        Route::post('create-new-disclosure','createNewDisclosure');
        Route::post('delete-disclosure-by-id','deleteDisclosure');
    });
    
    // get list of notes for specific member
    Route::controller(NotesController::class)
    ->group(function () {
        Route::post('get-list-board-notes','getListOfBoardNotes');
        Route::post('get-list-committee-notes','getListOfCommitteeNotes');
        Route::post('insert-new-note','insertNewNote');
        Route::post('extract-pdf-text','extractTextFromLocalPdfFiles');
        Route::get('get-all-pdffiles','getPdfFiles');
        Route::post('get-all-extract-text','makeSearchForAllFile');
        Route::post('extract-pdf-text-multiple-uri','extractEnglishTextFromMultiplePdfFilesFromUri');
        Route::post('get-all-arabic-text','extractArabicTextFromMultiplePdfFilesFromUri');
        Route::post('ge-text','searcha');
    });
   
    // get list of notification for specific member
    Route::controller(NotificationController::class)
    ->group(function () {
        Route::get('get-list-notifications','getListOfNotification');
    });

});










