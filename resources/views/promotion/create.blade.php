@extends('layouts.app')
@section('content')
<div class="container">
<div class="page-header">
  <h3>{{ trans('promotion.create_page') }}</h3>
</div>
@if(count($errors)>0)
<div class="alert alert-danger alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <ul>
    @foreach($errors->all() as $error)
        <li><strong>{!! $error !!}</strong></li>
    @endforeach
    </ul>
</div>
@endif
<form action="{{ route('promotions.store') }}" method="post">
    {{ csrf_field() }}
    <div class="form-group">
        <label for="title_store">{{ trans('promotion.title') }}</label>
        <input type="text" class="form-control" id="title" name="title" value="{{ old('title')}}">
    </div>
    <div class="form-group">
        <label for="description">{{ trans('promotion.description') }}</label>
        <textarea class="form-control" rows="5" id="description"  name="description" >{{ old('description')}}</textarea>
    </div>
    <div class="form-group">
        <label for="percent">{{ trans('promotion.percent') }}</label><span>( % )</span>
        <input type="number" class="form-control" id="percent" name="percent" value="{{ old('percent')}}">
    </div>
    <div class="form-group">
        <label for="quantity">{{ trans('promotion.quantity') }}</label>
        <input type="number" class="form-control" id="quantity" name="quantity" value="{{ old('quantity')}}">
    </div>
    <div class="form-group">
        <label for="start_date">{{ trans('promotion.date_start') }}</label>
        <input type="datetime-local" class="form-control" id="start_date" name="date_start" value="{{ old('date_start') }}">
    </div>
    <div class="form-group">
        <label for="end_date">{{ trans('promotion.date_end') }}</label>
        <input type="datetime-local" class="form-control" id="end_date" name="date_end" value="{{ old('date_end') }}">
    </div>
    <input type="hidden" name="product_id" value="1">
    <input type="submit" class="btn btn-default" value="{{ trans('promotion.submit') }}" />
    <input type="reset" class="btn btn-default" value="{{ trans('promotion.clear') }}" />
</form>
</div>
@stop


