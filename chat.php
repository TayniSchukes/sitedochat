<?php
    #Conectando usando a chave criada e o link da api
    $chave = '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';
    $url = 'https://api.openai.com/v1/chat/completions';
    $pergunta = $_POST["pergunta_usuario"];
    #Usando a variável data para expecificar o modelo do Chat usado
    #Aqui também criamos os array's com o role (papel) de usuário e sistema. O de sistema terá as perguntas, e o usuário receberá a pergunta.
    $data = array(
        'model' => 'gpt-3.5-turbo',
        'messages' => array(
            array('role' => 'system', 'content' => 'Você é um assistente que fala sobre quais tópicos?'),
            array('role' => 'user', 'content' => $pergunta)
        )
    );
    #Aqui usamos o curl_init para iniciar a extenção cURL, que será usada para aplicar a API.
    # A função curl_setopt é usada para alterar diversas opções dentro da aplicação.
    $curl = curl_init($url);
    #Na função abaixo ela é utilizada para definir o método aplicado, que será com post.
    curl_setopt($curl, CURLOPT_POST, true);
    #Na função abaixo ela é utilizada para comunicar que os dados serão decodificados em JSON.
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
    #Na função abaixo ela é utilizada para que a resposta seja armazenada e trazida para a nossa página, e não gerada diretamente.
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    #Na função abaixo ela é utilizada para que a chave seja chamada assim como o link
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Authorization: Bearer ' . $chave
));
#Aplicamos então a extensão cURL e armazenamos em uma variável de resposta
$resposta = curl_exec($curl);
#Fechando a aplicação
curl_close($curl);
#Validando a conexão
if ($resposta === false) {
    echo 'Erro na requisição: ' . curl_error($curl);
} else {
    #Decodificando a resposta
    $resposta = json_decode($resposta, true);
    #Armazena a resposta do chat
    $chatGptResponse = $resposta['choices'][0]['message']['content'];
    #Printa a resposta do Chat na tela ?>
    <!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Resposta do Chat</title>
        <style>
            h1{
                text-align: center;
            }
            .respondendo{
                border: 1px solid black;
                width: 600px;
                margin-left: auto;
                margin-right: auto;
                border-radius: 15px;
                padding: 5px;
            }
            a {
                text-decoration: none;
                color: white;
            }
            li {
                list-style: none;
                width: 150px;
                height: 20px;
                background-color: black;
                border-radius: 5px;
                text-align: center;
                margin-left: auto;
                margin-right: auto;
                margin-top: 5%;
            }
        </style>
    </head>
    <body>
        <h1>Sua resposta:</h1>
        <div class="respondendo">
            <?php echo 'Resposta do ChatGPT-3: ' . $chatGptResponse; ?>
        </div>
        <li><a href="index.html">Fazer outra pergunta</a></li>
    </body>
    </html>
    
<?php
}
?>