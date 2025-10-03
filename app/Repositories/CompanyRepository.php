<?php

namespace App\Repositories;

use App\Interfaces\CompanyRepositoryInterface;
use App\Models\Company;

class CompanyRepository implements CompanyRepositoryInterface
{
    protected $model;

    public function __construct(Company $company)
    {
        $this->model = $company;
    }

    // Get all companies with relations
    public function getAllWithRelations()
    {
        return $this->model->with([
            'user', 'companyType', 'tag', 'peoples',
            'companyEmail', 'companyPhone', 'companyAddress', 'companyUrl', 'companyPeople'
        ]);
    }

    // Get companies for specific user with relations
    public function getByUserWithRelations($userId)
    {
        return $this->model->with([
            'user', 'companyType', 'tag', 'peoples',
            'companyEmail', 'companyPhone', 'companyAddress', 'companyUrl'
        ])->where('user_id', $userId);
    }

    // Count all companies
    public function countAll()
    {
        return $this->model->count();
    }

    // Count companies by user
    public function countByUser($userId)
    {
        return $this->model->where('user_id', $userId)->count();
    }


}
