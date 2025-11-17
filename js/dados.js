document.getElementById("form-dados").addEventListener("submit", function (e) {
  e.preventDefault();

  // Limpa mensagens anteriores
  document.querySelectorAll(".erro-msg").forEach(el => el.textContent = "");

  let valido = true;

  const email = document.getElementById("email").value.trim();
  const tel = document.getElementById("tel").value.trim();
  const cep = document.getElementById("cep").value.trim();

  function mostrarErro(id, msg) {
    document.getElementById(id).textContent = msg;
    valido = false;
  }

  function validarEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
  }

  if (!validarEmail(email)) mostrarErro("erro-email", "E-mail inválido.");
  if (!/^\d{10,11}$/.test(tel)) mostrarErro("erro-tel", "Telefone deve ter 10 ou 11 dígitos.");
  if (!/^\d{8}$/.test(cep)) mostrarErro("erro-cep", "CEP deve ter 8 dígitos.");

  if (valido) this.submit();
});