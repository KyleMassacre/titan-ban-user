@extends('banuser::admin.index')
@section('partial')
    <div class="card shadow mb-4">
        {!! Form::open()->route('admin.banuser.store')->post() !!}
        <div class="card-body">
            <div class="form-group">
                {!! Form::select('bannable_id', 'Select User')
                    ->value(old('bannable_id'))
                    ->options($users, 'name', 'id')
                    ->help('Select the user to ban')
                     ->attrs(['class' => 'user_select']) !!}
                {!! Form::text('reason', 'Reason for ban')
                    ->value(old('reason'))
                    ->help('Enter a reason for banning the user')!!}
                {!! Form::date('ban_until', 'How Long')
                    ->value(old('ban_until'))
                    ->help('When should they be banned until?') !!}
                {!! Form::checkbox('forever', 'Forever')
                    ->checked(old('forever') == 'on') !!}
            </div>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            {!! Form::submit("Ban")->danger() !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@push('scripts')
    <script type="application/javascript">
        $('.user_select').select2({
            'minimumInputLength' : 2
        });
    </script>
@endpush
