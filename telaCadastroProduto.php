<?php
require_once 'conexaoMysql.php';
?>   
<!doctype html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <title>Cadastro de Produtos</title>
    </head>
    <body>
        <?php require_once 'menuSuperior.php'; ?>
        <form action="cadastroProduto.php" method="post">
            <div class="form-row">
                <div class="col-md-1 offset-md-3 mb-3">
                    <label for="cod_reduzido">Cód. Reduzido</label>
                    <input type="text" name ="cod_reduzido" class="form-control" id="validationDefault01" disabled>
                </div>
                <div class="col-md-5 mb-3">
                    <label for="nom_produto">Descrição</label>
                    <input type="text" name="nom_produto" class="form-control" id="validationDefault02" required>
                </div>
                <div class="col-md-1 mb-3">
                    <label for="flg_status">Status</label>
                    <select class="custom-select" name="flg_status" id="validationDefault03" required>
                        <option selected value="A">Ativo</option>
                        <option value = "I"> Inativo </option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-1 offset-md-3 mb-3">
                    <label for="cod_barra">Cód. Barra</label>
                    <input type="text" name="cod_barra" class="form-control" id="validationDefault04">
                </div>
                <div class="col-md-1 mb-3">
                    <label for="qtd_estoque">Estoque</label>
                    <input type="text" name="qtd_estoque" class="form-control" id="validationDefault04" required>
                </div>

                <div class="col-md-2 mb-3">
                    <label for="cod_fabricante">Fabricante</label>
                    <select class="custom-select" name="cod_fabricante" id="validationDefault05" required>
                        <option>Selecione</option>
                        <?php
                        $result = "SELECT * FROM cad_fabricantes ORDER BY nom_fabricante ASC";
                        $resultado = mysqli_query($conexaoMysql, $result);
                        while ($row_fabricante = mysqli_fetch_assoc($resultado)) {
                            ?>
                            <option value="<?php echo $row_fabricante['cod_fabricante']; ?>"><?php echo $row_fabricante['nom_fabricante']; ?></option> <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-2 mb-3">
                    <label for="cod_categoria">Categoria</label>
                    <select class="custom-select" name="cod_categoria" id="validationDefault06" required>
                        <option value="null">Selecione</option>
                        <?php
                        $result = "SELECT * FROM cad_categorias ORDER BY nom_categoria ASC";
                        $resultado = mysqli_query($conexaoMysql, $result);
                        while ($row_fabricante = mysqli_fetch_assoc($resultado)) {
                            ?>
                            <option value="<?php echo $row_fabricante['cod_categoria']; ?>"><?php echo $row_fabricante['nom_categoria']; ?></option> <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-1 offset-md-3 mb-3">
                    <label for="cod_ncm">NCM</label>
                    <input type="text" name="cod_ncm" class="form-control" id="validationDefault09" required>
                </div>
                <div class="col-md-1 mb-3">
                    <label for="cod_cest">CEST</label>
                    <input type="text" name="cod_cest" class="form-control" id="validationDefault10">
                </div>

            </div>    
            <button class="btn btn-primary offset-md-3" type="submit">Gravar</button>
        </form>

    </body>
</html>