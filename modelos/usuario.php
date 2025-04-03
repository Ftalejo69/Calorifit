<?php
// usuario.php
include_once '../configuracion/conexion.php';
require(__DIR__ . '/../vendor/autoload.php');

// conexion Composer haya instalado PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class UsuarioModel {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    // Comprueba si el correo ya existe en la base de datos
    public function emailExists($correo) {
        $correo = $this->conexion->real_escape_string($correo);
        $sql = "SELECT id FROM usuarios WHERE correo = '$correo' LIMIT 1";
        $result = $this->conexion->query($sql);
        return ($result && $result->num_rows > 0);
    }

    // Valida que la contraseña tenga mínimo 8 caracteres, una mayúscula, un número y un símbolo.
    public function validatePassword($password) {
        if (strlen($password) < 8) return false;
        if (!preg_match('/[A-Z]/', $password)) return false;
        if (!preg_match('/[0-9]/', $password)) return false;
        if (!preg_match('/[\W]/', $password)) return false;
        return true;
    }

    // Registra un usuario y envía el correo de verificación
    public function registerUser($nombre, $correo, $telefono, $password) {
        if ($this->emailExists($correo)) {
            return array('success' => false, 'message' => '⚠️ El correo ya está registrado.');
        }
        if (!$this->validatePassword($password)) {
            return array('success' => false, 'message' => '⚠️ La contraseña debe tener al menos 8 caracteres, una mayúscula, un número y un símbolo.');
        }

        $hash = password_hash($password, PASSWORD_BCRYPT);
        $token = bin2hex(random_bytes(16));  // Genera un token de 32 caracteres
        $nombre = $this->conexion->real_escape_string($nombre);
        $correo = $this->conexion->real_escape_string($correo);
        $telefono = $this->conexion->real_escape_string($telefono);

        // Inserta el usuario con verificado = 0
        $sql = "INSERT INTO usuarios (nombre, correo, contrasena, telefono, token, verificado)
                VALUES ('$nombre', '$correo', '$hash', '$telefono', '$token', 0)";
        
        if ($this->conexion->query($sql)) {
            // **Envío de correo con PHPMailer**
            $mail = new PHPMailer(true);
            try {
                // Configuración del servidor SMTP
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'calorifit131@gmail.com';  // TU CORREO GMAIL
                $mail->Password = 'qqpi lgla yqoe cfbx';  // TU CONTRASEÑA O APP PASSWORD
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                // Remitente y destinatario
                $mail->setFrom('tu_correo@gmail.com', 'CaloriFit');
                $mail->addAddress($correo, $nombre);

                // Contenido del correo
                $mail->isHTML(true);
                $mail->Subject = 'Verifica tu correo';
                $verificationLink = "http://localhost/calorifit/html/inicio.php?token=" . $token;
                $mail->Body = "Hola $nombre,<br><br>Por favor, verifica tu correo para calorifit clic en el siguiente enlace:<br><br><a href='$verificationLink'>$verificationLink</a>";

                // Enviar correo
                $mail->send();
                return array('success' => true, 'message' => '✅ Registro exitoso. Revisa tu correo para verificar tu cuenta.');
            } catch (Exception $e) {
                return array('success' => true, 'message' => '✅ Registro exitoso, pero no se pudo enviar el correo. Error: ' . $mail->ErrorInfo);
            }
        } else {
            return array('success' => false, 'message' => '❌ Error al registrar: ' . $this->conexion->error);
        }
    }

    // Verifica el correo usando el token recibido en el enlace
    public function verifyEmail($token) {
        $token = $this->conexion->real_escape_string($token);
        $sql = "UPDATE usuarios SET verificado = 1, token = NULL WHERE token = '$token' AND verificado = 0";
        if ($this->conexion->query($sql) && $this->conexion->affected_rows > 0) {
            return true;
        }
        return false;
    }

    // Inicia sesión verificando correo y contraseña
    public function loginUser($correo, $password) {
        $correo = $this->conexion->real_escape_string($correo);
        $sql = "SELECT * FROM usuarios WHERE correo = '$correo' LIMIT 1";
        $result = $this->conexion->query($sql);
        if ($result && $result->num_rows == 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['contrasena'])) {
                return array('success' => true, 'user' => $user);
            } else {
                return array('success' => false, 'message' => '⚠️ Contraseña incorrecta.');
            }
        } else {
            return array('success' => false, 'message' => '⚠️ Usuario no encontrado.');
        }
    }
}
  

?>