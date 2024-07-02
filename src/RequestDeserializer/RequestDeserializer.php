<?php

declare(strict_types=1);
namespace App\RequestDeserializer;

use Symfony\Component\HttpFoundation\Request;

interface RequestDeserializer
{
    public function fromRequestBody(Request $request, string $fqcnType): object;

    public function fromQuery(Request $request, string $fqcnType): object;

    public function fromAttributes(Request $request, string $fqcnType): object;
}
