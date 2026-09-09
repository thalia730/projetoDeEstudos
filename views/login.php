<?php
// Inicia a sessão caso queira limpar dados anteriores de login
if (session_status() === PHP_SESSION_NONE) { session_start(); }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema de Estudos</title>
    <!-- Vincula ao arquivo css que está dentro da pasta pública -->
    <link rel="stylesheet" href="public/style.css">
</head>
<body class="body-login">
    <div class="card-login">
        <header class="login-header">
            <h1>Plataforma de Estudos</h1>
            <p>Faça o login para acessar o simulado</p>
        </header>

        <!-- Exibe mensagem de erro caso venha o parâmetro na URL -->
        <?php if (isset($_GET['mensagem'])): ?>
            <div class="alerta erro">
                <?= htmlspecialchars($_GET['mensagem']) ?>
            </div>
        <?php endif; ?>

        <!-- Envia as informações para o arquivo index.php público que gerencia as ações -->
        <form action="public/index.php?action=logar" method="POST" class="formulario">
            
            <div class="campo">
                <label for="email">E-mail de acesso:</label>
                <input type="email" name="email" id="email" required placeholder="exemplo@estudante.com">
            </div>

            <div class="campo">
                <label for="senha">Senha:</label>
                <input type="password" name="senha" id="senha" required placeholder="Digite sua senha">
            </div>

            <div class="campo">
                <label for="tipo_usuario">Identifique seu perfil:</label>
                <select name="tipo_usuario" id="tipo_usuario" required>
                    <option value="aluno">Sou Aluno (Senha: aluno123)</option>
                    <option value="admin">Sou Administrador (Senha: admin123)</option>
                </select>
            </div>

            <button type="submit" class="btn-entrar">Entrar no Sistema</button>
        </form>
    </div>

    <!-- Vincula ao arquivo javascript para possíveis validações visuais -->
    <script src="public/script.js"></script>
</body>
</html>
