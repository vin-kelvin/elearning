<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Teacher</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/popup.js') }}"></script>

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

  <div class="container">
    <div class="row">
      <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between sticky-top flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2 shadow-sm">QUIZ Description</h1>
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
                <h5>{{ __('Quiz Description') }} <span class=" badge rounded-pill bg-danger">{{ ucwords($masomo->count()) }}</span></h5>
                <button class="btn btn-primary btn-md ms-auto" data-bs-toggle="modal" data-bs-target="#AddSubject" title="Add New Subject" data-bs-toggle="tooltip" data-bs-placement="top">+</button>
              </div>
              
             <!-- Modal popn up AddSubject -->
            <div class="modal fade" id="AddSubject" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered " id="AddSubject">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Paper Description</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  {{-- MASOMO NA MDA --}}
                  <form action="{{ url('/Paper') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="title">Quiz Name</label>
                            <input type="text" class="form-control" name="quizname" placeholder="Example: Quiz 1" id="title" required>
                        </div>
                
                        <div class="mb-3">
                            <label for="subject" class="form-label">Topic Cover</label>
                            <select class="form-select" id="subject" name="topiccovered" required>
                                <option disabled selected>select</option>
                                <option value="all Topic">All Topic</option>
                                <option value="Individual Topic">Individual Topic</option>
                            </select>
                        </div>
                
                        <div class="mb-3">
                            <label for="description" class="form-label">Description:</label>
                            <textarea name="description" class="form-control" id="description" placeholder="Briefly describe what students are expected to learn" rows="2" required></textarea>
                            <div class="invalid-feedback">
                                Like Topic covered, total question. If it is an individual topic, you can mention it here.
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
            </div> {{-- end of pop up --}}
            
      
           {{-- view subject --}}
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-sm">
                  <thead class="table-light">
                    <tr >
                      <th>QUIZ NAME</th>
                      <th>TOPIC COVERED</th>
                      <th>DESCRIPTION</th>
                      <th>DATE</th>
                      <th>ACTION</th>
                    </tr>
                  </thead>

                  <tbody>
                    @if ($masomo ->count()> 0)   
                        @foreach ($masomo as $subject)
                            <tr class="table-light table-hover">
                                <td>{{ ucwords($subject->quizname) }}</td>
                                <td>{{ ucwords($subject->topiccovered) }}</td>
                                <td>{!! nl2br(e(ucwords($subject->description))) !!}</td>
                                <td>{{ $subject->created_at }}</td>
                                <td>
                                  <button class="btn btn-outline-success btn-md ms-auto" ><a href="AddQuiz" style="text-decoration:none; color:black">Add Questions</a>
                                  </button>

                                  <button type="submit" class="btn btn-outline-danger sm">Delete</button>
                                    
                                </td>
                            </tr>
                        @endforeach
                    @else
                    <tr>
                      <td colspan="5" class="text-center">No data available</td>
                    </tr>
                    @endif
                  </tbody>
                
              </table>
            </div>
          </div>
          
          </div><br>

          {{-- Ku ADD QUIZ --}}
          
          
          <canvas class="my-4 w-100" id="myChart" width="300" height="0.1"></canvas>

        
          

       {{-- Profile modal tyake  --}}
        <div class="modal fade " id="Profile" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="examplModalLabel">My Profile</h5> 
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
  
                  {{-- profile files --}}
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
      </main>
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
                  <b>My Subject <span class=" badge rounded-pill bg-danger"> {{ ucwords($masomo->count()) }}</span> </b>
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





