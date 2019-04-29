<?php
  include ('header.php');
  switch ($Login->IsLogged()) {
    case false:
      ?>
      <div class="column is-4 is-offset-4">
        <h3 class="title is-medium">Cadastrar</h3>
        <p class="subtitle">Insira os dados para continuar.</p>
        <div class="box">
          <figure class="image is-128x128 avatar"><img class="is-rounded" src="<?php echo $Load->Gravatar(); ?>"></figure>
          <form method="post" action="" method="POST">
            <div class="field">
              <div class="control">
                <input class="input is-large" type="email" name="email" placeholder="Seu E-mail" autofocus="">
              </div>
            </div>
            <div class="field">
              <div class="control">
                <input class="input is-large" type="password" name="password" placeholder="<?php echo $password; ?>" autofocus="">
              </div>
            </div>
            <div class="field">
              <div class="control">
                <input class="input is-large" type="password" name="password_conf" placeholder="<?php echo $password_conf; ?>" autofocus="">
              </div>
            </div>
            <div class="field" id="type_use">
              <label class="label">Tipo de Usuário</label>
                <div class="control has-icons-left">
                  <div class="select is-hovered is-link">
                    <select name="type_use">
                      <option value="1">Diretor</option>
                      <option value="2">Coordenador</option>
                      <option value="3">Funcionário</option>
                      <option value="4" disabled>Professor</option>
                      <option value="5" disabled>Aluno</option>
                    </select>
                  </div>
                  <span class="icon is-small is-left"><i class="fas fa-chalkboard-teacher"></i></span>
                </div>
              </div>
            <div class="field"><label class="checkbox"><input type="checkbox">&nbsp;Aceito os Termos</label></div>
            <input class="button is-block is-info is-large is-fullwidth" type="submit" name="signup" value="Cadastrar" />
          </form>
        </div>
        <p class="links">
          <a href="login">Entrar</a> &nbsp;·&nbsp;
          <a href="forgot-pass">Recuperar senha</a> &nbsp;·&nbsp;
          <a href="help">Ajuda</a>
        </p>
        <p class="subtitle is-6">
          <?php
            if(isset($_POST['signup'])) {
              # Resgata variáveis do formulário
              $email = isset($_POST['email']) ? $_POST['email'] : '';
              $password = isset($_POST['password']) ? $_POST['password'] : '';
              $password_conf = isset($_POST['password_conf']) ? $_POST['password_conf'] : '';

              # Verifica se os campos estão vazios e exibe uma mensagem de erro
              if (empty($email) || empty($password) || empty($password_conf)) {
                echo 'Informe o email e a senha.';
                exit;
              }

              if($password != $password_conf){
                echo 'As duas senhas não conferem';
                exit;
              }

              # Verifica se o usuário existe e exibe ou uma mensagem de erro ou vai ao cadastro
              $con = $PDO->prepare($Tables->SelectFrom(null, 'users WHERE email LIKE '.$email.' AND status_use = 1', 0, 1)) or die ($PDO);
              if(count($con) == 1){
                  echo 'E-mail já existe. Deseja <strong><a href="forgot-pass?email='.$email.'">recuperar sua senha</a></strong> ou <strong><a href="login?email='.$email.'">fazer login</a></strong>?';
                  exit;
              }

              # Gerar a critografia da senha
              $password = $Tables->HashStr($password);
              $photo = $Load->Gravatar($email);

              $stmt = $PDO->prepare("INSERT INTO users (email, password, photo, type_use) VALUES (:email, :password, :photo, 1)");
              $stmt->bindParam(':email', $email);
              $stmt->bindParam(':password', $password);
              $stmt->bindParam(':photo', $photo);

              $result = $stmt->execute();
              if ($result){
                  $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
                  if (count($users) <= 0) {
                    echo 'Ops, houve um erro aqui.';
                    exit;
                  }

                  # Busca os resultados e os cataloga com a variável $_SESSION
                  $user = $users[0];
                  #session_start();
                  $_SESSION['logged_in'] = true;
              
                  $_SESSION['id'] = $user['id_use'];
                  $_SESSION['name'] = $user['name_use'];
                  #redireciona para a página de perfil aonde ele finalizará o cadastro  
                  header ('Location: profile');
              }
            }
          ?>
        </p>
      </div>
      <?php
    break;
    case true:
      ?>
      <div class="column is-4 is-offset-4">
        <div class="box">
          <h3 class="title is-medium">Ops</h3>
          <p class="subtitle">Esta página está inacessível, pois a sua seção foi inicializada.</p>
          <p class="links">
            <a href="index">Início</a> &nbsp;·&nbsp;
            <a href="#">Voltar aonde estava</a> &nbsp;·&nbsp;
            <a href="help">Ajuda</a>
          </p>
        </div>
      </div>
      <?php
    break;
  }
  include('footer.php');