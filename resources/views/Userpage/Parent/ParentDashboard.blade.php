<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.72.0">
    <title>Parent Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

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
          <button class="btn btn-outline-danger btn-md" type="submit">Logout</button>
        </form>
        @endif
      </li>
    </ul>
  </nav>

  <div class="container">
    <div class="row">
      <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between sticky-top flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">Welcome {{ auth()->user()->role }} {{ auth()->user()->name }}</h1>
          
          {{-- Code for message ya kuregister --}}
          @if (session()->has('success'))
          <div class="alert alert-success">
            {{ session('success') }}
          </div>
          @endif

       {{-- button ya menu na profile --}}
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

    

       {{-- Paren dashboard  view --}}
     <div class="row">
        {{-- Total sub dash --}}
       <div class="col-sm-5 flex-md-row mb-4">
        <div class="card">
          <div class="card-body center">
            <h5 class="card-title"style="text-align: center">Total Student Account</h5>
            
            <h3 class="card-text mb-0"style="text-align: center">
              @if ($teacher ->count()> 0)
                    {{ ucwords($teacher->count()) }} 
              @else
              0
              @endif
              
            </h3><br>
            
            <a href="/Inc/StudentAccount" class="btn btn-primary">View</a>
          </div>
        </div>
       </div>

      {{-- Request Asistance --}}
      <div class="col-sm-5 flex-md-row mb-4">
        <div class="card">
          <div class="card-body center">
            <h5 class="card-title"style="text-align: center">Total Student's Subject</h5>
            
            <h3 class="card-text mb-0"style="text-align: center">
              @if ($StudentWithSubject ->count()> 0)
                    {{ ucwords($StudentWithSubject->count()) }} 
              @else
              0
              @endif
              
            </h3><br>
            <a href="#" class="btn btn-primary">View</a>
          </div>
        </div>
      </div>

      {{-- Available Disscussion --}}
      <div class="col-sm-5 flex-md-row mb-4">
        <div class="card">
          <div class="card-body center">
            <h5 class="card-title"style="text-align: center">MY Student's Progress</h5>
            
            <h3 class="card-text mb-0"style="text-align: center">
             
             <div class="progress">
                 <div class="progress-bar  bg-${2|success,info,success,warning,wardanger}}" role="progressbar" style="width: 1%;"
                     aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" ${6| ,progress-bar-animated}>Description</div>
             </div>
          
            </h3>    <br>
              <a href="#" class="btn btn-primary">View</a>
          </div>
        </div>
      </div>

      {{-- Quiz participant --}}
      <div class="col-sm-5 flex-md-row mb-4">
        <div class="card">
          <div class="card-body center">
              <h5 class="card-title"style="text-align: center">Requested Teacher</h5>
            
              <h3 class="card-text mb-0"style="text-align: center">
                0
          
              </h3><br>
             <a href="#" class="btn btn-primary">View</a>
          </div>
        </div>
      </div>
     </div>
     
     
        </div>
      </main>
    </div>
  </div>

  {{-- menu code --}}
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
                <a class="nav-link active " style="color: #b84326;" aria-current="page" href="/ParentDashboard">
                  <i class="fa fa-dashboard" aria-hidden="true">
                    <span data-feather="home"></span>
                    Dashboard
                  </i>
               </a>
              </li>{{--mwisho wa code zinazoonesha dashboard --}}
      
              {{-- code ya kuonesha jinsi ya parent kua add mwanafunzi --}}
              <li class="nav-item">
                <a class="nav-link" href="/Inc/StudentAccount">
                  <span data-feather="file"></span>
                  Manage Student Account
                </a>
              </li>
      
              {{-- Code za kuadd somo kwa mwanafunzi --}}
              <li class="nav-item">
                <a class="nav-link" href="/Inc/ManageSubject">
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
                <a class="nav-link" href='/Inc/ExamStatus'>
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