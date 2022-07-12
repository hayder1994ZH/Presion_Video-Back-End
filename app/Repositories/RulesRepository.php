<?php
namespace App\Repositories;

use App\Models\Rules;

class RulesRepository extends BaseRepository{
    public function __construct()
    {
        parent::__construct(new Rules());
    }
}
