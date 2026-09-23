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

    case 'criarResumo':
        $admin = new AdminController();
        $admin->criarResumo();
        break;

    case 'editarResumo':
        $admin = new AdminController();
        $admin->editarResumo();
        break;

    case 'deletarResumo':
        $admin = new AdminController();
        $admin->deletarResumo();
        break;

    case 'criarMeta':
        $aluno = new AlunoController();
        $aluno->criarMeta();
        break;

    case 'editarMeta':
        $aluno = new AlunoController();
        $aluno->editarMeta();
        break;

    case 'deletarMeta':
        $aluno = new AlunoController();
        $aluno->deletarMeta();
        break;

    case 'concluirMeta':
        $aluno = new AlunoController();
        $aluno->concluirMeta();
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
