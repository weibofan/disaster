<?php

namespace app\api\model;
use traits\model\SoftDelete;
class Newsinfo extends BaseModel
{
    use SoftDelete;
    protected static $deleteTime = 'delete_time';
    
}