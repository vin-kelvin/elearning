@extends('layouts.app')


@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="display-6 font-italic">Frequently Asked Questions</div>

             <div class="col-md-8">
                <div class="card  text-white bg-success mb-3" style="max-width: 18rem;">
                    <div class="card-header">{{ __('  Ask Your Question') }}</div>
                            <div class="card-body">
                                {!! Form::open(['url' => '/submit'])!!}
                                    @csrf
                                <div class="form-group">
                                    {{Form::label('email', 'Email')}}
                                    {{Form::Text('email', '', ['class '=>'form-control', 'placeholder' => 'emaple@mail.com'])}}
                                </div>
                                <div class="form-group">
                                    {{Form::label('question', 'Question')}}
                                    {{Form::textarea('question', '', ['class '=>'form-control', 'placeholder' => 'Enter Your question'])}}
                                </div>                         
                                <div ><br>
            
                                    <button type="submit" class="btn btn-primary">Send</i></button>
    
                                </div>
    
                              
    
                              {!! Form::close()!!}
                            </div>
                            
                </div>
             </div>

              <div class="col-md-9"style="margin-left: 60%;margin-top: -79%;">
                <div class="card  text-white bg-white mb-6" style="max-width: 30rem;">
                    @if (count($messages)> 0)
                        @foreach ($messages as $messages)
                        <ul class="list-group  ">
                            <li class="list-group-item list-group-item-action bg-success text-white ">
                                Question: {{$messages ->message }}
                            </li>
                        </ul>
                    
                  
                        @endforeach
                
                    @endif
                </div>
              </div>


              
           

            </div>   

           

        </div>
              
    </div> 

</div> 
 
@endsection

