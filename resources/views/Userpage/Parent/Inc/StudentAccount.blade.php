<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.72.0">
    <title>Parent</title>
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
          <button class="btn btn-primary btn-md" type="submit">Sign out</button>
        </form>
        @endif
      </li>
    </ul>
  </nav>

  <div class="container">
    <div class="row">
      <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between sticky-top flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">Manage Student Account</h1>
          
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

      

        {{-- ku create student account by parent --}}
          <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h5>{{ __('  Create Student Account ') }}<span class=" badge rounded-pill bg-danger"> {{ ucwords($accounts->count()) }}</span></h5>
              <button class="btn btn-primary btn-md ms-auto" data-bs-toggle="modal" data-bs-target="#AddSubject" title="Add New Subject" data-bs-toggle="tooltip" data-bs-placement="top">Add</button>
            </div>
          
              <div class="modal fade" id="AddSubject" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered " id="AddSubject">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Create Student Account</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">+</button>
                    </div><br>
                    {{-- Form ya kua add student account --}}
                    <form method="POST" action="{{ url('/ManageAccount') }}">
                      @csrf
      
                      <div class="row mb-3">
                          <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Student Name') }}</label>
                          <div class="col-md-6">
                              <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
      
                              @error('name')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                        </div>
                   
                        <div class="row mb-3">
                          <label for="role" class="col-md-4 col-form-label text-md-end">{{ __('Registered Student') }}</label>
                      
                          <div class="col-md-6" >
                              <select id="role"  class="form-select" aria-label="Default select example" name="role" type="text" >
                                  <option  value="student">Student</option>
                              </select>
                      
                              @error('role')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                            </div>
                        </div>
                    
                       <div class="row mb-3">
                        <label for="username" class="col-md-4 col-form-label text-md-end">{{ __('Student Username') }}</label>
      
                        <div class="col-md-6">
                            <input id="username" type="name" class="form-control @error('name') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username">
      
                            @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                       </div>
                                 
                      {{-- Phone number --}}
  
                      <div class="row mb-3">
                          <label for="phone" class="col-md-4 col-form-label text-md-end">{{ __('Parent Phone Number') }}</label>
                          <div class="col-md-6">
                              <input id="phone" type="tel" class="form-control phone @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" placeholder="Enter phone number" required autocomplete="phone">
                              @error('phone')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                      </div>
                      {{-- phone number mwisho --}}
                      
      
                      <div class="row mb-3">
                          <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>
      
                          <div class="col-md-6">
                              <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
      
                              @error('password')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                      </div>
      
                      <div class="row mb-3">
                          <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>
      
                          <div class="col-md-6">
                              <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                          </div>
                      </div>          
                                              
                      <div class="modal-footer">
                       <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                       <button type="submit" class="btn btn-primary">{{ __('Create') }}</button>
                      </div>
                    </div>
                  </form>
               
                </div>
              </div> {{-- end of pop up --}}

              
                <div class="card-body">
                  <table class="table table-bordered table-striped table-sm">
                    <thead class="table-light">
                      <tr >
                        <th>NAME</th>
                        <th>USERNAME</th>
                        <th>ROLE</th>
                        <th>CREATED BY</th>
                        <th>CREATED DATE</th>
                        <th>ACTION</th>
                      </tr>
                    </thead>
    
                    <tbody>
                      @if ($accounts ->count()> 0)   
                          @foreach ($accounts as $account)
                              <tr class="table-light table-hover">
                                  <td>{{ ucwords($account->name) }}</td>
                                  <td>{{ ucwords($account->username) }}</td>
                                  <td>{{ ucwords($account->role) }}</td>
                                  <td>
                                    @if ($account->parent_id)
                                        {{ ucwords($account->where('id', $account->parent_id)->first()->name) }}
                                    @else
                                        No Parent Assigned
                                    @endif
                                </td>
                                  <td>{{ $account->created_at }}</td>
                                  <td>
                                      <button type="submit" class="btn btn-outline-danger sm">Delete</button>
                                      <button type="submit" class="btn btn-outline-dark sm">Edit</button>
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
              
            
          
          </div><br>

  
         
     
     
        </div>
      </main>
    </div>
  </div>

  
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
                  <a class="nav-link active " style="color: #b84326;" aria-current="page" href="/Inc/StudentAccount">
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