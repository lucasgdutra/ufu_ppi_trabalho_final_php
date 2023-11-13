<?php
$links = ["/css/jogo.css"];
include '../includes/navbar.php'; ?>
<main class="container">
  <div class="mt-5 d-flex flex-row justify-content-between">
    <h5>Pares encontrados: <span id="score">0</span></h5>
    <h5>Quantidade de movimentos: <span id="moves">0</span></h5>
    <h5>Tempo: <span id="time">00:00</span></h5>
  </div>
  <div class="d-flex gap-1 justify-content-evenly my-5 flex-wrap">
    <div class="flip-card">
      <div class="card flip-card-inner" data-animal-id="boto-cor-de-rosa">
        <div class="flip-card-back">
          <img src="/img/boto-pequeno.webp" class="card-img-top" alt="boto-cor-de-rosa" width="333" height="250" loading="lazy" decoding="async" />
          <div class="card-body p-1 pt-0">
            <h5 class="card-title">boto-cor-de-rosa</h5>
            <h6 class="card-subtitle mb-2 text-muted">inia geoffrensis</h6>
            <h6 class="card-subtitle mb-2 text-muted">Mamífero</h6>
            <span class="badge text-bg-danger">Risco de Extinção Alto</span>
          </div>
        </div>
        <div class="flip-card-front d-flex flex-column justify-content-start">
          <img src="/img/card-back.webp" class="card-img-top" alt="Desenho de verso da carta, contendo dois animais centralizados, onça pintada e arara azul, ao fundo uma floresta cortado por um rio" width="143" height="250" loading="lazy" decoding="async" />

          <span class="text-center text-wrap fs-5">(Clique para virar a carta)</span>
        </div>
      </div>
    </div>
    <div class="flip-card">
      <div class="card flip-card-inner" data-animal-id="jabuti">
        <div class="flip-card-back">
          <img src="/img/jabuti-pequeno.webp" class="card-img-top" alt="jabuti" width="187" height="250" loading="lazy" decoding="async" />
          <div class="card-body p-1 pt-0">
            <h5 class="card-title">jabuti</h5>
            <h6 class="card-subtitle mb-2 text-muted">
              chelonoidis denticulata
            </h6>
            <h6 class="card-subtitle mb-2 text-muted">Réptil</h6>
            <span class="badge text-bg-warning">Risco de Extinção Médio</span>
          </div>
        </div>
        <div class="flip-card-front d-flex flex-column justify-content-start">
          <img src="/img/card-back.webp" class="card-img-top" alt="Desenho de verso da carta, contendo dois animais centralizados, onça pintada e arara azul, ao fundo uma floresta cortado por um rio" width="143" height="250" loading="lazy" decoding="async" />

          <span class="text-center text-wrap fs-5">(Clique para virar a carta)</span>
        </div>
      </div>
    </div>
    <div class="flip-card">
      <div class="card flip-card-inner" data-animal-id="tucano">
        <div class="flip-card-back">
          <img src="/img/tucano-pequeno.webp" class="card-img-top" alt="tucano" width="405" height="250" loading="lazy" decoding="async" />
          <div class="card-body p-1 pt-0">
            <h5 class="card-title">tucano</h5>
            <h6 class="card-subtitle mb-2 text-muted">ramphastos toco</h6>
            <h6 class="card-subtitle mb-2 text-muted">Ave</h6>
            <span class="badge text-bg-warning">Risco de Extinção Médio</span>
          </div>
        </div>
        <div class="flip-card-front d-flex flex-column justify-content-start">
          <img src="/img/card-back.webp" class="card-img-top" alt="Desenho de verso da carta, contendo dois animais centralizados, onça pintada e arara azul, ao fundo uma floresta cortado por um rio" width="143" height="250" loading="lazy" decoding="async" />

          <span class="text-center text-wrap fs-5">(Clique para virar a carta)</span>
        </div>
      </div>
    </div>
    <div class="flip-card">
      <div class="card flip-card-inner" data-animal-id="onça">
        <div class="flip-card-back">
          <img src="/img/onca-pequeno.webp" class="card-img-top" alt="onça" width="250" height="250" loading="lazy" decoding="async" />
          <div class="card-body p-1 pt-0">
            <h5 class="card-title">onça</h5>
            <h6 class="card-subtitle mb-2 text-muted">panthera onca</h6>
            <h6 class="card-subtitle mb-2 text-muted">Mamífero</h6>
            <span class="badge text-bg-success">Risco de Extinção Baixo</span>
          </div>
        </div>
        <div class="flip-card-front d-flex flex-column justify-content-start">
          <img src="/img/card-back.webp" class="card-img-top" alt="Desenho de verso da carta, contendo dois animais centralizados, onça pintada e arara azul, ao fundo uma floresta cortado por um rio" width="143" height="250" loading="lazy" decoding="async" />

          <span class="text-center text-wrap fs-5">(Clique para virar a carta)</span>
        </div>
      </div>
    </div>
    <div class="flip-card">
      <div class="card flip-card-inner" data-animal-id="arara-azul">
        <div class="flip-card-back">
          <img src="/img/arara-azul-pequeno.webp" class="card-img-top" alt="arara-azul" width="375" height="250" loading="lazy" decoding="async" />
          <div class="card-body p-1 pt-0">
            <h5 class="card-title">arara-azul</h5>
            <h6 class="card-subtitle mb-2 text-muted">
              anodorhynchus hyacinthinus
            </h6>
            <h6 class="card-subtitle mb-2 text-muted">Ave</h6>
            <span class="badge text-bg-danger">Risco de Extinção Alto</span>
          </div>
        </div>
        <div class="flip-card-front d-flex flex-column justify-content-start">
          <img src="/img/card-back.webp" class="card-img-top" alt="Desenho de verso da carta, contendo dois animais centralizados, onça pintada e arara azul, ao fundo uma floresta cortado por um rio" width="143" height="250" loading="lazy" decoding="async" />

          <span class="text-center text-wrap fs-5">(Clique para virar a carta)</span>
        </div>
      </div>
    </div>
    <div class="flip-card">
      <div class="card flip-card-inner" data-animal-id="tucano">
        <div class="flip-card-back">
          <img src="/img/tucano-pequeno.webp" class="card-img-top" alt="tucano" width="405" height="250" loading="lazy" decoding="async" />
          <div class="card-body p-1 pt-0">
            <h5 class="card-title">tucano</h5>
            <h6 class="card-subtitle mb-2 text-muted">ramphastos toco</h6>
            <h6 class="card-subtitle mb-2 text-muted">Ave</h6>
            <span class="badge text-bg-warning">Risco de Extinção Médio</span>
          </div>
        </div>
        <div class="flip-card-front d-flex flex-column justify-content-start">
          <img src="/img/card-back.webp" class="card-img-top" alt="Desenho de verso da carta, contendo dois animais centralizados, onça pintada e arara azul, ao fundo uma floresta cortado por um rio" width="143" height="250" loading="lazy" decoding="async" />

          <span class="text-center text-wrap fs-5">(Clique para virar a carta)</span>
        </div>
      </div>
    </div>
    <div class="flip-card">
      <div class="card flip-card-inner" data-animal-id="jabuti">
        <div class="flip-card-back">
          <img src="/img/jabuti-pequeno.webp" class="card-img-top" alt="jabuti" width="187" height="250" loading="lazy" decoding="async" />
          <div class="card-body p-1 pt-0">
            <h5 class="card-title">jabuti</h5>
            <h6 class="card-subtitle mb-2 text-muted">
              chelonoidis denticulata
            </h6>
            <h6 class="card-subtitle mb-2 text-muted">Réptil</h6>
            <span class="badge text-bg-warning">Risco de Extinção Médio</span>
          </div>
        </div>
        <div class="flip-card-front d-flex flex-column justify-content-start">
          <img src="/img/card-back.webp" class="card-img-top" alt="Desenho de verso da carta, contendo dois animais centralizados, onça pintada e arara azul, ao fundo uma floresta cortado por um rio" width="143" height="250" loading="lazy" decoding="async" />

          <span class="text-center text-wrap fs-5">(Clique para virar a carta)</span>
        </div>
      </div>
    </div>
    <div class="flip-card">
      <div class="card flip-card-inner" data-animal-id="onça">
        <div class="flip-card-back">
          <img src="/img/onca-pequeno.webp" class="card-img-top" alt="onça" width="250" height="250" loading="lazy" decoding="async" />
          <div class="card-body p-1 pt-0">
            <h5 class="card-title">onça</h5>
            <h6 class="card-subtitle mb-2 text-muted">panthera onca</h6>
            <h6 class="card-subtitle mb-2 text-muted">Mamífero</h6>
            <span class="badge text-bg-success">Risco de Extinção Baixo</span>
          </div>
        </div>
        <div class="flip-card-front d-flex flex-column justify-content-start">
          <img src="/img/card-back.webp" class="card-img-top" alt="Desenho de verso da carta, contendo dois animais centralizados, onça pintada e arara azul, ao fundo uma floresta cortado por um rio" width="143" height="250" loading="lazy" decoding="async" />

          <span class="text-center text-wrap fs-5">(Clique para virar a carta)</span>
        </div>
      </div>
    </div>
    <div class="flip-card">
      <div class="card flip-card-inner" data-animal-id="boto-cor-de-rosa">
        <div class="flip-card-back">
          <img src="/img/boto-pequeno.webp" class="card-img-top" alt="boto-cor-de-rosa" width="333" height="250" loading="lazy" decoding="async" />
          <div class="card-body p-1 pt-0">
            <h5 class="card-title">boto-cor-de-rosa</h5>
            <h6 class="card-subtitle mb-2 text-muted">inia geoffrensis</h6>
            <h6 class="card-subtitle mb-2 text-muted">Mamífero</h6>
            <span class="badge text-bg-danger">Risco de Extinção Alto</span>
          </div>
        </div>
        <div class="flip-card-front d-flex flex-column justify-content-start">
          <img src="/img/card-back.webp" class="card-img-top" alt="Desenho de verso da carta, contendo dois animais centralizados, onça pintada e arara azul, ao fundo uma floresta cortado por um rio" width="143" height="250" loading="lazy" decoding="async" />

          <span class="text-center text-wrap fs-5">(Clique para virar a carta)</span>
        </div>
      </div>
    </div>
    <div class="flip-card">
      <div class="card flip-card-inner" data-animal-id="pirarucu">
        <div class="flip-card-back">
          <img src="/img/pirarucu-pequeno.webp" class="card-img-top" alt="pirarucu" width="333" height="250" loading="lazy" decoding="async" />
          <div class="card-body p-1 pt-0">
            <h5 class="card-title">pirarucu</h5>
            <h6 class="card-subtitle mb-2 text-muted">arapaima gigas</h6>
            <h6 class="card-subtitle mb-2 text-muted">Peixe</h6>
            <span class="badge text-bg-success">Risco de Extinção Baixo</span>
          </div>
        </div>
        <div class="flip-card-front d-flex flex-column justify-content-start">
          <img src="/img/card-back.webp" class="card-img-top" alt="Desenho de verso da carta, contendo dois animais centralizados, onça pintada e arara azul, ao fundo uma floresta cortado por um rio" width="143" height="250" loading="lazy" decoding="async" />

          <span class="text-center text-wrap fs-5">(Clique para virar a carta)</span>
        </div>
      </div>
    </div>
    <div class="flip-card">
      <div class="card flip-card-inner" data-animal-id="arara-azul">
        <div class="flip-card-back">
          <img src="/img/arara-azul-pequeno.webp" class="card-img-top" alt="arara-azul" width="375" height="250" loading="lazy" decoding="async" />
          <div class="card-body p-1 pt-0">
            <h5 class="card-title">arara-azul</h5>
            <h6 class="card-subtitle mb-2 text-muted">
              anodorhynchus hyacinthinus
            </h6>
            <h6 class="card-subtitle mb-2 text-muted">Ave</h6>
            <span class="badge text-bg-danger">Risco de Extinção Alto</span>
          </div>
        </div>
        <div class="flip-card-front d-flex flex-column justify-content-start">
          <img src="/img/card-back.webp" class="card-img-top" alt="Desenho de verso da carta, contendo dois animais centralizados, onça pintada e arara azul, ao fundo uma floresta cortado por um rio" width="143" height="250" loading="lazy" decoding="async" />

          <span class="text-center text-wrap fs-5">(Clique para virar a carta)</span>
        </div>
      </div>
    </div>
    <div class="flip-card">
      <div class="card flip-card-inner" data-animal-id="pirarucu">
        <div class="flip-card-back">
          <img src="/img/pirarucu-pequeno.webp" class="card-img-top" alt="pirarucu" width="333" height="250" loading="lazy" decoding="async" />
          <div class="card-body p-1 pt-0">
            <h5 class="card-title">pirarucu</h5>
            <h6 class="card-subtitle mb-2 text-muted">arapaima gigas</h6>
            <h6 class="card-subtitle mb-2 text-muted">Peixe</h6>
            <span class="badge text-bg-success">Risco de Extinção Baixo</span>
          </div>
        </div>
        <div class="flip-card-front d-flex flex-column justify-content-start">
          <img src="/img/card-back.webp" class="card-img-top" alt="Desenho de verso da carta, contendo dois animais centralizados, onça pintada e arara azul, ao fundo uma floresta cortado por um rio" width="143" height="250" loading="lazy" decoding="async" />

          <span class="text-center text-wrap fs-5">(Clique para virar a carta)</span>
        </div>
      </div>
    </div>
  </div>
</main>
<?php
$scripts = [
  "/js/jogo.js",
];
include '../includes/footer.php'; ?>