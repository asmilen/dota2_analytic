@extends('admin.template')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Leagues</h1>
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
                            @foreach($leagues as $league)
                                <tr>
                                    <td>{{$league->id}}</td>
                                    <td>{{$league->name}}</td>
                                    <td>{{$league->full_name }}</td>
                                    <td>{{$league->desc }}</td>
                                    <td><img src="{{url('files/' . $league->image)}}" /></td>
                                    <td>{{ ($league->status) ? 'Active' : 'Inactive' }}</td>
                                    <td>
                                        <button id-attr="{{$league->id}}" class="btn btn-primary btn-sm edit-league" type="button">Edit</button>&nbsp;
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['admin.leagues.destroy', $league->id]]) !!}
                                        <button type="submit" class="btn btn-danger btn-mini">Delete</button>
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                    <div class="row">

                        <div class="col-sm-6">{!!$leagues->render()!!}</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <button class="btn btn-primary add-league" type="button">Add</button>
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
            $('.add-league').click(function(){
                window.location.href = '/leagues/create';
            });
            $('.edit-league').click(function(){
                window.location.href = 'leagues/' + $(this).attr('id-attr') + '/edit';
            });
        });
    </script>
@endsection