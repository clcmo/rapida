<?php
  /**
   * The login page for our theme.
   *
   * Displays all of form login page
   *
   * @package Bulma by Milla
   */
  include('header-index.php');
  include('load/pages/login.php');
?>
  <div class="column is-4 is-offset-4">
    <h3 class="title is-medium">Login</h3>
    <p class="subtitle">Insira os dados para continuar.</p>
    <div class="box">
      <figure class="image is-128x128 avatar"><img class="is-rounded" src="<?php echo $picture; ?>"></figure>
      <form method="post" action="">
        <div class="field"><div class="control"><input class="input is-large" type="email" name="email" placeholder="<?php echo $placeholder; ?>" value="<?php echo $email; ?>" autofocus=""></div></div>
        <div class="field"><div class="control"><input class="input is-large" type="password" name="password" placeholder="Sua Senha"></div></div>
        <div class="field"><label class="checkbox"><input type="checkbox">&nbsp;Lembre-me</label></div>
        <input class="button is-block is-info is-large is-fullwidth" type="submit" name="signin" value="Entrar" />
      </form>
    </div>
    <p class="links">
      <a href="signup">Cadastrar</a> &nbsp;·&nbsp;
      <a href="forgot_pass">Recuperar Senha</a> &nbsp;·&nbsp;
      <a href="help">Ajuda</a>
    </p>
    <p class="subtitle is-6">
      <?php
        if(isset($_POST['signin'])) {
          // Resgata variáveis do formulário
          $email = isset($_POST['email']) ? $_POST['email'] : '';
          $password = isset($_POST['password']) ? $_POST['password'] : '';

          //Verifica se os campos estão vazios e exibe uma mensagem de erro
          if (empty($email) || empty($password)) {
            echo 'Informe email e senha.';
            exit;
          }

          $password = $Tables->HashStr($password);

          $sql = $Tables->LoadFrom('users WHERE email LIKE :email AND password LIKE :password AND status_use = 1 LIMIT 1');
          
          //Verificar se o usuário existe e se a senha é a mesma     
          $stmt = $PDO->prepare($sql);
          $stmt->bindParam(':email', $email);
          $stmt->bindParam(':password', $password);
          $stmt->execute();
          $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

          if (count($users) <= 0) {
            echo 'Email ou senha incorretos. Deseja <strong><a href="forgot_pass?email='.$email.'">recuperar</a></strong>?';
            exit;
          }

          //Busca os resultados e os cataloga com a variável $_SESSION
          $user = $users[0];
          //session_start();
          $_SESSION['logged_in'] = true;
          
          $_SESSION['id'] = $user['id_use'];
          $_SESSION['name'] = $user['name_use'];
          //$_SESSION['type'] = $user['tipo_usu'];
          //$_SESSION['year_date'] = date('Y', strtotime($user['cadastro']));

          header('Location: admin.php');
        }
      ?>
    </p>
  </div>x
<?php include('footer-index.php'); ?>