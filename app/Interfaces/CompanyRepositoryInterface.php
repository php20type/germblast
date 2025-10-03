<?php

namespace App\Interfaces;

interface CompanyRepositoryInterface
{
    public function getAllWithRelations();
    public function getByUserWithRelations($userId);
    public function countAll();
    public function countByUser($userId);
}
