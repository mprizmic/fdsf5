<?php

namespace App\Service;

use App\Entity\User;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class Mailer {

    private $emailAplicacion;
    private $emailManager;
    private $registroUsuarios;

    public function __construct(string $emailAplicacion, RegistroUsuarios $registroUsuarios, MailerInterface $emailManager)
    {
        $this->emailAplicacion = $emailAplicacion;
        $this->emailManager = $emailManager;
        $this->registroUsuarios = $registroUsuarios;
    }

    public function enviarEmailRegistroUsuario(User $user) {
        
        $this->enviarEmail($user->getEmail(), 'Bienvenido a mis mascadores!', 'email/registro.html.twig', [
            'user' => $user,
            'url_activar_usuario' => $this->registroUsuarios->generarUrlActivacionUsuario($user),
        ]);
    }

    public function enviarEmail(String $para, string $titulo, string $template, array $params) {
        $email = (new TemplatedEmail())
        ->from($this->emailAplicacion)
        ->to($para)
        ->subject($titulo)
        ->htmlTemplate($template)
        ->context($params);

        $this->emailManager->send($email);
    }
}