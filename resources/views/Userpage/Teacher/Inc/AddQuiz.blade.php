<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Teacher</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link rel="stylesheet" href="/vendor/fontawesome-free/css/all.min.css">

    <script src="{{ asset('js/popup.js') }}"></script>

</head>

<body>
  <div id="loading-screen" class="loading-screen d-none">
    <div class="spinner-border" role="status">
      <span class="visually-hidden">Loading...</span>
    </div>
  </div>
  <div id="blur-overlay" class="blur-overlay d-none"></div>



  
  <nav class="navbar navbar-dark sticky-top bg-light flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" href="/"> << Home</a>
   <ul class="navbar-nav px-3" >
      {{-- Logout code --}}
      <li class="nav-item text-nowrap">
        @if (auth()->check())
        <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button class="btn btn-primary btn-md" type="submit">Logout</button>
        </form>
        @endif
      </li>
    </ul>
  </nav>

  <div class="container">
    <div class="row">
      <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between sticky-top flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2 shadow-sm">Welcome {{ auth()->user()->role }} {{ auth()->user()->name }}</h1>
          
          {{-- Code for message ya kuregister --}}
          @if (session()->has('success'))
          <div class="alert alert-success">
            {{ session('success') }}
          </div>
          @endif

       
          <div class="btn-toolbar mb-2 mb-md-0">
            <a class="btn btn-outline-dark" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
            Menu
            </a>
            <div></div>
            <div class="btn-group mr-2">
               <button class="btn  btn-outline-success btn-md ms-auto" data-bs-toggle="modal" data-bs-target="#Profile" title="Profile" data-bs-toggle="tooltip" data-bs-placement="top"> Profile</button>
            </div>
          </div>
   </div>

        <canvas class="my-4 w-100" id="myChart" width="300" height="0.1"></canvas>

    
        @if($errors->any())
         <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
          </div>
        @endif
    
        {{-- quiz add view --}}
        <div class="card mb-5">
          <div class="card-header">
              <h5>{{ __('Add Quiz Questions For: ') }}</h5>
          </div>
      
          <div class="card-body mb-3">
            <form action="{{ route('addQuiz') }}" method="POST" id="question-form">
              @csrf
          
              <div class="col-md-5">
                  <select id="question-type" class="form-select" aria-label="Default select example" name="questionType" required>
                      <option disabled selected><strong>Question Type</strong></option>
                      <option value="MultipleChoice">Multiple Choice</option>
                      <option value="TrueFalse">True & False</option>
                  </select>
              </div>
          
              {{-- Paper name --}}
              <div class="mb-3">
                  <label for="paper-name" class="form-label"><strong>Paper Name</strong></label>
                  @if ($papername->count() > 0)
                      <select class="form-select" id="paper-name" name="quizname" required>
                          <option disabled selected>Select a paper name</option>
                          @foreach ($papername as $quizId => $name)
                              <option value="{{ $name }}">{{ ucwords($name) }}</option>
                          @endforeach
                      </select>
                  @else
                      <select disabled selected class="form-select" style="background-color:rgba(223, 20, 20, 0.753); color:rgb(255, 255, 255); text-align:center; font-size:15px">
                          <option disabled selected>Add Paper Name</option>
                      </select>
                  @endif
              </div>
          
              {{-- Subject --}}
              <div class="mb-3">
                  <label for="subject-select" class="form-label"><strong>Subject</strong></label>
                  @if ($subject->count() > 0)
                      <select class="form-select" id="subject-select" name="subject" required>
                          <option disabled selected>Select a subject</option>
                          @foreach ($subject as $subj)
                              <option value="{{ $subj->id }}">{{ ucwords($subj->subject) }}</option>
                          @endforeach
                      </select>
                  @else
                      <select disabled selected class="form-select" style="background-color:rgba(223, 20, 20, 0.753); color:rgb(255, 255, 255); text-align:center; font-size:15px">
                          <option disabled selected>Add Subject To Proceed</option>
                      </select>
                  @endif
              </div>

              {{-- Question name --}}
              <div class="form-group mb-2">
                  <label for="title"><strong>Question</strong></label>
                  <textarea type="text" class="form-control" name="title" id="title" required></textarea>
                  @error('title')
                      <span class="text-danger">{{ $message }}</span>
                  @enderror
              </div>
          
              {{-- Answer option 1 --}}
              <div class="form-group mb-2">
                <label for="answer_option1"><strong>Answer Option 1</strong></label>
                <input type="text" class="form-control" name="option1" id="answer_option1" required onchange="updateCorrectAnswer()">
                  @error('answer_option1')
                      <span class="text-danger">{{ $message }}</span>
                  @enderror
              </div>
          
              <div class="form-group mb-2">
                  <label for="answer_option2"><strong>Answer Option 2</strong></label>
                    <input type="text" class="form-control" name="option2" id="answer_option2" required onchange="updateCorrectAnswer()">
                  @error('answer_option2')
                      <span class="text-danger">{{ $message }}</span>
                  @enderror
              </div>
          
              <div id="answer-option3" class="row mb-3" style="display: none;">
                  <div class="form-group">
                      <label for="answer_option3"><strong>Answer Option 3</strong></label>
                       <input type="text" class="form-control" name="option3" id="answer_option3" onchange="updateCorrectAnswer()">
                      @error('answer_option3')
                          <span class="text-danger">{{ $message }}</span>
                      @enderror
                  </div>
              </div>
          
              {{-- Correct answer --}}
              <div class="form-group mb-2">
                  <label for="selected_answer"><strong>Correct Answer</strong></label>
                  <div class="form-check">
                      <input class="form-check-input" type="radio" name="correct_answer" id="selected_answer1" value="option1" required>
                      <label class="form-check-label" for="selected_answer1">
                          <span id="correct_answer_label_1">Answer Option 1</span>
                      </label>
                  </div>
                  <div class="form-check">
                      <input class="form-check-input" type="radio" name="correct_answer" id="selected_answer2" value="option2" required>
                      <label class="form-check-label" for="selected_answer2">
                          <span id="correct_answer_label_2">Answer Option 2</span>
                      </label>
                  </div>
                  <div id="answer-option3-radio" class="form-check" style="display: none;">
                      <input class="form-check-input" type="radio" name="correct_answer" id="selected_answer3" value="option3" required>
                      <label class="form-check-label" for="selected_answer3">
                          <span id="correct_answer_label_3">Answer Option 3</span>
                      </label>
                  </div>
                  @error('correct_answer')
                      <span class="text-danger">{{ $message }}</span>
                  @enderror
              </div>
          
              <button type="submit" id="submit-quiz-btn" class="btn btn-primary" style="display: block;">Submit Quiz</button>
            </form>
          
      
              @php
        

              @endphp
             {{-- Script ya ku enable na disable radio batun ya answer 3 kama mtu akichagua multiple choice au true and false  --}}
              <script>
                  var questionTypeSelect = document.getElementById('question-type');
                  var answerOption3Div = document.getElementById('answer-option3');
                  var answerOption3Radio = document.getElementById('answer-option3-radio');
                //  var addQuestionBtn = document.getElementById('add-question-btn');
                  var submitQuizBtn = document.getElementById('submit-quiz-btn');
                  var quizForm = document.getElementById('quiz-form');
                  var questionCounter = 1;
      
                  questionTypeSelect.addEventListener('change', function() {
                      if (questionTypeSelect.value === 'TrueFalse') {
                          answerOption3Div.style.display = 'none';
                          answerOption3Radio.style.display = 'none';
                      } else {
                          answerOption3Div.style.display = 'block';
                          answerOption3Radio.style.display = 'block';
                      }
                  });
      
                  addQuestionBtn.addEventListener('click', function() {
                      var questionDiv = document.createElement('div');
                      questionDiv.innerHTML = `
                          <hr>
                          <h3>Question ${questionCounter}</h3>
                          <!-- Remaining question fields... -->
                      `;
                      quizForm.insertBefore(questionDiv, submitQuizBtn);
      
                      questionCounter++;
                  });

               
                    
      
                 
              </script>
          </div>
        </div>
      

   

          {{-- Question  To be Published --}}
        <div class="card mb-5">
            <div class="card-header">
                <h5>
                    @if ($papername->count() > 0)
                        <select class="form-select" id="paper-name" name="quizname"   style="background-color: rgba(190, 76, 23, 0.753); color: rgb(233, 233, 233); text-align: center; font-size: 15px"> required>
                            <option disabled selected>Select a paper name</option>
                            @foreach ($papername as $quizname)
                                <option value="{{ $quizname }}" @if ($selectedPaper === $quizname) selected @endif>
                                    {{ ucwords($quizname) }}
                                </option>
                            @endforeach
                        </select>
                    @else
                        <select disabled selected class="form-select"
                            style="background-color: rgba(223, 20, 20, 0.753); color: rgb(255, 255, 255); text-align: center; font-size: 15px">
                            <option disabled selected>No Paper Added</option>
                        </select>
                    @endif
                </h5>
            </div>
          <form action="{{ route('publishQuestions') }}" method="POST">
              @csrf
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-sm">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Paper Name</th>
                                <th>Question</th>
                                <th>Subject</th>
                                <th>Question Type</th>
                                <th> Answer 1</th>
                                <th> Answer 2</th>
                                <th> Answer 3</th>
                                <th>Correct Answer</th>
                                <th>QN TO POST</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @if ($paperquestion->count() > 0)
                            <?php $questionNumber = 1  ?>
                                @foreach ($paperquestion as $question)
                                 
                                    <tr class="table-light table-hover" >
                                        <td>{{ $questionNumber++ }}</td>
                                        <td>{{ ucwords($question->quizname) }}</td>
                                        <td style="color: green">{{ ucwords($question->title) }} ?</td>
                                        <td style="color: rgb(17, 0, 255)">{{ ucwords($question->subject) }}</td>
                                        <td>{{ ucwords($question->questionType) }}</td>
                                        <td>{{ ucwords($question->option1) }}</td>
                                        <td>{{ ucwords($question->option2) }}</td>

                                        @if (!is_null($question->option3))
                                          <td>{{ ucwords($question->option3) }}</td>
                                         @else
                                          <td style="color: red; text-align:center">---</td>
                                        @endif
  

                                        <td>{{ ucwords($question->correct_answer) }}</td>
                                        
                                        <td style="text-align: center;">
                                          <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="selectedQuestions[]" value="{{ $question->id }}" id="flexCheckDefault" style="width: 25px; height: 25px; background-color: rgb(149, 163, 170); border: 2px solid rgb(0, 0, 0);">
                                          </div>
                                        </td>
                                                                            
                                                            
                                        
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6" class="text-center">No data available</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card-footer">
              <button id="publish-btn" type="submit" class="btn btn-outline-success btn-publish" name="action" value="publish">Publish Questions</button>
              <button id="delete-btn" type="submit" class="btn btn-outline-danger btn-delete" name="action" value="delete">Delete Questions</button>
              </div>
              
            
            
          </form>
        </div>
        <script>
          $(document).ready(function() {
            $('.btn-publish, .btn-delete').click(function() {
              var button = $(this);
              button.addClass('disabled');
              $('#loading-screen').removeClass('d-none');
              $('#blur-overlay').removeClass('d-none');
            });
          });
        </script>
        

          {{-- Published question  Score --}}
       <div class="card mb-5 shadow">
          <div class="card-header">
              <h5>PUBLISHED QUESTIONS</h5>
          </div>
        <form action="{{ route('publishQuestions') }}" method="POST">
            @csrf
          <div class="card-body">
              <div class="table-responsive">
                  <table class="table table-bordered table-striped table-sm" >
                      <thead class="table-light">
                          <tr>
                              <th></th>
                              <th >No</th>
                              <th>Paper Name</th>
                              <th>Question</th>
                              <th>Subject</th>
                              <th>Question Type</th>
                              <th> Answer 1</th>
                              <th> Answer 2</th>
                              <th> Answer 3</th>
                             
                                           
                          </tr>
                      </thead>
                      <tbody class="shadow" >
                          @if ($publishedquestion->count() > 0)
                          <?php $questionNumber = 1  ?>
                              @foreach ($publishedquestion as $question)
                               
                                  <tr class="table-light table-hover " >
                                      <td style="color: rgb(207, 178, 14)">✔</td>
                                      <td >{{ $questionNumber++ }} </td>
                                      <td>{{ ucwords($question->paper_name) }}</td>
                                      <td  style="color: green">{{ ucwords($question->question) }} ?</td>
                                      <td style="color: rgb(17, 0, 255)">{{ ucwords($question->subject_name) }}</td>
                                      <td>{{ ucwords($question->question_type) }}</td>
                                      <td>{{ ucwords($question->option1) }}</td>
                                      <td>{{ ucwords($question->option2) }}</td>

                                      @if (!is_null($question->option3))
                                        <td>{{ ucwords($question->option3) }}</td>
                                       @else
                                        <td style="color: red">***</td>
                                      @endif
                                     

                                   
                    
                                  </tr>
                              @endforeach
                          @else
                              <tr>
                                  <td colspan="6" class="text-center">No data available</td>
                              </tr>
                          @endif
                      </tbody>
                  </table>
              </div>
          </div>

        </form>
      </div>

    </div>
        
     
    </main>
    </div>
  </div>




   {{-- Profile modal tyake  --}}
  <div class="modal fade " id="Profile" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="examplModalLabel">My Profile</h5> 
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        {{-- profile --}}
        <div class="modal-body ">
          <form action="#" method="#" enctype="multipart/form-data" id="AddSubject">
            @csrf
            <div class="row mb-3">
              <div class="col-md-3">
                <label for="name" class="form-label">Name:</label>
              </div>
              <div class="col-md-9">
                <h5 style="color: #8a2e17;">{{ auth()->user()->name }}</h5>
              </div>
            </div>
          
            <div class="row mb-3">
              <div class="col-md-3">
                <label for="phone" class="form-label">Phone:</label>
              </div>
              <div class="col-md-9">
                <h5 style="color: #8a2e17;">{{ auth()->user()->phone }}</h5>
              </div>
            </div>
          
            <div class="row mb-3">
              <div class="col-md-3">
                <label for="email" class="form-label">Email:</label>
              </div>
              <div class="col-md-9">
                <h5 style="color: #8a2e17;">{{ auth()->user()->email }}</h5>
              </div>
            </div>
          
            <div class="row mb-3">
              <div class="col-md-3">
                <label for="role" class="form-label">Role:</label>
              </div>
              <div class="col-md-9">
                <h5 style="color: #8a2e17;">{{ auth()->user()->role }}</h5>
              </div>
            </div>
          
            <div class="row mb-3">
              <div class="col-md-3">
                <label for="employee_number" class="form-label">Employee Number:</label>
              </div>
              <div class="col-md-9">
                <h5  style="color: #8a2e17;">{{ auth()->user()->employee_number }}</h5>
              </div>
            </div>
          
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Edit</button>
            </div>
          </form>
          
        
       
      </div>
    </div>
  </div> 

  </div>
  
