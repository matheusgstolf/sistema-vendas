<?php
require_once 'conexaoMysql.php';
require_once 'menuSuperior.php';
?>   
<!doctype html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <title>Venda</title>
    </head>
    <body>
        <script type="text/javascript">
            function id(valor_campo) {
                return document.getElementById(valor_campo);
            }
            function getValor(valor_campo) {
                var valor = document.getElementById(valor_campo).value.replace(",", ".");
                return parseFloat(valor);
            }
            function calculaValorLiquido() {
                var total = getValor('vlr_venda') - ((getValor('perc_desconto') / 100) * getValor('vlr_venda'));
                id('vlr_liquido').value = total;
            }
        </script>
        <form method="POST" action="venda.php" class="needs-validation" novalidate>
            <div class="form-row">
                <div class="col-md-7 offset-md-2 mb-3">
                    <label for="select_item">Item</label>
                    <select class="custom-select" name="select_item" id="select_item" required>
                        <option value="0">Selecione</option>
                        <?php
                        $result = "SELECT * FROM cad_produtos "
                                . "WHERE flg_status = 'A' "
                                . "ORDER BY nom_produto ASC";
                        $resultado = mysqli_query($conexaoMysql, $result);
                        while ($row = mysqli_fetch_assoc($resultado)) { ?>    
                            <option value="<?php echo $row['cod_reduzido']; ?>">
                                <?php echo $row['nom_produto']; ?></option> <?php
                        }
                        ?>
                    </select>
                </div> 
                <div class="col-md-1 mb-3">
                    <label for="qtd_produto">Quantidade</label>
                    <input type="text" class="form-control" name="qtd_produto" id="qtd_produto" required>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-2 offset-md-2 mb-3">
                    <label for="vlr_venda">Valor Unitário</label>
                    <input type="text" class="form-control" name="vlr_venda" id="vlr_venda">
                </div>
                <div class="col-md-2 mb-3">
                    <label for="perc_desconto">% Desconto</label>
                    <input type="text" class="form-control" name="perc_desconto" id="perc_desconto" onBlur="calculaValorLiquido()">
                </div>
                <div class="col-md-2 mb-3">
                    <label for="vlr_liquido">Valor Líquido</label>
                    <input type="text" class="form-control" name="vlr_liquido" readonly id="vlr_liquido">
                </div>
            </div>
            <button type="submit" name="incluir" class="offset-md-2 btn btn-primary">Incluir Item</button>
            <button type="submit" name="concluir" class="btn btn-primary">Finalizar Venda</button>
            <button type="submit" name="cancelar" class="btn btn-danger">Cancelar Venda</button>
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Código</th>
                        <th scope="col">Produto</th>
                        <th scope="col">Quantidade</th>
                        <th scope="col">Valor Unitário</th>
                        <th scope="col">Desconto</th>
                        <th scope="col">Total Item</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require_once 'conexaoMysql.php';
                    $sqlNumVenda = "SELECT num_sequencial FROM cad_gerenciadorid WHERE cod_sequencial = 1";
                    $queryExec = mysqli_query($conexaoMysql, $sqlNumVenda);
                    $result = mysqli_fetch_assoc($queryExec);

                    $numVenda = $result['num_sequencial'];
                    $codReduzido = $_POST['select_item'];
                    $valorUnitario = $_POST['vlr_venda'];
                    $qtdProduto = $_POST['qtd_produto'];
                    $percDesconto = $_POST['perc_desconto'];

                    $tratamentoVlrUnitario = str_replace(",", ".", $valorUnitario);
                    $tratamentoPercDesconto = str_replace(",", ".", $percDesconto);

                    $vlrDesconto = ((float) $tratamentoVlrUnitario * ((float) $tratamentoPercDesconto / 100));
                    $vlrLiquido = (float) $tratamentoVlrUnitario - (float) $vlrDesconto;
                    $vlrTotal = (float) $vlrLiquido * (float) $qtdProduto;
                    $vlrLiquido = ((float) $tratamentoVlrUnitario - ((float) $tratamentoVlrUnitario * ((float) $tratamentoPercDesconto / 100)));

                    $html = '';
                    if (isset($_POST['incluir'])) {
                        if ($codReduzido == 0 || empty($valorUnitario) || empty($qtdProduto)) { ?> 
                            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="myModalLabel">Erro ao vender item!</h4>
                                        </div>
                                        <div class="modal-body">								
                                            <?php echo "Por gentileza, favor preencher todos os campos <br>" ?>
                                        </div>
                                        <div class="modal-footer">
                                            <a href="telaVenda.php">
                                                <button type="button" class="btn btn-danger">
                                                    Ok
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>			
                        <script>
                            $(document).ready(function () {
                                $('#myModal').modal('show');
                            });
                        </script>
                        <?php
                    }
                    $qInsert = "INSERT INTO venda_item (num_venda, cod_reduzido, qtd_produto, vlr_unitario, perc_desconto, vlr_desconto, vlr_liquido, vlr_total)
                                    VALUES ($numVenda, $codReduzido, $qtdProduto, $tratamentoVlrUnitario, $tratamentoPercDesconto, $vlrDesconto,  $vlrLiquido, $vlrTotal)";
                    $qExecInsert = mysqli_query($conexaoMysql, $qInsert);
                    $qSelect = "SELECT venda_item.cod_reduzido, cad_produtos.nom_produto, venda_item.qtd_produto, venda_item.vlr_unitario, venda_item.vlr_desconto, venda_item.vlr_total
                                    FROM venda_item
                                    INNER JOIN cad_produtos ON cad_produtos.cod_reduzido = venda_item.cod_reduzido
                                    WHERE num_venda = $numVenda AND flg_excluido is null";
                    $qSelectExec = mysqli_query($conexaoMysql, $qSelect);
                    while ($qSelectResult = mysqli_fetch_array($qSelectExec)) {
                        $html .= "<tr>";
                        $html .= "<th scope = 'row'>" . $qSelectResult['cod_reduzido'] . "</th>";
                        $html .= "<td>" . $qSelectResult['nom_produto'] . "</td>";
                        $html .= "<td>" . $qSelectResult['qtd_produto'] . "</td>";
                        $html .= "<td>" . $qSelectResult['vlr_unitario'] . "</td>";
                        $html .= "<td>" . $qSelectResult['vlr_desconto'] . "</td>";
                        $html .= "<td>" . $qSelectResult['vlr_total'] . "</td>";
                        $html .= "</tr>";
                    }
                    echo $html;
                } elseif (isset($_POST['concluir'])) {
                    $validaItensNota = "SELECT * FROM venda_item WHERE num_venda = $numVenda";
                    $execValidaItensNota = mysqli_query($conexaoMysql, $validaItensNota);
                    $numLinhas = mysqli_num_rows($execValidaItensNota);
                    if ($numLinhas < 1) {
                        ?>
                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel">Erro!</h4>
                                    </div>
                                    <div class="modal-body">								
                                        <?php echo "Não é possível finalizar uma venda, sendo que a mesma não foi iniciada.<br>"
                                        . "Favor inclua itens na venda para poder finalizar a mesma"
                                        ?>      
                                    </div>
                                    <div class="modal-footer">
                                        <a href="telaVenda.php">
                                            <button type="button" class="btn btn-danger">
                                                Ok
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>			
                        <script>
                            $(document).ready(function () {
                                $('#myModal').modal('show');
                            });
                        </script>
                        <?php
                        exit();
                    } 
                    $sqlSaidaEstoque = "SELECT cod_reduzido,qtd_produto "
                                     . "FROM venda_item "
                                     . "WHERE "
                                        . "num_venda = $numVenda AND "
                                        . "flg_excluido is null";
                    $execSaidaEstoque = mysqli_query($conexaoMysql, $sqlSaidaEstoque);

                    while ($resultSaidaEstoque = mysqli_fetch_array($execSaidaEstoque)) {
                        $codigo = $resultSaidaEstoque['cod_reduzido'];
                        $qtdSaida = $resultSaidaEstoque['qtd_produto'];
                        $sqlConsultaEstoque = "SELECT qtd_estoque FROM cad_produtos WHERE cod_reduzido = $codigo";
                        $execConsultaEstoque = mysqli_query($conexaoMysql, $sqlConsultaEstoque);
                        $resultConsultaEstoque = mysqli_fetch_assoc($execConsultaEstoque);
                        $qtdEstoque = (int) $resultConsultaEstoque['qtd_estoque'];
                        $estoqueAtualizado = $qtdEstoque - $qtdSaida;

                        $sqlAtualizaEstoque = "UPDATE cad_produtos "
                                            . "SET "
                                                . "qtd_estoque = $estoqueAtualizado "
                                            . "WHERE "
                                                . "cod_reduzido = $codigo";  
                        $execAtualizaEstoque = mysqli_query($conexaoMysql, $sqlAtualizaEstoque);
                    }
                    ?>
                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="myModalLabel">Venda finalizada com Sucesso!</h4>
                                </div>
                                <div class="modal-body">
                                    <?php echo "A venda de N°: $numVenda foi concluída com êxito"; ?>
                                </div>
                                <div class="modal-footer">
                                    <a href="telaVenda.php"><button type="button" class="btn btn-success">Ok</button></a>
                                </div>
                            </div>
                        </div>
                    </div>				
                    <script>
                        $(document).ready(function () {
                            $('#myModal').modal('show');
                        });
                    </script>   

                    <?php
                    $numVendaAtualizado = $numVenda + 1;
                    $sqlAtualizaNumVenda = "UPDATE cad_gerenciadorid
                                                SET num_sequencial = $numVendaAtualizado
                                                WHERE cod_sequencial = 1";
                    $execAtualizaNumVenda = mysqli_query($conexaoMysql, $sqlAtualizaNumVenda);

                } elseif (isset($_POST['cancelar'])) {
                    $validaItensNota = "SELECT * FROM venda_item WHERE num_venda = $numVenda";
                    $execValidaItensNota = mysqli_query($conexaoMysql, $validaItensNota);
                    $numLinhas = mysqli_num_rows($execValidaItensNota);
                    if ($numLinhas < 1) { ?>
                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel">Erro!</h4>
                                    </div>
                                    <div class="modal-body">								
                                        <?php echo "Não é possível cancelar uma venda, "
                                                 . "sendo que a mesma não foi iniciada.<br>"
                                        ?>      
                                    </div>
                                    <div class="modal-footer">
                                        <a href="telaVenda.php">
                                            <button type="button" class="btn btn-danger">
                                                Ok
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>			
                        <script>
                            $(document).ready(function () {
                                $('#myModal').modal('show');
                            });
                        </script>
                        <?php
                        exit();
                    }
                    $sqlCancelarItens = "UPDATE venda_item
                                             SET flg_excluido = 'S'
                                             WHERE num_venda = $numVenda";
                    $execCancelaItens = mysqli_query($conexaoMysql, $sqlCancelarItens);
                    
                    ?>
                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="myModalLabel">Venda cancelada com Sucesso!</h4>
                                </div>
                                <div class="modal-body">
                                    <?php echo "A venda de N°: $numVenda foi cancelada com êxito"; ?>
                                </div>
                                <div class="modal-footer">
                                    <a href="telaVenda.php"><button type="button" class="btn btn-success">Ok</button></a>
                                </div>
                            </div>
                        </div>
                    </div>				
                    <script>
                        $(document).ready(function () {
                            $('#myModal').modal('show');
                        });
                    </script>
                    <?php
                    $numVendaAtualizado = $numVenda + 1;
                    $sqlAtualizaNumVenda = "UPDATE cad_gerenciadorid "
                                         . "SET "
                                            . "num_sequencial = $numVendaAtualizado "
                                         . "WHERE "
                                            . "cod_sequencial = 1";                                                
                    $execAtualizaNumVenda = mysqli_query($conexaoMysql, $sqlAtualizaNumVenda);
                }
                ?>   
                </tbody>    
            </table>
    </body>
</html>







