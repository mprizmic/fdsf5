<?php
// src/Service/MessageGenerator.php

namespace App\Service;

class MessageGenerator
{
    public function getHappyMessage(): string
    {
        $messages = [
            'Ojos que no ven corazón que no siente',
            'Show me the code',
            'Primero ata bien tu camello y luego confìa en Dios',
        ];

        $index = array_rand($messages);

        return $messages[$index];
    }
}