<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" data-bs-scroll="true" aria-labelledby="offcanvasExampleLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasExampleLabel">Dashboard</h5>   
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <div class="sidebar">
      <nav  class=" d-md-block bg-light sidebar collapse">
        <div class="position-sticky pt-3">
          <ul class="nav flex-column">
            {{-- hii inaonesha dashboard --}}
            <li class="nav-item">
              <a class="nav-link  "  href="/TeacherDashboard">
                  <span data-feather="home"></span>
                  My Dashboard
             </a>
            </li>{{--mwisho wa code zinazoonesha dashboard --}}
    
            {{-- code ya kuonesha jinsi ya parent kua add mwanafunzi --}}
            <li class="nav-item">
              <a class="nav-link active" href="/Inc/Message">
                <span data-feather="file"></span>
                 Message
              </a>
            </li>
    
            {{-- Code za kuadd somo kwa mwanafunzi --}}
            <li class="nav-item">
              <a class="nav-link"style="color: #b84326; " aria-current="page" href="/Inc/MySubject">
                <span data-feather="shopping-cart"></span>
                <b>My Subject <span class=" badge rounded-pill bg-danger"> {{ ucwords($subject->count()) }}</span> </b>
              </a>
            </li>
    
            {{-- Kuangalia progress yake --}}
            <li class="nav-item">
              <a class="nav-link "  href="/Inc/Paper">
                <span data-feather="users"></span>
              Add Quiz
              </a>
            </li>
    
            {{-- code za kuangalia status ya mtihani kama ni done au not done --}}
            <li class="nav-item">
              <a class="nav-link" href="/Inc/Discussion">
                <span data-feather="bar-chart-2"></span>
              View Discussion
              </a>
            </li>

               {{-- code za kuangalia status ya mtihani kama ni done au not done --}}
               <li class="nav-item">
                <a class="nav-link" href="/Inc/ParentRequest">
                  <span data-feather="bar-chart-2"></span>
                View Parent Request
                </a>
              </li>
       
    
          <h4 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
            <span class="shadow">Reports</span>
            
          </h4>
          <ul class="nav flex-column mb-2">
            <li class="nav-item">
              <a class="nav-link" href="/Inc/Exam_Participation_Report">
                <span data-feather="file-text"></span>
               Exams Participant Report
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/Inc/Subject_Enroll_Report">
                <span data-feather="file-text"></span>
               Subject Enroll Report
              </a>
            </li>
         
        </div>
      </nav>
    </div>
 
  </div>
  </div>






  <footer class="footer">
  
  <p>
      &copy; All Right Reerved 2023
      <br>
      <b>Work of Ashura Kiemba </b>
        
  </p>
  </footer>
</body>