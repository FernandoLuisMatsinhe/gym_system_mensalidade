<?php
include('db.php');

function getMensalidadesVencendo() {
    $hoje = date('Y-m-d');
    $data_futura = date('Y-m-d', strtotime('+5 days', strtotime($hoje)));

    $sql = "SELECT c.nome, c.email, c.telefone, m.data_vencimento 
            FROM clientes c 
            INNER JOIN mensalidades m ON c.id = m.cliente_id 
            WHERE m.data_vencimento BETWEEN '$hoje' AND '$data_futura' AND m.status = 'pendente'";

    $result = $conn->query($sql);
    
    $clientes = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $clientes[] = $row;
        }
    }
    
    return $clientes;
}
?>