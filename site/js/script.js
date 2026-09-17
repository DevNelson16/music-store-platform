document.addEventListener('DOMContentLoaded', () => {
    // Referências aos elementos do DOM
    const publicView = document.getElementById('public-view');
    const adminLoginView = document.getElementById('admin-login-view');
    const adminDashboardView = document.getElementById('admin-dashboard-view');
    const publicContentList = document.getElementById('public-content-list');
    const adminContentList = document.getElementById('admin-content-list');
    const adminLoginForm = document.getElementById('admin-login-form');
    const adminPasswordInput = document.getElementById('admin-password');
    const addContentForm = document.getElementById('add-content-form');
    const newTitleInput = document.getElementById('new-title');
    const newBodyInput = document.getElementById('new-body');
    const viewPublicBtn = document.getElementById('view-public-btn');
    const loginAdminBtn = document.getElementById('login-admin-btn');
    const logoutAdminBtn = document.getElementById('logout-admin-btn');
    const messageBox = document.getElementById('message-box');

    let isLoggedIn = false; // Estado de login do administrador

    // --- Funções Auxiliares ---

    // Função para exibir mensagens ao utilizador (substitui alert())
    function showMessage(message, type = 'success') {
        messageBox.textContent = message;
        messageBox.className = `p-3 mb-4 rounded-md text-center font-medium ${type}`;
        messageBox.classList.remove('hidden');
        setTimeout(() => {
            messageBox.classList.add('hidden');
        }, 5000); // Esconde a mensagem após 5 segundos
    }

    // Função para alternar as visualizações
    function showView(viewId) {
        publicView.classList.add('hidden');
        adminLoginView.classList.add('hidden');
        adminDashboardView.classList.add('hidden');

        document.getElementById(viewId).classList.remove('hidden');

        // Atualiza o estado dos botões de navegação
        viewPublicBtn.classList.remove('bg-indigo-600', 'text-white', 'shadow-lg');
        viewPublicBtn.classList.add('bg-gray-200', 'text-gray-700', 'hover:bg-gray-300');
        loginAdminBtn.classList.remove('bg-indigo-600', 'text-white', 'shadow-lg');
        loginAdminBtn.classList.add('bg-gray-200', 'text-gray-700', 'hover:bg-gray-300');

        if (viewId === 'public-view') {
            viewPublicBtn.classList.add('bg-indigo-600', 'text-white', 'shadow-lg');
            viewPublicBtn.classList.remove('bg-gray-200', 'text-gray-700', 'hover:bg-gray-300');
        } else if (viewId === 'admin-login-view' && !isLoggedIn) {
            loginAdminBtn.classList.add('bg-indigo-600', 'text-white', 'shadow-lg');
            loginAdminBtn.classList.remove('bg-gray-200', 'text-gray-700', 'hover:bg-gray-300');
        } else if (viewId === 'admin-dashboard-view' && isLoggedIn) {
            loginAdminBtn.classList.add('bg-indigo-600', 'text-white', 'shadow-lg');
            loginAdminBtn.classList.remove('bg-gray-200', 'text-gray-700', 'hover:bg-gray-300');
        }
    }

    // Função para atualizar o estado dos botões de login/logout
    function updateAuthButtons() {
        if (isLoggedIn) {
            loginAdminBtn.classList.add('hidden');
            logoutAdminBtn.classList.remove('hidden');
        } else {
            loginAdminBtn.classList.remove('hidden');
            logoutAdminBtn.classList.add('hidden');
        }
    }

    // --- Comunicação com o Backend (PHP) ---

    // Função para buscar conteúdo do PHP
    async function fetchContent() {
        try {
            const response = await fetch('api.php?action=get_content');
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            const data = await response.json();
            if (data.success) {
                renderPublicContent(data.content);
                if (isLoggedIn) {
                    renderAdminContent(data.content);
                }
            } else {
                showMessage(`Erro ao carregar conteúdo: ${data.message}`, 'error');
            }
        } catch (error) {
            console.error('Erro ao buscar conteúdo:', error);
            showMessage('Erro de rede ao carregar conteúdo.', 'error');
        }
    }

    // Função para adicionar conteúdo via PHP
    async function addContent(title, body) {
        try {
            const response = await fetch('api.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${localStorage.getItem('adminToken')}` // Envia o token
                },
                body: JSON.stringify({ action: 'add_content', title, body })
            });
            const data = await response.json();
            if (data.success) {
                showMessage('Conteúdo adicionado com sucesso!', 'success');
                fetchContent(); // Recarrega o conteúdo
                newTitleInput.value = '';
                newBodyInput.value = '';
            } else {
                showMessage(`Erro ao adicionar conteúdo: ${data.message}`, 'error');
            }
        } catch (error) {
            console.error('Erro ao adicionar conteúdo:', error);
            showMessage('Erro de rede ao adicionar conteúdo.', 'error');
        }
    }

    // Função para atualizar conteúdo via PHP
    async function updateContent(id, title, body) {
        try {
            const response = await fetch('api.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${localStorage.getItem('adminToken')}` // Envia o token
                },
                body: JSON.stringify({ action: 'update_content', id, title, body })
            });
            const data = await response.json();
            if (data.success) {
                showMessage('Conteúdo atualizado com sucesso!', 'success');
                fetchContent(); // Recarrega o conteúdo
            } else {
                showMessage(`Erro ao atualizar conteúdo: ${data.message}`, 'error');
            }
        } catch (error) {
            console.error('Erro ao atualizar conteúdo:', error);
            showMessage('Erro de rede ao atualizar conteúdo.', 'error');
        }
    }

    // Função para excluir conteúdo via PHP
    async function deleteContent(id) {
        try {
            const response = await fetch('api.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${localStorage.getItem('adminToken')}` // Envia o token
                },
                body: JSON.stringify({ action: 'delete_content', id })
            });
            const data = await response.json();
            if (data.success) {
                showMessage('Conteúdo excluído com sucesso!', 'success');
                fetchContent(); // Recarrega o conteúdo
            } else {
                showMessage(`Erro ao excluir conteúdo: ${data.message}`, 'error');
            }
        } catch (error) {
            console.error('Erro ao excluir conteúdo:', error);
            showMessage('Erro de rede ao excluir conteúdo.', 'error');
        }
    }

    // --- Funções de Renderização ---

    // Renderiza o conteúdo na visualização pública
    function renderPublicContent(content) {
        publicContentList.innerHTML = ''; // Limpa o conteúdo existente
        if (content.length === 0) {
            publicContentList.innerHTML = '<p class="text-gray-600 text-center py-8 col-span-full">Nenhum conteúdo disponível ainda. O administrador pode adicioná-lo!</p>';
            return;
        }
        content.forEach(item => {
            const card = document.createElement('div');
            card.className = 'content-card';
            card.innerHTML = `
                <h3 class="text-xl font-semibold text-gray-900 mb-2">${item.title}</h3>
                <p class="text-gray-700 leading-relaxed">${item.body}</p>
            `;
            publicContentList.appendChild(card);
        });
    }

    // Renderiza o conteúdo no painel de administração para edição/exclusão
    function renderAdminContent(content) {
        adminContentList.innerHTML = ''; // Limpa o conteúdo existente
        if (content.length === 0) {
            adminContentList.innerHTML = '<p class="text-gray-600 text-center py-4">Nenhum conteúdo para gerenciar.</p>';
            return;
        }
        content.forEach(item => {
            const itemDiv = document.createElement('div');
            itemDiv.className = 'flex flex-col sm:flex-row items-start sm:items-center justify-between bg-white p-4 rounded-md shadow-sm border border-gray-200';
            itemDiv.innerHTML = `
                <div class="flex-grow mb-3 sm:mb-0">
                    <h4 class="text-lg font-semibold text-gray-900">${item.title}</h4>
                    <p class="text-sm text-gray-600">${item.body.substring(0, 100)}...</p>
                </div>
                <div class="flex space-x-2">
                    <button data-id="${item.id}" data-title="${item.title}" data-body="${item.body}" class="admin-action-btn edit">Editar</button>
                    <button data-id="${item.id}" class="admin-action-btn delete">Excluir</button>
                </div>
            `;
            adminContentList.appendChild(itemDiv);
        });

        // Adiciona listeners para os botões de editar e excluir
        adminContentList.querySelectorAll('.admin-action-btn.edit').forEach(button => {
            button.addEventListener('click', (e) => {
                const id = e.target.dataset.id;
                const title = e.target.dataset.title;
                const body = e.target.dataset.body;
                showEditForm(id, title, body);
            });
        });

        adminContentList.querySelectorAll('.admin-action-btn.delete').forEach(button => {
            button.addEventListener('click', (e) => {
                const id = e.target.dataset.id;
                if (confirm('Tem certeza que deseja excluir este item?')) { // Usando confirm() para simplificar a demonstração, mas em produção, use um modal customizado.
                    deleteContent(id);
                }
            });
        });
    }

    // Mostra um formulário de edição para um item específico
    function showEditForm(id, title, body) {
        let editFormContainer = document.getElementById('edit-form-container');
        if (!editFormContainer) {
            editFormContainer = document.createElement('div');
            editFormContainer.id = 'edit-form-container';
            editFormContainer.className = 'edit-form-container mt-6';
            adminDashboardView.appendChild(editFormContainer);
        }

        editFormContainer.innerHTML = `
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Editar Conteúdo</h3>
            <form id="edit-content-form" class="space-y-4">
                <input type="hidden" id="edit-id" value="${id}">
                <div>
                    <label for="edit-title" class="block text-sm font-medium text-gray-700 mb-1">Título:</label>
                    <input type="text" id="edit-title" value="${title}"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        required>
                </div>
                <div>
                    <label for="edit-body" class="block text-sm font-medium text-gray-700 mb-1">Corpo:</label>
                    <textarea id="edit-body" rows="4"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        required>${body}</textarea>
                </div>
                <div class="flex space-x-2">
                    <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded-md font-semibold hover:bg-blue-700 transition-colors duration-200 shadow-md">
                        Salvar Edição
                    </button>
                    <button type="button" id="cancel-edit-btn" class="bg-gray-400 text-white py-2 px-4 rounded-md font-semibold hover:bg-gray-500 transition-colors duration-200 shadow-md">
                        Cancelar
                    </button>
                </div>
            </form>
        `;

        const editContentForm = document.getElementById('edit-content-form');
        const cancelEditBtn = document.getElementById('cancel-edit-btn');

        editContentForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const editedId = document.getElementById('edit-id').value;
            const editedTitle = document.getElementById('edit-title').value;
            const editedBody = document.getElementById('edit-body').value;
            updateContent(editedId, editedTitle, editedBody);
            editFormContainer.innerHTML = ''; // Esconde o formulário após salvar
        });

        cancelEditBtn.addEventListener('click', () => {
            editFormContainer.innerHTML = ''; // Esconde o formulário ao cancelar
        });
    }

    // --- Event Listeners ---

    // Navegação: Ver Site
    viewPublicBtn.addEventListener('click', () => {
        showView('public-view');
        fetchContent(); // Garante que o conteúdo público esteja atualizado
    });

    // Navegação: Login Admin
    loginAdminBtn.addEventListener('click', () => {
        if (!isLoggedIn) {
            showView('admin-login-view');
        } else {
            showView('admin-dashboard-view'); // Se já logado, vai direto para o dashboard
            fetchContent(); // Garante que o conteúdo admin esteja atualizado
        }
    });

    // Navegação: Logout Admin
    logoutAdminBtn.addEventListener('click', () => {
        isLoggedIn = false;
        localStorage.removeItem('adminToken'); // Remove o token de autenticação
        updateAuthButtons();
        showView('public-view');
        showMessage('Logout de administrador.', 'success');
    });

    // Submissão do formulário de login do administrador
    adminLoginForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const password = adminPasswordInput.value;

        try {
            const response = await fetch('api.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ action: 'admin_login', password })
            });
            const data = await response.json();
            if (data.success) {
                isLoggedIn = true;
                localStorage.setItem('adminToken', data.token); // Armazena o token
                updateAuthButtons();
                showView('admin-dashboard-view');
                fetchContent(); // Carrega o conteúdo para o admin
                showMessage('Login de administrador bem-sucedido!', 'success');
            } else {
                showMessage(`Login falhou: ${data.message}`, 'error');
            }
        } catch (error) {
            console.error('Erro no login:', error);
            showMessage('Erro de rede ao tentar fazer login.', 'error');
        }
        adminPasswordInput.value = ''; // Limpa o campo de senha
    });

    // Submissão do formulário de adicionar conteúdo
    addContentForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const title = newTitleInput.value.trim();
        const body = newBodyInput.value.trim();
        if (title && body) {
            addContent(title, body);
        } else {
            showMessage('Por favor, preencha o título e o corpo do conteúdo.', 'error');
        }
    });

    // --- Inicialização ---

    // Verifica se há um token de admin no localStorage ao carregar a página
    const token = localStorage.getItem('adminToken');
    if (token) {
        // Para uma aplicação real, você enviaria este token para o servidor para validação
        // Aqui, para simplificar, assumimos que se há um token, o utilizador está logado.
        isLoggedIn = true;
    }
    updateAuthButtons(); // Atualiza os botões com base no estado de login inicial
    showView('public-view'); // Começa na visualização pública
    fetchContent(); // Carrega o conteúdo inicial
});
