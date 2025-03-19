<?php
    function enviarEmail($email, $nome, $data_vencimento) {
        $assunto = "Aviso: Sua mensalidade está prestes a vencer!";
        $mensagem = "
        <html>
        <head>
            <title>Aviso de Vencimento de Mensalidade</title>
        </head>
        <body>
            <p>Olá $nome,</p>
            <p>Informamos que sua mensalidade está prestes a vencer em $data_vencimento. Por favor, realize o pagamento o quanto antes para evitar interrupção nos seus serviços.</p>
            <p>Atenciosamente,<br>Soufitness</p>
        </body>
        </html>
        ";

        // Cabeçalhos do e-mail
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8" . "\r\n";

        // Enviar o e-mail
        mail($email, $assunto, $mensagem, $headers);
    }
?>

