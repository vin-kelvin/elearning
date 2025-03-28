<?php

namespace App\Http\Controllers;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

use App\Models\User;
use App\Models\AddSubject;
use App\Models\studentWithSubject;
use App\Models\QuestionBank;
use App\Models\testquestions;
use App\Models\testanswers;
use App\Models\TestResult;
use Illuminate\Support\Facades\Auth;
use App\Models\Upload_Learning_Material;

use App\PDF\StudentReportPDF;
use PDF;

use Illuminate\Http\Request;


class StudentDashboardController extends Controller
{           
    public function  StudentDashboard(){
    
    $student = studentWithSubject::where('student', auth()->user()->id)->get();
    $result = TestResult::where('User_id', auth()->user()->id)->get();
    return view('Userpage/Student/StudentDashboard',  compact('student', 'result'));
    }

    
    public function MyLearning()
    {
        $student = StudentWithSubject::where('student', auth()->user()->id)->first();
        $teacherId = Upload_Learning_Material::where('uploaded_by', auth()->user()->id)->get();

        if ($student) {
            $subjectId = AddSubject::pluck('subject');

            $assignedSubjects = Upload_Learning_Material::whereIn('subject', $subjectId)->get();
            //$maswali = QuestionBank::where('subject_id', $subjectId)->first();
        } else {
            $assignedSubjects = collect([]); // Assign an empty collection
            $maswali = null; // Set $maswali to null if the student is not found
        }
    
        return view('Userpage.Student.Inc.MyLearning', compact('assignedSubjects', 'teacherId'))
            ->with('success', 'Sent Successfully');
    }

    


    public function TakeQuiz()
    {

        $student = StudentWithSubject::where('student', auth()->user()->id)->first();

        if ($student) {
            $subjectId = AddSubject::pluck('id');

            $assignedSubjects = QuestionBank::whereIn('subject_id', $subjectId)->get();
            //$maswali = QuestionBank::where('subject_id', $subjectId)->first();
        } else {
            $assignedSubjects = collect([]); // Assign an empty collection
            $maswali = null; // Set $maswali to null if the student is not found
        }
        
        return view('Userpage.Student.Inc.TakeQuiz', compact('assignedSubjects', 'student'))
            ->with('success', 'Sent Successfully');
    }

    public function QuestionDay()
    {

        $student = StudentWithSubject::where('student', auth()->user()->id)->first();

        if ($student) {
            $subjectId = AddSubject::pluck('id');

            $assignedSubjects = QuestionBank::whereIn('subject_id', $subjectId)->get();
            //$maswali = QuestionBank::where('subject_id', $subjectId)->first();
        } else {
            $assignedSubjects = collect([]); // Assign an empty collection
            $maswali = null; // Set $maswali to null if the student is not found
        }
        
        return view('Userpage.Student.Inc.QuestionDay', compact('assignedSubjects', 'student'))
            ->with('success', 'Sent Successfully');
    }

   
    public function saveTest(Request $request)
    {
        // Get the submitted answers from the request
        $submittedAnswers = $request->except('_token');
        $studentId = auth()->user()->id;

        $teacher = Auth::user('role', 'teacher');
        $teacherId = $teacher->id;

        // Process and save the submitted answers
        foreach ($submittedAnswers as $questionId => $submittedAnswer) {
        // Retrieve the corresponding question from the database
        $question = QuestionBank::find($questionId);

        // Compare the submitted answer with the correct answer
        $isCorrect = ($submittedAnswer === $question->correct_answer);

        // Create a new TestResult record
        TestResult::create([
            'user_id' => $studentId,
            'question_id' => $questionId,
            'submitted_answer' => $submittedAnswer,
            'is_correct' => $isCorrect,
            'correct_answer' => $question->correct_answer,
            'teacher_id' => $teacherId,
            'updated_at' => now(),
            'created_at' => now(),
            'is_answered' => true,
        ]);

        // Mark the question as answered
        $question->is_answered = true;
        $question->student_id = $studentId;
        $question->save();
        }

        return back()->with('success', 'Test submitted successfully');
    }

    public function Result()
    {
        $student = auth()->user();
        $studentId = $student->id;
        $questions = QuestionBank::pluck('subject_name', 'question_id');
    
        if ($student) {
            $assignedSubjects = TestResult::whereIn('question_id', $questions->keys())->get();
        } else {
            $assignedSubjects = collect([]); // Assign an empty collection
        }
    
        $subjectNames = $questions->only($assignedSubjects->pluck('question_id'));
    
        return view('Userpage.Student.Inc.Result', compact('assignedSubjects', 'questions', 'subjectNames'))
            ->with('success', 'Sent Successfully');

    }

    public function generatePDF()
    {
        // Get the authenticated student
        $student = Auth::user();
        $studentId = $student->id;

        // Retrieve the test results for the student
        $testResults = TestResult::where('student_id', $studentId)->get();

        // Calculate the total score and average
        $totalScore = $testResults->sum('score');
        $averageScore = $testResults->avg('score');

        // Determine the student's position
        $position = TestResult::where('score', '>', $totalScore)->count() + 1;

        // Create a new instance of StudentReportPDF
        $pdf = new StudentReportPDF();

        // Generate the PDF content
        $content = view('pdf.student_report', compact('student', 'testResults', 'totalScore', 'averageScore', 'position'));

        // Generate the PDF and output as a download
        $pdf->generate($content);
    }

    public function downloadPDF()
    {
        // Get the authenticated student
        $student = auth()->user();
        $studentId = $student->id;
        
        // Retrieve the test results for the student
        $testResults = TestResult::where('student_id', $studentId)->get();
        
        // Calculate the total score and average
        $totalScore = $testResults->sum('score');
        $averageScore = $testResults->avg('score');
        
        // Determine the student's position
        $position = TestResult::where('score', '>', $totalScore)->count() + 1;
        
        // Create a new instance of Dompdf
        $dompdf = new Dompdf();
        
        // Generate the PDF content
        $pdfContent = view('pdf.student_report', compact('student', 'testResults', 'totalScore', 'averageScore', 'position'))->render();
        
        // Load the PDF content into Dompdf
        $dompdf->loadHtml($pdfContent);
        
        // Render the PDF
        $dompdf->render();
        
        // Output the PDF as a download
        return $dompdf->stream('student_report.pdf');
    }


    

    
}
    
    
    
    
    

    