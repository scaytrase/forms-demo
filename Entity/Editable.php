<?php

namespace ScayTrase\Demo\Forms\Entity;

interface Editable
{
    public function getFormClass();

    public static function create();
}
