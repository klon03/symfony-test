<?php

namespace App\Security;
use App\Formatter\ApiResponseFormatter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;

class AccessDeniedHandler implements AccessDeniedHandlerInterface
{
    public function __construct(private ApiResponseFormatter $responseFormatter)
    {
    }

    public function handle(Request $request, AccessDeniedException $accessDeniedException): JsonResponse
    {
        $att = $accessDeniedException->getAttributes();
        $text = "Odmowa dostępu, brak uprawnień: ";
        foreach ($att as $a) {
            $text .= $a . ' ';
        }
        return  $this->responseFormatter->error($text, [], Response::HTTP_FORBIDDEN);
    }
}
