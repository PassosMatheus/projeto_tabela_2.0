$( document ).ready(function() {
    carregarTabela();
});

function adicionar() {
    $.ajax({
        method: "POST",
        url: "animal.php",
        data: $("#formCadastro").serialize(), //Aqui devem estar os dados que eu quero mandar.
        preventCache: true, //Isso é para impedir que o navegador faça cache.
        handleAs: 'json', //É a forma como eu devo tratar a resposta. Nesse caso, estou imaginando que o servidor vai me mandar sempre um json valido.
        async: true, //Assincrono, significa que enquanto o servidor não me responder o usuario pode fazer qualquer outra coisa na página. Ou seja, a página não fica travada.
        success: function (data) {
            console.log('A resposta que tive foi: ', data);
            if (data.result === 'OK') {
                $("#dadosTabela tbody tr").empty();
                carregarTabela();
                $('#adicao').modal('hide');
            } else {
                alert(data.msgResult);
                console.error(data.msgResult);
            }
        },
        error: function (errorMsg, ioArgs) {
            console.log(errorMsg, ioArgs);
            alert(errorMsg);
        }
    });
}

function editar(id) {
    $.ajax({
        method: "POST",
        url: "animal.php",
        data: {"comando":"editar", id}, 
        preventCache: true, 
        handleAs: 'json', 
        async: true, 
        success: function (data) {
            console.log('Os dados selecionados para edição foram: ', data);
            if (data.result === 'OK') {
                $(data.animais).each(function(i, animal) {
                    var tipo = animal.tipo;
                    var nome = animal.nome;
                    var idade = animal.idade;
                    
                    $('#id').val(id);
                    $('#tipo').val(tipo);
                    $('#nome').val(nome);
                    $('#idade').val(idade);
                }); 
                $("#editar").modal();
            } else {
                alert(data.msgResult);
                console.error(data.msgResult);
            }
        },
        error: function (errorMsg, ioArgs) {
            console.log(errorMsg, ioArgs);
            alert(errorMsg);
        }
    });
}

function salvar() {
    $.ajax({
        method: "POST",
        url: "animal.php",
        data:  $("#formEditar").serialize(), 
        preventCache: true, 
        handleAs: 'json', 
        async: true, 
        success: function (data) {
            console.log('Os dados selecionados para edição foram: ', data);
            if (data.result === 'OK') {
                $("#dadosTabela tbody tr").empty();
                carregarTabela();
                $('#editar').modal('hide');
            } else {
                alert(data.msgResult);
                console.error(data.msgResult);
            }
        },
        error: function (errorMsg, ioArgs) {
            console.log(errorMsg, ioArgs);
            alert(errorMsg);
        }
    });
}


function excluir(id) {
    $.ajax({
        method: "POST",
        url: "animal.php",
        data: {"comando":"excluir", id}, 
        preventCache: true, 
        handleAs: 'json',
        async: true, 
        success: function (data) {
            console.log('A resposta que tive foi: ', data);
            if (data.result === 'OK') {
                console.log(data.msgResult);
                $("#dadosTabela tbody tr").empty();
                carregarTabela();
            } else {
                alert(data.msgResult);
                console.error(data.msgResult);
            }
        },
        error: function (errorMsg, ioArgs) {
            console.log(errorMsg, ioArgs);
            alert(errorMsg);
        }
    });
}

function order(orderBy) {
    var sentido = $('#img-'+orderBy).attr('sentido');
    comando = sentido === 'up' ? 'ordemAsc' : 'ordemDesc';
    $.ajax({
        method: "POST",
        url: "animal.php",
        data: {"comando":comando, orderBy}, 
        preventCache: true, 
        handleAs: 'json',
        async: true, 
        success: function (data) {
            console.log('A resposta que tive foi: ', data);
            if (data.result === 'OK') {
                $("#dadosTabela tbody tr").empty();
                $(data.animais).each(function(i, animal) {
                    var id = animal.id;
                    var tipo = animal.tipo;
                    var nome = animal.nome;
                    var idade = animal.idade;
                    $('#dadosTabela tr:last').after('<tr><td>'+tipo+'</td> <td>'+nome+'</td> <td>'+idade+'</td> <td><button class="btn btn-sm btn-outline-primary" data-toggle="modal" onclick="editar('+id+')">Editar</button> - <button class="btn btn-sm btn-outline-danger" onclick="excluir('+id+')">Excluir</button></td>');
                    document.getElementById('img-'+orderBy).src = "assets/imagens/seta_"+sentido+".png";
                    var novoSentido = sentido === 'up' ? 'down' : 'up';
                    $('#img-'+orderBy).attr('sentido', novoSentido);
                });
            } else {
                alert(data.msgResult);
                console.error(data.msgResult);
            }
        },
        error: function (errorMsg, ioArgs) {
            console.log(errorMsg, ioArgs);
            alert(errorMsg);
        }
    });
}

function carregarTabela() {
    $.ajax({
        method: "POST",
        url: "animal.php",
        data: {"comando":"carregarTabela"}, 
        preventCache: true, 
        handleAs: 'json',
        async: true, 
        success: function (data) {
            console.log('A resposta que tive foi: ', data);
            if (data.result === 'OK') {
                $(data.animais).each(function(i, animal) {
                    var id = animal.id;
                    var tipo = animal.tipo;
                    var nome = animal.nome;
                    var idade = animal.idade;
                    
                    $('#dadosTabela tr:last').after('<tr><td>'+tipo+'</td> <td>'+nome+'</td> <td>'+idade+'</td> <td><button class="btn btn-sm btn-outline-primary" data-toggle="modal" onclick="editar('+id+')">Editar</button> - <button class="btn btn-sm btn-outline-danger" onclick="excluir('+id+')">Excluir</button></td></tr>');
                });
            
            } else {
                alert(data.msgResult);
                console.error(data.msgResult);
            } 
        },
        error: function (errorMsg, ioArgs) {
            console.log(errorMsg, ioArgs);
            alert(errorMsg);
        }
    });
}