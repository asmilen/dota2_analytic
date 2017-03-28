@extends('admin.template')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Matches</h1>
        </div>

    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">

                <div>Thoi gian hien tai {{\Carbon\Carbon::now()->toDateTimeString()}}</div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Team A</th>
                                <th>Team B</th>
                                <th>Match time</th>
                                <th>rate a</th>
                                <th>rate b</th>
                                <th>result</th>
                                <th>League</th>
                                <th>D2top Id</th>
                                <th>status</th>
                                <th>Handicap a</th>
                                <th>Handicap b</th>
                                <th>Rounds</th>
                                <th>Type</th>
                                <th>Score</th>    
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($matches as $match)
                                <tr>
                                    <td>{{$match->id}}</td>
                                    <td>{{$match->teamA->name}} ({{$match->teamA->id}})</td>
                                    <td>{{$match->teamB->name}}  ({{$match->teamB->id}})</td>
                                    <td>{{$match->match_time}}</td>
                                    <td>{{$match->rate_a}}</td>
                                    <td>{{$match->rate_b}}</td>
                                    <td>{{$match->result}}</td>
                                    <td>{{$match->League->name}}  ({{$match->League->id}})</td>
                                    <td>{{$match->d2top_id}}</td>
                                    <td>{{$match->status}}</td>
                                    <td>{{$match->handicap_a}}</td>
                                    <td>{{$match->handicap_b}}</td>
                                    <td>{{$match->rounds}}</td>
                                    <td>{{$match->type}}</td>
                                    <td>{{$match->score}}</td>
                                    <td>{{$match->desc}}</td>
                                    <td>
                                        @if ($match->status == config('constants.STATUS_NOT_ACTIVE') || $match->status == config('constants.STATUS_ACTIVE'))
                                            <button id-attr="{{$match->id}}" class="btn btn-primary btn-sm edit-match" type="button">Edit</button>
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['admin.matches.destroy', $match->id]]) !!}
                                                <button type="submit" class="btn btn-danger btn-mini">Delete</button>
                                            {!! Form::close() !!}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                    <div class="row">

                        <div class="col-sm-6">{!!$matches->render()!!}</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <button class="btn btn-primary add-match" type="button">Add</button>
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
            $('.add-match').click(function(){
                window.location.href = window.location.origin + '/admin/matches/create';
            });
            $('.edit-match').click(function(){
                window.location.href = window.location.origin + '/admin/matches/' + $(this).attr('id-attr') + '/edit';
            });
        });
    </script>
@endsection