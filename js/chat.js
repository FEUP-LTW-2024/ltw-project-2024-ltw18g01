$(document).ready(function(){
    // Função para obter os usuários com quem o usuário atual está falando
    function getUsersWithMessages() {
        $.ajax({
            type: 'POST',
            url: '../utils/get_users_with_messages_ajax.php',
            success: function(data) {
                // Limpar o dropdown de usuário
                $('#userDropdown').html('<option value="">Selecione um usuário</option>');
                // Adicionar opções ao dropdown de usuário com base nos dados recebidos
                $.each(data, function(key, user) {
                    $('#userDropdown').append('<option value="' + user.userId + '">' + user.username + '</option>');
                });
            }
        });
    }

    // Chamar a função para obter os usuários com quem o usuário atual está falando
    getUsersWithMessages();

    // Evento de mudança do dropdown de usuário
    $('#userDropdown').change(function(){
        var userId = $(this).val();
        if(userId){
            $.ajax({
                type: 'POST',
                url: '../utils/get_users_with_messages_ajax.php',
                data: 'userId='+userId,
                success: function(html){
                    $('#availableUserDropdown').html(html);
                }
            });
        } else {
            $('#availableUserDropdown').html('<option value="">Selecione um usuário disponível</option>');
        }
    });
});

// Adicionar um evento de mudança ao elemento selectUser
document.getElementById('selectUser').addEventListener('change', function() {
    // Obter o ID do usuário selecionado
    var selectedUserId = this.value;

    // Chamar a função para exibir a conversa com o usuário selecionado
    displayConversation(selectedUserId);
});

// Função para exibir a conversa com o usuário selecionado
function displayConversation(selectedUserId) {
    // Fazer uma solicitação AJAX para obter as mensagens trocadas entre os usuários
    fetch('/actions/conversation.php?userId=' + selectedUserId)
        .then(response => response.text())
        .then(data => {
            // Exibir as mensagens na div de conversa
            document.getElementById('conversation').innerHTML = data;
        })
        .catch(error => console.error('Erro ao obter a conversa:', error));
}

function startConversation() {
    // Função para iniciar uma conversa com o usuário selecionado
    const selectedUserId = document.getElementById('selectUser').value;
    // Redirecionar para a página de conversa com o usuário selecionado
    window.location.href = `/actions/conversation.php?userId=${selectedUserId}`;
}
// chat.js

function loadConversationOnUserSelect() {
    // Adicionar um evento de mudança ao menu suspenso
    document.getElementById('selectUser').addEventListener('change', function() {
        // Obter o ID do usuário selecionado
        var selectedUserId = this.value;

        // Fazer uma solicitação AJAX para obter as mensagens trocadas com o usuário selecionado
        fetchConversation(selectedUserId);
    });
}

function fetchConversation(userId) {
    // Fazer uma solicitação AJAX para obter as mensagens trocadas com o usuário selecionado
    fetch('/actions/getConversations_action.php?userId=' + userId)
        .then(response => {
            if (!response.ok) {
                throw new Error('Erro ao recuperar mensagens.');
            }
            return response.text();
        })
        .then(data => {
            // Exibir as mensagens na div de conversa
            document.getElementById('conversation').innerHTML = data;
        })
        .catch(error => {
            console.error('Erro ao recuperar mensagens:', error.message);
        });
}

// Chamar a função ao carregar a página para carregar a conversa ao selecionar um usuário

// Adicionar um evento de mudança ao menu suspenso
document.getElementById('selectUser').addEventListener('change', function() {
    // Obter o ID do usuário selecionado
    var selectedUserId = this.value;

    // Chamar a função para exibir a conversa com o usuário selecionado
    displayConversation(selectedUserId);
});
