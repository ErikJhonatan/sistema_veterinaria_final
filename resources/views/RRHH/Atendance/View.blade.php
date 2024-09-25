<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marcador de Asistencia</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Marcador de Asistencia</h1>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">

                        <button type="button" class="btn btn-success btn-block mb-3" onclick="startQRCodeScanner()">Abrir Escáner</button>

                        <div id="qr-reader" style="width: 100%; height: 300px; display: none;"></div>
                        <div id="buttons-container" style="display: none;">
                            <button type="button" class="btn btn-primary btn-block mb-3" onclick="markTime('Llegada')">Marcar Hora de Llegada</button>
                            <button type="button" class="btn btn-warning btn-block mb-3" onclick="markTime('Almuerzo')">Marcar Hora de Almuerzo</button>
                            <button type="button" class="btn btn-danger btn-block mb-3" onclick="markTime('Salida')">Marcar Hora de Salida</button>
                        </div>
    
                        <div id="message" class="text-center mt-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @vite('resources/js/app.js')
  
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        let currentType = '';
    
        function startQRCodeScanner() {
            document.getElementById('qr-reader').style.display = 'block'; 
            document.getElementById('buttons-container').style.display = 'none'; 
    
            const html5QrCode = new Html5Qrcode("qr-reader");
    
            html5QrCode.start(
                { facingMode: "environment" },
                { fps: 10, qrbox: 250 },
                (decodedText, decodedResult) => {
                    html5QrCode.stop().then(() => {
                        document.getElementById('qr-reader').style.display = 'none'; 
                        document.getElementById('buttons-container').style.display = 'block'; 
                        handleQRCode(decodedText);  
                    }).catch((err) => {
                        console.error(`Error al detener el escáner de códigos QR: ${err}`);
                    });
                },
                (errorMessage) => {
                    console.warn(`Error de escaneo de código QR: ${errorMessage}`);
                }
            ).catch(err => {
                console.error(`Error al iniciar el escáner de códigos QR: ${err}`);
            });
        }
    
        function handleQRCode(decodedText) {
            currentType = decodedText; 
            let message = 'QR escaneado exitosamente. Contenido: ' + decodedText;
            if (isValidURL(decodedText)) {
                message += ' (URL detectada)';
            } else if (isPhoneNumber(decodedText)) {
                message += ' (Número de teléfono detectado)';
            } else if (!isNaN(decodedText)) {
                message += ' (Número detectado)';
            }
    
            document.getElementById('message').textContent = message + '. Elija una opción para marcar.';
        }
    
        function isValidURL(string) {
            try {
                new URL(string);
                return true;
            } catch (_) {
                return false;  
            }
        }
    
        function isPhoneNumber(string) {
            const phoneRegex = /^\+?[0-9]{10,15}$/;
            return phoneRegex.test(string);
        }
    
        function markTime(type) {
            const qrCodeData = currentType; 
            if (!qrCodeData) {
                document.getElementById('message').textContent = 'No se ha escaneado ningún código QR.';
                return;
            }
    
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            fetch('/RRHH/Asistencia/Form', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ type: type, qr_code: qrCodeData })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('message').textContent = data.message;
                } else {
                    document.getElementById('message').textContent = 'Error en la respuesta del servidor: ' + data.message;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('message').textContent = 'Error al marcar el tiempo.';
            });
        }
    </script>
    
@switch(session('Menss'))
    @case(1)
        <script>
            toastr.error('Internal Serve Error')
        </script>
        @break
    @case(2)
       <script>
        toastr.warning('Hoy ya marcaste la hora de llegada')
        </script> 
        @break
    @case(3)
    <script>
        toastr.success('Hora de llegada marcada')
    </script>
    <script>
        toastr.warning('Tuviste un retraso de {{ $Retardo }} Minutos')
    </script>
    @break
    @case(4)
    <script>
        toastr.success('Almuerzo iniciado')
    </script>
    @break
   
    @case(5)
    <script>
        toastr.success('Tu horario a finalizado')
    </script>
    <script>
        toastr.warning('Tuviste un retraso de {{ $Retardo }} Minutos en tu salida')
    </script>
    @break
    @case(6)
    <script>
        toastr.warning('Debes marcar primero la entrada')
    </script>
    @break
    @default
        
@endswitch
</body>
</html>
