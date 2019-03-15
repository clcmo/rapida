<?php
  /**
   * The login page for our theme.
   *
   * Displays all of form login page
   *
   * @package Milla Meets Bulma
   */
  include('header-index.php');
  include('load/login.php');
?>
  <div class="column is-4 is-offset-4">
    <h3 class="title is-medium">Recuperar</h3>
    <p class="subtitle">Insira os dados para recuperar sua senha.</p>
    <div class="box">
      <figure class="avatar"><img src="<?php echo $picture; ?>"></figure>
      <form method="post" action="">
        <div class="field"><div class="control"><input class="input is-large" type="email" name="email" placeholder="<?php echo $placeholder; ?>" value="<?php echo $email; ?>" autofocus=""></div></div>
        <input class="button is-block is-info is-large is-fullwidth" type="submit" name="recover" value="Recuperar" />
      </form>
    </div>
    <p class="links">
      <a href="signup">Cadastrar</a> &nbsp;·&nbsp;
      <a href="forgot_pass">Recuperar Senha</a> &nbsp;·&nbsp;
      <a href="help">Ajuda</a>
    </p>
    <p class="subtitle is-6">
      <?php
        if(isset($_POST['recover'])) {
          // Resgata variáveis do formulário
          $email = isset($_POST['email']) ? $_POST['email'] : '';

          //Verifica se os campos estão vazios e exibe uma mensagem de erro
          if (empty($email)) {
            echo 'Informe email.';
            exit;
          }

          //verifica se o usuário existe e exibe ou uma mensagem de erro ou vai ao cadastro
          $sql = $Tables->LoadFrom('users WHERE email = '.$email.' AND status_use = 1 LIMIT 1');
          $con = $PDO->prepare($sql) or die ($PDO);
          if(count($con) == 1){
              $password = $Load->RandomPass();
              $password = $Tables->HashStr($password);

              $sql = $Tables->LoadFrom('users WHERE email = '.$email.' AND password = :password AND status_use = 1 LIMIT 1');
              $stmt = $PDO->prepare($sql);
              $stmt->bindParam(':password', $password);
              $stmt->execute();
              $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
              if (count($users) <= 0) {
                echo 'Um erro aconteceu';
                exit;
              }

            //Busca os resultados e os cataloga com a variável $_SESSION
            $user = $users[0];
            //session_start();
            $_SESSION['logged_in'] = true;
            
            $_SESSION['id'] = $user['id_use'];
            $_SESSION['name'] = $user['name_use'];
            header('Location: admin.php');
              //$password = $Tables->HashStr();
              //echo 'Sua nova senha é '.$password;
              //echo 'Sua nova senha será encaminhada por email';
          }
          
         /* //Verificar se o usuário existe e se a senha é a mesma     
          $stmt = $PDO->prepare($sql);
          $stmt->bindParam(':email', $email);
          $stmt->execute();
          $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

          if (count($users) <= 0) {
            echo 'Email ou senha incorretos.';
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

          header('Location: admin.php');*/
        }
      ?>
    </p>
  </div>    
<?php include('footer-index.php'); ?>