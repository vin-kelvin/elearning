<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Parent</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <script src="{{ asset('js/app.js') }}"></script>
    {{-- comment <script src="{{ asset('js/popup.js') }}"></script>--}}

</head>

<body >
  <nav class="navbar navbar-dark sticky-top bg-light flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" href="/"> << Home</a>
   <ul class="navbar-nav px-5" >
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

  @if (session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif

  <div class="container">
    <div class="row">
      <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between sticky-top flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2 shadow-sm">My Subject(s)</h1>
          {{-- Code for message ya kuregister --}}
       

             {{-- Menun na profile --}}
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
       {{-- handle error --}}
              @if($errors->any())
              <div class="alert alert-danger">
                  <ul>
                      @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                     @endforeach
                  </ul>
              </div>
              @endif

        <canvas class="my-4 w-100" id="myChart" width="300" height="0.1"></canvas>

           {{-- Add subject view --}}
          <div class="card">
              <div class="card-header d-flex justify-content-between align-items-center">
                <h5>{{ __('My Subject(s)') }} <span class=" badge rounded-pill bg-danger"></span></h5>
                <button class="btn btn-primary btn-md ms-auto" data-bs-toggle="modal" data-bs-target="#AddSubject" title="Add New Subject" data-bs-toggle="tooltip" data-bs-placement="top">+</button>
              </div>
              
             <!-- Modal popn up AddSubject -->
            <div class="modal fade" id="AddSubject" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered " id="AddSubject">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Assaing Student Learning Subject</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  {{-- MASOMO NA MDA --}}
                <form action="{{ url('/ManageSubject') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="student" class="form-label">Student</label>
                            <select class="form-select" id="student" name="student" style="color:black !important;" required>
                                <option disabled selected>Select a Student</option>
                                @if ($accounts->count() > 0)
                                    @foreach ($accounts as $account)
                                        <option value="{{ $account->id }}">{{ $account->name }}</option>
                                    @endforeach
                                @else
                                    <option disabled selected>No Student</option>
                                @endif
                            </select>
                        </div>
                
                        <div class="card" style="margin-bottom: 10px;">
                            <div class="card-header"><label for="subject" class="form-label">Available Subjects</label></div>
                            <div class="card-body" style="display: flex; flex-wrap: wrap;">
                                @if ($masomo->count() > 0)
                                    @foreach ($masomo as $masomo)
                                        <div style="flex: 0 0 33.33%; margin-bottom: 10px;" value="{{ $masomo->id }}">
                                            <input class="form-check-input" type="checkbox" value="{{ $masomo->id }}" name="subjects[]">
                                            <label class="form-check-label" for="flexCheck1">{{ ucwords($masomo->subject) }}</label>
                                        </div>
                                    @endforeach
                                @else
                                    <div style="flex: 0 0 10%; margin-bottom: 10px; ">
                                        <label class="form-check-label" for="flexCheck1">Empty</label>
                                    </div>
                                @endif
                            </div>
                        </div>
                
                        <div class="mb-3">
                            <label for="test" class="form-label">Available On Test</label>
                            <select class="form-select" id="test" name="test" required>
                                <option disabled selected>Iwepo Kwenye Test Zake</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                
                        <div class="mb-3">
                            <label for="teacher" class="form-label">Suggested Teacher</label>
                            <select class="form-select" id="teacher" name="teacher" style="color:black !important;" required>
                                @if ($teacher->count() > 0)
                                    <option disabled selected>Select a Teacher</option>
                                    @foreach ($teacher as $teacher)
                                        <option value="{{ $teacher->id }}">{{ ucwords($teacher->name) }}</option>
                                    @endforeach
                                @else
                                    <option disabled selected>No Teachers available</option>
                                @endif
                            </select>
                        </div>
                
                        <div class="mb-3">
                            <label for="description" class="form-label">Request To Teacher:</label>
                            <textarea name="description" class="form-control" id="description" placeholder="Briefly describe what students are expected to learn" rows="2" required></textarea>
                            <div class="invalid-feedback">
                                Please enter a description. (Optional)
                            </div>
                        </div>
                    </div>
                
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" data-bs-dismiss="modal">Add</button>
                    </div>
                </form>
                
                </div>
              </div>
            </div>       {{-- end of pop up --}}
            
      
           {{-- view subject --}}
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered table-striped table-sm">
                    <thead class="table-light">
                        <tr>
                            <th>STUDENT</th>
                            <th>SUBJECT</th>
                            <th>ON TEST</th>
                            <th>TEACHER SUGGESTED</th>
                            <th>DESCRIPTION</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($StudentWithSubject->count() > 0)
                            @foreach ($StudentWithSubject as $data)
                            <tr class="table-light table-hover">
                                <td>{{ $data->user->name}}</td>
                                <td>{{ $data->subject->subject }}</td>
                                <td>{{ $data->test }}</td>
                                <td>{{ $data->teacherUser->name}}</td>
                                <td>{{ $data->description }}</td>
                                <td>
                                    <button type="submit" class="btn btn-outline-danger sm">Delete</button>
                                    <button type="submit" class="btn btn-outline-dark sm">Edit</button>
                                    <button type="button" class="btn btn-outline-success sm" data-bs-toggle="modal" data-bs-target="#addQuestionModal">
                                      Add Question
                                    </button>
                                    
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
          
          </div><br>



     


          
          <canvas class="my-4 w-100" id="myChart" width="300" height="0.1"></canvas>


     
     </main>
    </div>
  </div>

  @if (session('error'))
  <div class="alert alert-danger">
      {{ session('error') }}
  </div>
@endif

   {{-- Add question model --}}
   <div class="modal fade" id="addQuestionModal" tabindex="-1" aria-labelledby="addQuestionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            @if($allowedSubjects->isEmpty())
                <div class="modal-body">
                    <span>This subject is set for learning only and is not available in student tests</span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            @else
                <div class="modal-header">
                    <h5 class="modal-title" id="addQuestionModalLabel">Add Question</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <ul class="nav nav-tabs" id="questionTabs" role="tablist">
                        @foreach ($allowedSubjects as $subject)
                            @php
                                $subjectName = $subject->addSubject->subject ?? 'Unknown Subject';
                            @endphp
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ $loop->first ? 'active' : '' }}" id="tab{{ $subject->id }}" data-bs-toggle="tab" data-bs-target="#panel{{ $subject->id }}" type="button" role="tab" aria-controls="panel{{ $subject->id }}" aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                    {{ ucwords($subject->Subject->subject) }}
                                </button>
                            </li>
                        @endforeach
                    </ul>

                    <div class="tab-content" id="questionTabContent">
                        @if ($questionBank->count() > 0)
                            <form action="{{ route('storeSelectedQuestions') }}" method="POST" onsubmit="submitForm(event)">
                                @csrf
                                @foreach ($questionBank as $subject)
                                    <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="panel{{ $subject->id }}" role="tabpanel" aria-labelledby="tab{{ $subject->id }}">
                                        <input type="hidden" name="subjectName" value="{{ $subject->subject_name }}">
                                        @php
                                            $questions = $StudentWithSubject->filter(function ($question) use ($subject) {
                                                return $question->test == 'Yes' && $question->subject_id == $subject->subjects;
                                            });
                                        @endphp

                                        @if ($questions->isNotEmpty())
                                            <ul class="list-group">
                                                @foreach ($questionBank as $index => $question)
                                                    <li class="list-group-item">
                                                        <input class="form-check-input me-1" type="checkbox" name="selectedQuestions[]" value="{{ $index }}" aria-label="...">
                                                        <span>{{ ucwords($question->question) }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <p>No questions available for this subject.</p>
                                        @endif
                                    </div>
                                @endforeach
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                        @else
                            <p>No questions available.</p>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    function submitForm(event) {
        event.preventDefault();
        // Additional JavaScript logic can be added here
        // For example, you can show a confirmation dialog before submitting the form
        event.target.submit();
    }
</script>




  <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" data-bs-scroll="true" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title" id="offcanvasExampleLabel">Parent Dashboard</h5>   
      <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
      <div>
        <nav  class=" d-md-block bg-light sidebar collapse">
          <div class="position-sticky pt-3">
            <ul class="nav flex-column">
              {{-- hii inaonesha dashboard --}}
              <li class="nav-item">
                <a class="nav-link"href="/ParentDashboard" >
                 <i class="fa fa-dashboard" aria-hidden="true">
                    <span data-feather="home"></span>
                    Dashboard
                  </i>
               </a>
              </li>{{--mwisho wa code zinazoonesha dashboard --}}
      
              {{-- code ya kuonesha jinsi ya parent kua add mwanafunzi --}}
              <li class="nav-item">
                  <a class="nav-link " aria-current="page" href="/Inc/StudentAccount">
                  <span data-feather="file"></span>
                  Manage Student Account
                </a>
              </li>
      
              {{-- Code za kuadd somo kwa mwanafunzi --}}
              <li class="nav-item">
                <a class="nav-link active"  style="color: #b84326;" href="/Inc/ManageSubject">
                  <span data-feather="shopping-cart"></span>
                  Manage Subject 
                </a>
              </li>
      
              {{-- Kuangalia progress yake --}}
              <li class="nav-item">
                <a class="nav-link" href="#">
                  <span data-feather="users"></span>
                  Student Progress
                </a>
              </li>
      
              {{-- code za kuangalia status ya mtihani kama ni done au not done --}}
              <li class="nav-item">
                <a class="nav-link" href="#">
                  <span data-feather="bar-chart-2"></span>
                  Exams Status
                </a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="/Inc/TeacherAvailable">
                  <span data-feather="bar-chart-2"></span>
                  Teacher Available
                </a>
              </li>
         
      
            <h4 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
              <span>Student Reports</span>
              
            </h4>
            <ul class="nav flex-column mb-2">
              <li class="nav-item">
                <a class="nav-link" href="#">
                  <span data-feather="file-text"></span>
                 Exams Result Report
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">
                  <span data-feather="file-text"></span>
                 Learning Progress Report
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">
                  <span data-feather="file-text"></span>
               Last Visit Report
                </a>
              </li>
            </ul>
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
                <label for="name" class="form-label">Username:</label>
              </div>
              <div class="col-md-9">
                <h5 style="color: #8a2e17;">{{ auth()->user()->username }}</h5>
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
          
            
          
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Edit</button>
            </div>
          </form>
          
        
       
      </div>
    </div>
  </div> 




