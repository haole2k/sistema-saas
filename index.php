<?php
require_once("conexao.php");
$senha = '123';
$senha_crip = md5($senha);

//Criar um usuário caso não tenha nenhum super adm sas
$query = $pdo->query("SELECT * FROM usuarios WHERE nivel = 'SAS'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);

if ($total_reg == 0) {
  $pdo->query("INSERT into usuarios SET empresa = '0', nome = 'Administrador SAS', cpf = '000.000.000-00', email = 'contato@hugocursos.com.br', senha = '$senha', senha_crip = '$senha_crip', ativo = 'Sim', foto = 'sem-foto.jpg', nivel = 'SAS', data = curDate() ");
}

//Criar uma empresa de teste caso não tenha nenhuma
$query = $pdo->query("SELECT * FROM empresas");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);

if ($total_reg == 0) {
  $pdo->query("INSERT into empresas SET nome = 'Empresa Teste', email = 'teste@hotmail.com', telefone = '(00)00000-0000', ativo = 'Sim', data_cad = curDate() ");
  $id_empresa = $pdo->lastInsertId();
  $pdo->query("INSERT into usuarios SET empresa = '$id_empresa', nome = 'Administrador', cpf = '111.111.111-11', email = 'teste@hotmail.com', senha = '$senha', senha_crip = '$senha_crip', ativo = 'Sim', foto = 'sem-foto.jpg', nivel = 'Administrador', data = curDate() ");
}

?>
<!DOCTYPE html>
<html>

<head>
  <title>Sistema SaaS</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link href="./vendor/bootstrap/dist/css/bootstrap.min.css" rel='stylesheet' type='text/css' />
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="/assets/fontawesome/css/all.min.css">
  <link rel="stylesheet" href="/assets/fontawesome/js/all.min.js">

  <link rel="stylesheet" href="css/login.css">
  <link rel="icon" type="image/png" href="img/icone.png" />

  <link type="text/css" href="./vendor/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">

  <link type="text/css" href="./vendor/notyf/notyf.min.css" rel="stylesheet">
  <link type="text/css" href="./css/volt.css" rel="stylesheet">
</head>

<body>
  <main>

    <!-- Section -->
    <section class="vh-lg-100 mt-5 mt-lg-0 bg-soft d-flex align-items-center">
      <div class="container">
        <div class="row justify-content-center form-bg-image" data-background-lg="./assets/img/illustrations/signin1.svg">
          <div class="col-12 d-flex align-items-center justify-content-center">
            <div class="bg-white shadow border-0 rounded border-light p-4 p-lg-5 w-100 fmxw-500">
              <div class="text-center text-md-center mb-4 mt-md-0">
                <img src="img/logo3.png" alt="">
              </div>
              <form action="autenticar.php" method="post" class="mt-4">
                <div class="form-group mb-4">
                  <label for="email">Login</label>
                  <div class="input-group">
                    <span class="input-group-text" id="basic-addon1">
                      <svg class="icon icon-xs text-gray-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                      </svg>
                    </span>
                    <input type="text" name="usuario" class="form-control" Placeholder="Email ou CPF" autofocus required>
                  </div>
                </div>
                <div class="form-group">
                  <div class="form-group mb-4">
                    <label for="password">Senha</label>
                    <div class="input-group">
                      <span class="input-group-text" id="basic-addon2">
                        <svg class="icon icon-xs text-gray-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                          <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                        </svg>
                      </span>
                      <input style="margin: 0;" type="password" name="senha" class="form-control" Placeholder="Senha" required>
                    </div>
                  </div>
                  <div class="d-flex justify-content-between align-items-top mb-4">
                    <div><a data-bs-toggle="modal" data-bs-target="#exampleModal" class="small text-right">Recuperar senha</a></div>
                  </div>
                </div>
                <div class="d-grid">
                  <button type="submit" class="btn btn-gray-800">Login</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
</body>

</html>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="width:350px">
      <div style="width: 100%;display: flex;justify-content: flex-end;align-items: flex-end;padding: 2%;">
        <button type="button" id="btn-fechar-rec" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form method="post" id="form-recuperar">
        <div class="modal-body" style="width:300px">

          <div class="form-group">
            <label for="email">Email</label>
            <div class="input-group">
              <span class="input-group-text" id="basic-addon1">
                <svg class="icon icon-xs text-gray-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                  <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                  <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                </svg>
              </span>
              <input placeholder="Digite seu Email" class="form-control" type="email" name="email" id="email-recuperar" required>
            </div>
          </div>
          <br>
          <button style="width:100%" type="submit" class="btn btn-primary">Recuperar</button>

          <br>
          <small>
            <div id="mensagem-recuperar" align="center"></div>
          </small>
        </div>

      </form>
    </div>
  </div>
</div>


<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<!-- Core -->
<script src="./vendor/@popperjs/core/dist/umd/popper.min.js"></script>
<script src="./vendor/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Vendor JS -->
<script src="./vendor/onscreen/dist/on-screen.umd.min.js"></script>

<!-- Slider -->
<script src="./vendor/nouislider/distribute/nouislider.min.js"></script>

<!-- Smooth scroll -->
<script src="./vendor/smooth-scroll/dist/smooth-scroll.polyfills.min.js"></script>

<!-- Charts -->
<script src="./vendor/chartist/dist/chartist.min.js"></script>
<script src="./vendor/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js"></script>

<!-- Datepicker -->
<script src="./vendor/vanillajs-datepicker/dist/js/datepicker.min.js"></script>

<!-- Sweet Alerts 2 -->
<script src="./vendor/sweetalert2/dist/sweetalert2.all.min.js"></script>

<!-- Moment JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js"></script>

<!-- Vanilla JS Datepicker -->
<script src="./vendor/vanillajs-datepicker/dist/js/datepicker.min.js"></script>

<!-- Notyf -->
<script src="./vendor/notyf/notyf.min.js"></script>

<!-- Simplebar -->
<script src="./vendor/simplebar/dist/simplebar.min.js"></script>

<!-- Github buttons -->
<script async defer src="https://buttons.github.io/buttons.js"></script>

<!-- Volt JS -->
<script src="./assets/js/volt.js"></script>


<script type="text/javascript">
  $("#form-recuperar").submit(function() {

    event.preventDefault();
    var formData = new FormData(this);

    $.ajax({
      url: "recuperar-senha.php",
      type: 'POST',
      data: formData,

      success: function(mensagem) {
        $('#mensagem-recuperar').text('');
        $('#mensagem-recuperar').removeClass()
        if (mensagem.trim() == "Recuperado com Sucesso") {
          //$('#btn-fechar-rec').click();         
          $('#email-recuperar').val('');
          $('#mensagem-recuperar').addClass('text-success')
          $('#mensagem-recuperar').text('Sua Senha foi enviada para o Email')

        } else {

          $('#mensagem-recuperar').addClass('text-danger')
          $('#mensagem-recuperar').text(mensagem)
        }


      },

      cache: false,
      contentType: false,
      processData: false,

    });

  });
</script>