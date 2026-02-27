<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda Digital</title>
    <style>
        body{
            background-color: #f723a2;
        }
    </style>
</head>
<body>
    <?php
        date_default_timezone_set('America/Sao_Paulo');
        $arquivo = "agenda.json";
        $tarefas = json_decode(file_get_contents($arquivo),true);

       if($_SERVER["REQUEST_METHOD"]=="POST"){
           $nova_tarefa = $_POST["tarefa"];
           $tarefas[] =[
               "tarefa" => $nova_tarefa,
               "data" => date("d/m/Y H:i:s")
           ];
       }
           file_put_contents($arquivo, json_encode($tarefas, JSON_PRETTY_PRINT));
    $tarefas = json_decode(file_get_contents($arquivo), true);
    ?>
    <h1>Minha Lista de Tarefas</h1>
    <h2>Hoje é dia <?php echo date('d/m/Y'); ?></h2>
    <h2>Agora são <?php echo date('H:i:s'); ?></h2>

    <br/><br/>

    <form method="post" action="">
        <label for="tarefa">Tarefa</label>
        <input type="text" id="tarefa" name="tarefa">
        <input type="submit" value="Salvar">
    </form>

    <br/><br/>

    <h2>Para hoje temos: </h2>
    <p><?php echo $tarefas; ?></p>
</body>
</html>