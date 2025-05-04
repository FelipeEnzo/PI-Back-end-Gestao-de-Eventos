<?php
// Verificar a sessão do usuário
require ("verifica_sessao.php");

// Conecta ao banco de dados
include("conexao.php");

// Consultar os eventos com status "pendente" OBS: VERIFICAR QUAL O NOME CORRETO DOS ATRIBUTOS NO BANCO
// OBS: A tabela cadastro_evento também deve conter o atributo status_evento
$sql = "SELECT id_evento, nome, descricao, imagem FROM cadastro_evento WHERE status_evento = 'pendente'";
$result_evento = mysqli_query($conn, $sql);

// Verifica se há eventos pendentes
if (mysqli_num_rows($result_evento) > 0) {
    // Percorre os eventos
    while ($evento = mysqli_fetch_assoc($result_evento)) {
        // Insere as informações do evento no HTML
        ?>
        <div class="background_validação">
            <div class="validação_imagem">
                <h2><?php echo htmlspecialchars($evento['nome']); ?></h2>
                <picture>
                    <img src="<?php echo htmlspecialchars($evento['imagem']); ?>" alt="IMAGEM DO EVENTO">
                </picture>
            </div>

            <div class="validação_texto">
                <p>
                    <?php echo nl2br(htmlspecialchars($evento['descricao'])); ?>
                </p>

                <div class="opções">
                    <span class="aprovar" data-id="<?php echo $evento['id_evento']; ?>">APROVAR</span>
                    <span class="rejeitar" data-id="<?php echo $evento['id_evento']; ?>">REJEITAR</span>
                </div>
            </div>
        </div>

        <?php
    }
} else {
    echo "Não há eventos com aprovação pendente.";
}


// Verifica o método POST e se $_POST "id_evento" e "acao" estão definidos
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id_evento"], $_POST["acao"])) {

    // Armazena a ação "APROVADO/NEGADO" e o id do evento
    $input_id_evento = intval($_POST["id_evento"]);
    $input_acao = $_POST["acao"];

    // Verifica a ação
    if ($input_acao == "APROVADO" || $input_acao == "NEGADO") {
        // Atualiza a tabela cadastro_evento com prepared statements 
        $sql = "UPDATE cadastro_evento SET status_evento = ? WHERE id_evento = ?";
        
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "si", $input_acao, $input_id_evento);
        mysqli_stmt_execute($stmt);

        echo "EVENTO $input_acao!";
    }
}