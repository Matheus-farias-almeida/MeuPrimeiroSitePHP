<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda Digital - Reymond</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --primary: #7c3aed;
            --primary-dark: #5b21b6;
            --bg: #f8f9fc;
            --card: #ffffff;
            --text: #1e293b;
            --text-light: #64748b;
            --danger: #ef4444;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: system-ui, -apple-system, sans-serif;
            background: linear-gradient(7deg, #249eea 14%, #144ba2 98%);
            color: var(--text);
            min-height: 100vh;
            padding: 20px 15px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
        }

        header {
            text-align: center;
            color: white;
            margin-bottom: 2.5rem;
            text-shadow: 0 2px 10px rgba(0,0,0,0.3);
        }

        h1 {
            font-size: 2.8rem;
            margin-bottom: 0.6rem;
        }

        .date-info {
            font-size: 1.1rem;
            opacity: 0.95;
        }

        .card {
            background: var(--card);
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.18);
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .form-section {
            padding: 2rem 1.8rem;
        }

        .input-group {
            display: flex;
            gap: 12px;
            margin-top: 1.3rem;
        }

        input[type="text"] {
            flex: 1;
            padding: 14px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 1.05rem;
            transition: all 0.2s;
        }

        input[type="text"]:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(124,58,237,0.2);
        }

        button {
            background: var(--primary);
            color: white;
            border: none;
            padding: 0 1.8rem;
            border-radius: 10px;
            font-size: 1.05rem;
            cursor: pointer;
            transition: all 0.2s;
            font-weight: 600;
        }

        button:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
        }

        .tasks-section {
            padding: 0 1.8rem 2rem;
        }

        .tasks-title {
            color: var(--primary);
            margin-bottom: 1.4rem;
            font-size: 1.4rem;
        }

        .task-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .task-item {
            background: #f8fafc;
            border-left: 5px solid var(--primary);
            border-radius: 8px;
            padding: 1.3rem 1.4rem;
            transition: all 0.15s;
        }

        .task-item:hover {
            transform: translateX(6px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }

        .task-text {
            font-size: 1.1rem;
            margin-bottom: 0.6rem;
            color: var(--text);
        }

        .task-date {
            font-size: 0.9rem;
            color: var(--text-light);
            font-family: monospace;
        }

        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: #94a3b8;
            font-style: italic;
        }

        footer {
            text-align: center;
            margin-top: 3rem;
            color: rgba(255,255,255,0.8);
            font-size: 0.95rem;
        }
    </style>
</head>
<body>

<div class="container">
    <header>
        <h1>Minha Agenda</h1>
        <div class="date-info">
            Hoje é <?php echo date('d/m/Y'); ?> • <?php echo date('H:i'); ?>
        </div>
    </header>

    <div class="card">
        <div class="form-section">
            <form method="post" action="">
                <div class="input-group">
                    <input
                        type="text"
                        id="tarefa"
                        name="tarefa"
                        placeholder="O que você precisa fazer hoje?"
                        autocomplete="off"
                        required
                    >
                    <button type="submit">
                        <i class="fas fa-plus"></i> Adicionar
                    </button>
                </div>
            </form>
        </div>

        <div class="tasks-section">
            <h2 class="tasks-title">Tarefas cadastradas</h2>

            <?php
            date_default_timezone_set('America/Sao_Paulo');
            $arquivo = "agenda.json";

            $tarefas = file_exists($arquivo)
                ? json_decode(file_get_contents($arquivo), true)
                : [];

            // Adiciona nova tarefa
            if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["tarefa"])) {
                $nova_tarefa = trim($_POST["tarefa"]);
                $tarefas[] = [
                    "tarefa" => $nova_tarefa,
                    "data"   => date("d/m/Y H:i:s")
                ];
                file_put_contents($arquivo, json_encode($tarefas, JSON_PRETTY_PRINT));
            }

            // Recarrega após possível salvamento
            $tarefas = file_exists($arquivo)
                ? json_decode(file_get_contents($arquivo), true)
                : [];
            ?>

            <?php if (!empty($tarefas)): ?>
                <div class="task-list">
                    <?php
                    // Mostra da mais recente para a mais antiga
                    foreach (array_reverse($tarefas) as $item): ?>
                        <div class="task-item">
                            <div class="task-text">
                                <?= htmlspecialchars($item["tarefa"]) ?>
                            </div>
                            <div class="task-date">
                                <i class="far fa-clock"></i>
                                <?= htmlspecialchars($item["data"]) ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    Nenhuma tarefa cadastrada ainda...<br>
                    Comece adicionando algo acima ↑
                </div>
            <?php endif; ?>
        </div>
    </div>

    <footer>
        Agenda Simples • <?php echo date("Y"); ?>
    </footer>
</div>

</body>
</html>
