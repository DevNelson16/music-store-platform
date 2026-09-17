<?php
session_start();
session_unset();   // limpa todas as variáveis da sessão
session_destroy(); // destrói a sessão

// redireciona para a página de login
header("Location: login_admin.php");
exit;
