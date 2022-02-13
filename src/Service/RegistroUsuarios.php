<?php

namespace App\Service;

use App\Entity\User;
use Nzo\UrlEncryptorBundle\UrlEncryptor\UrlEncryptor;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class RegistroUsuarios {

    private $router;
    private $encryptor;

    public function __construct(UrlEncryptor $encryptor, UrlGeneratorInterface $router)
    {
        $this->router = $router;
        $this->encryptor = $encryptor;
    }

    public function generarUrlActivacionUsuario(User $user) {
        $fechaHoraExpiracion = new \DateTime();
        $fechaHoraExpiracion->modify('+1 day');

        $datos = [
            'id' => $user->getId(),
            'fechaExpiracion' => $fechaHoraExpiracion->format('Y-m-d H:m:s')
        ];

        /* los datos no puede pasar en json asì que tienen que ir encriptados */

        $token = $this->encryptor->encrypt(json_encode($datos));

        return $this->router->generate('app_activar_usuario', [
            'token' => $token
        ], UrlGeneratorInterface::ABSOLUTE_URL);
    }

}