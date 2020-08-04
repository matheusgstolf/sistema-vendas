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
            <?php
            require_once 'conexaoMysql.php';

            $codBarra = $_POST['cod_barra'];
            $nomProduto = $_POST['nom_produto'];
            $flgStatus = $_POST['flg_status'];
            $codCategoria = $_POST['cod_categoria'];
            $codFabricante = $_POST['cod_fabricante'];
            $codNcm = $_POST['cod_ncm'];
            $codCest = $_POST['cod_cest'];
            $qtdEstoque = $_POST['qtd_estoque'];
            
            $codCest = (empty($codCest)) ? 0 : $codCest;
            
            $sqlInsert = (" INSERT INTO cad_produtos 
                (cod_barra,nom_produto,flg_status,cod_categoria,cod_fabricante,cod_ncm,cod_cest,qtd_estoque)
                VALUES 
                ('$codBarra','$nomProduto','$flgStatus',$codCategoria,$codFabricante,'$codNcm','$codCest',$qtdEstoque)");
            $queryExec = mysqli_query($conexaoMysql, $sqlInsert);

            if (!$queryExec) {?>
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel">Erro no cadastro!</h4>
                            </div>
                            <div class="modal-body">								
                                <?php echo "Erro ao inserir produto <br>" . mysqli_error($conexaoMysql); ?>
                            </div>
                            <div class="modal-footer">
                                <a href="telaCadastroProduto.php"><button type="button" class="btn btn-danger">Ok</button></a>
                            </div>
                        </div>
                    </div>
                </div>			
                <script>
                    $(document).ready(function () {
                        $('#myModal').modal('show');
                    });
                </script>
            <?php } ?>   
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Cadastrado com Sucesso!</h4>
                        </div>
                        <div class="modal-body">
                            <?php echo "Cadastrado com Sucesso!"; ?>
                        </div>
                        <div class="modal-footer">
                            <a href="telaCadastroProduto.php"><button type="button" class="btn btn-success">Ok</button></a>
                        </div>
                    </div>
                </div>
            </div>				
            <script>
                $(document).ready(function () {
                    $('#myModal').modal('show');
                });
            </script>  
    </body>    
</html> 

