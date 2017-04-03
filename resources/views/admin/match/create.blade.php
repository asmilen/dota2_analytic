@extends('admin.template')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Matches</h1>
        </div>

    </div>
    <div class="row">
        <div class="col-lg-12">

                <h2>Add</h2>

                {!! Form::model($match = new \App\Match , ['route' => ['matches.store']]) !!}

                <div class="form-group">
                    {!! Form::label('team_a', 'Team A') !!} :
                    {!! Form::select('team_a', array('' => 'Choose Team A') + \App\Team::orderBy('name')->pluck('name','id')->all(), null, ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('team_b', 'Team B') !!} :
                    {!! Form::select('team_b', array('' => 'Choose Team B') + \App\Team::orderBy('name')->pluck('name','id')->all(), null, ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('match_time', 'Giờ bắt đầu trận đấu') !!}
                    {!! Form::input('text','match_time', null,['class' => 'form-control', 'id' => 'match_time']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('league_id', 'Giải đấu') !!} :
                    {!! Form::select('league_id', array('' => 'Chọn giải đấu') + \App\League::latest()->pluck('name','id')->all(), null, ['class' => 'form-control']) !!}
                </div>

                @foreach(\App\BetSite::all() as $bet_site)
                    <div class="form-group">
                        {!! Form::label($bet_site->id.'_normal_url', $bet_site->name .' Url') !!}
                        {!! Form::text($bet_site->id.'_normal_url', null, ['class' => 'form-control']) !!}
                    </div>
                @endforeach

                <div class="form-group">
                    {!! Form::label('rounds', 'Rounds') !!}
                    {!! Form::select('rounds', array('BO1' => 'BO1','BO2' => 'BO2','BO3' => 'BO3','BO5' => 'BO5','BO7' => 'BO7',), null, ['class' => 'form-control']) !!}
                </div>
                <input type="checkbox" name="handicap_a1" value="1"> Handicap A<br>
                <input type="checkbox" name="handicap_b1" value="1"> Handicap B<br>
                <input type="checkbox" name="fb" value="1"> First Blood<br>
                <input type="checkbox" name="10kills" value="1"> First 10 Kills<br>

            <div class="form-group">
                {!! Form::submit('Save', ['class' => 'btn btn-primary form-control']) !!}
            </div>
            {!! Form::close() !!}
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

            $('[type=checkbox]').click(function() {
                console.log(this.checked);
            });
        });


    </script>
@endsection