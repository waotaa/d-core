<?php

namespace Vng\DennisCore\Jobs;

class RemoveResourceFromPublicElasticJob extends RemoveResourceFromElasticJob
{
    use PublicElasticClientTrait;
}
