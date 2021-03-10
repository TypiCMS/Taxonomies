<?php

namespace TypiCMS\Modules\Taxonomies\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use TypiCMS\Modules\Core\Http\Controllers\BaseAdminController;
use TypiCMS\Modules\Taxonomies\Http\Requests\FormRequest;
use TypiCMS\Modules\Taxonomies\Models\Taxonomy;
use TypiCMS\Modules\Taxonomies\Models\Term;

class AdminController extends BaseAdminController
{
    public function index(): View
    {
        return view('taxonomies::admin.index');
    }

    public function create(): View
    {
        $model = new Taxonomy();

        return view('taxonomies::admin.create')
            ->with(compact('model'));
    }

    public function edit(Taxonomy $taxonomy): View
    {
        return view('taxonomies::admin.edit')
            ->with(['model' => $taxonomy]);
    }

    public function store(FormRequest $request): RedirectResponse
    {
        $taxonomy = Taxonomy::create($request->validated());

        return $this->redirect($request, $taxonomy);
    }

    public function update(Taxonomy $taxonomy, FormRequest $request): RedirectResponse
    {
        $taxonomy->update($request->validated());
        (new Term())->flushCache();

        return $this->redirect($request, $taxonomy);
    }
}
