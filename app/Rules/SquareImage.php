<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
// use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;

class SquareImage implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        //
    }

    public function passes($attribute, $value)
    {
        // Periksa apakah file adalah gambar
        if ($value->isValid() && $value->getMimeType() === 'image/jpeg' || $value->getMimeType() === 'image/png' || $value->getMimeType() === 'image/gif' || $value->getMimeType() === 'image/svg+xml') {
            // Dapatkan dimensi gambar
            $image = Image::make($value->getRealPath());
            return $image->width() === $image->height();
        }

        return false;
    }

    public function message()
    {
        return 'The :attribute must be a square image (1:1 ratio).';
    }
}
