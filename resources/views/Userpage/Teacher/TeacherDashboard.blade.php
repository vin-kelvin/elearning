<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <link rel="stylesheet" href="/node_modules/@fortawesome/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
   


    <script src="{{ asset('js/app.js') }}"></script>
</head>

<body >
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
      <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4 ">
        <div class="d-flex justify-content-between sticky-top flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2 shadow-sm">Welcome {{ auth()->user()->role }} {{ auth()->user()->name }}</h1>
          
          {{-- Code for message ya kuregister --}}
          @if (session()->has('success'))
          <div class="alert alert-success">
            {{ session('success') }}
          </div>
          @endif

       
          <div class="btn-toolbar mb-2 mb-md-0">
            <a class="btn  btn-outline-dark btn-md ms-auto" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
            Menu
            </a>
            <div></div>
            <div class="btn-group mr-2">
              <button class="btn  btn-outline-success btn-md ms-auto" data-bs-toggle="modal" data-bs-target="#Profile" title="Profile" data-bs-toggle="tooltip" data-bs-placement="top"> Profile</button>
           </div>
          
          </div>
        </div>

        <canvas class="my-4 w-100" id="myChart" width="300" height="0.1"></canvas>

      

    

        {{-- Teacher view --}}
      <div class="row ">
            {{-- Total sub dash --}}
           <div class="col-sm-5 flex-md-row mb-4">
            <div class="card btn btn-outline-success shadow">
              <div class="card-body center">
                <h5 class="card-title"style="text-align: center">Total Subject(s)</h5>
                
                <h3 class="card-text mb-0"style="text-align: center">
                  @if ($masomo ->count()> 0)
               <i class="fa fa-bandcamp" aria-hidden="true"></i>

                      {{ ucwords($masomo->count()) }}
                   
                      
                    @else
                      0
                  @endif
              
                </h3><br>
                <a href="/Inc/MySubject" class="btn btn-primary">View</a>
              </div>
            </div>
           </div>
`
          {{-- Request Asistance --}}
          <div class="col-sm-5 flex-md-row mb-4 ">
            <div class="card btn btn-outline-success  shadow">
              <div class="card-body center">
                <h5 class="card-title"style="text-align: center">Parent Request</h5>
                
                <h3 class="card-text mb-0"style="text-align: center">
                  @if ($masomo ->count()> 0)
                      {{ ucwords($masomo->count()) }}
                   
                      
                   @else
                      0
                  @endif
              
                </h3> <br>
                <a href="/Inc/ParentRequest" class="btn btn-primary">View</a>
              </div>
            </div>
          </div>

          {{-- Available Disscussion --}}
          <div class="col-sm-5 flex-md-row mb-4 ">
            <div class="card btn btn-outline-success shadow">
              <div class="card-body center">
                <h5 class="card-title"style="text-align: center">Discussion Status</h5>
                
                <h3 class="card-text mb-0"style="text-align: center">
                  @if ($masomo ->count()> 0)
                      {{ ucwords($masomo->count()) }}
                   
                      
                    @else
                      0
                  @endif
              
                </h3>    <br>
                  <a href="/Inc/Discussion" class="btn btn-primary">View</a>
              </div>
            </div>
          </div>

          {{-- Quiz participant --}}
          <div class="col-sm-5 flex-md-row mb-4 ">
            <div class="card shadow btn-outline-success  btn">
              <div class="card-body center">
                  <h5 class="card-title"style="text-align: center">Total Quiz</h5>
                
                  <h3 class="card-text mb-0"style="text-align: center">
                  @if ($masomo ->count()> 0)
                      {{ ucwords($paper->count()) }}
                   
                      
                    @else
                      0
                  @endif
              
                  </h3><br>
                 <a href="/Inc/Paper" class="btn btn-primary">View</a>
              </div>
            </div>
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
                    99+
                    <span class="visually-hidden">unread messages</span>
                  </span>
                    
                </a>
              </li>
      
              {{-- Code za kuadd somo kwa mwanafunzi --}}
              <li class="nav-item">
                <a class="nav-link" href="/Inc/MySubject">
                  
                  My Subject 
                  <span class=" badge rounded-pill bg-danger">{{ ucwords($masomo->count()) }}</span>
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




