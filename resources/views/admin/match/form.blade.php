@extends('admin.template')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Matches</h1>
        </div>

    </div>
    <div class="row">
        <div class="col-lg-12">

            <h2>Edit</h2>
            {!! Form::model($match, [
                'method' => 'PATCH',
                'route' => ['admin.matches.update', $match->id],
             ]) !!}

            <div class="form-group">
                    {!! Form::label('team_a', 'Team A') !!} : 
                    {!! Form::select('team_a', \App\Team::lists('name','id')->all(), null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('team_b', 'Team B') !!} : 
                {!! Form::select('team_b', \App\Team::lists('name','id')->all(), null, ['class' => 'form-control']) !!}
            </div>

            @if ($match->status == config('constants.STATUS_NOT_ACTIVE'))

                <div class="form-group">
                    {!! Form::label('match_time', 'Giờ bắt đầu trận đấu') !!}
                    {!! Form::input('text','match_time', null,['class' => 'form-control', 'id' => 'match_time']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('rate_a', 'Rate A') !!}
                    {!! Form::text('rate_a',null,['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('rate_b', 'Rate B') !!}
                    {!! Form::text('rate_b',null,['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('desc', 'Description') !!} :
                    {!! Form::text('desc',null, ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('status', 'Publish Match') !!}
                    {!! Form::text('status', null, ['class' => 'form-control']) !!}
                </div>

            @endif

            @if ($match->status == config('constants.STATUS_NOT_PLAY'))
                <div class="form-group">
                    {!! Form::label('score_a', $match->teamA->name) !!}
                    {!! Form::text('score_a',null,['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('score_b', $match->teamB->name) !!}
                    {!! Form::text('score_b',null,['class' => 'form-control']) !!}
                </div>

            @endif

            <div class="form-group">
                {!! Form::submit('Save', ['class' => 'btn btn-primary form-control','onclick' => 'return confirm("Bạn có chắc chắn muốn cập nhật trận đấu?");']) !!}
            </div>
            {!! Form::close() !!}
            @include('admin.list')
        </div>
    </div>
@endsection

@section('footer')
    <script>
        $(document).ready(function(){
            jQuery.datetimepicker.setLocale('vi');

            jQuery('#match_time').datetimepicker({
                i18n:{
                    vi:{
                        months:[
                            'Thang 1','Thang 2','Thang 3','Thang 4',
                            'Thang 5','Thang 6','Thang 7','Thang 8',
                            'Thang 9','Thang 10','Thang 11','Thang 12',
                        ],
                        dayOfWeek:[
                            "Chu Nhat", "Thu 2", "Thu 3", "Thu 4",
                            "Thu 5", "Thu 6", "Thu 7",
                        ]
                    }
                },
                timepicker:true,
                format:'Y-m-d H:i:s'
            });
        });
    </script>
@endsection