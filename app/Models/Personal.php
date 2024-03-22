<?php

namespace App\Models;

use App\Enums\Language;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Personal extends Model
{
    use HasFactory;

    protected $table = 'personal';

    public $timestamps = false;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'gender',
        'ip_address',
        'country',
        'language',

    ];


    protected function firstName(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Str::upper($value)
        );
    }

    protected $casts = [
        'language' => Language::class,
        /*        'country' => Pais::class, */

    ];


    function toArray(): array
    {

        return $this->attributesToArray();
    }
}
