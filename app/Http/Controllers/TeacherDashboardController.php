<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\JsonResponse;
use App\Models\AddSubject;
use App\Models\testquestions;
use App\Models\Paper;
use App\Models\testresult;
use App\Models\testanswers;
use Illuminate\Support\Facades\Auth;
use App\Models\Upload_Learning_Material;
use App\Models\QuestionBank;
use App\Models\StudentWithSubject;
use Illuminate\Http\Request;



use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\VarDumper\Cloner\Data;

class TeacherDashboardController extends Controller
{
public function  TeacherDashboard(){
        $masomo = AddSubject::where('added_by', auth()->user()->id)->get();
        $paper = Paper::where('added_by', auth()->user()->id)->get();
        $subject = AddSubject::where('added_by', auth()->user()->id)->get();
        return view('Userpage/Teacher/TeacherDashboard', compact('masomo','paper', 'subject'));
}

    //SUBCATEGORY MENU MANAGER


    //ADD PAPER DESCRIPTION
    public function Paper_Manager() {

        $masomo = Paper::where('added_by', auth()->user()->id)->get();
        $subject = AddSubject::where('added_by', auth()->user()->id)->get();

        return view('Userpage/Teacher/Inc/Paper', compact('masomo', 'subject'));
    }

//paper description
public function Paper_Manager_AddPaper(Request $request) {

    $request->validate([
        'quizname' => 'required',
        'topiccovered' => 'required',
        'description' => 'required',
    ]);
            //Addin new subject to the database
   $paper = new Paper();
   $paper -> quizname = $request -> input('quizname');
   $paper -> topiccovered = $request -> input('topiccovered');
   $paper -> description = $request -> input('description');

   // get the logged-in teacher's ID and add it to the subject instance
   $teacher = Auth::user();
   $paper->added_by = $teacher->id;

   $paper-> save();

   return redirect()->back()->with('success', 'Upload successful');
}


public function AddQuiz_Manager()
{
    $subject = AddSubject::where('added_by', auth()->user()->id)->get();
    $papername = Paper::where('added_by', auth()->user()->id)->pluck('quizname');
    
    $paperquestion = testquestions::where('teacher_id', auth()->user()->id)->get();
    $publishedquestion  = QuestionBank::all();

    $selectedPaper = Paper::where('added_by', auth()->user()->id)->pluck('quizname'); // Define the selectedPaper variable
    

    return view('Userpage/Teacher/Inc/AddQuiz', compact('subject', 'selectedPaper', 'papername', 'paperquestion', 'publishedquestion'));
}

  

public function AddQuiz_Manager_AddQuiz(Request $request)
{
    // Validate request data
    $request->validate([
        'subject' => 'required',
        'questionType' => 'required',
        'title' => 'required',
        'correct_answer' => 'required',
    ]);

    // Create a new question instance and set its properties
    $question = new testquestions();
    $question->questionType = $request->input('questionType');
    $question->title = $request->input('title');
    $question->option1 = $request->input('option1');
    $question->option2 = $request->input('option2');
    $question->option3 = $request->input('option3');
    $question->teacher_id = Auth::id(); // set the current teacher's ID as the owner of the question
    

    
    $correctAnswer= $request->input('correct_answer');
    if ($correctAnswer == "option1") {
        $question->correct_answer = $request->input('option1');
    } elseif ($correctAnswer == "option2") {
        $question->correct_answer = $request->input('option2');
    } else {
        // Handle the case when "option3" is selected (if applicable)
        $question->correct_answer = $request->input('option3'); // or set it to NULL if option3 is not available
    }
    
    // Get the subject instance based on the input value
    $subject = AddSubject::find($request->input('subject'));

    // Check if the subject exists
    if ($subject) {
        $question->subject_id = $subject->id;
        $question->subject = $subject->subject;
    } else {
        // Handle the case when the subject does not exist
        return redirect()->back()->with('error', 'Invalid subject');
    }

    // Get the paper instance based on the input value
    $papername = Paper::where('quizname', $request->input('quizname'))->first();

    // Check if the paper exists
    if ($papername) {
        $question->quizname = $papername->quizname;
    } else {
        // Handle the case when the paper does not exist
        return redirect()->back()->with('error', 'Invalid quizname');
    }

    $teacher = Auth::user();
    $question->teacher_id = $teacher->id;

    // Save the question to the database
    $question->save();

    // Redirect to a success page
    return redirect()->back()->with('success', 'Question added successfully');
}



public function publishQuestions(Request $request)
{
    $action = $request->input('action');
    $selectedQuestions = $request->input('selectedQuestions');

    // Check if any questions are selected
    if (!empty($selectedQuestions)) {
        if ($action === 'publish') {
            // Publish the selected questions
            foreach ($selectedQuestions as $questionId) {
                // Retrieve the question details
                $question = testquestions::find($questionId);
                if ($question) {
                    // Find the subject for the question
                    $subject = AddSubject::where('subject', $question->subject)->first();
                    $teacher = Auth::user();
                    if ($subject) {
                        // Create a new entry in the QuestionBank table
                        $publishedQuestion = new QuestionBank();
                        $publishedQuestion->question_id = $question->id;
                        $publishedQuestion->paper_name = $question->quizname;
                        $publishedQuestion->subject_name = $question->subject;
                        $publishedQuestion->subject_id = $subject->id;
                        $publishedQuestion->question = $question->title;
                        $publishedQuestion->question_type = $question->questionType;
                        $publishedQuestion->option1 = $question->option1;
                        $publishedQuestion->option2 = $question->option2;
                        $publishedQuestion->option3 = $question->option3;
                        $publishedQuestion->correct_answer = $question->correct_answer;
                        $publishedQuestion->teacher_id = $teacher->id;

                        // Save the published question
                        $publishedQuestion->save();
                    } else {
                        return response()->json(['message' => 'Validation failed']);
                    }
                } else {
                    return back()->with('success', 'Questions published successfully');
                }
            }

            // Redirect back with success message
            return redirect()->back()->with('success', 'Questions published successfully');
        } elseif ($action === 'delete') {
            // Delete the selected questions
            foreach ($selectedQuestions as $questionId) {
                // Find the question by ID
                $question = testquestions::find($questionId);

                if ($question) {
                    // Delete the question
                    $question->delete();
                }
            }

            // Redirect back with success message
            return redirect()->back()->with('success', 'Questions deleted successfully');
        }
    }

    // No questions selected, handle the case accordingly
    return redirect()->back()->with('error', 'No questions selected');
}

public function subject()
{
    return $this->belongsTo(AddSubject::class, 'subject_id');
}



public function Exam_Participation_Report_Manager()
{
    $assignedSubjects = StudentWithSubject::with('studentUser')->get();
    
    return view('UserPage/Teacher/Inc/Exam_Participation_Report', compact('assignedSubjects'))
        ->with('success', 'Sent Successfully');
}

    

