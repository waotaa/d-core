<?php

namespace Vng\DennisCore\Jobs;

class DeletePublicIndexJob extends DeleteIndexJob
{
    use PublicElasticClientTrait;
}
