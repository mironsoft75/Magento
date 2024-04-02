<?php
namespace CustomeModule\RestApiExample\Model;

use CustomeModule\RestApiExample\Api\PostRepositoryInterface;

class PostRepository implements PostRepositoryInterface
{


    /**
     * Return Response for Rest api
     *
     * @api
     * @param No params.
     * @return string[]
     */
    public function getList()
    {
        return "First Rest Api Example";


    }
}
//end class
