@extends('layouts.mainlayout')

@section('content')
<div class="col">
	@include('forms.symptom-form')

	<div class="col-lg-10 mt-4">
	    <table class="table">
	        <thead>
	            <tr>
	                <th scope="col">Date</th>
	                <th scope="col">Symptom</th>
	                <th scope="col">Actions</th>
	            </tr>
	        </thead>
	        <tbody>
	           @foreach($entries as $share)
	                <tr>
	                    <td>{{$share->log_date}}</td>
	                    <td>{{$share->name}}</td>
	                    <td>
	                        <form action="{{ route('symptom.destroy', $share->id)}}" method="post">
	                            @csrf @method('POST')
	                            <button class="btn btn-danger" type="submit">Delete</button>
	                        </form>
	                    </td>
	                </tr>
	            @endforeach
	        </tbody>
	    </table>
	</div>
</div>
@endsection