<?php
require_once 'config/conexao.php';
require_once 'models/usuario.php';

class authController {
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            global $conexao;

            $email = $_POST['email'];
            $senha = $_POST['senha'];
            $tipo = $_POST['tipo_usuario'];

            $loginValido = false;
            if ($tipo === 'admin' && $senha === 'admin123') {
                $loginValido = true;
            } elseif ($tipo === 'aluno' && $senha === 'aluno123') {
                $loginValido = true;
            }

            if ($loginValido) {
            if(session_status() === PHP_SESSION_NONE) {
                session_start();
            }
                $_SESSION['usuario_logado'] =true;
                $_SESSION['tipo'] = $tipo;
                $_SESSION['email'] = $email;

                if ($tipo === 'admin') {
                    header('Location: admin_dashboard.php');
                } else {
                    header('Location: aluno_dashboard.php');
                }
                exit();
            } else {
                $erro = "Email ou senha inválidos.";
            }
        }
    }

    public function logout() {
        if(session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        header('Location: login.php');
        exit();
    }
}