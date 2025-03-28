{{-- This code is for detecting error --}}
@if(count($errors) > 0 )
@foreach ($errors -> all() as $error)

    <div class="alert alert-danger alert-dismissible fade show" role="alert"">
        {{$error}}
    </div>
    

@endforeach

@endif {{-- Error message display --}}

{{-- Success message for submit --}}
@if (session('success'))
<div class="alert alert-success">
    {{session('success')}}
</div>
    
@endif