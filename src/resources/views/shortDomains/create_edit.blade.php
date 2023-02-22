@extends('layouts.crud.create_edit')



@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title_singular }}
        @endslot
        @slot('breadcrumb')
            {{ Breadcrumbs::render('shortener_shortDomain_create_edit') }}
        @endslot
    @endcomponent
@endsection

@section('content')
    @parent
    <div class="row">
        <div class="col-md-4">
            @component('components.box')
                {!! CoralsForm::openForm($shortDomain) !!}

                {!! CoralsForm::text('title','Shortener::attributes.shortDomain.title',true) !!}
                {!! CoralsForm::text('base_url','Shortener::attributes.shortDomain.base_url',true) !!}
                {!! CoralsForm::radio('status','Corals::attributes.status', true, trans('Corals::attributes.status_options')) !!}

                {!! CoralsForm::customFields($shortDomain) !!}

                {!! CoralsForm::formButtons() !!}
                {!! CoralsForm::closeForm($shortDomain) !!}
            @endcomponent
        </div>
    </div>
@endsection

@section('js')
@endsection
