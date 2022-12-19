<?php

namespace Vng\DennisCore\Casts;

use Vng\DennisCore\Services\TextEditService;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class CleanedHtml implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        return $this->transformHtml($value);
    }

    public function set($model, string $key, $value, array $attributes)
    {
        return $this->transformHtml($value);
    }

    private function transformHtml($html): ?string
    {
        if (!is_string($html)) {
            return $html;
        }
        return TextEditService::cleanHtml($html);
    }
}
