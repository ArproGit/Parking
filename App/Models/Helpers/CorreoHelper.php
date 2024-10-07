<?php
namespace App\Models\Helpers;

// -----
// Se cambia por PHP MAILER, diferencie ambas funciones..
// enviarCorreoUsuarioPendiente
// enviarCorreoUsuarioVencido
// 
// Considerar entre función mail, phpmailer usando gmail o phpmailer usando sendgrid
//                      VELOCIDAD de Envío      Spam        Precio
// mail()                   +++                 ---         Free
// PHPMailer + Gmail        ---                 +++         500 envios free diarios
// PHPMailer + SendGrid     +++                 99.9%       100 envios diarios con planes
// 
// -----

require( dirname(__FILE__)  . '/../../../vendor/composer/phpmailer/Exception.php');
require( dirname(__FILE__)  . '/../../../vendor/composer/phpmailer/PHPMailer.php');
require( dirname(__FILE__)  . '/../../../vendor/composer/phpmailer/SMTP.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class CorreoHelper {
    
    function enviarCorreoUsuarioPendiente($correoUsuario, $dias_faltantes, $cliente_pendiente) {
        $dominio =  $cliente_pendiente["dominio"];
        $fecha_vencimiento = date("d/m/Y H:i:s", strtotime($cliente_pendiente["fecha_vencimiento"]));
        $nombre_empresa =  $cliente_pendiente["nombre_empresa"];
        $moneda_cliente =  $cliente_pendiente["moneda"];
        $renovacion_cliente = number_format($cliente_pendiente["renovacion"], 0, '.', '.');

        $mensaje = "<html><body>";
        $mensaje .= "<h1>Estimado, $nombre_empresa ,</h1>";
        $mensaje .= "<h2>Buenos Días.</h2>";
        $mensaje .= "<h3>El Hosting del sitio web $dominio vence el $fecha_vencimiento .</h3>";
        if ($dias_faltantes == 1) {
            $mensaje .= "<h3>Queda $dias_faltantes día antes de que tu cuenta llegue a su vencimiento.</h3>";
            $mensaje .= "<br>";
        } else {
            $mensaje .= "<h3>Quedan $dias_faltantes días antes de que tu cuenta llegue a su vencimiento.</h3>";
            $mensaje .= "<br>";
        }

        if ($moneda_cliente === "Dolar") {
            $mensaje .= "<h3>El costo por 1 año es de U\$S $renovacion_cliente + iva (Dólares Americanos). Renovamos los servicios?.</h3>";
            $mensaje .= "<p>GIRO POR ABITAB.NET CUENTA 2237.</p>";
            // $mensaje .= "<h2>BROU C/A dólares 0014XXXXXX-000XX Nombre: AGM</h2>";
            $mensaje .= "<p>BROU C/A dólares 0014XXXXXX-000XX Nombre: AGM</p>";
        }
        if ($moneda_cliente === "Pesos") {
            $mensaje .= "<h3>El costo por 1 año es de $ $renovacion_cliente + iva (Pesos). Renovamos los servicios?.</h3>";
            $mensaje .= "<p>GIRO POR ABITAB.NET CUENTA 2237.</p>";
            // $mensaje .= "<h2>BROU C/A pesos 0014XXXXXX-000XX Nombre: AGM</h2>";
            $mensaje .= "<p>BROU C/A pesos 0014XXXXXX-000XX Nombre: AGM</p>";
        }
      
        $mensaje .= "<p>Luego de realizar el giro, por favor no olvidar de enviarnos el comprobante por email junto con los datos para realizar su factura de pago.</p>";
        $mensaje .= "<br>";
        $mensaje .= "<p>Pasando la fecha de vencimiento, la multa a pagar es de U\$S 100 + iva (Dólares Americanos) además del costo de renovación.</p>";
        $mensaje .= "<p>Al no renovar, se pierde la cuenta con todos los datos, no se acepta reclamos.</p>";
        $mensaje .= "<br>";
        $mensaje .= "<h3>Gracias y cordiales saludos.</h3>";
        $mensaje .= "<br>";
        $mensaje .= "<h3>AGMARKETING URUGUAY</h3>";
        $mensaje .= "<h3><a href='https://www.agenciamarketing.com.uy' title='Agencia Marketing'>https://www.agenciamarketing.com.uy</a></h3>";
        $mensaje .= "</body></html>";

        $mail = new PHPMailer(true);
        
        try {
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = 'smtp.hostinger.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'contacto@maatreeftest.tech'; 
            $mail->Password = 'ContactoReef33!'; 
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
            $mail->Port = 587; 

            $mail->setFrom('contacto@maatreeftest.tech', 'AGMarketing');
            $mail->addAddress($correoUsuario, $nombre_empresa);

            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';
            $mail->isHTML(true);
            $mail->Subject = 'Proximidad de vencimiento para ' . $dominio;
            $mail->Body = $mensaje;

            $mail->send();
            return "ok";
        } catch (Exception $e) {
            return "error";
        }

    }
    function enviarCorreoUsuarioVencido($correoUsuario, $dias_faltantes, $cliente_vencido) {
        $dominio =  $cliente_vencido["dominio"];
        $fecha_vencimiento = date("d/m/Y H:i:s", strtotime($cliente_vencido["fecha_vencimiento"]));
        $nombre_empresa =  $cliente_vencido["nombre_empresa"];
        $moneda_cliente =  $cliente_vencido["moneda"];
        $renovacion_cliente = number_format($cliente_vencido["renovacion"], 0, '.', '.');


        $mensaje = "<html><body>";
        $mensaje .= "<h1>Estimado, $nombre_empresa ,</h1>";
        $mensaje .= "<h2>Buenos Días.</h2>";
        $mensaje .= "<h3>El Hosting del sitio web $dominio venció el $fecha_vencimiento .</h3>";
        $mensaje .= "<br>";
        if ($moneda_cliente === "Dolar") {
            $mensaje .= "<h3>El costo por 1 año es de U\$S $renovacion_cliente + iva (Dólares Americanos). Renovamos los servicios?.</h3>";
            $mensaje .= "<p>GIRO POR ABITAB.NET CUENTA 2237.</p>";
            // $mensaje .= "<h2>BROU C/A dólares 0014XXXXXX-000XX Nombre: AGM</h2>";
            $mensaje .= "<p>BROU C/A dólares 0014XXXXXX-000XX Nombre: AGM</p>";
        }
        if ($moneda_cliente === "Pesos") {
            $mensaje .= "<h3>El costo por 1 año es de $ $renovacion_cliente + iva (Pesos). Renovamos los servicios?.</h3>";
            $mensaje .= "<p>GIRO POR ABITAB.NET CUENTA 2237.</p>";
            // $mensaje .= "<h2>BROU C/A pesos 0014XXXXXX-000XX Nombre: AGM</h2>";
            $mensaje .= "<p>BROU C/A pesos 0014XXXXXX-000XX Nombre: AGM</p>";
        }
        $mensaje .= "<p>Luego de realizar el giro, por favor no olvidar de enviarnos el comprobante por email junto con los datos para realizar su factura de pago.</p>";
        $mensaje .= "<br>";
        $mensaje .= "<p>Pasando la fecha de vencimiento, la multa a pagar es de U\$S 100 + iva (Dólares Americanos) además del costo de renovación.</p>";
        $mensaje .= "<p>Al no renovar, se pierde la cuenta con todos los datos, no se acepta reclamos.</p>";
        $mensaje .= "<br>";
        $mensaje .= "<h3>Gracias y cordiales saludos.</h3>";
        $mensaje .= "<br>";
        $mensaje .= "<h3>AGMARKETING URUGUAY</h3>";
        $mensaje .= "<h3><a href='https://www.agenciamarketing.com.uy' title='Agencia Marketing'>https://www.agenciamarketing.com.uy</a></h3>";
        $mensaje .= "</body></html>";
        
        $mail = new PHPMailer(true);
        
        try {
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = 'smtp.hostinger.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'contacto@maatreeftest.tech'; 
            $mail->Password = 'ContactoReef33!'; 
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
            $mail->Port = 587; 

            $mail->setFrom('contacto@maatreeftest.tech', 'AGMarketing');
            $mail->addAddress($correoUsuario, $nombre_empresa);

            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';
            $mail->isHTML(true);
            $mail->Subject = 'Vencimiento para ' . $dominio;
            $mail->Body = $mensaje;

            $mail->send();
            return "ok";
        } catch (Exception $e) {
            return "error";
        }
    }

}