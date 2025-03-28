<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\ParentDashboardController;
use App\Http\Controllers\TeacherDashboardController;
use App\Http\Controllers\StudentDashboardController;

Route::get('/', 'LandingController@homePage');
Auth::routes();  

Route::get('/about', function () {
    return view('About');
});

Route::get('/help', [HelpController::class, 'Faqview']);
Route::post('/submit', [HelpController::class, 'submit'])->name('submit');
Route::get('/testresult/pdf', [StudentDashboardController::class, 'downloadPDF'])->name('testresult.pdf');



//Route::get('', [TeacherDashboardController::class, 'MySubject_Manager_AddSubjectDownload'])->name('download');
Route::get('download{file}', 'TeacherDashboardController@MySubject_Manager_AddSubjectDownload')->name('download');


//PArent group
Route::middleware(['auth', 'user_role:parent'])->group(function () {
    //dashboard
    Route::get('/ParentDashboard', [ParentDashboardController::class, 'ParentDashboard']);

    Route::get('/Inc/ExamStatus', [ParentDashboardController::class, 'ExamStatusResult']);
    //manage account view
    Route::get('/Inc/StudentAccount', [ParentDashboardController::class, 'ManageAccount']);
    //manage account post
    Route::post('/ManageAccount', [ParentDashboardController::class, 'ManageAccountManager']);

    //manage subject view
    Route::get('/Inc/ManageSubject', [ParentDashboardController::class, 'ManageSubject']);
    //manage subject post
    Route::post('/ManageSubject', [ParentDashboardController::class, 'ManageSubjectManager']);
    Route::post('/store-selected-questions', [ParentDashboardController::class, 'storeSelectedQuestions'])->name('storeSelectedQuestions');

    //TEACHER AVAILABLE
    Route::get('/Inc/TeacherAvailable', [ParentDashboardController::class, 'TeacherAvailable']);

    

    
});



Route::middleware(['auth', 'user_role:student'])->group(function () {
        //dashboard
        Route::get('/StudentDashboard', [StudentDashboardController::class, 'StudentDashboard']);
        //myLeaning
        Route::get('Inc/MyLearning', [StudentDashboardController::class, 'MyLearning']);
        Route::get('Inc/TakeQuiz', [StudentDashboardController::class, 'TakeQuiz']);
        Route::post('save', [StudentDashboardController::class, 'saveTest']);
        Route::get('Inc/QuestionDay', [StudentDashboardController::class, 'QuestionDay']);
       // Route::get('Result', [StudentDashboardController::class, 'Result']);

       Route::get('/Result', function(){
        return view('Inc.Result');
    });
    
        

});






Route::middleware(['auth', 'user_role:teacher'])->group(function () {
    Route::get('/TeacherDashboard', [TeacherDashboardController::class, 'TeacherDashboard']);

    // Quiz routes
    Route::get('Inc/AddQuiz', [TeacherDashboardController::class, 'AddQuiz_Manager'])->name('Quiz');
    Route::post('/Quiz', [TeacherDashboardController::class, 'AddQuiz_Manager_AddQuiz'])->name('addQuiz');
    Route::delete('/questions/{id}', 'TeacherDashboardController@AddQuiz_Manager_DeleteQuiz')->name('deleteQuestion');

    
    //paper 
    Route::get('Inc/Paper', [TeacherDashboardController::class, 'Paper_Manager']);
    Route::post('/Paper', [TeacherDashboardController::class, 'Paper_Manager_AddPaper']);

    // Discussion route
    Route::get('/Inc/Discussion', [TeacherDashboardController::class, 'Disccussion_Manager']);

    // Exam Participation Report route
    Route::get('/Inc/Exam_Participation_Report', [TeacherDashboardController::class, 'Exam_Participation_Report_Manager']);

    // Message route
    Route::get('/Inc/Message', [TeacherDashboardController::class, 'Message_Manager']);

    // MySubject routes
    Route::get('/Inc/MySubject', [TeacherDashboardController::class, 'MySubject_Manager'])->name('my_subject');
    Route::post('/AddSubject', [TeacherDashboardController::class, 'MySubject_Manager_AddSubject']);
    Route::get('/Inc/MySubject', [TeacherDashboardController::class, 'MySubject_Manager_AddSubjectView'])->name('add_subject');
    Route::post('/UploadSubject', [TeacherDashboardController::class, 'MySubject_Manager_UploadSubject']);
    Route::post('/publishquestions', [TeacherDashboardController::class, 'publishQuestions'])->name('publishQuestions');

    Route::post('/uploaded/{id}', 'TeacherDashboardController@MySubject_Manager_DeleteUploadSubject')->name('deleteUploaded');


    // Parent Request route
    Route::get('/Inc/ParentRequest', [TeacherDashboardController::class, 'ParentRequest_Manager']);

    // Student Enroll Report route
    Route::get('/Inc/Student_Enroll_Report', [TeacherDashboardController::class, 'Student_Enroll_Report_Manager']);
});