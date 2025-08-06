<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Envío de Correos - SendGrid</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            padding: 40px;
            width: 100%;
            max-width: 500px;
        }
        
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
            font-size: 2.2em;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 600;
        }
        
        input, textarea {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e1e5e9;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }
        
        input:focus, textarea:focus {
            outline: none;
            border-color: #667eea;
        }
        
        textarea {
            resize: vertical;
            min-height: 120px;
        }
        
        button {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s ease;
        }
        
        button:hover {
            transform: translateY(-2px);
        }
        
        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: 500;
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>📧 Enviar Correo</h1>
        
        <?php
        require_once 'vendor/autoload.php';
        
        // Cargar configuración
        $config = require_once 'config.php';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $destinatario = $_POST['destinatario'] ?? '';
            $asunto = $_POST['asunto'] ?? '';
            $mensaje = $_POST['mensaje'] ?? '';
            
            if (empty($destinatario) || empty($asunto) || empty($mensaje)) {
                echo '<div class="alert alert-error">Por favor, complete todos los campos.</div>';
            } else {
                try {
                    // Configurar SendGrid
                    $apiKey = $config['sendgrid']['api_key'];
                    $fromEmail = $config['sendgrid']['from_email'];
                    $fromName = $config['sendgrid']['from_name'];
                    
                    $email = new \SendGrid\Mail\Mail();
                    $email->setFrom($fromEmail, $fromName);
                    $email->setSubject($asunto);
                    $email->addTo($destinatario);
                    $email->addContent("text/plain", $mensaje);
                    $email->addContent("text/html", nl2br($mensaje));
                    
                    $sendgrid = new \SendGrid($apiKey);
                    $response = $sendgrid->send($email);
                    
                    if ($response->statusCode() == 202) {
                        echo '<div class="alert alert-success">✅ Correo enviado exitosamente!</div>';
                        // Limpiar formulario
                        $destinatario = $asunto = $mensaje = '';
                    } else {
                        echo '<div class="alert alert-error">❌ Error al enviar el correo. Código: ' . $response->statusCode() . '</div>';
                    }
                } catch (Exception $e) {
                    echo '<div class="alert alert-error">❌ Error: ' . $e->getMessage() . '</div>';
                }
            }
        }
        ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="destinatario">📧 Destinatario:</label>
                <input type="email" id="destinatario" name="destinatario" 
                       value="<?php echo htmlspecialchars($destinatario ?? ''); ?>" 
                       placeholder="ejemplo@correo.com" required>
            </div>
            
            <div class="form-group">
                <label for="asunto">📝 Asunto:</label>
                <input type="text" id="asunto" name="asunto" 
                       value="<?php echo htmlspecialchars($asunto ?? ''); ?>" 
                       placeholder="Asunto del correo" required>
            </div>
            
            <div class="form-group">
                <label for="mensaje">💬 Mensaje:</label>
                <textarea id="mensaje" name="mensaje" 
                          placeholder="Escribe tu mensaje aquí..." required><?php echo htmlspecialchars($mensaje ?? ''); ?></textarea>
            </div>
            
            <button type="submit">🚀 Enviar Correo</button>
        </form>
    </div>
</body>
</html>
