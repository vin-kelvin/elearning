<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.72.0">
    <title>Exam Participant</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

</head>

<body>
    <nav class="navbar navbar-dark sticky-top bg-light flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" href="/"> << Home</a>
        <ul class="navbar-nav px-3">
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
            <main class="col-md-9">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2 shadow-sm">Result</h1>

                    {{-- Code for registration success message --}}
                    @if (session()->has('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif

                    <div class="btn-toolbar mb-2 mb-md-0">
                        <a class="btn btn-primary" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button"
                            aria-controls="offcanvasExample">
                            Menu
                        </a>
                        <div></div>
                        <div class="btn-group mr-2">
                            <button class="btn btn-outline-success btn-md ms-auto" data-bs-toggle="modal"
                                data-bs-target="#Profile" title="Profile" data-bs-toggle="tooltip"
                                data-bs-placement="top">
                                Profile
                            </button>
                        </div>
                    </div>
                </div>

                <canvas class="my-4 w-100" id="myChart" width="300" height="0.1"></canvas>
                <div class="row">
                    {{-- Content Area --}}
                    <div class="col-md-12">
                        <div class="subject-content">
                            <!-- Default content -->
                            <h5 class="shadow bg-warning col-md-12" style="text-align: center; height: 30px; font-style: italic">
                                <strong> View Your Results</strong>
                            </h5>
                        </div>
                        @foreach ($assignedSubjects as $subject)
                        <ul class="list-group">
                            <li class="list-group-item bg-warning">
                                <a href="#" class="list-group-item list-group-item-action" data-bs-toggle="modal" data-bs-target="#subjectModal{{ $subject->id }}">
                                    Student Name: {{ $subject }}
                                </a>
                            </li>
                        </ul>
                    
                        <!-- Subject Modal -->
                        <div class="modal fade" id="subjectModal{{ $subject->id }}" tabindex="-1" aria-labelledby="subjectModal{{ $subject->id }}Label" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="subjectModal{{ $subject->id }}Label">Available Results For {{ strtoupper($subject->subject_name) }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                    
                                    <div class="modal-body">
                                        <div class="card-body">
                                            {{-- Table to view uploaded files --}}
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>Question</th>
                                                            <th>Correct Answer</th>
                                                            <th>Student's Answer</th>
                                                            <th>Result</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($subject as $result)
                                                            <tr>
                                                                <td>{{ $result }}</td>
                                                                <td>{{ $result}}</td>
                                                                <td>{{ $result }}</td>
                                                                <td>
                                                                    @if ($result)
                                                                        <span class="text-success">Correct ✔</span>
                                                                    @else
                                                                        <span class="text-danger">Incorrect ❌</span>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    
                    
                    </div>
                </div>
                
                
            </main>

          
        </div>
    </div>

    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" data-bs-scroll="true" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
          <h5 class="offcanvas-title" id="offcanvasExampleLabel">Dashboard</h5>   
          <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
          <div>
            <nav  class=" d-md-block bg-light sidebar collapse">
              <div class="position-sticky pt-3">
                <ul class="nav flex-column">
                  {{-- hii inaonesha dashboard --}}
                  <li class="nav-item">
                    <a class="nav-link active " style="color: #b84326;" aria-current="page" href="/TeacherDashboard">
                    
                        <span data-feather="home"></span>
                        <b>My Dashboard</b>
                    
                   </a>
                  </li>{{--mwisho wa code zinazoonesha dashboard --}}
          
                  {{-- code ya kuonesha jinsi ya parent kua add mwanafunzi --}}
                  <li class="nav-item">
                    <a class="nav-link" href="/Inc/Message">
                      Message
                      <span class=" badge rounded-pill bg-danger">
                        +
                        <span class="visually-hidden">unread messages</span>
                      </span>
                        
                    </a>
                  </li>
          
                  {{-- Code za kuadd somo kwa mwanafunzi --}}
                  <li class="nav-item">
                    <a class="nav-link" href="/Inc/MySubject">
                      
                      My Subject 
                      <span class=" badge rounded-pill bg-danger">{{-- comment {{ ucwords($masomo->count()) }}--}}</span>
                    </a>
                  </li>
          
                  {{-- Kuangalia progress yake --}}
                  <li class="nav-item">
                    <a class="nav-link" href="/Inc/Paper">
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

    <div class="modal fade " id="Profile" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="examplModalLabel">My Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

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

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Edit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    
</body>

</html>
