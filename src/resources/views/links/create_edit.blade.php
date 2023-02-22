@extends('layouts.crud.create_edit')



@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title_singular }}
        @endslot
        @slot('breadcrumb')
            {{ Breadcrumbs::render('shortener_link_create_edit') }}
        @endslot
    @endcomponent
@endsection

@section('content')
    @parent
    <div class="row">
        <div class="col-md-12">
            @component('components.box')
                {!! CoralsForm::openForm($link) !!}
                <div class="row">
                    <div class="col-md-4">
                        {!! CoralsForm::text('url','Shortener::attributes.link.url',true) !!}
                        {!! CoralsForm::select('short_domain_id', 'Shortener::attributes.shortDomain.base_url', \Shortener::getShortDomainsList(), false,null,
                                                                                    ['help_text'=>trans('Shortener::labels.link.short_domain_help_text',['domain'=>config('app.url')])]) !!}
                        {!! CoralsForm::radio('status','Corals::attributes.status', true, trans('Corals::attributes.status_options')) !!}
                        {!! CoralsForm::text('alias','Shortener::attributes.link.alias',false) !!}
                    </div>
                    <div class="col-md-4">
                        {!! CoralsForm::date('expired_at','Shortener::attributes.link.expired_at', false, $link->expired_at) !!}
                        {!! CoralsForm::checkbox('show_splash_page','Shortener::attributes.link.show_splash_page', $link->exists?$link->show_splash_page:true) !!}
                        {!! CoralsForm::textarea('description','Shortener::attributes.link.description', false) !!}
                    </div>
                    <div class="col-md-4">
                        <label>@lang('Shortener::attributes.link.parameters')</label>
                        @include("Corals::key_value",[
                           "label"=>["key"=> trans("Corals::labels.key"), "value"=>trans("Corals::labels.value")],
                           "name"=>"parameters",
                           "options"=>data_get($link,"parameters",[])
                           ])
                    </div>
                </div>

                {!! CoralsForm::customFields($link) !!}

                <div class="row">
                    <div class="col-md-12">
                        {!! CoralsForm::formButtons() !!}
                    </div>
                </div>
                {!! CoralsForm::closeForm($link) !!}
            @endcomponent
        </div>
    </div>
@endsection

@section('js')
@endsection
