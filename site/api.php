<?php
// api.php

// Configurações de cabeçalho para permitir requisições de diferentes origens (CORS)
header("Access-Control-Allow-Origin: *"); // Permite acesso de qualquer origem. Para produção, restrinja a domínios específicos.
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Lida com requisições OPTIONS (pré-voo CORS)
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

// --- Configurações Básicas ---
$adminPassword = 'admin'; // Senha de administrador para demonstração. EM PRODUÇÃO, NUNCA FAÇA ISSO!
                          // Use hashing de senha (password_hash), bancos de dados de utilizadores e sessões.
$contentFile = 'content.json'; // Arquivo para armazenar o conteúdo. EM PRODUÇÃO, USE UM BANCO DE DADOS.

// --- Funções Auxiliares ---

// Função para ler o conteúdo do arquivo JSON
function readContent($file) {
    if (!file_exists($file) || filesize($file) == 0) {
        return [];
    }
    $json = file_get_contents($file);
    return json_decode($json, true) ?: [];
}

// Função para escrever o conteúdo no arquivo JSON
function writeContent($file, $data) {
    return file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
}

// Função para gerar um token de autenticação simples (para demonstração)
function generateToken() {
    return bin2hex(random_bytes(16)); // Gera um token hexadecimal de 32 caracteres
}

// Função para validar o token de autenticação
function validateToken() {
    $headers = getallheaders();
    $authHeader = $headers['Authorization'] ?? '';

    // Verifica se o cabeçalho de autorização existe e começa com "Bearer "
    if (preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
        $token = $matches[1];
        // Para esta demonstração, qualquer token presente é considerado válido.
        // EM PRODUÇÃO, você validaria este token contra um token armazenado em sessão/banco de dados.
        // Por exemplo: return $token === $_SESSION['admin_token'];
        return true;
    }
    return false;
}

// --- Lógica Principal da API ---

$method = $_SERVER['REQUEST_METHOD'];
$action = $_GET['action'] ?? null; // Ação para requisições GET
$data = json_decode(file_get_contents("php://input"), true); // Dados para requisições POST

// Se for uma requisição POST, a ação virá no corpo da requisição
if ($method === 'POST' && isset($data['action'])) {
    $action = $data['action'];
}

switch ($action) {
    case 'get_content':
        // Retorna todo o conteúdo
        $content = readContent($contentFile);
        echo json_encode(['success' => true, 'content' => array_values($content)]);
        break;

    case 'admin_login':
        // Lida com o login do administrador
        $password = $data['password'] ?? '';
        if ($password === $adminPassword) {
            $token = generateToken();
            // EM PRODUÇÃO: Armazene este token em uma sessão ou banco de dados para validação futura.
            echo json_encode(['success' => true, 'message' => 'Login bem-sucedido!', 'token' => $token]);
        } else {
            http_response_code(401); // Unauthorized
            echo json_encode(['success' => false, 'message' => 'Senha incorreta.']);
        }
        break;

    case 'add_content':
        // Adiciona novo conteúdo (requer autenticação)
        if (!validateToken()) {
            http_response_code(401); // Unauthorized
            echo json_encode(['success' => false, 'message' => 'Não autorizado. Faça login como administrador.']);
            exit();
        }

        $title = $data['title'] ?? '';
        $body = $data['body'] ?? '';

        if (empty($title) || empty($body)) {
            http_response_code(400); // Bad Request
            echo json_encode(['success' => false, 'message' => 'Título e corpo são obrigatórios.']);
            break;
        }

        $content = readContent($contentFile);
        $id = uniqid(); // Gera um ID único
        $content[$id] = ['id' => $id, 'title' => $title, 'body' => $body];

        if (writeContent($contentFile, $content)) {
            echo json_encode(['success' => true, 'message' => 'Conteúdo adicionado com sucesso!', 'id' => $id]);
        } else {
            http_response_code(500); // Internal Server Error
            echo json_encode(['success' => false, 'message' => 'Erro ao salvar conteúdo.']);
        }
        break;

    case 'update_content':
        // Atualiza conteúdo existente (requer autenticação)
        if (!validateToken()) {
            http_response_code(401); // Unauthorized
            echo json_encode(['success' => false, 'message' => 'Não autorizado. Faça login como administrador.']);
            exit();
        }

        $id = $data['id'] ?? '';
        $title = $data['title'] ?? '';
        $body = $data['body'] ?? '';

        if (empty($id) || empty($title) || empty($body)) {
            http_response_code(400); // Bad Request
            echo json_encode(['success' => false, 'message' => 'ID, título e corpo são obrigatórios para atualização.']);
            break;
        }

        $content = readContent($contentFile);
        if (isset($content[$id])) {
            $content[$id]['title'] = $title;
            $content[$id]['body'] = $body;
            if (writeContent($contentFile, $content)) {
                echo json_encode(['success' => true, 'message' => 'Conteúdo atualizado com sucesso!']);
            } else {
                http_response_code(500); // Internal Server Error
                echo json_encode(['success' => false, 'message' => 'Erro ao atualizar conteúdo.']);
            }
        } else {
            http_response_code(404); // Not Found
            echo json_encode(['success' => false, 'message' => 'Conteúdo não encontrado.']);
        }
        break;

    case 'delete_content':
        // Exclui conteúdo (requer autenticação)
        if (!validateToken()) {
            http_response_code(401); // Unauthorized
            echo json_encode(['success' => false, 'message' => 'Não autorizado. Faça login como administrador.']);
            exit();
        }

        $id = $data['id'] ?? '';

        if (empty($id)) {
            http_response_code(400); // Bad Request
            echo json_encode(['success' => false, 'message' => 'ID do conteúdo é obrigatório para exclusão.']);
            break;
        }

        $content = readContent($contentFile);
        if (isset($content[$id])) {
            unset($content[$id]);
            if (writeContent($contentFile, $content)) {
                echo json_encode(['success' => true, 'message' => 'Conteúdo excluído com sucesso!']);
            } else {
                http_response_code(500); // Internal Server Error
                echo json_encode(['success' => false, 'message' => 'Erro ao excluir conteúdo.']);
            }
        } else {
            http_response_code(404); // Not Found
            echo json_encode(['success' => false, 'message' => 'Conteúdo não encontrado.']);
        }
        break;

    default:
        // Ação inválida ou não especificada
        http_response_code(400); // Bad Request
        echo json_encode(['success' => false, 'message' => 'Ação inválida ou não especificada.']);
        break;
}

?>
