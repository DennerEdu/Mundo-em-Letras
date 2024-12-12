let isLogin = true; // Estado inicial: estamos no modo login

document.getElementById('toggle-btn').addEventListener('click', toggleForm);

function toggleForm() {
  const formTitle = document.getElementById('form-title');
  const form = document.getElementById('form');
  const toggleBtn = document.getElementById('toggle-btn');

  if (isLogin) {
    // Mudar para Cadastro
    formTitle.innerText = "Cadastro";
    form.innerHTML = `
      <label for="username">Usuário</label>
      <input type="text" id="username" name="username" required>
      <label for="email">Email</label>
      <input type="email" id="email" name="email" required>
      <label for="password">Senha</label>
      <input type="password" id="password" name="password" required>
      <button type="submit">Cadastrar</button>
    `;
    toggleBtn.innerText = "Ir para Login";
  } else {
    // Voltar para Login
    formTitle.innerText = "Login";
    form.innerHTML = `
      <label for="username">Usuário</label>
      <input type="text" id="username" name="username" required>
      <label for="password">Senha</label>
      <input type="password" id="password" name="password" required>
      <button type="submit">Entrar</button>
    `;
    toggleBtn.innerText = "Ir para Cadastro";
  }

  isLogin = !isLogin; // Alternar o estado
}
