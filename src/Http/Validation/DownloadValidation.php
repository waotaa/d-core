<?php

namespace Vng\DennisCore\Http\Validation;

use Illuminate\Database\Eloquent\Model;

class DownloadValidation extends ModelValidation
{
    public function rules(): array
    {
        return [
            'label' => [
                'required'
            ],

            // Normale upload
            'file' => [
                'required_without:key',
                // verboden ALS key is ingevuld
                'prohibited_if:key,*',
                'file',
                'mimes:pdf,doc,docx,jpg,png',
                'max:5000',
            ],

            // Vapor multipart upload
            'key' => [
                'required_without:file',
                // verboden ALS file is ingevuld
                'prohibited_if:file,*',
                'string',
            ],

            'filename' => [
                // verplicht als key aanwezig is
                'required_with:key',
                // verboden als file is ingevuld
                'prohibited_if:file,*',
                'string',
            ],
            'organisation_id' => [
                'required'
            ]
        ];
    }

    protected function updateRules(Model $model): array
    {
        $rules = $this->rules();

        // Pas bestaande regels aan
        $rules['file'] = [
            'nullable', // nullable, not required when key is missing
            'prohibited_unless:key,null',
            'max:5000',
        ];
        $rules['key'] = [
            'nullable', // nullable, not required when file is missing
            'prohibited_unless:file,null'
        ];

        return $rules;
    }
}
