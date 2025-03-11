<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lectura de Código de Barras</title>
    <style>
        #scanner-container {
            position: relative;
            width: 100%;
            height: 100%;
        }
        #scanner {
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
        }
        #result {
            margin-top: 20px;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <h1>Lectura de Código de Barras</h1>
    <div id="scanner-container">
        <div id="scanner"></div>
    </div>
    <div id="result">Esperando escaneo...</div>

    <!-- Incluir el CDN de QuaggaJS -->
    <script src="https://unpkg.com/quagga@0.12.1/dist/quagga.min.js"></script>

    <script>
        // Configuración de QuaggaJS para leer código de barras
        function startScanner() {
            // Verificar que Quagga está cargado
            if (typeof Quagga === 'undefined') {
                console.error('Quagga no está definido');
                return;
            }

            Quagga.init({
                inputStream: {
                    name: "Live",
                    type: "LiveStream",
                    target: document.querySelector('#scanner'), // donde se mostrará la cámara
                    constraints: {
                        facingMode: "environment" // usar la cámara trasera
                    }
                },
                decoder: {
                    readers: ["code_128_reader", "ean_reader", "ean_8_reader", "upc_reader"] // tipos de códigos soportados
                }
            }, function(err) {
                if (err) {
                    console.log(err);
                    alert("Error al iniciar el escáner");
                    return;
                }
                console.log("Escáner iniciado");
                Quagga.start();
            });

            // Evento cuando se detecta un código
            Quagga.onDetected(function(result) {
                document.getElementById('result').innerText = "Código detectado: " + result.codeResult.code;
            });
        }

        // Iniciar el escáner cuando cargue la página
        window.onload = startScanner;
    </script>
</body>
</html>
