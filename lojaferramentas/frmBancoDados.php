<?php

	$host = "localhost";
	$user = "root";
	$password = "root";
	$banco = "lojaferramentas";
	
	$conexao = mysqli_connect($host, $user, $password, $banco);
	
	$idPedidoCompraAtual = 0;
	/*if (!session_start())
	{
		session_start();
	}
	
	$_SESSION["id"] = "";*/
	
	
	if (!$conexao)
	{
		echo "Problema na conexão com o Banco de Dados";
	}
	else
	{
		mysqli_select_db($conexao, $banco);
		
		$acao = "";
		
		if (isset($_REQUEST["acao"]))
		{
			$acao = $_REQUEST["acao"];
		}
		
		if ($acao == "login")
		{
			//Váriaveis de entrada
			$usuariologin = $_REQUEST["usuariologin"];
			$senhalogin = $_REQUEST["senhalogin"];
			
			$sqlstring = "select * from tblusuario where nomeUsuario = '" . $usuariologin . "' and senhaUsuario = '" . $senhalogin . "'";
			
			$result = mysqli_query($conexao, $sqlstring);
			
			if	(mysqli_affected_rows($conexao) > 0)
			{
				echo "OK";
				
				//$dados = mysqli_fetch_array($result);
				//$_SESSION["id"] = $dados["idUsuario"];
			}
			else
			{
				echo "Usuário ou senha errados!";
			}
		}
		
		if ($acao == "carregarProdutos")
		{
			$sqlstring = "select count(idProduto) as totalProdutos from tblprodutos";
			$result = mysqli_query($conexao, $sqlstring);
			
			if (mysqli_affected_rows($conexao) > 0)
			{
				$dados = mysqli_fetch_array($result);
				$totalProdutos = $dados["totalProdutos"];
				
				for ($i = 1; $i <= 4; $i++)
				{
					$sqlstring = "select * from tblprodutos where idProduto = " . $i;
					$result = mysqli_query($conexao, $sqlstring);
					
					if (mysqli_affected_rows($conexao) > 0)
					{
						$dados = mysqli_fetch_array($result);
						$idProduto = $dados["idProduto"];
						$valorProduto = $dados["valorProduto"];
						$nomeProduto = $dados["nomeProduto"];
						$quantidadeProduto = $dados["quantidadeProduto"];
						
						$strDivProduto = '
                        <div class="widget widget-container content-area vertical-col uib-card uib_w_85 section-dimension-85 cpad-15 cpad-5" data-uib="layout/card" data-ver="0" id="cardProduto' . $i . '">
                            <div class="widget uib_w_91 scale-image d-margins" data-uib="media/img" data-ver="0">
                                <figure class="figure-align">
                                    <img src="images/Strabburg.jpg">
                                    <figcaption data-position="bottom"></figcaption>
                                </figure>
                            </div>
							
                            <section class="card-header widget-container content-area vertical-col">

                                <div class="tarea widget uib_w_89 d-margins" data-uib="media/text" data-ver="0" name="uib_w_89">
                                    <div class="widget-container left-receptacle"></div>
                                    <div class="widget-container right-receptacle"></div>
                                    <div class="text-container text-center">
                                        <h4><b><p>'. $nomeProduto .'</p></b></h4>
                                    </div>
                                </div>
                            </section>
                         
                            <section class="card-footer widget-container content-area vertical-col">
								<div class="tarea widget uib_w_89 d-margins" data-uib="media/text" data-ver="0" name="uib_w_89">
									<div class="widget-container left-receptacle">
										<p>R$'. $valorProduto .'</p>
									</div>
									
									<div class="widget-container right-receptacle">
										<button class="btn btn-sm widget uib_w_77 d-margins btn-danger" data-uib="twitter%20bootstrap/button" 
										data-ver="1" codigo="'. $idProduto .'" quantidade="1" valor="'. $valorProduto .'" id="btnAdicionarCarrinho" data-produto="'. $idProduto .'">
										<i class="glyphicon glyphicon-ok-circle button-icon-left" data-position="left"></i> Add Carrinho</button>
									</div>
								
								</div>
							</section>
                        </div>
					</div>';
					
					echo $strDivProduto;
					
					}
					else
					{
						echo "Erro ao achar o produto";
					}
				}
				
			}
			else
			{
				echo "Erro na contagem de produtos!";
			}
		}
		
		if ($acao == "construirCarrinho")
		{
			$produtoadicionado = $_REQUEST["produtoAdicionado"];
			
			$sqlstring = "select * from tblprodutos where idProduto = " . $produtoadicionado;
			$result = mysqli_query($conexao, $sqlstring);
			
			if (mysqli_affected_rows($conexao) > 0)
			{
				$dados = mysqli_fetch_array($result);
				$idProduto = $dados["idProduto"];
				$valorProduto = $dados["valorProduto"];
				$nomeProduto = $dados["nomeProduto"];
				$quantidadeProduto = $dados["quantidadeProduto"];
				
				$strDivProdutoCar = '
				   <div class="grid grid-pad urow uib_row_10 row-height-10" data-uib="layout/row" data-ver="0">
                        <div class="col uib_col_12 col-0_2-12_2-6" data-uib="layout/col" data-ver="0">
                            <div class="widget-container content-area vertical-col">
                                <div class="tarea widget uib_w_96 d-margins" data-uib="media/text" data-ver="0" name="uib_w_96" id="txtCodigoProdutoCar">
                                    <div class="widget-container left-receptacle"></div>
                                    <div class="widget-container right-receptacle"></div>
                                    <div class="text-container">
                                        <p id="idProdutoCar">'. $idProduto .'</p>
                                    </div>
                                </div>
                                <span class="uib_shim"></span>
                            </div>
                        </div>
                        <div class="col uib_col_25 col-0_4-12_4-6" data-uib="layout/col" data-ver="0">
                            <div class="widget-container content-area vertical-col">
                                <div class="tarea widget uib_w_93 d-margins" data-uib="media/text" data-ver="0" name="uib_w_93" id="txtNomeProdutoCar">
                                    <div class="widget-container left-receptacle"></div>
                                    <div class="widget-container right-receptacle"></div>
                                    <div class="text-container">
                                        <p>'. $nomeProduto .'</p>
                                    </div>
                                </div><span class="uib_shim"></span>
                            </div>
                        </div>
                        <div class="col uib_col_10 col-0_4-12_4-6" data-uib="layout/col" data-ver="0">
                            <div class="widget-container content-area vertical-col">
                                <div class="tarea widget uib_w_94 d-margins" data-uib="media/text" data-ver="0" name="uib_w_94">
                                    <div class="widget-container left-receptacle"></div>
                                    <div class="widget-container right-receptacle"></div>
                                    <div class="text-container">
                                       
										<input class="wide-control form-control default" type="number" 
										id="txtQuantidadeProduto" value="1" min="1" max="'. $quantidadeProduto .'">
										
                                    </div>
                                </div>
                                <span class="uib_shim"></span>
                            </div>
                        </div>
                        <div class="col uib_col_11 col-0_2-12_2-6" data-uib="layout/col" data-ver="0">
                            <div class="widget-container content-area vertical-col">
                                <div class="tarea widget uib_w_95 d-margins" data-uib="media/text" data-ver="0" name="uib_w_95">
                                    <div class="widget-container left-receptacle"></div>
                                    <div class="widget-container right-receptacle"></div>
                                    <div class="text-container">
                                        <p id="txtValorProdutoCar">'. $valorProduto .'</p>
                                    </div>
                                </div>
                                <span class="uib_shim"></span>
                            </div>
                        </div>

                        <span class="uib_shim"></span>
                    </div>';
					
			echo $strDivProdutoCar;
			}
			else
			{
				echo "Produto não encotrado ao adicionar no carrinho!";
			}
		}
		
		if ($acao == "cadastrarUsuario")
		{
			//Váriaveis de cadastro
			$cpf = $_REQUEST["cpf"];
			$nomepessoa = $_REQUEST["nomepessoa"];
			$dtnasc = $_REQUEST["dtnasc"];
			$tipousuario = $_REQUEST["tipousuario"];
			$usuariocad = $_REQUEST["usuariocad"];
			$senhacad = $_REQUEST["senhacad"];
				
			$sqlstring = "select * from tblpessoas where cpfPessoa = " . $cpf;
			$result = mysqli_query($conexao, $sqlstring);
			
			if (mysqli_affected_rows($conexao) == 0)
			{
				$sqlstring = "insert into tblpessoas(idPessoa, cpfPessoa, nomePessoa, dtNascPessoa, tipoPessoa) values(NULL," . $cpf . ",'" . $nomepessoa . "','" . $dtnasc . "','" . $tipousuario . "')";
			
				$result = mysqli_query($conexao, $sqlstring);
				
				if (mysqli_affected_rows($conexao) > 0)
				{
					$sqlstring = "select * from tblpessoas where cpfPessoa =" . $cpf; //. " and nomePessoa ='" . $nomepessoa ."' and dtNascPessoa =" . $dtnasc;
					$result = mysqli_query($conexao, $sqlstring);
					
					if (mysqli_affected_rows($conexao) > 0)
					{
						$dados = mysqli_fetch_array($result);
						$idPessoa = $dados["idPessoa"];
					
						$sqlstring = "insert into tblusuario(idUsuario, idPessoa, nomeUsuario, senhaUsuario) values(NULL, ";
						$sqlstring .= $idPessoa . ",'" . $usuariocad . "','" . $senhacad . "')";
						$result = mysqli_query($conexao, $sqlstring);
						
						if (mysqli_affected_rows($conexao) > 0)
						{
							echo "Sucesso! Cadastro realizado com sucesso";
						}
						else
						{
							echo "Erro no cadastramento geral";
						}
					}
					else
					{
						echo "Erro no cadastramento do usuário!";
					}
				}
				else
				{
					echo "Erro no cadastramento!";
				}
			}
			else
			{
				echo "Já existe um usuário com este CPF!";
			}
	
		}
		
		if ($acao == "incluirProduto")
		{
			//Váriaveis
			$nomeprod = $_REQUEST["nomeprod"];
			$valorprod = $_REQUEST["valorprod"];
			$quantidadeprod = $_REQUEST["quantidadeprod"];
			$fornecedorproduto = $_REQUEST["fornecedorproduto"];
			
			$sqlstring = "insert into tblprodutos(idProduto, valorProduto, nomeProduto, quantidadeProduto) values(NULL, ";
			$sqlstring .= $valorprod . ", '" . $nomeprod . "'," . $quantidadeprod . ")";
			$result = mysqli_query($conexao, $sqlstring);
			
			if (mysqli_affected_rows($conexao) > 0)
			{
				$sqlstring = "select * from tblprodutos where nomeProduto = '" . $nomeprod . "' and valorProduto = " . $valorprod;
				$result = mysqli_query($conexao, $sqlstring);
				
				if (mysqli_affected_rows($conexao) > 0)
				{
					$dados = mysqli_fetch_array($result);
					$idProduto = $dados["idProduto"];
					
					
					$sqlstring = "select * from tblfornecedores where nomeFornecedor = '" . $fornecedorproduto ."'";
					$result = mysqli_query($conexao, $sqlstring);
					
					if (mysqli_affected_rows($conexao) > 0)
					{
						$dados = mysqli_fetch_array($result);
						$idFornecedor = $dados["idFornecedor"];
						
						$sqlstring = "insert into tblprodfornec(idProdFornec, idProduto, idFornecedor) values(NULL,";
						$sqlstring .= $idProduto . "," . $idFornecedor .")";
						$result = mysqli_query($conexao, $sqlstring);
						
						if (mysqli_affected_rows($conexao) > 0)
						{
							echo "Produto incluído com sucesso!";
						}
						else
						{
							echo "Erro ao incluir na tabela de relação produto x fornecedor!";
						}
					}
					else
					{
						echo "Erro ao achar o fornecedor!";
					}
				}
				else
				{
					echo "Erro ao achar o produto!";
				}
				
			}
			else
			{
				echo "Erro na inclusão do produto!";
			}
		}
		
		if ($acao == "excluirProduto")
		{
			//Váriaveis
			$codigoprod = $_REQUEST["codigoprod"];
			
			$sqlstring = "select * from tblprodutos where idProduto = " . $codigoprod;
			$result = mysqli_query($conexao, $sqlstring);
			
			if (mysqli_affected_rows($conexao) > 0)
			{
				$sqlstring = "delete from tblprodutos where idProduto = " . $codigoprod;
				$result = mysqli_query($conexao, $sqlstring);
				
				if (mysqli_affected_rows($conexao) > 0)
				{
					echo "Produto excluído com sucesso!";
				}
				else
				{
					echo "Erro na exclusão do produto!";
				}
			}
			else
			{
				echo "Produto não encotrado!";
			}
		}
		
		if ($acao == "finalizarCompra")
		{
			//Váriaveis
			$statuspedido = $_REQUEST["statuspedido"];
			$usuariopedido = $_REQUEST["usuariopedido"];
			$datahorapedido = $_REQUEST["datahorapedido"];
			$idPedido = 0;
			
			$sqlstring = "insert into tblpedidos(idPedido, idUsuarioPedido, statusPedido, dataHoraPedido) values(NULL, '";
			$sqlstring .= $usuariopedido . "', '" . $statuspedido . "','" . $datahorapedido . "')";
			$result = mysqli_query($conexao, $sqlstring);
			
			if (mysqli_affected_rows($conexao) > 0)
			{
				$sqlstring = "select * from tblpedidos where dataHoraPedido = '" . $datahorapedido. "' and idUsuarioPedido = '" . $usuariopedido . "'";
				$result = mysqli_query($conexao, $sqlstring);
				
				if (mysqli_affected_rows($conexao) > 0)
				{
					$dados = mysqli_fetch_array($result);
					$idPedido = $dados["idPedido"];
					$idPedidoCompraAtual = $idPedido;
					
					//Pega todos os produtos daquele usuário
					$sqlstring = "select * from tblcarrinho where idUsuario = '" . $usuariopedido . "'";
					$result = mysqli_query($conexao, $sqlstring);
					
					if (mysqli_affected_rows($conexao) > 0)
					{
						//$dados = mysqli_fetch_array($result);
						$dados = mysqli_fetch_row($result);
						
						while ($dados)
						{
							$idProduto = $dados[1];
							$quantidadeComprada = $dados[2];
							$precoProduto = $dados[3];
							
							$valorTotal = $precoProduto * $quantidadeComprada;
							
							$sqlstring = "insert into tbldetpedido(idPedido, idProduto, quantidadeComprada, valorTotal) values(";
							$sqlstring .= $idPedido . "," . $idProduto . "," . $quantidadeComprada . "," . $valorTotal . ")";
							$resulta = mysqli_query($conexao, $sqlstring);
							
							/*if (mysqli_affected_rows($conexao) > 0)
							{
								echo "Inclusão bem sucedida na tabela detalhe de pedido!";
							}
							else
							{
								echo "Erro na inclusão da tabela detalhe de pedido";
							}*/
							
							$dados = mysqli_fetch_row($result);
						}
						
						$sqlstring = "delete from tblcarrinho";
						$result = mysqli_query($conexao, $sqlstring);
						
						if (mysqli_affected_rows($conexao) > 0)
						{
							$sqlstring = "select * from tbldetpedido where idPedido = " . $idPedidoCompraAtual;
							$result = mysqli_query($conexao, $sqlstring);
							
							if (mysqli_affected_rows($conexao) > 0)
							{
								$dados = mysqli_fetch_row($result);
								
								while ($dados)
								{
									$idProduto = $dados[1];
									$quantidadeComprada = $dados[2];
									
									$sqlstring = "update tblprodutos set quantidadeProduto = quantidadeProduto -" . $quantidadeComprada . " where idProduto = " . $idProduto;
									$resulta = mysqli_query($conexao, $sqlstring);
									
									$dados = mysqli_fetch_row($result);
								}
								
								//fechar pedido
								$sqlstring = "update tblpedidos set statusPedido = 'Fechado' where idPedido = " . $idPedidoCompraAtual;
								$result = mysqli_query($conexao, $sqlstring);
								
								if (mysqli_affected_rows($conexao) > 0)
								{
									echo "OK";
								}
								else
								{
									echo "Update não funcionou";
								}
							}
							else
							{
								echo "Erro ao encontrar tabela detalhe X pedido!";
							}
						}
						else
						{
							echo "Erro ao excluir do carrinho temporário!";
						}
						
						//$idProduto = $dados["idProduto"];
						//$quantidadeComprada = $dados["quantidadeProduto"];
						//$precoProduto = $dados["precoProduto"];
						//$valorTotal = $precoProduto * $quantidadeComprada;
						
						//$sqlstring = "insert into tbldetpedido(idPedido, idProduto, quantidadeComprada, valorTotal) values(";
						//$sqlstring .= $idPedido . "," . $idProduto . "," . $quantidadeComprada . "," . $valorTotal . ")";
						//$result = mysqli_query($conexao, $sqlstring);
						
						
						//$dados = mysqli_fetch_row($result);
					}
					else
					{
						echo "Erro ao encontrar o carrinho";
					}
					
				}
				else
				{
					echo "Erro ao encontrar o ID do pedido";
				}
				
			}
			else
			{
				echo "Problema na inclusão do pedido!";
			}
		}
		
		if ($acao == "excluirPedido")
		{
			//Váriaveis
			$codigopedido = $_REQUEST["codigopedido"];
			
			$sqlstring = "select * from tblpedidos where idPedido = " . $codigopedido;
			$result = mysqli_query($conexao, $sqlstring);
			
			if (mysqli_affected_rows($conexao) > 0)
			{
				$sqlstring = "delete from tblpedidos where idPedido = " . $codigopedido;
				$result = mysqli_query($conexao, $sqlstring);
				
				if (mysqli_affected_rows($conexao) > 0)
				{
					echo "Pedido excluído com sucesso!";
				}
				else
				{
					echo "Erro na exclusão do pedido!";
				}
			}
			else
			{
				echo "Pedido não encontrado!";
			}
		}
		
		if ($acao == "alterarPedido")
		{
			//Váriaveis
			$codigopedido = $_REQUEST["codigopedido"];
			$statuspedido = $_REQUEST["statuspedido"];
			$datahorapedido = $_REQUEST["datahorapedido"];
			
			$sqlstring = "select * from tblpedidos where idPedido = " . $codigopedido;
			$result = mysqli_query($conexao, $sqlstring);
			
			if (mysqli_affected_rows($conexao) > 0)
			{
				$dados = mysqli_fetch_array($result);
				$statusPedido = $dados["statusPedido"];
				
				if ($statusPedido == "Fechado")
				{
					echo "O pedido já está fechado, não pode ser alterado!";
				}
				else
				{
					$sqlstring = "update tblpedidos set statusPedido = '" . $statuspedido . "', dataHoraPedido = '" . $datahorapedido . "';";
					$result = mysqli_query($conexao, $sqlstring);
					
					if (mysqli_affected_rows($conexao) > 0)
					{
						echo "Pedido alterado com sucesso!";
					}
					else
					{
						echo "Erro na alteração do pedido!";
					}
				}
				
			}
			else
			{
				echo "Pedido não encontrado!";
			}
		}
		
		if ($acao == "cadastrarFornecedor")
		{
			$nomeFornecedor = $_REQUEST["nomefornecedor"];
			$cnpj = $_REQUEST["cnpj"];
			
			$sqlstring = "select * from tblfornecedores where nomeFornecedor = '" . $nomeFornecedor . "'";
			$result = mysqli_query($conexao, $sqlstring);
			
			if (mysqli_affected_rows($conexao) == 0)
			{
				$sqlstring = "insert into tblfornecedores(idFornecedor, cnpjFornecedor, nomeFornecedor) values(NULL,";
				$sqlstring .= $cnpj . ", '" . $nomeFornecedor . "')";
				$result = mysqli_query($conexao, $sqlstring);
				
				if (mysqli_affected_rows($conexao) > 0)
				{
					echo "Fornecedor cadastrado com sucesso!";
				}
				else
				{
					echo "Problema no cadastrado do fornecedor!";
				}
			}
			else
			{
				echo "Já existe uma empresa cadastrada com esse nome!";
			}
		}
		
		if ($acao == "excluirFornecedor")
		{
			$codigoFornecedor = $_REQUEST["codigofornecedor"];
	
			$sqlstring = "select * from tblfornecedores where idFornecedor =" . $codigoFornecedor;
			$result = mysqli_query($conexao, $sqlstring);
			
			if (mysqli_affected_rows($conexao) > 0)
			{
				$sqlstring = "delete from tblfornecedores where idFornecedor =" . $codigoFornecedor;
				$result = mysqli_query($conexao, $sqlstring);
				
				if (mysqli_affected_rows($conexao) > 0)
				{
					echo "Fornecedor excluído com sucesso!";
				}
				else
				{
					echo "Problema na exclusão do fornecedor!";
				}
			}
			else
			{
				echo "Fornecedor não encotrado!";
			}
		}
		
		if ($acao == "carregarFornecedoresProduto")
		{
			$sqlstring = "select nomeFornecedor from tblfornecedores";
			$result = mysqli_query($conexao, $sqlstring);
			
			if (mysqli_affected_rows($conexao) > 0)
			{
				$dados = mysqli_fetch_row($result);
				$strOpcoesNome = "";
								
				while ($dados) 
				{
					//count() usado para contar o número de elementos de um array
					$col = count($dados);
					
					for ($i = 0; $i < $col; $i++) 
					{
						$strOpcoesNome .= "<option value=". $dados[$i] .">" . $dados[$i] . "</option>";
						
						/*if ($i == $col)
						{
							$dados = false;
						}
						else
						{
							$dados = true;
						}*/
					}
			
					$dados = mysqli_fetch_row($result);
				}

				echo $strOpcoesNome;
			}
			else
			{
				echo "Problema na busca dos fornecedores!";
			}
		}
		
		if ($acao == "adicionarCarrinhoTemp")
		{
			$idUsuario = $_REQUEST["idusuario"];
			$idProduto = $_REQUEST["idproduto"];
			$quantidadeprod = $_REQUEST["quantidadeproduto"];
			$precoprod = $_REQUEST["precoproduto"];

			
			$sqlstring = "insert into tblcarrinho(idUsuario, idProduto, quantidadeProduto, precoProduto) values('" . $idUsuario . "',";
			$sqlstring .= $idProduto . "," . $quantidadeprod . "," . $precoprod . ")";
			$result = mysqli_query($conexao, $sqlstring);
			
			if (mysqli_affected_rows($conexao) > 0)
			{
				echo "Incluído no carrinho temporário!";
			}
			else
			{
				echo "Erro na inclusão do carrinho temporário!";
			}
		}
		
		/*if ($acao == "finalizarCompra")
		{
			//$idPedidoCompraAtual = $_REQUEST["idpedidocompraatual"];
			$idPedidoCompraAtual = 41;
			
			$sqlstring = "select * from tbldetpedidos where idPedido = " . $idPedidoCompraAtual;
			$result = mysqli_query($conexao, $sqlstring);
			
			if (mysqli_affected_rows($conexao) > 0)
			{
				$dados = mysqli_fetch_row($result);
				
				while ($dados)
				{
					$idProduto = $dados[1];
					$quantidadeComprada = $dados[2];
					
					$sqlstring = "update tblprodutos set quantidadeProduto = quantidadeProduto -" . $quantidadeComprada . " where idProduto = " . $idProduto;
					$resulta = mysqli_query($conexao, $sqlstring);
					
					$dados = mysqli_fetch_row($result);
				}
				
				//fechar pedido
				$sqlstring = "update tblpedidos set statusPedido = 'Fechado' where idPedido = " . $idPedidoCompraAtual;
				$result = mysqli_query($conexao, $sqlstring);
				
				if (mysqli_affected_rows($conexao) > 0)
				{
					echo "OK";
				}
			}
			else
			{
				echo $idPedidoCompraAtual . " - Problema ao encontrar a tabela de detalhe do pedido!";
			}
			
		}*/
		
		if ($acao == "fecharCaixa")
		{
			$dataCaixa = $_REQUEST["datacaixa"];
			$nomeFuncionario = $_REQUEST["nomefuncionario"];
			$idPedido = $_REQUEST["idpedido"];
			$nomeUsuario = $_REQUEST["nomeusuario"];
			
			$sqlstring = "insert into tblcaixa(idCaixa, dataCaixa, nomeFuncionario, idPedido, nomeUsuario) values(NULL, '";
			$sqlstring .= $dataCaixa . "', '" . $nomeFuncionario . "'," . $idPedido . ", '" . $nomeUsuario . "')";
			
			$result = mysqli_query($conexao, $sqlstring);
			
			if (mysqli_affected_rows($conexao) > 0)
			{
				$sqlstring = "update tblpedidos set statusPedido = 'Fechado' where idPedido = " . $idPedido;
				$result = mysqli_query($conexao, $sqlstring);
				
				if (mysqli_affected_rows($conexao) > 0)
				{
					echo "Caixa Fechado com sucesso!";
				}
				else
				{
					echo "Erro no fechamento do caixa!";
				}
			}
			else
			{
				echo "Erro ao inserir os dados no caixa!";
			}
		}	
			
	}
?>