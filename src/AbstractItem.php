<?php
namespace Swiped\HandbalWebservice;

class AbstractItem
{
    /**
     * Get all the public properties
     *
     * @return array
     */
    public function toArray()
    {
        return call_user_func('get_object_vars', $this);
    }
}
