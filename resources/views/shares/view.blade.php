@extends('layouts.publiclayout')

@section('content')
  <div class="col-12">
    <div class="col-12 text-center my-5">
        <div class="btn-group">
      <form action="{{ route('share.view', ['token'=>$access_string, 'dir'=>'prev', 'start'=>$entries[0]['date']]) }}" method="post">
        @csrf @method('GET')
        <button class="btn btn-block btn-dark" type="submit">Previous Week</button>
      </form>
          <form action="{{ route('share.view', ['token'=>$access_string, 'dir'=>'next', 'start'=>$entries[0]['date']]) }}" method="post">
          @csrf @method('GET')
          <button class="btn btn-block btn-dark ml-4" type="submit">Next Week</button>
        </form>
      </div>  
    </div>
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