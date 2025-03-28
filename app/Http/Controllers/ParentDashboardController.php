<?php

namespace App\Http\Controllers;


use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\StudentWithSubject;
use App\Models\AddSubject;
use App\Models\QuestionBank;
use App\Models\testquestions;
use App\Models\studentTest; // Import the SelectedQuestion model at the top of the file



use Illuminate\Http\Request;

class ParentDashboardController extends Controller
{
    public function ParentDashboard()
    {
        $teacher = User::where('parent_id', auth()->user()->id)->where('role', 'student')->get();
        
        $StudentWithSubject = StudentWithSubject::where('parent')->get();
        
        return view('UserPage.Parent.ParentDashboard',compact('teacher', 'StudentWithSubject'));
    }



    public function ManageAccount()
    {
        // Retrieve only the student accounts created by the parent
        $accounts =  User::where('parent_id', auth()->user()->id)->where('role', 'student')->get();
        return view('UserPage.Parent.Inc.StudentAccount', compact('accounts'));
    }


    //controller ya ku manage parent account
    public function ManageAccountManager(Request $request)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'role' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:10'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // Create a new instance of the User model
       
        

        $user = new User();

        // Set the attributes for the new user
        $parent= Auth::user();
        $user->parent_id = $parent->id;

        $user->name = $validatedData['name'];
        $user->username = $validatedData['username'];
        $user->role = $validatedData['role'];
        $user->phone = $validatedData['phone'];
        $user->password = Hash::make($validatedData['password']);
         

        // Save the new user to the database
        $user->save();

        // Perform any other necessary operations

        // Flash a success message to the session
        //Session::flash('success', 'Operation completed successfully.');

        // Redirect back to the previous page with a success message
        return redirect()->back()->with('success', 'Account created successfully');
    }


    //`controller ya kuview manage subject 
    public function ManageSubject()
    {
        $teacher = User::where('role', 'teacher')->get();
        $accounts = User::where('parent_id', auth()->user()->id)->where('role', 'student')->get();
        $masomo = AddSubject::where('added_by', '!=', auth()->user()->id)->get();
    
        //inachukua id ya mwalimu na mwanaunzi na ku fananisha kweny tbl studentwithsubj 
        $studentIds = User::where('parent_id', auth()->user()->id)
            ->where('role', 'student')
            ->pluck('id');
    
        $StudentWithSubject = studentWithSubject::whereIn('student', $studentIds)
            ->where('parent', auth()->user()->id)
            ->get();
    
      // Filter the allowed subjects with test = 'yes'
        $allowedSubjects = $StudentWithSubject->filter(function ($subject) {
            return strcasecmp($subject->test, 'yes') === 0;
        });

        // Get the question bank for the allowed subjects
        $questionBank = QuestionBank::whereIn('subject_id', $allowedSubjects->pluck('subject'))->get();

        return view('UserPage.Parent.Inc.ManageSubject', compact('accounts', 'questionBank', 'masomo', 'allowedSubjects', 'teacher', 'StudentWithSubject'));
    }

    public function storeSelectedQuestions(Request $request)
    {
        $subjectName = $request->input('subjectName');
        $selectedQuestions = $request->input('selectedQuestions');
        $parentId = User::where('role', 'parent')->pluck('id')->first();
        $studentId = User::where('parent_id', $parentId)->pluck('id')->first();

      

        // Store the selected questions in the database
        foreach ($selectedQuestions as $questionIndex => $selectedQuestion) {
            studentTest::create([
                'subject_name' => $subjectName,
                'question_index' => $selectedQuestion,
                'student_index' => $studentId,
                'parent_index' => $parentId ->id,
            ]);
        
        }
        
    
        // Redirect back with success message
        return redirect()->back()->with('success', 'Questions added successfully');
    }
    
    

    
    
    
    

    public function ManageSubjectManager(Request $request)
    {
        // Retrieve only the student accounts created by the parent
        
        $validatedData = $request->validate([
            'student' => 'required',
            'subjects' => 'required|array',
            'subjects.*' => 'exists:add_subjects,id', // Validate each subject ID exists in the "add_subjects" table
            'test' => 'nullable',
            'teacher' => 'nullable',
            'description' => 'nullable',
    ]);
         $existingSubject = StudentWithSubject::where('student', $validatedData['student'])
         ->whereIn('subjects', $validatedData['subjects'])
         ->first();

        if ($existingSubject)
            {
            return redirect()->back()->with('error', 'Subject already added for the student');
            }
            
        else{
            $studentWithSubject = new StudentWithSubject();
            $studentWithSubject->student = $validatedData['student'];
            $studentWithSubject->subjects = implode(',', $validatedData['subjects']);
            $studentWithSubject->test = $validatedData['test'];
            $studentWithSubject->teacher = $validatedData['teacher'];
            $studentWithSubject->description = $validatedData['description'];
            $studentWithSubject->parent = auth()->user()->id;
    
            $studentWithSubject->save();
    
    
            return redirect()->back()->with('success', 'Account created successfully');
        }
    }

    public function TeacherAvailable()
    {
        // Retrieve only the student accounts created by the parent
        $teacher = User::where('role', 'teacher')->get();
        $accounts =  User::where('parent_id', auth()->user()->id)->where('role', 'student')->get();
        $masomo = AddSubject::where('added_by',  auth()->user()->id)->get();
        
        // Check if there is any submitted data for the current user
        $StudentWithSubject = StudentWithSubject::where('parent', auth()->user()->id)->get();
    
        return view('UserPage.Parent.Inc.TeacherAvailable', compact('accounts', 'masomo', 'teacher', 'StudentWithSubject'))-> with('success', 'Question Sent Successfully');
    }

    public function ExamStatusResult()
    {
        $assignedSubjects = StudentWithSubject::with('studentUser')->get();
    
        return view('UserPage.Parent.Inc.ExamStatus', compact('assignedSubjects'))
            ->with('success', 'Sent Successfully');
    }
}
