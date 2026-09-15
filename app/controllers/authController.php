<?php
require_once __DIR__ . '/../../config/conexao.php';
require_once __DIR__ . '/../models/usuario.php';

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
                    header('Location: ../views/admin/dashboard.php');
                } else {
                    header('Location: ../views/aluno/dashboard.php');
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
        header("Location: ../views/login.php");
        exit();
    }
}