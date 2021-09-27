<?php

namespace TypiCMS\Modules\Taxonomies\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Arr;
use TypiCMS\Modules\Taxonomies\Facades\Taxonomies;
use TypiCMS\Modules\Taxonomies\Models\Term;

trait HasTerms
{
    public static function bootHasTerms()
    {
        static::saved(function (Model $model) {
            $data = array_filter(Arr::flatten((array) request('terms')));
            $model->terms()->sync($data);
        });
    }

    public function terms(): MorphToMany
    {
        return $this->morphToMany(Term::class, 'model', 'model_has_terms')
            ->orderBy('position')
            ->withTimestamps();
    }

    public function getTaxonomies(): Collection
    {
        return Taxonomies::whereJsonContains('modules', $this->getTable())
            ->order()
            ->get();
    }

    public function getTaxonomyValidationRules(): array
    {
        $taxonomies = $this->getTaxonomies();
        $rules = [];
        foreach ($taxonomies as $taxonomy) {
            $rules['terms.'.$taxonomy->name] = $taxonomy->validation_rule;
        }

        return $rules;
    }
}
