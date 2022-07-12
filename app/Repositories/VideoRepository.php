<?php
namespace App\Repositories;
use App\Models\Video;

class VideoRepository extends BaseRepository{
    public function __construct()
    {
        parent::__construct(new Video());
    }
}
