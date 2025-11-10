console.log('Botões de excluir detectados:', document.querySelectorAll('.btn-excluir'));




(() => {
  const pwInput = document.getElementById("senha");
  const pwToggle = document.getElementById("pwToggle");
  
if (pwInput && pwToggle) {
  pwToggle.addEventListener("click", () => {
    if (pwInput.type === "password") {
      pwInput.type = "text";
      pwToggle.textContent = "visibility";
    } else {
      pwInput.type = "password";
      pwToggle.textContent = "visibility_off";
    }
  });
}

// para que o botao + funcione
const imgFilePerfil = document.getElementById("imgFilePerfil");
const imgPreviewPerfil = document.getElementById("imgPreviewPerfil");
if (imgFilePerfil && imgPreviewPerfil) {
  imgPreviewPerfil.addEventListener("click", () => imgFilePerfil.click());
  imgFilePerfil.addEventListener("change", (e) => {
    const file = e.target.files[0];
    if (!file || !file.type.startsWith("image/")) {
      imgPreviewPerfil.textContent = "+";
      imgPreviewPerfil.style.backgroundImage = "";
      return;
    }
    const reader = new FileReader();
    reader.onload = (ev) => {
      imgPreviewPerfil.style.backgroundImage = `url(${ev.target.result})`;
      imgPreviewPerfil.style.backgroundSize = "cover";
      imgPreviewPerfil.style.backgroundPosition = "center";
      imgPreviewPerfil.textContent = "";
    };
    reader.readAsDataURL(file);
  });
}

// para que o botao + funcione
const imgFileCapa = document.getElementById("imgFileCapa");
const imgPreviewCapa = document.getElementById("imgPreviewCapa");
if (imgFileCapa && imgPreviewCapa) {
  imgPreviewCapa.addEventListener("click", () => imgFileCapa.click());
  imgFileCapa.addEventListener("change", (e) => {
    const file = e.target.files[0];
    if (!file || !file.type.startsWith("image/")) {
      imgPreviewCapa.textContent = "+";
      imgPreviewCapa.style.backgroundImage = "";
      return;
    }
    const reader = new FileReader();
    reader.onload = (ev) => {
      imgPreviewCapa.style.backgroundImage = `url(${ev.target.result})`;
      imgPreviewCapa.style.backgroundSize = "cover";
      imgPreviewCapa.style.backgroundPosition = "center";
      imgPreviewCapa.textContent = "";
    };
    reader.readAsDataURL(file);
  });
}

// Datalist dinâmico
const input = document.getElementById("cantorFav");
const datalist = document.getElementById("cantores");
if (input && datalist) {
  const options = Array.from(datalist.options).map(o => o.value);

  input.addEventListener("input", () => {
    const query = input.value.toLowerCase();
    datalist.innerHTML = "";
    if (!query) return;
    options.forEach(c => {
      if (c.toLowerCase().includes(query)) {
        const option = document.createElement("option");
        option.value = c;
        datalist.appendChild(option);
      }
    });
  });
}

// Animação de scroll aparece enquanto rola a pagina
function revealOnScroll(selector) {
  const elements = document.querySelectorAll(selector);
  if (!elements.length) return;

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.2 });

  elements.forEach(el => observer.observe(el));
}

revealOnScroll('.stat');
revealOnScroll('.step');
     
document.addEventListener("DOMContentLoaded", () => {
  const btn = document.getElementById('themeToggle');
  const root = document.body;

  // Aplica tema salvo no localStorage
  const current = localStorage.getItem('ss-theme');
  if (current === 'dark') root.classList.add('dark');

  btn.addEventListener('click', () => {
    root.classList.toggle('dark');
    localStorage.setItem('ss-theme', root.classList.contains('dark') ? 'dark' : 'light');
    console.log('Botão clicado!'); // Para testar
  });
});



    document.querySelectorAll('.btn-curtir').forEach(btn => {
    btn.addEventListener('click', function(e){
        e.preventDefault(); // não recarrega a página
        const idpost = this.dataset.id;
        const icon = this.querySelector('i'); // pega o ícone
        const stats = this.closest('.post-card1').querySelector('.stats1');

        fetch('curtir.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'idpost=' + encodeURIComponent(idpost)
        })
        .then(res => res.json())
        .then(data => {
            stats.textContent = data.totalCurtidas + ' Curtidas';

            if(data.status === 'curtido'){
                icon.classList.remove('fa-regular');
                icon.classList.add('fa-solid');
            } else {
                icon.classList.remove('fa-solid');
                icon.classList.add('fa-regular');
            }
        });
    });
    
});
















