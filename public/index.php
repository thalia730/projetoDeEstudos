<?php
// projetoDeEstudos > public > index.php

// Puxa as configurações de conexão e os controllers necessários
require_once '../config/conexao.php';
require_once '../app/controllers/authController.php';
require_once '../app/controllers/adminController.php';
require_once '../app/controllers/alunoController.php';

// Captura a ação vinda da URL (ex: index.php?action=logar)
$action = isset($_GET['action']) ? $_GET['action'] : '';

// Roteamento de Ações do Sistema
switch ($action) {
    case 'logar':
        $auth = new AuthController();
        $auth->login();
        break;

    case 'deslogar':
        $auth = new AuthController();
        $auth->logout();
        break;

    case 'criarQuestao':
        $admin = new AdminController();
        $admin->criarQuestao();
        break;

    case 'editarQuestao':
        $admin = new AdminController();
        $admin->editarQuestao();
        break;

    case 'deletarQuestao':
        $admin = new AdminController();
        $admin->deletarQuestao();
        break;

    case 'corrigirQuestoes':
        $aluno = new AlunoController();
        $aluno->corrigirQuestoes();
        break;

    default:
        // Se acessar a pasta public sem ação, manda de volta para o login externo
        header("Location: ../login.php");
        exit();
}
