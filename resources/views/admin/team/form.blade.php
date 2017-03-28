@extends('admin.template')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Teams</h1>
        </div>

    </div>
    <div class="row">
        <div class="col-lg-12">
            @if (!empty($team))
                <h2>Edit</h2>
                {!! Form::model($team, [
                    'method' => 'PATCH',
                    'route' => ['admin.teams.update', $team->id],
                    'files' => true
                 ]) !!}
            @else
                <h2>Add</h2>
                {!! Form::model($team = new App\Team, ['route' => ['admin.teams.store'], 'files' => true]) !!}
            @endif

            <div class="form-group">
                {!! Form::label('name', 'Team Name') !!}
                {!! Form::text('name', null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('full_name', 'Team Full Name') !!}
                {!! Form::text('full_name', null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('desc', 'Short Description') !!}
                {!! Form::textarea('desc', null, ['class' => 'form-control']) !!}
            </div>


            <div class="form-group">
                {!! Form::label('image', 'Image') !!}
                @if ($team->image)
                    <img src="{{url('img/cache/small/' . $team->image)}}" />
                    <hr>
                @endif
                {!! Form::file('image', null, ['class' => 'form-control']) !!}
            </div>


            <div class="form-group">
                {!! Form::label('status', 'Status') !!}
                {!! Form::checkbox('status', null, null) !!}
            </div>



            <div class="form-group">
                {!! Form::submit('Save', ['class' => 'btn btn-primary form-control']) !!}
            </div>

            {!! Form::close() !!}


        </div>
    </div>
@endsection