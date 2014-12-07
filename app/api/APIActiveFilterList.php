<?php

use Base;

class APIActiveFilterList extends \Base\BaseController {

    protected $repo_activeFilters;

    public function __construct(EloquentActiveFilterListInterface $repo_activeFilters) {
        $this->repo_activeFilters = $repo_activeFilters;
    }

    public function populateKeywords() {
        return Response::json(["keywords" => $this->repo_activeFilters->populateKeywords()->toArray()], 200);
    }

    /**
     * Populates root keywords.
     * Basically the first keyword in the array, since the keywords
     * are stored as an array in the database.
     * @return [array] [first item from the array]
     */
    public function populateRootKeywords() {
        return $this->repo_activeFilters->populateRootKeywords();
    }

}