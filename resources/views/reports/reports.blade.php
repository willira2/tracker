@extends('layouts.mainlayout')

@section('content')
  <div class="col-8">
    <div class="card-group">
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

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', () => {
       var ctx = document.getElementById('myChart');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                datasets: [{
                    label: '# of Votes',
                    data: [12, 19, 3, 5, 2, 3],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    });
   
</script>