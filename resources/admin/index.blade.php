@extends('core::admin.master')

@section('title', __('Taxonomies'))

@section('content')

<item-list
    url-base="/api/taxonomies"
    locale="{{ config('typicms.content_locale') }}"
    fields="id,title,position"
    table="taxonomies"
    title="taxonomies"
    :publishable="false"
    :exportable="false"
    :searchable="['title']"
    :sorting="['position']">

    <template slot="add-button" v-if="$can('create taxonomies')">
        @include('core::admin._button-create', ['module' => 'taxonomies'])
    </template>

    <template slot="columns" slot-scope="{ sortArray }">
        <item-list-column-header name="checkbox" v-if="$can('update taxonomies')||$can('delete taxonomies')"></item-list-column-header>
        <item-list-column-header name="edit" v-if="$can('update taxonomies')"></item-list-column-header>
        <item-list-column-header name="edit" v-if="$can('update terms')"></item-list-column-header>
        <item-list-column-header name="position" sortable :sort-array="sortArray" :label="$t('Position')"></item-list-column-header>
        <item-list-column-header name="title_translated" sortable :sort-array="sortArray" :label="$t('Title')"></item-list-column-header>
    </template>

    <template slot="table-row" slot-scope="{ model, checkedModels, loading }">
        <td class="checkbox" v-if="$can('update taxonomies')||$can('delete taxonomies')"><item-list-checkbox :model="model" :checked-models-prop="checkedModels" :loading="loading"></item-list-checkbox></td>
        <td v-if="$can('update taxonomies')">@include('core::admin._button-edit', ['segment' => 'taxonomies', 'module' => 'taxonomies'])</td>
        <td v-if="$can('update terms')">
            <a class="btn btn-light btn-xs" :href="'taxonomies/'+model.id+'/terms'">@lang('Terms')</a>
        </td>
        <td><item-list-position-input :model="model"></item-list-position-input></td>
        <td v-html="model.title_translated"></td>
    </template>

</item-list>

@endsection
