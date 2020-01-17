(function()
{
 "use strict";
  var $server = "http://localhost/lojaferramentas/";
  var $idPedidoCompraAtual;
    
 function register_event_handlers()
 {   
    $(document).on("click", "#btnQueroCadastrar", function(evt)
    {
         /*global activate_subpage */
         activate_subpage("#frmcadastro"); 
         return false;
    });
    
    $(document).load("load", "#frmHome", function(evt)
    {
       
       $.ajax({
            type: "post",
            url: $server + "frmBancoDados.php",
            data: {
                acao: "carregarProdutos",
            },
            dataType: "text",
            success: function(data){
                 //navigator.notification.alert(data);
                
                $("#todosProdutos").html(data);
               
            },
            error: function(erro, exception){
                navigator.notification.alert(erro.response.Text);
            }
       });                        
    });
     
    $(document).load("load", "#frmProduto", function(evt)
    {
        $.ajax({
            type: "post",
            url: $server + "frmBancoDados.php",
            data: {
                acao: "carregarFornecedoresProduto",
            },
            dataType: "text",
            success: function(data){
                //navigator.notification.alert(data);
                
                $("#txtFornecedorProduto").append(data);
               
            },
            error: function(erro, exception){
                navigator.notification.alert(erro.response.Text);
            }
       }); 
    });
   
     
    $(document).on("click", ".btn-sm", function(evt){
        
//        var datafinal = new Date();
//        var ano = data.getUTCFullYear();
//        var mes = data.getUTCMonth();
//        var dia = data.getUTCDate();
//        var hora = data.getUTCHours();
//        var minuto = data.getUTCMinutes();
//        var segundo = data.getUTCSeconds();
//
//        datafinal = new Date(ano, mes, dia, hora, minuto, segundo);
        
        var $produto = $(this).data("produto");
        var pedidoCriado = false;
        //navigator.notification.alert($produto);
        
        $.ajax({
            type: "post",
            url: $server + "frmBancoDados.php",
            data: {
                acao:"construirCarrinho",
                produtoAdicionado: $produto
            },
            dataType: "text",
            success: function(data){
                //navigator.notification.alert(data);
                
                $("#produtosCarrinho").append(data);
            },
            error: function(erro, exception){
                navigator.notification.alert(erro.response.Text);
            }
        });
        
         //Mostra ao usuário quantos produtos tem no seu carrinho de compra
        $("#txtNumeroProdutosCar").text(parseInt($("#txtNumeroProdutosCar").text()) + 1);
        
         //Adicionar os dados dos produtos temporariamente
        $.ajax({
            type: "post",
            url: $server + "frmBancoDados.php",
            data: {
                acao: "adicionarCarrinhoTemp",
                idusuario: $("#txtUsuarioLogin").val(),
                idproduto: $(this).attr("codigo"),
                quantidadeproduto: $(this).attr("quantidade"),
                precoproduto: $(this).attr("valor") 
            },
            dataType: "text",
            success: function(data){
                navigator.notification.alert(data);

            },
            error: function(erro, exception){
                navigator.notification.alert(erro.response.Text);
            }
        });
            
    });
     
    $(document).on("click", "#btnEntrar", function(evt)
    {
        if ($("#txtUsuarioLogin").val() == "")
        {
            navigator.notification.alert("Campo Código obrigatório!");
        }
        else if ($("#txtSenhaLogin").val() == "")
        {
            navigator.notification.alert("Campo Senha obrigatório!");
        }
        else
        {
            $.ajax({
                type: "post",
                url: $server + "frmBancoDados.php",
                data: {
                    acao: "login",
                    usuariologin: $("#txtUsuarioLogin").val(),
                    senhalogin: $("#txtSenhaLogin").val()
                },
                dataType: "text",
                success: function(data){
                    //navigator.notification.alert(data);
                    if (data == "OK")
                    {
                       activate_subpage("#frmHome"); 
                    }
                          
                },
                error: function(erro, exception){
                    navigator.notification.alert(erro.response.Text);
                }
            });
        }
         return false;
    });
    
        
    $(document).on("click", "#btnVoltarTelaCad", function(evt)
    {
         /*global activate_subpage */
         activate_subpage("#page_20_69"); 
         return false;
    });
    
    $(document).on("click", "#btnLimpar", function(evt)
    {
        $("#txtCPF").val("");
        $("#txtNome").val("");
        $("#txtDtNasc").val("");
        $("#txtUsuarioCad").val("");
        $("#txtSenhaCad").val("");
        $("#rdbCliente").checked = false;
        $("#rdbFuncionario").checked = false;
         return false;
    });
    
        
    $(document).on("click", "#btnCadastrar", function(evt)
    {
        if ($("#txtCPF").val() == "")
         {
              navigator.notification.alert("Campo CPF obrigatório!");
         }

         else if ($("#txtNome").val() == "")
         {
             navigator.notification.alert("Campo Nome obrigatório!");
         }
        
          else if ($("#txtDtNasc").val() == "")
         {
             navigator.notification.alert("Campo Data de Nascimento obrigatório!");
         }
        
          else if ($("#txtUsuarioCad").val() == "")
         {
             navigator.notification.alert("Campo Usuário obrigatório!");
         }
        
          else if ($("#txtSenhaCad").val() == "")
         {
             navigator.notification.alert("Campo Senha obrigatório!");
         }
        
         else if (($("#rdbCliente").is(":checked") == false) && ($("#rdbFuncionario").is(":checked") == false))
         {
             navigator.notification.alert("Campo de Tipo de Usuário obrigatório!");
         }
        
        else 
        {
            var tipoCliente = "";
            
            if ($("#rdbCliente").is(":checked"))
            {
                tipoCliente = "c";
            }
            else if ($("#rdbFuncionario").is(":checked"))
            {
                tipoCliente = "f";
            }
            
            $.ajax({
                type: "post",
                url: $server + "frmBancoDados.php",
                data: {
                    acao: "cadastrarUsuario",
                    cpf: $("#txtCPF").val(),
                    nomepessoa: $("#txtNome").val(),
                    dtnasc: $("#txtDtNasc").val(),
                    usuariocad: $("#txtUsuarioCad").val(),
                    senhacad: $("#txtSenhaCad").val(),
                    tipousuario: tipoCliente
                },
                dataType: "text",
                success: function(data) {
                    navigator.notification.alert(data);
                },
                error: function(erro, exception) {
                    navigator.notification.alert(erro.response.Text);
                }
            });
        } 
         return false;
    });
    
    $(document).on("click", "#btnIncluirProd", function(evt)
    {
        if ($("#txtNomeProd").val() == "")
        {
            navigator.notification.alert("Campo Nome do Produto obrigatório!");
        }

        else if ($("#txtValorProd").val() == "")
        {
            navigator.notification.alert("Campo Valor do Produto obrigatório!");
        }
        else if ($("#txtQuantidadeProd").val() == "")
        {
            navigator.notification.alert("Campo Quantidade do Produto obrigatório!");
        }
        else
        {
            $.ajax({
                type: "post",
                url: $server + "frmBancoDados.php",
                data: {
                    acao: "incluirProduto",
                    fornecedorproduto: $("#txtFornecedorProduto option:selected").text(),
                    nomeprod: $("#txtNomeProd").val(),
                    valorprod: $("#txtValorProd").val(),
                    quantidadeprod: $("#txtQuantidadeProd").val()
                },
                dataType: "text",
                success: function(data){
                    navigator.notification.alert(data);
                },
                error: function(erro, exception){
                    navigator.notification.alert(erro.response.Text);
                }
            });
        }
        
        return false;
        
    });
    
        
    $(document).on("click", "#btnExcluirProd", function(evt)
    {
        if ($("#txtCodigoProd").val() == "")
        {
            navigator.notification.alert("Campo Código obrigatório!");
        }
        else
        {
            $.ajax({
                type: "post",
                url: $server + "frmBancoDados.php",
                data: {
                    acao: "excluirProduto",
                    codigoprod: $("#txtCodigoProd").val()
                },
                dataType: "text",
                success: function(data){
                    navigator.notification.alert(data);
                },
                error: function(erro, exception){
                    navigator.notification.alert(erro.response.Text);
                }
            });
        }
          
         return false;
    });
    

    $(document).on("click", "#lvVoltarSide", function(evt)
    {
         /*global activate_subpage */
         activate_subpage("#frmHome"); 
         return false;
    });
    
        
    $(document).on("click", "#lvAdminSide", function(evt)
    {
         /*global activate_subpage */
         activate_subpage("#frmAdm"); 
         return false;
    });
    
    $(document).on("click", "#btnAtivarSide", function(evt)
    {
         /*global uib_sb */
         /* Other possible functions are: 
           uib_sb.open_sidebar($sb)
           uib_sb.close_sidebar($sb)
           uib_sb.toggle_sidebar($sb)
            uib_sb.close_all_sidebars()
          See js/sidebar.js for the full sidebar API */
        
         uib_sb.toggle_sidebar($("#sdbMenu"));  
         return false;
    });
    
    $(document).on("click", "#btnFecharSide", function(evt)
    {
         /*global uib_sb */
         /* Other possible functions are: 
           uib_sb.open_sidebar($sb)
           uib_sb.close_sidebar($sb)
           uib_sb.toggle_sidebar($sb)
            uib_sb.close_all_sidebars()
          See js/sidebar.js for the full sidebar API */
        
         uib_sb.toggle_sidebar($("#sdbMenu"));  
         return false;
    });
    
        
    $(document).on("click", "#lvProdutosAdmin", function(evt)
    {
         /*global activate_subpage */
         activate_subpage("#frmProduto"); 
         return false;
    });
    
       
    $(document).on("click", "#lvPedidosAdmin", function(evt)
    {
         /*global activate_subpage */
         activate_subpage("#frmPedido");
        $("#txtUsuarioPedido").val($("#txtUsuarioLogin").val());
         return false;
    });
    
    $(document).on("click", "#lvCaixaAdmin", function(evt)
    {
         /*global activate_subpage */
         activate_subpage("#frmCaixa"); 
         return false;
    });
    
    $(document).on("click", "#btnLimparProd", function(evt)
    {
        $("#txtCodigoProd").val("");
        $("#txtNomeProd").val("");
        $("#txtValorProd").val("");
        $("#txtQuantidadeProd").val("");

         return false;
    });
    
    $(document).on("click", "#btnIncluirPedido", function(evt)
    {
        if ($("#txtStatusPedido").val() == "")
        {
            navigator.notification.alert("Campo Status do Pedido obrigatório!");
        }
        else if ($("#txtDataHoraPedido").val() == "")
        {
            navigator.notification.alert("Campo Data e Hora obrigatório!");
        }
        else
        {
            $.ajax({
                type: "post",
                url: $server + "frmBancoDados.php",
                data: {
                    acao: "incluirPedido",
                    statuspedido: $("#txtStatusPedido").val(),
                    usuariopedido: $("#txtUsuarioPedido").val(),
                    datahorapedido: $("#txtDataHoraPedido").val()
                },
                dataType: "text",
                success: function(data){
                    navigator.notification.alert(data);
                },
                error: function(erro, exception){
                    navigator.notification.alert(erro.response.Text);
                }
            });
        }
         return false;
    });
    
    $(document).on("click", "#btnAlterarPedido", function(evt)
    {
        if ($("#txtCodigoPedido").val() == "")
        {
            navigator.notification.alert("Campo Código do Pedido obrigatório!");
        }
        else if ($("#txtStatusPedido").val() == "")
        {
            navigator.notification.alert("Campo Status do Pedido obrigatório!");
        }
        else if ($("#txtDataHoraPedido").val() == "")
        {
            navigator.notification.alert("Campo Data e Hora obrigatório!");
        }
        else
        {
            $.ajax({
                type: "post",
                url: $server + "frmBancoDados.php",
                data: {
                    acao: "alterarPedido",
                    codigopedido: $("#txtCodigoPedido").val(),
                    statuspedido: $("#txtStatusPedido").val(),
                    datahorapedido: $("#txtDataHoraPedido").val()
                },
                dataType: "text",
                success: function(data){
                    navigator.notification.alert(data);
                },
                error: function(erro, exception){
                    navigator.notification.alert(erro.response.Text);
                }
            });
        }
         return false;
    });
    
    $(document).on("click", "#btnExcluirPedido", function(evt)
    {
        if ($("#txtCodigoPedido").val() == "")
        {
            navigator.notification.alert("Campo Código do Pedido obrigatório!");
        }
        else
        {
            $.ajax({
                type: "post",
                url: $server + "frmBancoDados.php",
                data: {
                    acao: "excluirPedido",
                    codigopedido: $("#txtCodigoPedido").val()
                },
                dataType: "text",
                success: function(data){
                    navigator.notification.alert(data);
                },
                error: function(erro, exception){
                    navigator.notification.alert(erro.response.Text);
                }
            });
        }
         return false;
    });
    
        /* button  #btnCarrinhoCompra */
    
    
        /* button  #btnCadastrarFornecedor */
    $(document).on("click", "#btnCadastrarFornecedor", function(evt)
    {
        if ($("#txtNomeFornecedorCad").val() == "")
        {
            navigator.notification.alert("Campo Nome do Fornecedor obrigatório!");
        }
        else if ($("#txtCnpjCad").val() == "")
        {
            navigator.notification.alert("Campo CNPJ do fornecedor obrigatório!");
        }
        else
        {
            $.ajax({
                type: "post",
                url: $server + "frmBancoDados.php",
                data: {
                    acao: "cadastrarFornecedor",
                    nomefornecedor: $("#txtNomeFornecedorCad").val(),
                    cnpj: $("#txtCnpjCad").val()
                },
                dataType: "text",
                success: function(data){
                    navigator.notification.alert(data);
                },
                error: function(erro, exception){
                    navigator.notification.alert(erro.response.Text);
                }
            });
        }
         return false;
    });
    
        /* listitem  #lvFornecedoresAdmin */
    $(document).on("click", "#lvFornecedoresAdmin", function(evt)
    {
         /*global activate_subpage */
         activate_subpage("#frmForncedores"); 
         return false;
    });
    
        /* button  #btnLimparFornecedor */
    $(document).on("click", "#btnLimparFornecedor", function(evt)
    {
        $("#txtNomeFornecedorCad").val("");
        $("#txtCnpjCad").val("");
        $("#txtCodigoFornecedorCad").val("");
         return false;
    });
    
        /* button  #btnExcluirFornecedor */
    $(document).on("click", "#btnExcluirFornecedor", function(evt)
    {
       if ($("#txtCodigoFornecedorCad").val() == "")
        {
            navigator.notification.alert("Campo Código do Fornecedor obrigatório!");
        }
        else
        {
            $.ajax({
                type: "post",
                url: $server + "frmBancoDados.php",
                data: {
                    acao: "excluirFornecedor",
                    codigofornecedor: $("#txtCodigoFornecedorCad").val()
                },
                dataType: "text",
                success: function(data){
                    navigator.notification.alert(data);
                },
                error: function(erro, exception){
                    navigator.notification.alert(erro.response.Text);
                }
            });
        }
         return false;
    });
     
        /* button  #btnCarrinhoCompra */
    $(document).on("click", "#btnCarrinhoCompra", function(evt)
    {
         /*global activate_subpage */
         activate_subpage("#frmCarrinho"); 
         return false;
    });
    
        /* button  #btnFinalizarCompra */
    $(document).on("click", "#btnFinalizarCompra", function(evt)
    {
//        $.ajax({
//            type: "POST",
//            url: $server + "frmBancoDados.php",
//            data: {
//                acao: "incluirPedido",
//                statuspedido: "Aberto",
//                usuariopedido: $("#txtUsuarioLogin").val(),
//                datahorapedido: "2019-11-21T20:31"
//            },
//            dataType: "text",
//            success: function(data){
//                //navigator.notification.alert(data);
//                
//                $idPedidoCompraAtual = data;
//            },
//            error: function(erro, exception){
//                navigator.notification.alert(erro.response.Text);
//            }
//        });
//        
        $.ajax({
            type: "post",
            url: $server + "frmBancoDados.php",
            data: {
                acao: "finalizarCompra",
                statuspedido: "Aberto",
                usuariopedido: $("#txtUsuarioLogin").val(),
                datahorapedido: "2019-11-21T20:31"
            },
            dataType: "text",
            success: function(data){
                navigator.notification.alert(data);
                if (data == "OK")
                {
                    activate_subpage("#frmFinalizarPedido"); 
                }
            },
            error: function(erro, exception){
                navigator.notification.alert(erro.response.Text);
            }
        });  

         return false;
    });
    
        /* button  #btnVoltarCompraConcluida */
    $(document).on("click", "#btnVoltarCompraConcluida", function(evt)
    {
         /*global activate_subpage */
         activate_subpage("#frmHome"); 
         return false;
    });
    
        /* button  #btnFecharCaixa */
    $(document).on("click", "#btnFecharCaixa", function(evt)
    {
       $.ajax({
            type: "post",
            url: $server + "frmBancoDados.php",
            data: {
                acao: "fecharCaixa",
                datacaixa: $("#txtDataHoraCaixa").val(),
                nomefuncionario: $("#txtNomeFuncionarioCaixa").val(),
                idpedido: $("#txtIdPedidoCaixa").val(),
                nomeusuario: $("#txtNomeUsuarioCaixa").val()
            },
            dataType: "text",
            success: function(data){
                navigator.notification.alert(data);
            },
            error: function(erro, exception){
                navigator.notification.alert(erro.response.Text);
            }
        });  
        
        return false;
    });
    
    }
 document.addEventListener("app.Ready", register_event_handlers, false);
})();
