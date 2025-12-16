<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Jogadores</title>

<style>
body {
    font-family: Arial, sans-serif;
    background: #f4f6f8;
    margin: 0;
    padding: 20px;
}

h1, h2 {
    margin-bottom: 10px;
}

.container {
    max-width: 900px;
    margin: auto;
}

.card {
    background: #fff;
    padding: 15px;
    border-radius: 6px;
    margin-bottom: 20px;
}

/* FORM */
form {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

input {
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

input:focus {
    outline: none;
    border-color: #2563eb;
}

button {
    padding: 8px 14px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

button[type="submit"] {
    background: #2563eb;
    color: #fff;
}

#cancelEdit {
    background: #999;
    color: #fff;
}

/* TABELA */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}

th, td {
    border: 1px solid #ddd;
    padding: 8px;
}

th {
    background: #f0f0f0;
}

/* BOTÕES */
.btn-edit {
    background: #16a34a;
    color: #fff;
}

.btn-delete {
    background: #dc2626;
    color: #fff;
}

/* MENSAGEM */
#mensagem {
    margin-top: 10px;
    color: #16a34a;
    font-weight: bold;
}
</style>
</head>

<body>
<div class="container">

<h1>Gerenciamento de Jogadores</h1>

<div class="card">
<h2>Cadastrar / Editar Jogador</h2>

<form id="formJogador">
    <input type="hidden" id="jogadorId">

    <input type="text" id="nome" placeholder="Nome" required>
    <input type="number" id="idade" placeholder="Idade" required>
    <input type="text" id="posicao" placeholder="Posição" required>
    <input type="text" id="nacionalidade" placeholder="Nacionalidade" required>
    <input type="text" id="time" placeholder="Time" required>

    <div class="form-actions">
        <button type="submit">Salvar</button>
        <button type="button" id="cancelEdit" style="display:none;">Cancelar</button>
    </div>
</form>

<p id="mensagem"></p>
</div>

<div class="card">
<h2>Lista de Jogadores</h2>

<table id="tabelaJogadores">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Idade</th>
            <th>Posição</th>
            <th>Nacionalidade</th>
            <th>Time</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>
</div>

</div>

<!-- JS ORIGINAL (NÃO ALTERADO) -->
<script>
const apiUrl = "https://apifutebol.webapptech.site/api";
const tabela = document.querySelector("#tabelaJogadores tbody");
const form = document.getElementById('formJogador');
const msg = document.getElementById('mensagem');
const cancelEdit = document.getElementById('cancelEdit');

let editId = null;

function listarJogadores() {
    fetch(`${apiUrl}/jogadores`)
        .then(res => res.json())
        .then(data => {
            tabela.innerHTML = '';
            data.data.forEach(j => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${j.nome}</td>
                    <td>${j.idade}</td>
                    <td>${j.posicao}</td>
                    <td>${j.nacionalidade}</td>
                    <td>${j.time}</td>
                    <td>
                        <button class="btn-edit" onclick="editar(${j.id})">Editar</button>
                        <button class="btn-delete" onclick="deletar(${j.id})">Deletar</button>
                    </td>
                `;
                tabela.appendChild(tr);
            });
        });
}

form.addEventListener('submit', function(e){
    e.preventDefault();

    const jogador = {
        nome: nome.value,
        idade: idade.value,
        posicao: posicao.value,
        nacionalidade: nacionalidade.value,
        time: time.value
    };

    let metodo = 'POST';
    let url = `${apiUrl}/criarJogadores`;

    if(editId){
        metodo = 'PUT';
        url = `${apiUrl}/upJogadores/${editId}`;
    }

    fetch(url, {
        method: metodo,
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(jogador)
    })
    .then(res => res.json())
    .then(() => {
        msg.innerHTML = 'Jogador salvo com sucesso';
        form.reset();
        editId = null;
        cancelEdit.style.display = 'none';
        listarJogadores();
    });
});

function editar(id){
    fetch(`${apiUrl}/jogadores/${id}`)
        .then(res => res.json())
        .then(resp => {
            const j = resp.data;
            nome.value = j.nome;
            idade.value = j.idade;
            posicao.value = j.posicao;
            nacionalidade.value = j.nacionalidade;
            time.value = j.time;
            editId = id;
            cancelEdit.style.display = 'inline';
        });
}

cancelEdit.addEventListener('click', () => {
    form.reset();
    editId = null;
    cancelEdit.style.display = 'none';
});

function deletar(id){
    if(!confirm('Deseja realmente deletar este jogador?')) return;
    fetch(`${apiUrl}/delJogadores/${id}`, { method: 'DELETE' })
        .then(res => res.json())
        .then(() => listarJogadores());
}

listarJogadores();
</script>

</body>
</html>
