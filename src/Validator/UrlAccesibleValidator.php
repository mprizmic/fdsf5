<?php

namespace App\Validator;

Use App\Service\ClienteHttp;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;


class UrlAccesibleValidator extends ConstraintValidator
{
    private $clienteHttp;

    public function __construct(ClienteHttp $clienteHttp)
    {
        $this->clienteHttp = $clienteHttp;
    }
    public function validate($value, Constraint $constraint)
    {
        /* @var $constraint \App\Validator\UrlAccesible */

        if (null === $value || '' === $value) {
            return;
        }

        // TODO: implement the validation here
        $codigoEstado = $this->clienteHttp->obtenerCodigoUrl($value);

        if (null === $codigoEstado){
            $codigoEstado='Error';
        }
        if (200 !== $codigoEstado){
            $this->context->buildViolation($constraint->message)
            ->setParameter('{{ codigo }}', $codigoEstado)
            ->addViolation();
        }
    }
}
