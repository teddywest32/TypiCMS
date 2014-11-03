@section('js')
    {{ HTML::script(asset('//tinymce.cachefly.net/4.1/tinymce.min.js')) }}
    {{ HTML::script(asset('js/admin/form.js')) }}
@stop

@section('otherSideLink')
    @include('admin._navbar-public-link')
@stop


@include('admin._buttons-form')

{{ BootForm::hidden('id') }}
{{ BootForm::hidden('position', $model->position ? : 0) }}
{{ BootForm::hidden('parent_id') }}

<ul class="nav nav-tabs">
    <li class="active">
        <a href="#tab-main" data-target="#tab-main" data-toggle="tab">@lang('global.Content')</a>
    </li>
    <li>
        <a href="#tab-files" data-target="#tab-files" data-toggle="tab">@lang('global.Files')</a>
    </li>
    <li>
        <a href="#tab-meta" data-target="#tab-meta" data-toggle="tab">@lang('global.Meta')</a>
    </li>
    <li>
        <a href="#tab-options" data-target="#tab-options" data-toggle="tab">@lang('global.Options')</a>
    </li>
</ul>

<div class="tab-content">

    {{-- Main tab --}}
    <div class="tab-pane fade in active" id="tab-main">

        @include('admin._tabs-lang-form', ['target' => 'content'])

        <div class="tab-content">

        @foreach ($locales as $lang)

            <div class="tab-pane fade in @if ($locale == $lang)active @endif" id="content-{{ $lang }}">

                <div class="row">

                    <div class="col-md-6">
                        {{ BootForm::text(trans('labels.title'), $lang.'[title]') }}
                    </div>
                    <div class="col-md-6 form-group @if($errors->has($lang.'.slug'))has-error @endif">
                        {{ Form::label($lang.'[slug]', trans('validation.attributes.url'), array('class' => 'control-label')) }}
                        <div class="input-group">
                            <span class="input-group-addon">{{ $model->present()->parentUri($lang) }}</span>
                            {{ Form::text($lang.'[slug]', $model->translate($lang)->slug, array('class' => 'form-control')) }}
                            <span class="input-group-btn">
                                <button class="btn btn-default btn-slug @if($errors->has($lang.'.slug'))btn-danger @endif" type="button">@lang('validation.attributes.generate')</button>
                            </span>
                        </div>
                        {{ $errors->first($lang.'.slug', '<p class="help-block">:message</p>') }}
                    </div>
                </div>

                {{ BootForm::hidden($lang.'[uri]') }}

                {{ BootForm::checkbox(trans('labels.online'), $lang.'[status]') }}

                {{ BootForm::textarea(trans('labels.body'), $lang.'[body]')->addClass('editor') }}
            
            </div>
            
        @endforeach

        </div>

    </div>

    {{-- Galleries tab --}}
    <div class="tab-pane fade in" id="tab-files">

        @include('admin._image-fieldset', ['field' => 'image'])

        @include('admin._galleries-fieldset')

    </div>

    {{-- Metadata tab --}}
    <div class="tab-pane fade in" id="tab-meta">

        @include('admin._tabs-lang-form', ['target' => 'meta'])

        <div class="tab-content">

        {{-- Headers --}}
        @foreach ($locales as $lang)

        <div class="tab-pane fade in @if ($locale == $lang)active @endif" id="meta-{{ $lang }}">

            {{ BootForm::text(trans('labels.meta_title'), $lang.'[meta_title]') }}

            {{ BootForm::text(trans('labels.meta_keywords'), $lang.'[meta_keywords]') }}

            {{ BootForm::text(trans('labels.meta_description'), $lang.'[meta_description]') }}

        </div>

        @endforeach

        </div>

    </div>

    {{-- Options --}}
    <div class="tab-pane fade in" id="tab-options">

        {{ BootForm::checkbox(trans('labels.is_home'), 'is_home') }}

        {{ BootForm::text(trans('labels.template'), 'template') }}

        {{ BootForm::textarea(trans('labels.css'), 'css') }}

        {{ BootForm::textarea(trans('labels.js'), 'js') }}

    </div>

</div>
