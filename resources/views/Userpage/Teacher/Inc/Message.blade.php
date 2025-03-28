<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Teacher</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}"></script>
    <style>
 
           /* Sidebar */
       .offcanvas {
       position: fixed;
       top: 0;
       bottom: 0;
       left: 0;
       display: flex;
       flex-direction: column;
       max-width: 100%;
       visibility: hidden;
       background-color: #ffffff;
       overflow-y: auto;
       transition: transform .3s ease-in-out,visibility .3s linear;
       transform: translateX(-100%);
      }
      
      .offcanvas-header {
       display: flex;
       align-items: center;
       justify-content: space-between;
       padding: 1rem;
       background-color: #ffffff;
       color: #000000;
       box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
      }

      
      .offcanvas-title {
       margin-bottom: 0;
       line-height: 1.5;
      
      }
      
      .offcanvas-body {
       flex-grow: 1;
       padding: 1rem;
      
      }
      
      .sidebar {
       position: sticky;
       top: 4rem;
       height: calc(95vh - 4rem);
       padding-top: .5rem;
       overflow-x: hidden;
       overflow-y: auto;
      
      
      }
      
      .sidebar .nav-link {
      font-weight: 400 bold;
      font-size: 16px;
      color: #494848;
      border-bottom: 0.01cm solid #d8cdcb;
      transition: all 0.2s linear;
      }


      .sidebar .nav-link:hover {
      font-weight: 500;
      font-size: 19px;
      color: #b84326;
      border-bottom: 0.01cm solid #d8cdcb;
      }

      
    
     /* Navbar */
      .navbar {
        height: 60px;
   
      }

      .navbar-brand {
        font-size: 1rem;
        font-weight: 600;
        color: #000000;
      }

      .navbar-brand:hover {
        color: #b84326;
      }


      .card {
        padding: 0.5rem;
        border-radius: 20px;
        box-shadow: 0px 1px 5px 0px rgba(0, 0, 0, 0.5);
        background-color: #ffffff;
      }
      .table.table-striped {
        background-color: #c98c5e; /* Change the background color */
      }

      .table.table-striped tbody tr:nth-of-type(odd) {
       background-color: #fff2e8; /* Change the background color of odd rows */
        }

      .table.table-striped tbody td {
        color: #8e301e; /* Change the color of the table cells */
        }


      /* Footer */
      footer {
        height: 100px;
        padding: 2em;
        background-color: #ffffff;
        text-align: center;
        margin-top: 50px;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
      }
    
      /* additional styles */
      .btn-primary {
        background-color: #b84326;
        border-color: #b84326;
      }
      
      .btn-primary:hover {
        background-color: #8e301e;
        border-color: #8e301e;
      }
      
      .alert {
        background-color: #d4edda;
        color: #155724;
        border-color: #c3e6cb;
      }
    </style>

</head>

<body >
  {{-- BAR YA JUU --}}
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

  {{-- JINA LA SECTION, MENU NA PROFILE --}}
  <div class="container">
    <div class="row">
      <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2 shadow-sm">Message & Chats</h1>
          
          {{-- Code for message ya kuregister --}}
          @if (session()->has('success'))
          <div class="alert alert-success">
            {{ session('success') }}
          </div>
          @endif

       
          <div class="btn-toolbar mb-2 mb-md-0">
            <a class="btn btn-primary" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
            Menu
            </a>
            <div></div>
            <div class="btn-group mr-2">
              <button class="btn  btn-outline-success btn-md ms-auto" data-bs-toggle="modal" data-bs-target="#Profile" title="Profile" data-bs-toggle="tooltip" data-bs-placement="top"> Profile</button>
           </div>
          
          </div>
        </div>

        <canvas class="my-4 w-100" id="myChart" width="300" height="0.1"></canvas>

    

        {{-- CONTENT ZA PAGE--}}
          <div class="card">
            <div class="card-header"><h5>{{ __('  My Messages') }}</h5></div>
            <div class="card-body">

             

            </div>
          
          </div><br>

     
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
                <a class="nav-link  "  href="/TeacherDashboard">
                    <span data-feather="home"></span>
                    My Dashboard
               </a>
              </li>{{--mwisho wa code zinazoonesha dashboard --}}
      
              {{-- code ya kuonesha jinsi ya parent kua add mwanafunzi --}}
              <li class="nav-item">
                <a class="nav-link active"style="color: #b84326; " aria-current="page" href="/Inc/Message">
                  <span data-feather="file"></span>
                  <b>  Message</b>
                </a>
              </li>
      
              {{-- Code za kuadd somo kwa mwanafunzi --}}
              <li class="nav-item">
                <a class="nav-link" href="/Inc/MySubject">
                  <span data-feather="shopping-cart"></span>
                  My Subject 
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


<footer class="footer">
  
  <p>
      &copy; All Right Reerved 2023
      <br>
      <b>Work of Ashura Kiemba </b>
        
  </p>
</footer>