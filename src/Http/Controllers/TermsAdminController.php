<?php

namespace TypiCMS\Modules\Taxonomies\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use TypiCMS\Modules\Core\Http\Controllers\BaseAdminController;
use TypiCMS\Modules\Taxonomies\Http\Requests\TermFormRequest;
use TypiCMS\Modules\Taxonomies\Models\Taxonomy;
use TypiCMS\Modules\Taxonomies\Models\Term;

class TermsAdminController extends BaseAdminController
{
    public function index(Taxonomy $taxonomy): View
    {
        return view('taxonomies::admin.index-terms')
            ->with(compact('taxonomy'));
    }

    public function create(Taxonomy $taxonomy): View
    {
        $model = new Term();

        return view('taxonomies::admin.create-term')
            ->with(compact('model', 'taxonomy'));
    }

    public function edit(Taxonomy $taxonomy, Term $term): View
    {
        return view('taxonomies::admin.edit-term')
            ->with([
                'model' => $term,
                'taxonomy' => $taxonomy,
            ]);
    }

    public function store(Taxonomy $taxonomy, TermFormRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['taxonomy_id'] = $taxonomy->id;
        $term = Term::create($data);

        return $this->redirect($request, $term);
    }

    public function update(Taxonomy $taxonomy, Term $term, TermFormRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['taxonomy_id'] = $taxonomy->id;
        $term->update($data);

        return $this->redirect($request, $term);
    }
}
