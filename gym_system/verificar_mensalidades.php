<?php
include('mensalidades.php');
include('enviar_email.php');
include('enviar_sms.php');

$clientes = getMensalidadesVencendo();

foreach ($clientes as $cliente) {
    // Enviar e-mail
    enviarEmail($cliente['email'], $cliente['nome'], $cliente['data_vencimento']);
    
    // Enviar SMS (caso haja telefone)
    if ($cliente['telefone']) {
        enviarSMS($cliente['telefone'], $cliente['nome'], $cliente['data_vencimento']);
    }
}
?>