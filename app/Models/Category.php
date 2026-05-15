<?php

namespace App\Models;

use App\Models\Scopes\IsActiveScope;
use Illuminate\Database\Eloquent\Model;
use Override;

class Category extends Model
{
    protected $table = "categories";
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        "id",
        "name",
        "description"
    ];

    #[Override]
    protected static function booted()
    {
        parent::booted();
        self::addGlobalScope(new IsActiveScope());
    }
}
