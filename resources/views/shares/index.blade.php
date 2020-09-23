@extends('layouts.mainlayout')

@section('content')
<div class="col">
    <form action="{{ route('share.store') }}" method="post">
        @csrf @method('POST')
        <button class="btn btn-primary" type="submit">Create New Share</button>
    </form>

    <div class="col-lg-10 mt-4">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Created</th>
                    <th scope="col">Share Link</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
               @foreach($shares as $share)
                    <tr>
                        <td>{{ date('m-d-Y g:ia', strtotime($share->created_at)) }}</td>
                        <td>{{ url('/v').'/'.$share->access_string }}</td>
                        <td class="text-right">
                            <button class="btn btn-outline-primary copy-button" aria-pressed="false" type="button">Copy Link</button>
                        </td>
                        <td>
                            <form action="{{ route('share.destroy', $share->id)}}" method="post">
                                @csrf @method('POST')
                                <button class="btn btn-outline-danger" type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', () => {
        $(".copy-button").click(function() {
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val($(this).parent().prev().text()).select();
            document.execCommand("copy");
            $temp.remove();
            $(this).addClass('active').text('Copied!').attr("aria-pressed","true");
        });
    });
</script>