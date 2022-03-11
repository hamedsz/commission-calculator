<?php

namespace App\Entities;

interface CommissionCalculatorInterface
{
    public function __construct(Operation $operation);

    public function calculate() : float;
}
