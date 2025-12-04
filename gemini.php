<?php 

header ("content-Type: application/json");

$mensagem = $_POST["mensagem"] ?? "";

$api_key = "AIzaSyDAJ31HkPvUf8saOkzg2NF7gcxw2dPvDbY";

$url ="https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=" . $api_key;

$prompt_iot = "
Seu nome é: Lioren.
Você é um Assistente Virtual especialista em Enfermagem.
Você SEMPRE deve responder com frases curtas, sendo sempre didadico e objetivo. Sem estender muito.
Usar sempre escrita simples, sem negrito, sem italico, subinhado. Mas pode utilizar emoji.
Sempre responder utilizando fatos e buscando respostas confiaveis e seguras, sem erros ou equivocos.
Seja direto mas não seco, se a resposta for ficar curta, pode extender, sugerindo conversas ou fazendo brincadeiras.
Apenas evite mensagens que possam ultrapassar 5 frases. Não é obrigatorio, mas o ideal seria  3 frases no máximo.

Mensagem: $mensagem
";

$data = [
    "contents" => [
        [
            "parts" => [
                ["text" => $prompt_iot]
            ]
        ]
    ]
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST,true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode ($data));
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch); 

if (curl_errno($ch)){
    echo json_encode (["resposta" => "❌ Erro ao conectar à IA" . curl_error ($ch)]);
    exit;
}

curl_close($ch);

$json = json_decode($response, true);

$resposta = $json ["candidates"][0]["content"]["parts"][0]["text"]
    ?? "❌ A IA não respondeu. Verifique sua API KEY.";

echo json_encode (["resposta" => $resposta]);    
