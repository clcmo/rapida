<?php
	include('main.php');
	$checked1 = $checked2 = '';
	$article_message = 'Conjunto de disciplinas previamente estabelecidas para determinado assunto';
    $nome_cur = 'Informe o nome do curso';

	if(isset($_GET['id'])){
		$sql = $Tables->LoadFrom('cursos WHERE id_cur = '.$_GET['id']);
    	$query = $PDO->query($sql) or die ($PDO);
		while($row = $query->fetch(PDO::FETCH_OBJ)){
			$id = $row->id_cur;
			$nome_cur = $title_message = $row->nome_cur;
			/*switch ($row->id_cur) {
				case 1:
					$article_message = '
						<p>Nesta modalidade de ensino, o aluno cursará o Ensino Médio estruturado em conjunto com a formação de Técnico em Administração, numa jornada de até 40 aulas semanais (até 8 aulas diárias), em cada uma das 3 séries. Ao final do curso, o aluno terá concluído o Ensino Médio e obterá, também, o diploma de Técnico em Administração, com validade nacional, de acordo com o perfil profissional a seguir: O TÉCNICO EM ADMINISTRAÇÃO é o profissional que adota postura ética na execução da rotina administrativa, na elaboração do planejamento da produção e materiais, recursos humanos, financeiros e mercadológicos. Realiza atividades de controle e auxilia nos processos de direção, utilizando ferramentas da informática. Fomenta ideias e práticas empreendedoras. Desempenha suas atividades observando as normas de segurança, saúde e higiene do trabalho, bem como as de preservação ambiental.</p>
						<p>Eixo Tecnológico: GESTÃO E NEGÓCIOS</p>
						<p>Mercado de trabalho: instituições públicas, privadas e do terceiro setor.</p>';
						//criar seção de descrição no banco de dados para $article_message
				break;
				
				default:
					# code...
				break;
			}*/

			//atualizar script de checagem do tipo do curso
			$checked1 = ($row->tipo_cur == 1) ? 'checked' : '';
			$checked2 = ($row->tipo_cur == 2) ? 'checked' : '';
		}
	}
    