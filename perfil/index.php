<?php
// ------------------------------
// PROCESSA ENVIO DE AVALIAÇÕES
// ------------------------------
$arquivo = 'avaliacoes.json';
$avaliacoes = file_exists($arquivo) ? json_decode(file_get_contents($arquivo), true) ?? [] : [];

if (isset($_POST['enviar'])) {
    $nome = htmlspecialchars($_POST['nome']);
    $comentario = htmlspecialchars($_POST['comentario']);
    $avaliacao = intval($_POST['avaliacao']);
    $data = date('d/m/Y H:i');

    $novo = [
        'nome' => $nome,
        'comentario' => $comentario,
        'avaliacao' => $avaliacao,
        'data' => $data
    ];

    $avaliacoes[] = $novo;
    file_put_contents($arquivo, json_encode($avaliacoes));

    // Redireciona para evitar reenvio
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Perfil do Prestador - Prestadores.Net</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="homeperfil.css">
  <link rel="stylesheet" href="mediaperfil.css">
</head>
<body>

<div class="voltar-container">
  <a href="../index.html" class="btn-voltar">← Voltar ao início</a>
  <header>
    <h1 class="titulo-3d-real">Área do profissional</h1>
  </header>
</div>

<main class="perfil-container">

  <div class="foto-perfil">
    <img src="../imagens/eduardommm.webp" alt="Foto do Profissional">
  </div>

  <section class="info-perfil">
    <h2>Eduardo</h2>
    <p class="profissao">Montador de Móveis</p>

    <ul class="campos-adicionais">
      <li><strong>Experiência:</strong> Desde 2009</li>
      <li><strong>Serviços Oferecidos:</strong> Montagem e desmontagem de móveis, instalação de TVs e armários.</li>
    </ul>

    <section class="redes-sociais-container">
      <h2>Redes sociais</h2>
      <div class="redes-sociais">
        <a href="https://www.instagram.com/montadordemoveismaringa/" target="_blank" class="social instagram">
          <i class="fa-brands fa-instagram"></i>
        </a>
        <a href="https://www.facebook.com/Montadormaringa/" target="_blank" class="social facebook">
          <i class="fa-brands fa-facebook-f"></i>
        </a>
        <a href="https://wa.me/message/E2F2BD5UIQKTN1" target="_blank" class="social whatsapp">
          <i class="fa-brands fa-whatsapp"></i>
        </a>
      </div> 
      <section class="galeria">
        <h3>Galeria do profissional</h3>
      
        <div class="carrossel">
          <button class="carrossel-btn prev" aria-label="Imagem anterior">
            <i class="fa-solid fa-chevron-left"></i>
          </button>
      
          <div class="carrossel-track">
            <img src="../imagens/serviços/20260112_100047.jpg" alt="Montagem de móveis">
            <img src="../imagens/serviços/20260112_134344.jpg" alt="Armário montado">
            <img src="../imagens/serviços/20260119_093416.jpg" alt="roupeiro">
            
          </div>
      
          <button class="carrossel-btn next" aria-label="Próxima imagem">
            <i class="fa-solid fa-chevron-right"></i>
          </button>
        </div>
      </section>
    </section>
  </section>
 
      
  <div class="acao-orcamento">
    <a href="https://wa.me/message/E2F2BD5UIQKTN1" target="_blank" class="btn-orcamento-poder">
      Solicitar Orçamento
    </a>
  </div>

  <!-- AVALIAÇÕES -->
  <section class="avaliacoes">
    <h3>Avaliações dos Clientes</h3>
    <p id="avaliacao-clientes">Nos conte sua experiência com esse profissional</p>

    <!-- FORMULÁRIO DE AVALIAÇÃO -->
    <form class="form-avaliacao" action="" method="POST">
  <h4>Deixe sua Avaliação</h4>

  <!-- Nome do cliente -->
  <input type="text" name="nome" placeholder="Seu nome" required><br><br>

  <!-- Avaliação em estrelas -->
  <div class="estrelas">
    <input type="radio" id="star5" name="avaliacao" value="5" required><label for="star5">★</label>
    <input type="radio" id="star4" name="avaliacao" value="4"><label for="star4">★</label>
    <input type="radio" id="star3" name="avaliacao" value="3"><label for="star3">★</label>
    <input type="radio" id="star2" name="avaliacao" value="2"><label for="star2">★</label>
    <input type="radio" id="star1" name="avaliacao" value="1"><label for="star1">★</label>
  </div>

  <!-- Comentário -->
  <textarea name="comentario" placeholder="Escreva seu comentário..." required></textarea><br><br>

  <button type="submit" name="enviar">Enviar Avaliação</button>
</form>


    <!-- LISTAGEM DE AVALIAÇÕES -->
    <div class="carrossel-track-avaliacoes">
    <?php
    foreach($avaliacoes as $avaliacao) {
        $nome = isset($avaliacao['nome']) ? $avaliacao['nome'] : 'Anônimo';
        $estrela = isset($avaliacao['avaliacao']) ? intval($avaliacao['avaliacao']) : 0;
        $comentario = isset($avaliacao['comentario']) ? $avaliacao['comentario'] : '';
        $data = isset($avaliacao['data']) ? $avaliacao['data'] : '';
        echo '<div class="avaliacao-item">';
        echo '<div class="avaliacao-estrelas">'.str_repeat('★', $estrela).'</div>';
        echo '<div class="avaliacao-comentario">'.$comentario.'</div>';
        echo '<div class="avaliacao-data">'.$nome.' '.$data.'</div>';
        echo '</div>';
    }
    ?>
  </div>
  </section>
</main>

<footer>
  <p>O portal dos <span>melhores Prestadores</span> do Brasil</p>
</footer>
<script>
// Carrossel da galeria de fotos
const trackGaleria = document.querySelector('.carrossel-track');
const slidesGaleria = Array.from(trackGaleria.children);
const btnPrev = document.querySelector('.carrossel-btn.prev');
const btnNext = document.querySelector('.carrossel-btn.next');
let indexGaleria = 0;

function updateCarouselGaleria() {
  trackGaleria.style.transform = `translateX(-${indexGaleria * 100}%)`;
}

btnNext.addEventListener('click', () => {
  indexGaleria = (indexGaleria + 1) % slidesGaleria.length;
  updateCarouselGaleria();
});

btnPrev.addEventListener('click', () => {
  indexGaleria = (indexGaleria - 1 + slidesGaleria.length) % slidesGaleria.length;
  updateCarouselGaleria();
});

// Carrossel de avaliações
const trackAvaliacoes = document.querySelector('.carrossel-track-avaliacoes');
const itensAvaliacoes = document.querySelectorAll('.carrossel-track-avaliacoes .avaliacao-item');
let indexAvaliacoes = 0;

function atualizarCarrosselAvaliacoes() {
  itensAvaliacoes.forEach((item, i) => {
    item.classList.toggle('visivel', i === indexAvaliacoes);
  });
  trackAvaliacoes.style.transform = `translateX(-${indexAvaliacoes * 100}%)`;
}

// Inicializa o primeiro item visível
atualizarCarrosselAvaliacoes();

// Rotação automática a cada 4s
if(itensAvaliacoes.length > 0) {
  setInterval(() => {
    indexAvaliacoes = (indexAvaliacoes + 1) % itensAvaliacoes.length;
    atualizarCarrosselAvaliacoes();
  }, 4000);
}
</script>




</body>
</html>