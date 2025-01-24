<?php

namespace Vng\DennisCore\Services\Storage;

class InternalStorageService extends AbstractStorageService
{
    public function getBasePath(): string
    {
        return 'internal';
    }
}