
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <meta name="generator" content="Hugo 0.72.0">
  <title>Dashboard</title>

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
            <h1 class="h2 shadow-sm">QUIZ</h1>
            
            {{-- Code for registration success message --}}
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
                    <button class="btn btn-outline-success btn-md ms-auto" data-bs-toggle="modal" data-bs-target="#Profile" title="Profile" data-bs-toggle="tooltip" data-bs-placement="top">Profile</button>
                </div>
            </div>
        </div>
    
        <canvas class="my-4 w-100" id="myChart" width="300" height="0.1"></canvas>
    
        {{-- Student view --}}
        <div class="row">
          {{-- Content Area --}}
          <div class="col-md-9 subject-text">
              <div id="subjectText" class="subject-content">
                  <!-- Default content -->
                  <h5 class="shadow bg-warning col-md-20" style="text-align: center; height: 30px; font-style:italic">
                      <strong>Select Subject For Test</strong>
                  </h5>
              </div>
      
              @foreach($assignedSubjects as $subject)
              <div id="subjectText{{ $subject->id }}" style="display: none" class="subject-content">
                  <!-- Content for subject {{ $subject->id }} -->
                  <h5 class="shadow bg-warning col-md-20" style="text-align: center; height: 30px;">
                      <strong>Available Question For {{ strtoupper($subject->subject_name) }}</strong>
                  </h5>
          
                  <div class="card-body">
                      {{-- Table to view uploaded files --}}
                      <div class="table-responsive">
                          <table class="table table-bordered table-striped table-sm">
                          
                              <thead class="table-light">
                                  <tr>
                                      <th></th>
                                      <th>SWALI</th>
                                      <th>chagua Jibu Sahihi</th>
                                      <th>Aina Ya Swali</th>
                                  </tr>
                              </thead>
                              
          
                              <tbody>
                                <form id="quizForm" action="{{ url('/save') }}" method="POST">
                                    @csrf
                                    @if ($assignedSubjects->count() > 0)
                                    <?php
                                    $questionNumber = 1;
                                    $subjectQuestions = $assignedSubjects->where('subject_name', $subject->subject_name)->shuffle()->take(5);
                                    $unansweredQuestions = false; // Flag to track if there are unanswered questions
                                    ?>
                                    @foreach ($subjectQuestions as $swali)
                                        @if ($swali->subject_name === $subject->subject_name && !$swali->is_answered)
                                            <tr class="table-light table-hover">
                                                <td style="color: black">{{ $questionNumber++ }}</td>
                                                {{-- List ya maswali --}}
                                                <td style="color: rgb(238, 30, 2)">
                                                    <ul class="list-group">
                                                        <li class="list-group-item bg-warning" name="{{ ucwords($swali->question) }}" value="{{ ucwords($swali->question) }}">
                                                            <label class="form-check-label">{{ ucwords($swali->question) }} ?</label>
                                                        </li>
                                                    </ul>
                                                </td>
                                                {{-- List ya majibu --}}
                                                <td style="color: black;">
                                                    <ul class="list-group list-group-item-success" id="list-tab" role="tablist">
                                                        <li class="list-group-item list-group-item-action">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="{{ $swali->id }}" value="{{ $swali->option1 }}">
                                                                <label class="form-check-label">{{ ucwords($swali->option1) }}</label>
                                                            </div>
                                                        </li>
                                                        <li class="list-group-item list-group-item-action">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="{{ $swali->id }}" value="{{ $swali->option2 }}">
                                                                <label class="form-check-label">{{ ucwords($swali->option2) }}</label>
                                                            </div>
                                                        </li>
                                                        @if ($swali->question_type !== 'TrueFalse')
                                                            <li class="list-group-item list-group-item-action">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="{{ $swali->id }}" value="{{ $swali->option3 }}">
                                                                    <label class="form-check-label">{{ ucwords($swali->option3) }}</label>
                                                                </div>
                                                            </li>
                                                        @endif
                                                    </ul>
                                                </td>
                                                <td style="color: rgba(211, 168, 113, 0.753)">This is {{ ucwords($swali->question_type) }} Question</td>
                                            </tr>
                                        @else
                                            <?php
                                            if ($swali->subject_name === $subject->subject_name && $swali->is_answered) {
                                                $unansweredQuestions = true;
                                            }
                                            ?>
                                        @endif
                                    @endforeach
                                    @if ($unansweredQuestions > 1)
                                        <tr>
                                            <td colspan="4" class="text-center">
                                                <ul class="list-group">
                                                    <li class="list-group-item list-group-item-action">
                                                        <div class="form-check">
                                                            No Questions Available for Now. Visit <a href="/Inc/MyLearning">Here</a> to study.
                                                        </div>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                    @endif
                                @else
                                    <tr>
                                        <td colspan="4" class="text-center">No data available</td>
                                    </tr>
                                @endif
                                
                                <tr>
                                  <td colspan="4" style="text-align:right">
                                      <button type="submit" class="btn btn-outline-primary">Save</button>
                                  </td>
                              </tr>
                                

                                  

                                </form>
                            
                              
                            </tbody>
                            
                          </table>
                        
                           
                      </div>
                  </div>
                  <script>
                    function saveAndReload(event, subjectId) {
                        event.preventDefault(); // Prevent form submission
                
                        // Submit the form asynchronously
                        document.getElementById('quizForm').submit();
                
                        // Reload the page with the selected subject
                        setTimeout(function() {
                            location.href = '#subjectText' + subjectId;
                            location.reload();
                        }, 1000); // Optional: Add a delay (in milliseconds) before reloading the page
                    }
                </script>
                
                
          
                  <script>
                    
                      function toggleSubjectText(subjectId) {
                          // Get all subject content elements
                          var subjectContents = document.getElementsByClassName('subject-content');
          
                          // Hide all subject contents
                          for (var i = 0; i < subjectContents.length; i++) {
                              subjectContents[i].style.display = 'none';
                          }
          
                          // Show the selected subject content
                          var selectedSubjectContent = document.getElementById('subjectText' + subjectId);
                          if (selectedSubjectContent) {
                              selectedSubjectContent.style.display = 'block';
                          }
                      }
          
                      function submitQuiz() {
                          // Perform the AJAX request
                          $.ajax({
                              type: 'POST',
                              url: '{{ url("save") }}',
                              data: $('#quizForm').serialize(),
                              success: function(response) {
                                  // Show the success message in a pop-up
                                  alert(response.message);
                              },
                              error: function(error) {
                                  // Show the error message in a pop-up
                                  alert('Error occurred while saving the quiz.');
                              }
                          });
                      }
                  </script>
              </div>
          @endforeach
          
          
          </div>
        
          <script>
            function toggleSubjectText(subjectId) {
                // Get all subject content elements
                var subjectContents = document.getElementsByClassName('subject-content');

                // Hide all subject contents
                for (var i = 0; i < subjectContents.length; i++) {
                    subjectContents[i].style.display = 'none';
                }

                // Show the selected subject content
                var selectedSubjectContent = document.getElementById('subjectText' + subjectId);
                if (selectedSubjectContent) {
                    selectedSubjectContent.style.display = 'block';
                }
            }

            function submitQuiz() {
                // Perform the AJAX request
                $.ajax({
                    type: 'POST',
                    url: '{{ url("save") }}',
                    data: $('#quizForm').serialize(),
                    success: function(response) {
                        // Show the success message in a pop-up
                        alert(response.message);
                    },
                    error: function(error) {
                        // Show the error message in a pop-up
                        alert('Error occurred while saving the quiz.');
                    }
                });
            }
        </script>
      
    </main>
    
 <!-- Section ya kulia ya kudisplay maswali -->

  {{-- Subject List --}}
  <div class="col-md-3" style="margin-top: 139px;">
    <div class="list-group">
        <h5 class="list-group-item bg-warning shadow">Subjects With Test</h5>
        @if ($assignedSubjects->isNotEmpty())
            @php
                $displayedSubjects = [];
            @endphp
            @foreach ($assignedSubjects as $subject)
                @if (!in_array($subject->subject_name, $displayedSubjects))
                    @php
                        $displayedSubjects[] = $subject->subject_name;
                    @endphp
                    <a href="#" class="list-group-item list-group-item-action"
                        onclick="toggleSubjectText('{{ $subject->id }}')"
                        style="background-color: #fff;"
                        onmouseover="this.style.backgroundColor='#b84326'; this.style.color='white'"
                        onmouseout="this.style.backgroundColor='#fff'; this.style.color='black'">
                        {{ ucwords($subject->subject_name) }}<br>
                    </a>
                    <span> </span>
                @endif
            @endforeach
        @else
            <a href="#" class="list-group-item list-group-item-action"
                style="background-color: #fff;"
                onmouseover="this.style.backgroundColor='#b84326'; this.style.color='white'"
                onmouseout="this.style.backgroundColor='#fff'; this.style.color='black'">
                No Data Available
            </a>
        @endif
    </div>
