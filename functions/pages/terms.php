<?php
	$title = $Load->WhatLink();
	$message = '
		<strong>SEÇÃO 1 - SOBRE A RÁPIDA</strong>
		<br/>Criada em 2019, a Rápida espera em prover a interação compartilhada entre os alunos com os colaboradores da escola.
		<p class="has-text-left">
		<strong>SEÇÃO 2 - PRIVACIDADE E USO DOS DADOS</strong>
		<br/>Com a utilização do serviço terceiro Gravatar, da WordPress, os usuários cadastrados no sistema já contam com o recurso da exibição da foto de perfil no sistema.
		<br/>O recurso coletará apenas o endereço de e-mail registrado no sistema para a aplicação desta imagem.
		<br/>Esta mudança de foto poderá ser feita através de sua página de perfil, entretanto, não será modificada a foto registrada no serviço Gravatar.
		<p class="has-text-left">
		<strong>SEÇÃO 3 - SOBRE OS USUÁRIOS E O CÓDIGO DE CONDUTA</strong>
		<br/>No interesse de promover um ambiente interativo e acolhedor, nós
		colaboradores prometemos fazer esta contribuição para uma experiência livre de comportamentos inadequados para todos.
		<p class="has-text-left">
		<br/>Exemplos de comportamento que contribuem para criar um ambiente positivo devem incluir:
		<ul class="has-text-left">
			<li><strong>Uso de linguagem acolhedora e inclusiva,</strong></li>
			<li><strong>Ser respeitoso com diferentes pontos de vista e experiências,</strong></li>
			<li><strong>Graciosamente aceitando críticas construtivas,</strong></li>
			<li><strong>Focando no que é melhor para a comunidade, e</strong></li>
			<li><strong>Mostrando empatia para com outros membros da comunidade.</strong></li>
		</ul>
		</br>
		<p class="has-text-left">
		Exemplos de comportamento inaceitável pelos participantes incluem:
		<ul class="has-text-left">
			<li><strong>O uso de linguagem ou imagens de conteúdo sexual,</strong></li>
			<li><strong>Trolling, insultos / comentários depreciativos e ataques pessoais ou políticos,</strong></li>
			<li><strong>Assédio público ou privado,</strong></li>
			<li><strong>Publicar informações privadas de outras pessoas, como endereço físico ou eletrônico, sem permissão explícita, e</strong></li>
			<li><strong>Outra conduta que poderia razoavelmente ser considerada inadequada em um ambiente profissional.</strong></li>
		</ul>
		<p class="has-text-left">
		</br>Os mantenedores do projeto são responsáveis ​​por esclarecer os padrões aceitáveis de
		comportamento e espera-se que tomem medidas corretivas apropriadas e justas
		respostas a quaisquer instâncias de comportamento inaceitável.
		</br>Os mantenedores do projeto têm o direito e a responsabilidade de remover, editar ou
		rejeitar contribuições que não estão alinhados com este Código de Conduta, ou banir temporariamente ou
		permanentemente qualquer usuários para outros comportamentos que considerem inadequados, ameaçador, ofensivo ou prejudicial.
		</br>Instâncias de comportamento abusivo, de assédio ou inaceitável podem ser relatadas entrando em contato com a equipe. Todas as reclamações serão analisadas e investigadas e resultarão em uma resposta considerada necessária e apropriada às circunstâncias. A equipe do projeto é obrigada a manter a confidencialidade em relação ao relator de um incidente.
		</br>Mais detalhes sobre políticas de execução específicas podem ser publicados separadamente.
		</br>Os mantenedores do projeto que não seguem ou aplicam o Código de Conduta de boa fé podem enfrentar repercussões temporárias ou permanentes, conforme determinado por outros membros da liderança do projeto.';
		
	include('models/about.php');