document.addEventListener('click', async (e) => {
  const botao = e.target.closest('.btn-excluir');
  if (!botao) return;

  e.preventDefault();

  let id = botao.dataset.idpostagens || botao.dataset.id;
  if (!id && botao.href) {
    try {
      const u = new URL(botao.href, window.location.href);
      id = u.searchParams.get('idpostagens') || u.searchParams.get('id');
    } catch {
      const m = botao.href.match(/idpostagens=([^&]+)/) || botao.href.match(/id=([^&]+)/);
      if (m) id = decodeURIComponent(m[1]);
    }
  }
  if (!id) {
    const postAncestor = botao.closest('[data-idpostagens], [data-id]');
    if (postAncestor) id = postAncestor.dataset.idpostagens || postAncestor.dataset.id;
  }

  if (!id) {
    alert('Erro: ID da postagem não encontrado.');
    return;
  }

  if (!confirm('Tem certeza que deseja excluir esta postagem?')) return;

  try {
    const res = await fetch('excluir-postagem.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: new URLSearchParams({ idpostagens: id })
    });

    const data = await res.json();

    if (!data.success) {
      alert(data.message || 'Erro ao excluir a postagem.');
      return;
    }

    // opcional: remove do DOM antes de recarregar
    const postagem = botao.closest('.postagem') || botao.closest('[data-idpostagens]') || botao.closest('[data-id]');
    if (postagem) postagem.remove();

    // recarrega a página para atualizar tudo
    location.reload();

  } catch (err) {
    console.error('[Excluir] erro:', err);
    alert('Não foi possível excluir a postagem.');
  }
});








document.querySelectorAll('.btn-comentar').forEach(btn => {
  btn.addEventListener('click', (e) => {
    e.preventDefault(); // agora funciona
    const idpost = btn.dataset.idpostagens;
    const modalEl = document.getElementById('modalComentarios' + idpost);
    if (!modalEl) return;

    const myModal = new bootstrap.Modal(modalEl, { backdrop: true, keyboard: true });
    myModal.show();

    // Carrega comentários ao abrir
    fetch('buscar-comentarios.php?idpostagens=' + idpost)
      .then(r => r.json())
      .then(comentarios => {
        const lista = document.getElementById('listaComentarios' + idpost);
        if (!lista) return;

        if (!comentarios || comentarios.length === 0) {
          lista.innerHTML = '<p>Nenhum comentário ainda 😶</p>';
        } else {
          lista.innerHTML = comentarios.map(c => `
            <div class="comentario d-flex align-items-start mb-2">
              <img src="uploads/${c.foto_usuario || 'default.jpg'}" class="foto-comentario me-2" style="width:36px;height:36px;border-radius:50%;">
              <div>
                <strong>${c.apelido}</strong>
                <div>${c.texto}</div>
              </div>
            </div>
          `).join('');
          lista.scrollTop = lista.scrollHeight;
        }
      }).catch(() => {
        const lista = document.getElementById('listaComentarios' + idpost);
        if (lista) lista.innerHTML = '<p class="text-danger">Erro ao carregar comentários.</p>';
      });
  });
});


// Enviar comentário
document.addEventListener('click', e => {
  const botao = e.target.closest('.btn-enviar');
  if (!botao) return;

  const id = botao.dataset.idpostagens;
  const input = document.getElementById('inputComentario' + id);
  if (!input || !input.value.trim()) return;

  botao.disabled = true;
  fetch('adicionar_comentario.php', {
    method: 'POST',
    body: new URLSearchParams({ idpostagens: id, texto: input.value }),
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
  })
  .then(r => r.json())
  .then(comentarios => {
    const lista = document.getElementById('listaComentarios' + id);
    if (!lista) return;

    if (!comentarios || comentarios.length === 0) {
      lista.innerHTML = '<p>Nenhum comentário ainda 😶</p>';
    } else {
      lista.innerHTML = comentarios.map(c => `
        <div class="comentario d-flex align-items-start mb-2">
          <img src="uploads/${c.foto_usuario || 'default.jpg'}" class="foto-comentario me-2" style="width:36px;height:36px;border-radius:50%;">
          <div>
            <strong>${c.apelido}</strong>
            <div>${c.texto}</div>
          </div>
        </div>
      `).join('');
      lista.scrollTop = lista.scrollHeight;
    }

    input.value = '';
  })
  .catch(err => console.error(err))
  .finally(() => botao.disabled = false);
});






