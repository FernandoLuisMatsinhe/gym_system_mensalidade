// Usando o Twilio API (instale o Twilio SDK via Composer primeiro)
require_once 'vendor/autoload.php'; // Inclua o autoload do Composer

use Twilio\Rest\Client;
<?php
    function enviarSMS($telefone, $nome, $data_vencimento) {
        $sid = 'your_twilio_sid';
        $token = 'your_twilio_token';
        $from = 'your_twilio_phone_number';

        $client = new Client($sid, $token);
        
        $message = "Olá $nome, sua mensalidade do ginásio vence em $data_vencimento. Pague o quanto antes!";
        
        $client->messages->create(
            $telefone, // Número do cliente
            [
                'from' => $from,
                'body' => $message
            ]
        );
    }

?>