@if ($errors->any())
    <ul class="alert alert-danger">
        @foreach ($errors->all() as $message)
            <li>{{ $message }}</li>
        @endforeach
    </ul>
@endif

<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', trans('user.name')) !!}
    {!! Form::text('name', null , ['class' => 'form-control']) !!}
</div>

<!-- Email Field -->
<div class="form-group col-sm-6">
    {!! Form::label('email', trans('user.email')) !!}
    {!! Form::text('email', null , ['class' => 'form-control', 'readonly']) !!}
</div>
<!-- Avatar Field -->
<div class="form-group col-sm-6">
    <div class="form-group col-sm-4">
    {!! Form::label('avatar', trans('user.avatar')) !!}
    </div>
    <div class="form-group col-sm-8">
    <img src="{{ config('image.path_avatar')}}/{{Auth::user()->avatar }}" class="img-circle avatar" id="output">
    {!! Form::file('avatar', array('id' => 'load-avatar')) !!}
    </div>
</div>

<!-- Gender Field -->
<div class="form-group col-sm-6">
    <div class="form-group">
        {!! Form::label('gender', trans('user.gender')) !!}
    </div>
    <div class="form-group col-sm-3">
        <span>{!! trans('user.male') !!}</span>
    {!! Form::radio('gender', '1', true, array('class' => 'name')) !!}
    </div>
    <div class="form-group col-sm-3">
    <span>{!! trans('user.female') !!}</span>
    {!! Form::radio('gender', '2', null, array('class' => 'name')) !!}
    </div>
    <div class="form-group col-sm-3">
    <span>{!! trans('user.other') !!}</span>
    {!! Form::radio('gender', '3', null, array('class' => 'name')) !!}
    </div>
</div>
<div class="clearfix"></div>

<!-- Birthday Field -->
<div class="form-group col-sm-6">
    {!! Form::label('dob', trans('user.dob')) !!}
    {!! Form::date('dob', null , ['class' => 'form-control']) !!}
</div>

<!-- Phone Field -->
<div class="form-group col-sm-6">
    {!! Form::label('phone', trans('user.phone')) !!}
    {!! Form::text('phone', null , ['class' => 'form-control']) !!}
</div>

<!-- Address Field -->
<div class="form-group col-sm-12">
    {!! Form::label('address', trans('user.address')) !!}
    {!! Form::text('address', null , ['class' => 'form-control']) !!}
</div>
<div class="clearfix"></div>
<div class="content">
    <div class="box box-primary">
        <div class="form-group col-sm-12">
        {!! Form::label('old-password', trans('user.change-password')) !!}
        </div>
        <div class="form-group col-sm-6">
            {!! Form::label('old-password', trans('user.old-password')) !!}
            {!! Form::password('old-password', ['class'=>'form-control']) !!}
        </div>
        <div class="form-group col-sm-6">
            {!! Form::label('password', trans('user.reset-password')) !!}
            {!! Form::password('password', ['class'=>'form-control', 'id' => 'reset-password']) !!}
        </div>
        <div class="form-group col-sm-6">
            {!! Form::checkbox('show-password', 1, null, ['id' => 'show-password']) !!}{!! trans('user.show_password') !!}
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<div class="clearfix"></div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit( trans('label.save'), ['class' => 'btn btn-primary']) !!}
    <a href="{{ url('/user') }}" class="btn btn-default">{!!  trans('label.back') !!}</a>
</div>