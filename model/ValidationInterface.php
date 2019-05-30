<?php

namespace App\Model;

interface ValidationInterface
{

    public function validate(array $post): bool;

}