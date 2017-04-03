@extends('admin.template')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Teams</h1>
        </div>

    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Full Name</th>
                                <th>Desc</th>
                                <th>Logo</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($teams as $team)
                                <tr>
                                    <td>{{$team->id}}</td>
                                    <td>{{$team->name}}</td>
                                    <td>{{$team->full_name}}</td>
                                    <td>{{$team->desc }}</td>
                                    <td><img src="{{url('files/' . $team->image)}}" /></td>
                                    <td>{{ ($team->status) ? 'Active' : 'Inactive' }}</td>
                                    <td>
                                        <button id-attr="{{$team->id}}" class="btn btn-primary btn-sm edit-team" type="button">Edit</button>&nbsp;
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['teams.destroy', $team->id]]) !!}
                                        <button type="submit" class="btn btn-danger btn-mini">Delete</button>
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                    <div class="row">

                        <div class="col-sm-6">{!!$teams->render()!!}</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <button class="btn btn-primary add-team" type="button">Add</button>
                        </div>
                    </div>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>

    </div>
    
@endsection
@section('footer')
    <script>
        $(function(){
            $('.add-team').click(function(){
                window.location.href = '/teams/create';
            });
            $('.edit-team').click(function(){
                window.location.href = 'teams/' + $(this).attr('id-attr') + '/edit';
            });
        });
    </script>
@endsection