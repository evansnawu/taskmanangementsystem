<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Auth;

trait FilterByOwner

{
  public static function boot()
  {
    parent::boot();

    $table = (new static)->getTable();

    self::addGlobalScope(fn (Builder $builder) => $builder->where($table . '.user_id', (auth()->check() ? auth()->id() : null)));
  }
}
