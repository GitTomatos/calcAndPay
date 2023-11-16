<?php

declare(strict_types=1);

namespace App\System\Action;

use App\System\Output\Error\ApiOutputError;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class JsonAbstractController extends AbstractController
{
    public function __construct(private readonly ValidatorInterface $validator)
    {
    }

    protected function validateDto(ActionArgumentDtoInterface $actionArgumentDto): void
    {
        $violations = $this->validator->validate($actionArgumentDto);
        if (count($violations) < 1) {
            return;
        }

        $errors = [];

        /** @var ConstraintViolation */
        foreach ($violations as $violation) {
            $attribute = $violation->getPropertyPath();
            $errors[] = [
                'property' => $attribute,
                'value' => $violation->getInvalidValue(),
                'message' => $violation->getMessage(),
            ];
        }

        $apiOutputError = new ApiOutputError(
            message: 'Ошибки валидации запроса',
            type: '',
            code: 400,
            errors: $errors,
        );

        $response = new JsonResponse($apiOutputError, 400);
        $response->send();
        exit;
    }
}