<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faq;
use GuzzleHttp\Psr7\Message;

class HelpController extends Controller
{

    //Function ya kuview FAQ
    public function index(){
        return view('viewFaq');
    }

    //function ya kutuma FAQ kwenye Database
    public function submit(Request $request){
        $this -> validate($request, [
            'email' => 'required',
            'question' => 'required'


        ]);
       //create new frequent asked qustion
       $faq = new Faq;
       $faq -> email = $request -> input('email');
       $faq -> message = $request -> input('question');

       //save question
       $faq -> save();
       $messages = Faq:: all();
       //redirection to home page for now
       return redirect('') -> with('success', 'Question Sent Successfully');
       
       



    }

    //Function ya kudisplay FAQ kutoka kwenye DB
    public function viewFaq(){
        $messages = Faq:: all();
        
        return view('FaqView') -> with('messages', $messages);
    }

}
