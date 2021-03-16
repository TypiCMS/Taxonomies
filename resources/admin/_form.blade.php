@component('core::admin._buttons-form', ['model' => $model])
@endcomponent

{!! BootForm::hidden('id') !!}

{!! BootForm::text(__('Name'), 'name')->required() !!}
{!! TranslatableBootForm::text(__('String to show in results'), 'result_string') !!}

@include('core::form._title-and-slug')

<label class="form-label">@lang('Use in modules')</label>
{!! Form::hidden('modules[]')->value('') !!}
@foreach ($modules as $module => $properties)
<div class="form-check">
    {!! Form::checkbox('modules[]', $module)->id($module)->addClass('form-check-input') !!}
    <label class="form-check-label" for="{{ $module }}">@lang(ucfirst($module))</label>
</div>
@endforeach
