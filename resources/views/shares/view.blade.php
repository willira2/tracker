@extends('layouts.publiclayout')

@section('content')
  <div class="col-12">
    <div class="card-group my-5">
    @php($days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'])

    @for ($i = 0; $i < 7; $i++)
        <div class="card">
            <div class="card-body">
              <h5 class="card-title text-center">{{$days[$i]}}</h5>
              <p class="card-text text-center"><small class="text-muted">{{$entries[$i]['date']}}</small></p>
              <p class="card-text">
               <ul>
                    @if (array_key_exists('symptoms', $entries[$i]))
                        @foreach($entries[$i]['symptoms'] as $symptom => $value)
                            <li>{{$value}}</li>
                        @endforeach
                    @endif
                </ul>
              </p>
            </div>
        </div>
    @endfor
    </div>
  </div>
@endsection