@php
    $model->terms = $model->terms()->pluck('terms.id')->all();
@endphp
@if ($taxonomies = Taxonomies::whereRaw('JSON_CONTAINS(modules, \'"'.$module.'"\')')->order()->get() and $taxonomies->count() > 0)
    @foreach ($taxonomies as $taxonomy)
    <div class="col-md-3">
        <label class="form-label" for="">{{ $taxonomy->title }}</label>
        @foreach ($taxonomy->terms as $term)
        <div class="form-check">
            {!! Form::checkbox('terms[]', $term->id)->id('term_'.$term->id)->addClass('form-check-input') !!}
            <label class="form-check-label" for="{{ 'term_'.$term->id }}">{{ $term->title }}</label>
        </div>
        @endforeach
    </div>
    @endforeach
@endif
