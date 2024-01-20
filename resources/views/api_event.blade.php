<?php
// Conexión a la base de datos (ajusta la configuración según tu entorno)
$conexion = new mysqli("localhost", "root", "", "appeventos", 3309);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
?>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('API DE EVENTOS') }}
        </h2>
    </x-slot>
    <div id="eventos-container">
        <!-- Aquí se mostrarán los datos de la API -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                // Realizar una solicitud AJAX para obtener la lista de eventos paginada
                $.get('/api/events/1', function(data) {
                    // Manejar la respuesta y mostrar los datos en la vista
                    var eventosHtml = '<ul>';
                    $.each(data, function(index, evento) {
                        eventosHtml += '<li>' + evento.nombre + ' - ' + evento.fecha + '</li>';
                    });
                    eventosHtml += '</ul>';
                    $('#eventos-container').html(eventosHtml);
                });

                // Realizar una solicitud AJAX para obtener un evento específico por ID
                var eventoId = 1; // Cambia esto por el ID del evento que deseas obtener
                $.get('/api/evento/' + eventoId, function(evento) {
                    // Manejar la respuesta y mostrar los datos en la vista
                    var eventoHtml = '<h2>' + evento.nombre + '</h2>';
                    eventoHtml += '<p>Fecha: ' + evento.fecha + '</p>';
                    eventoHtml += '<p>Descripción: ' + evento.descripcion + '</p>';
                    // Agrega más campos según sea necesario
                    $('#evento-container').html(eventoHtml);
                });
            });
        </script>
        <?php
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $perPage = 10;
        $offset = ($page - 1) * $perPage;

        $consulta = "SELECT * FROM evento_culturals LIMIT $offset, $perPage";
        $resultado = $conexion->query($consulta);

        $eventos = [];
        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $eventos[] = $fila;
            }
        }

        header('Content-Type: application/json');
        echo json_encode($eventos);

        ?>
    </div>
</x-app-layout>