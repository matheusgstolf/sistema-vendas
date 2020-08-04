<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

        <title>Fabricantes</title>
    </head>
    <body>
        <?php require_once 'menuSuperior.php'; ?>
        <form action="cadastroFabricante.php" method="POST">
            <div class="form-row">
                <div class="col-md-1 offset-md-3 mb-3">
                    <label for="cod_fabricante">Cód. Fabricante</label>
                    <input type="text" class="form-control" disabled>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="nom_fabricante">Nome</label>
                    <input type="text" name="nom_fabricante" class="form-control">
                </div>
            </div>
             <button type="submit" class="btn btn-primary offset-md-3">Gravar</button>
        </form>
    </body>
</html>