    //for Message_Manage
    public function  Message_Manager(){
        return view('UserPage/Teacher/Inc/Message');
    }








    //CODE ZA MYSUBJECT
    
    //for MySubject_Manager ----------------------------------------------------view
    public function  MySubject_Manager(){
        return view('UserPage/Teacher/Inc/MySubject');
    }

    //for MySubject_Manager ----------------------------------------------------Adding Subject
    public function  MySubject_Manager_AddSubject(Request $request){
       // session()->start();
        $this -> validate($request, [
            'subject' => 'required',
            'description' => 'required'


        ]);
           //Addin new subject to the database
       $subject = new AddSubject;
       $subject -> subject = $request -> input('subject');
       $subject -> description = $request -> input('description');
 
       // get the logged-in teacher's ID and add it to the subject instance
       $teacher = Auth::user();
       $subject->added_by = $teacher->id;

       $subject-> save();

       //redirection to home page for now
        return redirect()->route('add_subject')->with('success', 'Item added successfully!');

    }

 

//for MySubject_Manager ----------------------------------------------------Uploading Subject
public function MySubject_Manager_UploadSubject(Request $request) {
    $validator = Validator::make($request->all(), [
        'subject' => 'required',
        'attachment_type' => 'required',
        'attachment_file' => 'required',
        'topic' => 'required'
    ], [
        'subject.required' => 'Please select a subject',
        'attachment_type.required' => 'Please select an attachment type',
        'attachment_file.required' => 'Please select a file to upload',
        'topic.required' => 'Please enter a topic'
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator);
    }

    // Add new subject to the database
    $upload = new Upload_Learning_Material;
    $upload->attachment_type = $request->input('attachment_type');
    $upload->topic = $request->input('topic');
    
    if ($request->hasFile('attachment_file')) {
        $attachment = $request->file('attachment_file');
        $attachmentPath = $attachment->store('Uploaded');
        $upload->attachment_file = public_path($attachmentPath);
    } else {
        return redirect()->back()->with('error', 'No attachment attached');
    }
    

    // Get the logged-in teacher's ID and add it to the subject instance
    $teacher = Auth::user();
    $upload->uploaded_by = $teacher->id;

    // Get the subject instance based on the input value
    $subjects = AddSubject::where('subject', $request->input('subject'))->first();
    if (!$subjects) {
        return redirect()->back()->with('error', 'Invalid subject');
    }
    $upload->subject = $subjects->subject;

    $upload->save();

    return redirect()->back()->with('success', 'Upload successful');
    
}






//DELETE SUBJECT
public function MySubject_Manager_DeleteUploadSubject($id){
    // Find the question by ID
    $data= Upload_Learning_Material::find($id);

    if (!$data) {
        // Handle the case when the question does not exist
        return redirect()->back()->with('error', 'Question not found');
    }

    // Delete the question
    $data->delete();

    // Redirect back with success message
    return redirect()->back()->with('success', 'Question deleted successfully');
}



//view uploaded and added subject file controller
public function MySubject_Manager_AddSubjectView()
{
    $masomo = AddSubject::where('added_by', auth()->user()->id)->get();

    $data = Upload_Learning_Material::where('uploaded_by', auth()->user()->id)->get();

    return view('Userpage.Teacher.Inc.MySubject', compact('masomo', 'data'));  
}

    public function MySubject_Manager_AddSubjectDownload($file)
    {
        $filePath = Upload_Learning_Material::find($file);

    if (file_exists($filePath)) {
        return response()->download($filePath);
    } else {
        abort(404); // Return a 404 Not Found error if the file doesn't exist
    }
    }



        //END YA KODI ZA MY SUBJECT 


        // for ParentRequest_Manager
    public function  ParentRequest_Manager(){
        return view('UserPage/Teacher/Inc/ParentRequest');
    }
        //for Student_Enroll_Report_Manager
    public function Student_Enroll_Report_Manager(){
        return view('UserPage/Teacher/Inc/Student_Enroll_Report');
    }

}
