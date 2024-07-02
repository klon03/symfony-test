<?php

namespace App\RequestDeserializer;

use App\Exceptions\InvalidInputDataException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Throwable;

class RequestJsonDeserializer implements RequestDeserializer
{
    public function __construct(private SerializerInterface $serializer)
    {
    }

    public function fromRequestBody(Request $request, string $fqcnType): object
    {
        try {
            return $this->serializer->deserialize($request->getContent(), $fqcnType, 'json');
        } catch (Throwable $exception) {
            throw new InvalidInputDataException($exception->getMessage());
        }
    }

    public function fromQuery(Request $request, string $fqcnType): object
    {
        try {
            return $this->serializer->deserialize(json_encode($request->query->all()), $fqcnType, 'json');
        } catch (Throwable $exception) {
            throw new InvalidInputDataException($exception->getMessage());
        }
    }

    public function fromAttributes(Request $request, string $fqcnType): object
    {
        try {
            return $this->serializer->deserialize(json_encode($request->attributes->all()), $fqcnType, 'json');
        } catch (Throwable $exception) {
            throw new InvalidInputDataException($exception->getMessage());
        }
    }

}
