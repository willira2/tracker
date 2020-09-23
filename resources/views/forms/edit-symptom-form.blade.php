<div class="container mt-4">
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
      <form name="add-blog-post-form" id="add-blog-post-form" method="put" action="{{ url('symptoms/update',$symptom->id) }}">
       @csrf
        <div class="form-group">
          <label for="Symptom">Symptom!</label>
          <input type="text" id="name" name="name" class="form-control" required="" value="{{ $symptom->name }}">
        </div>
        <div class="form-group">
          <label for="Severity">Severity</label>
          <input name="severity" class="form-control" required="" value="{{ $symptom->severity }}"></input>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
  </div>
</div>    
</body>
</html>