</div>
</div>


</div>

<!-- ... -->  
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
      <div>
        <nav  class=" d-md-block bg-light sidebar collapse">
          <div class="position-sticky pt-3">
            <ul class="nav flex-column">
              {{-- hii inaonesha dashboard --}}
              <li class="nav-item">
                <a class="nav-link  "aria-current="page" href="/StudentDashboard">
                
                    <span data-feather="home"></span>
                    <b>My Dashboard</b>
                
               </a>
              </li>{{--mwisho wa code zinazoonesha dashboard --}}
      
              {{-- code ya kuonesha jinsi ya parent kua add mwanafunzi --}}
              <li class="nav-item">
                <a class="nav-link "  href="/Inc/MyLearning">
                  <span data-feather="file"></span>
                My Learnings
                </a>
              </li>
         {{-- Code za kuadd somo kwa mwanafunzi --}}
         <li class="nav-item">
          <a class="nav-link" href="#">
            <span data-feather="shopping-cart"></span>
           Question Of The Day
          </a>
        </li>

        {{-- Kuangalia progress yake --}}
        <li class="nav-item">
          <a class="nav-link active" style="color: #b84326;"  href="/Inc/TakeQuiz">
            <span data-feather="users"></span>
            Online Competition
          </a>
        </li>
      
              {{-- code za kuangalia status ya mtihani kama ni done au not done --}}
              <li class="nav-item">
                <a class="nav-link" href="#">
                  <span data-feather="bar-chart-2"></span>
                  Discussion
                </a>
              </li>

                 {{-- code za kuangalia status ya mtihani kama ni done au not done --}}
                 <li class="nav-item">
                  <a class="nav-link" href="#">
                    <span data-feather="bar-chart-2"></span>
                    Ask Question
                  </a>
                </li>
         
      
            <h4 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
              <span class="shadow">Reports</span>
              
            </h4>
            <ul class="nav flex-column mb-2">
              <li class="nav-item">
                <a class="nav-link" href="/Inc/TestResult">
                  <span data-feather="file-text"></span>
                  Online Test Result 
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">
                  <span data-feather="file-text"></span>
                  Learnig Progress Reports
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">
                  <span data-feather="file-text"></span>
                 Online Test Rank
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




  



