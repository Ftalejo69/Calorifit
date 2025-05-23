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
        return strlen($password) >= 8 &&
               preg_match('/[A-Z]/', $password) &&
               preg_match('/[0-9]/', $password) &&
               preg_match('/[\W]/', $password);
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
            return array('success' => true, 'message' => '✅ Registro exitoso. Revisa tu correo para verificar tu cuenta.', 'token' => $token);
        } else {
            return array('success' => false, 'message' => '❌ Error al registrar: ' . $this->conexion->error);
        }
    }

    public function sendVerificationEmail($nombre, $correo, $token) {
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

            // Habilitar depuración
            $mail->SMTPDebug = 2; // Cambia a 0 para deshabilitar la depuración
            $mail->Debugoutput = function ($str, $level) {
                error_log("SMTP [$level]: $str");
            };

            // Remitente y destinatario
            $mail->setFrom('calorifit131@gmail.com', 'CaloriFit');
            $mail->addAddress($correo, $nombre);

            // Contenido del correo
            $mail->isHTML(true);
            $mail->Subject = 'Verifica tu correo';
            $verificationLink = "http://localhost/Calorifit/modelos/vista.php?token=" . $token;
            $mail->Body = "Hola $nombre,<br><br>Por favor, verifica tu correo para CaloriFit haciendo clic en el siguiente enlace:<br><br><a href='$verificationLink'>$verificationLink</a>";

            // Enviar correo
            $mail->send();
        } catch (Exception $e) {
            error_log("Error al enviar el correo: " . $mail->ErrorInfo); // Registrar el error en el log
            throw $e; // Lanza la excepción para manejarla en el script principal
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
        $sql = "SELECT u.*, 
                   COALESCE(r.nombre, 'usuario') AS rol 
            FROM usuarios u
            LEFT JOIN usuarios_roles ur ON u.id = ur.usuario_id
            LEFT JOIN roles r ON ur.rol_id = r.id
            WHERE u.correo = ? LIMIT 1";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result && $result->num_rows == 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['contrasena'])) {
                if (!$user['verificado']) {
                    return array('success' => false, 'message' => '⚠️ Por favor verifica tu correo primero.');
                }
                return array('success' => true, 'user' => $user);
            }
            return array('success' => false, 'message' => '⚠️ Contraseña incorrecta.');
        }
        return array('success' => false, 'message' => '⚠️ Usuario no encontrado.');
    }

    public function sendRecoveryEmail($correo) {
        if (!$this->emailExists($correo)) {
            return ['success' => false, 'message' => '⚠️ El correo no está registrado.'];
        }

        $token = bin2hex(random_bytes(16));
        $sql = "UPDATE usuarios SET token_recuperacion = ?, fecha_token = NOW() WHERE correo = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("ss", $token, $correo);

        if ($stmt->execute()) {
            try {
                $mail = new PHPMailer(true);
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'calorifit131@gmail.com';
                $mail->Password = 'qqpi lgla yqoe cfbx';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('calorifit131@gmail.com', 'CaloriFit');
                $mail->addAddress($correo);

                $mail->isHTML(true);
                $mail->Subject = 'Recuperación de Contraseña - CaloriFit';
                $recoveryLink = "http://localhost/Calorifit/vistas/reset_password.php?token=" . $token;
                $mail->Body = "Para cambiar tu contraseña, haz clic en el siguiente enlace:<br><br><a href='$recoveryLink'>$recoveryLink</a>";

                $mail->send();
                return ['success' => true, 'message' => '✅ Se ha enviado un enlace de recuperación a tu correo.'];
            } catch (Exception $e) {
                return ['success' => false, 'message' => '❌ Error al enviar el correo: ' . $mail->ErrorInfo];
            }
        }
        return ['success' => false, 'message' => '❌ Error al procesar la solicitud.'];
    }

    public function resetPassword($token, $newPassword) {
        if (!$this->validatePassword($newPassword)) {
            return ['success' => false, 'message' => '⚠️ La contraseña debe tener al menos 8 caracteres, una mayúscula, un número y un símbolo.'];
        }

        $hash = password_hash($newPassword, PASSWORD_BCRYPT);
        $sql = "UPDATE usuarios SET contrasena = ?, token_recuperacion = NULL, fecha_token = NULL 
                WHERE token_recuperacion = ? AND fecha_token >= NOW() - INTERVAL 1 HOUR";
        
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("ss", $hash, $token);
        
        if ($stmt->execute() && $stmt->affected_rows > 0) {
            return ['success' => true, 'message' => '✅ Contraseña actualizada correctamente.'];
        }
        return ['success' => false, 'message' => '❌ El enlace ha expirado o no es válido.'];
    }

    public function sendPasswordSetupEmail($nombre, $correo, $token) {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'calorifit131@gmail.com';
            $mail->Password = 'qqpi lgla yqoe cfbx';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('calorifit131@gmail.com', 'CaloriFit');
            $mail->addAddress($correo, $nombre);

            $mail->isHTML(true);
            $mail->Subject = 'Bienvenido a CaloriFit - Configura tu contraseña';
            $setupLink = "http://localhost/Calorifit/vistas/reset_password.php?token=" . $token;
            $mail->Body = "Hola $nombre,<br><br>
                        Has sido agregado como entrenador en CaloriFit. Por favor, configura tu contraseña haciendo clic en el siguiente enlace:<br><br>
                        <a href='$setupLink'>$setupLink</a><br><br>
                        Una vez que hayas configurado tu contraseña, podrás acceder a tu panel de entrenador.<br><br>
                        Saludos,<br>
                        Equipo CaloriFit";

            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Error al enviar correo: " . $mail->ErrorInfo);
            throw $e;
        }
    }
}
  

?>