// ATUALIZA CONTADOR DE SEGUIDOS
async function atualizarContadorSeguidos() {
    try {
        const resposta = await fetch('contar-seguido.php');
        const dados = await resposta.json();
        const contador = document.getElementById('contador-seguido');
        if (contador) {
            contador.textContent = dados.total;
        }
    } catch (err) {
        console.error('Erro ao atualizar contador de seguidos:', err);
    }
}









document.addEventListener('click', async function (e) {
    const btn = e.target.closest('.seguir-btn');
    if (!btn) return;

    e.preventDefault();
    const idseguido = btn.dataset.id;
    const estaSeguindo = btn.classList.contains('seguindo');
    const usuarioItem = btn.closest('.usuario-item');
    const listaSeguindo = document.querySelector('.perfil-lateral .usuarios-lista');

    try {
        const url = estaSeguindo ? 'deixar-de-seguir.php' : 'seguir.php';

        const resposta = await fetch(url, {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'idseguido=' + encodeURIComponent(idseguido)
        });

        const dados = await resposta.json();

        if (dados.success) {
            // Atualiza todos os botões com o mesmo ID
            document.querySelectorAll(`.seguir-btn[data-id="${idseguido}"]`).forEach(outroBtn => {
                if (estaSeguindo) {
                    outroBtn.textContent = 'Seguir';
                    outroBtn.classList.remove('seguindo');
                } else {
                    outroBtn.textContent = 'Seguindo';
                    outroBtn.classList.add('seguindo');
                }
            });

            // Atualiza o número de "Seguindo"
            atualizarContadorSeguidos();

            // Se parou de seguir, remove da lateral
            if (estaSeguindo && usuarioItem && listaSeguindo.contains(usuarioItem)) {
                usuarioItem.style.transition = "all 0.3s ease";
                usuarioItem.style.opacity = "0";
                setTimeout(() => usuarioItem.remove(), 300);
            }

            // Se começou a seguir e veio de outro bloco, move para a lateral
            if (!estaSeguindo && usuarioItem && !listaSeguindo.contains(usuarioItem)) {
                listaSeguindo.prepend(usuarioItem);
            }

            // Se veio do feed (sem estrutura de usuarioItem), cria novo card
            if (!estaSeguindo && !usuarioItem && listaSeguindo) {
                const post = btn.closest('.post-card1');
                if (post) {
                    const apelido = post.querySelector('.user-info1 strong')?.textContent || 'Usuário';
                    const foto = post.querySelector('.profile-img1')?.getAttribute('src')?.split('/').pop() || 'default.jpg';
                    const email = ''; // Adicione se quiser puxar do HTML

                    const novoItem = document.createElement('div');
                    novoItem.className = 'usuario-item';
                    novoItem.innerHTML = `
                        <div class="usuario-info">
                            <img src="uploads/${foto}" alt="${apelido}" class="usuario-foto">
                            <div class="usuario-texto">
                                <strong>${apelido}</strong>
                                <small>${email}</small>
                            </div>
                        </div>
                        <button class="seguir-btn seguindo" data-id="${idseguido}">Seguindo</button>
                    `;
                    listaSeguindo.prepend(novoItem);
                }
            }

        } else {
            criarAlerta(dados.msg || 'Erro ao seguir usuário.', 'danger');
        }

    } catch (err) {
        criarAlerta('Erro na requisição: ' + err.message, 'danger');
    }
});

// ALERTA BONITINHO
function criarAlerta(mensagem, tipo = 'success') {
    const alerta = document.createElement('div');
    alerta.className = `alert alert-${tipo} position-fixed top-0 start-50 translate-middle-x mt-3`;
    alerta.style.zIndex = 9999;
    alerta.textContent = mensagem;
    document.body.appendChild(alerta);
    setTimeout(() => alerta.remove(), 1500);
}




 
})();
