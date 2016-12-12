@extends ('layouts.template_admin')

@section ('main-content')
    <section class="content-header">
        <h1 class="pull-left">{!! trans('voucher.voucher') !!}</h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>
        @if(Session::has('msg'))
            <div class="alert alert-success">
                {{ Session::get('msg') }}
            </div>
        @endif
        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                @include('admin.voucher.table')
            </div>
        </div>
    </div>
@endsection
