<?php
$file = json_decode(file_get_contents("afficher.json"), true);

if (isset($_POST["nom"]))
{
    $file[] = ["nom" => $_POST["task"], "complete" => false];
    file_put_contents("./afficher.json", json_encode($file));
}
else
{
    $action = $_GET["action"] ?? null;
    $id = $_GET["id"] ?? null;

    switch ($action)
    {
        case "complete":
            $file[$id]["complete"] = true;
            break;
        case "delete":
            unset($file[$id]);
            $file = array_merge($file);
            break;
        case "decomplete":
            $file[$id]["complete"] = false;
            break;
    }
    file_put_contents("./afficher.json", json_encode($file));
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo list</title>
    <link rel="stylesheet" href="https://unpkg.com/mvp.css">
</head>
<style>
    .container {
        width: 60%;
        margin: 0 auto;
    }
</style>

<body>
    <div class="container">
        <form action="index.php" method="post">
            <label for="task">Tâche</label>
            <input type="text" name="task" id="task" autofocus>
            <button type="submit">Ajouter à la liste</button>
        </form>
        <div>
            <?php
            $list = file_get_contents("afficher.json");
            $tasks = json_decode($list, true);
            foreach ($tasks as $key => $task)
            {
                echo "<p>" . $task["nom"] . "   " .  ($task["complete"] ? "fait" : "à faire") .
                    "<a href='index.php?id={$key}&action=complete'>Compléter</a> 
                    <a href='index.php?id={$key}&action=delete'>Supprimer</a>
                    <a href='index.php?id={$key}&action=decomplete'>Décompléter</a></p>";
            }
            ?>
        </div>
    </div>

</body>

</html>