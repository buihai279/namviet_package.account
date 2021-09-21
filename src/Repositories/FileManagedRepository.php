<?php

namespace Namviet\Account\Repositories;


use Namviet\Account\Models\FileManaged;
use Prettus\Repository\Eloquent\BaseRepository;

class FileManagedRepository extends BaseRepository
{
    /*
    **
    * Specify Model class name
    *
    * @return string
    */
    function model()
    {
        return FileManaged::class;
    }

}
