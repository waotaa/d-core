<?php

namespace Vng\DennisCore\Interfaces;

interface SearchableInterface
{
    public function getSearchIndex();
    public function getSearchType();
    public function toSearchArray();
}
