document.getElementById("form-cadastro").addEventListener("submit", function (e) {
  e.preventDefault();

  // Limpa mensagens anteriores
  document.querySelectorAll(".erro-msg").forEach(el => el.textContent = "");

  let valido = true;

  const nome = document.getElementById("name").value.trim();
  const email = document.getElementById("email").value.trim();
  const cpf = document.getElementById("cpf").value.trim();
  const tel = document.getElementById("tel").value.trim();
  const nc = document.getElementById("nc").value.trim();
  const cep = document.getElementById("cep").value.trim();
  const senha = document.getElementById("senha").value;
  const cs = document.getElementById("cs").value;

  function mostrarErro(id, msg) {
    document.getElementById(id).textContent = msg;
    valido = false;
  }

  function validarEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
  }

  function validarCPF(cpf) {
    cpf = cpf.replace(/[^\d]+/g, '');
    if (cpf.length !== 11 || /^(\d)\1+$/.test(cpf)) return false;
    let soma = 0;
    for (let i = 0; i < 9; i++) soma += parseInt(cpf[i]) * (10 - i);
    let resto = (soma * 10) % 11;
    if (resto === 10 || resto === 11) resto = 0;
    if (resto !== parseInt(cpf[9])) return false;
    soma = 0;
    for (let i = 0; i < 10; i++) soma += parseInt(cpf[i]) * (11 - i);
    resto = (soma * 10) % 11;
    if (resto === 10 || resto === 11) resto = 0;
    return resto === parseInt(cpf[10]);
  }

  function validarSenha(s) {
    return /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).{8,}$/.test(s);
  }

  if (!nome) mostrarErro("erro-name", "Preencha o nome.");
  if (!validarEmail(email)) mostrarErro("erro-email", "E-mail inválido.");
  if (!validarCPF(cpf)) mostrarErro("erro-cpf", "CPF inválido.");
  if (!/^\d{10,11}$/.test(tel)) mostrarErro("erro-tel", "Telefone deve ter 10 ou 11 dígitos.");
  if (!nc) mostrarErro("erro-nc", "Preencha o nome do comércio.");
  if (!/^\d{8}$/.test(cep)) mostrarErro("erro-cep", "CEP deve ter 8 dígitos.");
  if (!validarSenha(senha)) mostrarErro("erro-senha", "Senha fraca. Use letras, números e símbolos.");
  if (senha !== cs) mostrarErro("erro-cs", "As senhas não coincidem.");

  if (valido) this.submit();
});