<?php

namespace App\Filters\V1;

use App\Filters\ApiFilter;

class UsersFilter extends ApiFilter
{
    protected $safeParams = [
        // 'firstName' => ['eq'],
        // 'lastName'=> ['eq'],
        'email' => ['eq'],
        // 'contactNumber' => ['eq'],
        // 'profileImage' => ['eq'],
        // 'timezone' => ['eq'],
    ];

    protected $columnMap = [
        // 'firstName' => 'first_name',
        // 'lastName' => 'last_name',
        // 'contactNumber' => 'contact_number',
    ];

    protected $operatorMap = [
        'eq' => '=',
    ];
}
