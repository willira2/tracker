<div class="col-lg-3">
  @if(session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
  @endif
  <div class="card">
    <div class="card-header text-center font-weight-bold">
      Add Symptom
    </div>
    <div class="card-body">
      	@php($options = [
      	'fever' => 'fever', 
      	'chills' => 'chills', 
      	'shortness of breath' => 'shortness of breath', 
      	'fatigue' => 'fatigue', 
      	'body aches' => 'body aches', 
      	'loss of taste or smell' => 'loss of taste or smell', 
      	'sore throat' => 'sore throat', 
      	'congestion or runny nose' => 'congestion or runny nose', 
      	'nausea' => 'nausea', 
      	'vomiting' => 'vomiting', 
      	'diarrhea' => 'diarrhea'])

		@open(['route' => 'symptom.new_entry', 'method' => 'POST', 'id' => 'symptom-form'])
			@csrf
		    @date('log_date')
		    @checkboxes('names[]', 'Symptoms', $options, null, ['switch' => true])
		    @submit('Save')
		@close

    </div>
  </div>
</div> 