<?php

namespace Vng\DennisCore\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Vng\DennisCore\Http\Validation\VideoValidation;
use Vng\DennisCore\Models\Video;

class VideoUpdateRequest extends FormRequest implements FormRequestInterface
{
    public function authorize(): bool
    {
        return Auth::user()->can('update', $this->route('video'));
    }

    public function rules(): array
    {
        $video = $this->route('video');
        if (!$video instanceof Video) {
            throw new \Exception('Cannot derive video from route');
        }
        return VideoValidation::make($this)->getUpdateRules($video);
    }
}
