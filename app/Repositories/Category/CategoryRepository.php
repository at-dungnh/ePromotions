<?php

namespace App\Repositories\Category;

use App\Repositories\BaseRepository;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Models\Category;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    /**
     * Constructor for category repository
     *
     * @param Category $category App\Models\Category
     */
    public function __construct(Category $category)
    {
        $this->model = $category;
    }

    /**
     * Get all categories only have name
     *
     * @return array List of categories
     */
    public function allName()
    {
        $list = $this->model->all()->toTree();
        $data = Category::recursiveTree($list, true, true);
        return $data;
    }

    /**
     * Get descendants of node by id
     *
     * @param Integer $id Id of root node
     *
     * @return array     List of descendant of node
     */
    public function findDescendants($id)
    {
        $list = $this->model->descendantsOf($id)->toTree();
        return $list;
    }

    /**
     * Get all categories is root
     *
     * @return array List root categories
     */
    public function allRoot()
    {
        $list = $this->model->whereIsRoot()->get()->toTree();
        return $list;
    }
}
