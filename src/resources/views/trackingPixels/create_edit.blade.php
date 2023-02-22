@extends('layouts.crud.create_edit')

@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title_singular }}
        @endslot
        @slot('breadcrumb')
            {{ Breadcrumbs::render('shortener_tracking_pixel_create_edit') }}
        @endslot
    @endcomponent
@endsection

@section('content')
    @parent
    <div class="row">
        <div class="col-md-8">
            @component('components.box')
                {!! CoralsForm::openForm($trackingPixel) !!}
                <div class="row">
                    <div class="col-md-6">
                        {!! CoralsForm::text('name','Shortener::attributes.tracking_pixel.name',true) !!}
                        {!! CoralsForm::select2('provider', 'Shortener::attributes.tracking_pixel.provider', config('shortener.models.tracking_pixel.providers'),true) !!}
                        {!! CoralsForm::radio('status','Corals::attributes.status', true, trans('Corals::attributes.status_options')) !!}
                        {!! CoralsForm::select2('short_domain_id', 'Shortener::attributes.tracking_pixel.short_domain', \Shortener::getShortDomainsList(),false) !!}
                    </div>
                    <div class="col-md-6">
                        {!! CoralsForm::textarea('head_script','Shortener::attributes.tracking_pixel.head_script',false,null,
                        ['placeholder' => 'Shortener::attributes.tracking_pixel.head_script_help']) !!}
                        {!! CoralsForm::textarea('body_script','Shortener::attributes.tracking_pixel.body_script',false,null,
                        ['placeholder' => 'Shortener::attributes.tracking_pixel.body_script_help']) !!}
                    </div>
                </div>

                {!! CoralsForm::customFields($trackingPixel) !!}

                <div class="row">
                    <div class="col-md-12">
                        {!! CoralsForm::formButtons() !!}
                    </div>
                </div>
                {!! CoralsForm::closeForm($trackingPixel) !!}
            @endcomponent
        </div>
    </div>
@endsection

@section('js')
@endsection
