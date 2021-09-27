<?php

namespace TypiCMS\Modules\Taxonomies\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use TypiCMS\Modules\Taxonomies\Models\Term;

trait HasTerms
{
    public static function bootHasTerms()
    {
        static::saved(function (Model $model) {
            $model->terms()->sync(array_filter((array) request('terms')));
        });
    }

    public function terms(): MorphToMany
    {
        return $this->morphToMany(Term::class, 'model', 'model_has_terms')
            ->orderBy('position')
            ->withTimestamps();
    }
}
