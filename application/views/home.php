<style>
    .maiuscula{
        text-transform:capitalize;
    }
</style>
<script src="<?php echo (base_url('assets/js/home/pessoa.js')) ?>" type="text/javascript"></script>
<script src="<?php echo (base_url('assets/js/home/conta.js')) ?>" type="text/javascript"></script>
<script src="<?php echo (base_url('assets/js/home/movimentacao.js')) ?>" type="text/javascript"></script>
<div class="content-wrapper" style="margin-left: 0px; min-height: 800px;">
    <br>
    <section class="content">
      <div class="container-fluid">

        <div class="row">
          <div class="col-12">
            <!-- Custom Tabs -->
            <div class="card">
              <div class="card-header d-flex p-0">
                <ul class="nav nav-pills ml-auto p-2">
                  <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">Pessoa</a></li>
                  <li class="nav-item" id="openConta"><a class="nav-link" href="#tab_2" data-toggle="tab">Conta</a></li>
                  <li class="nav-item" id="openMovimentacao"><a class="nav-link" href="#tab_3" data-toggle="tab">Movimentação</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="tab-pane active" id="tab_1">
                    <form method="post" name="formularioPessoa" id="formularioPessoa">
                        <input type="hidden" id="id_pessoa" name="id_pessoa" value="">
                        <div class="row">    
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nome <span style="color:red;">*</span></label>
                                    <input type="text" class="form-control maiuscula" name="pessoa_nome" id="pessoa_nome">
                                </div>
                            </div> 
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>CPF <span style="color:red;">*</span></label>
                                    <input type="text" class="form-control" name="pessoa_cpf" id="pessoa_cpf" data-inputmask='"mask": "999.999.999-99"' data-mask>
                                </div>
                            </div>              
                        </div>  
                        <div class="row">    
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>CEP <span style="color:red;">*</span></label>
                                    <input type="number" class="form-control" name="pessoa_cep" id="pessoa_cep" size="10" maxlength="9">                            
                                </div>
                            </div> 
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Número</label>
                                    <input type="number" class="form-control" name="pessoa_numero" id="pessoa_numero">
                                </div>
                            </div>  
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Logradouro</label>
                                    <input type="text" class="form-control" name="pessoa_logradouro" id="pessoa_logradouro">   
                                </div>
                            </div>              
                        </div>  
                        <div class="row">    
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Bairro</label>
                                    <input type="text" class="form-control" name="pessoa_bairro" id="pessoa_bairro">                            
                                </div>
                            </div> 
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Estado</label>
                                    <input type="text" class="form-control" name="pessoa_estado" id="pessoa_estado">                                                            
                                </div>
                            </div>  
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Município</label>
                                    <input type="text" class="form-control" name="pessoa_municipio" id="pessoa_municipio">   
                                </div>
                            </div>              
                        </div>
                        <div class="row">   
                            <div class="col-md-12">
                                <button type="button" onclick="salvar_pessoa()" class="btn btn-primary pull-right">Salvar</button>
                            </div>                    
                        </div> 
                    </form>
                    <hr>
                    <div class="table-responsive">
                        <table id="table-pessoa" class="table table-bordered table-striped table-hover" style=" width: 100%;">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>CPF</th> 
                                    <th>Endereço</th> 
                                    <th style="width: 30px;">Editar</th>              
                                    <th style="width: 30px;">Remover</th> 
                                </tr>
                            </thead>
                            <tbody></tbody>                                                                
                        </table>
                    </div>
                </div>

                <div class="tab-pane" id="tab_2">
                    <form method="post" name="formularioConta" id="formularioConta">
                        <input type="hidden" id="id_conta" name="id_conta" value="">
                        <div class="row">    
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Pessoa <span style="color:red;">*</span></label>
                                    <select class="form-control select_2" name="conta_pessoa" id="conta_pessoa" style="width: 100%;">
                                    </select>   
                                </div>
                            </div> 
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Número da Conta</label>
                                    <input type="number" class="form-control" name="conta_numero" id="conta_numero">
                                </div>
                            </div>              
                        </div>  
                        <div class="row">   
                            <div class="col-md-12">
                                <button type="button" onclick="salvar_conta()" class="btn btn-primary pull-right">Salvar</button>
                            </div>                    
                        </div> 
                    </form>
                    <hr>
                    <div class="table-responsive">
                        <table id="table-conta" class="table table-bordered table-striped table-hover" style=" width: 100%;">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>CPF</th> 
                                    <th>Número da Conta</th> 
                                    <th style="width: 30px;">Editar</th>              
                                    <th style="width: 30px;">Remover</th> 
                                </tr>
                            </thead>
                            <tbody></tbody>                                                                
                        </table>
                    </div>
                </div>
                  
                <div class="tab-pane" id="tab_3">
                    <form method="post" name="formularioMovimentacao" id="formularioMovimentacao">
                        <div class="row">    
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Pessoa <span style="color:red;">*</span></label>
                                    <select class="form-control select_2" name="movimentacao_pessoa" id="movimentacao_pessoa" style="width: 100%;" onchange="changeNumeroConta(this.options[this.selectedIndex].value)">
                                    </select>   
                                </div>
                            </div> 
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Número da Conta <span style="color:red;">*</span></label>
                                    <select class="form-control" name="movimentacao_numero" id="movimentacao_numero" style="width: 100%;" onchange="table_movimentacao(this.options[this.selectedIndex].value);verificaSaldo(this.options[this.selectedIndex].value);">
                                    </select>  
                                </div>
                            </div>              
                        </div> 
                        <div class="row">    
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Depositar/Retirar <span style="color:red;">*</span></label>
                                    <select class="form-control" name="movimentacao_depositar_retirar" id="movimentacao_depositar_retirar">
                                        <option value="">Selecione</option>
                                        <option value="depositar">Depositar</option>
                                        <option value="retirar">Retirar</option>
                                    </select> 
                                </div>
                            </div>  
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Valor <span style="color:red;">*</span></label>
                                    <input type="number" class="form-control" name="movimentacao_valor" id="movimentacao_valor">  
                                </div>
                            </div> 
                                 
                        </div> 
                        <div class="row">   
                            <div class="col-md-12">
                                <button type="button" onclick="salvar_movimentacao()" class="btn btn-primary pull-right">Salvar</button>
                            </div>                    
                        </div> 
                    </form>
                    <hr>
                    <div class="table-responsive">
                        <table id="table-movimentacao" class="table table-bordered table-striped table-hover" style=" width: 100%;">
                            <thead>
                                <tr>
                                    <th>Data</th>              
                                    <th>Valor</th> 
                                </tr>
                            </thead>
                            <tbody></tbody>                                                                
                        </table>
                        <h5>Saldo: R$ <span id="saldo"></span></h5>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>