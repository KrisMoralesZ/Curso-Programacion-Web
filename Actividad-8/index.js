function setLocalStorage(key, value) {
  localStorage.setItem(key, JSON.stringify(value));
}

function getLocalStorage(key) {
  const value = localStorage.getItem(key);
  return JSON.parse(value);
}

function handleFormSubmit(event) {
  event.preventDefault();

  const form = event.target;
  const formData = {
    nombre: form.nombre.value,
    email: form.email.value,
    password: form.password.value
  };

  setLocalStorage("formData", formData);
  console.log("Datos guardados en localStorage:", formData);
  form.reset();
}

const form = document.querySelector(".form-section");
form.addEventListener("submit", handleFormSubmit);