const toggleBtn = document.getElementById("toggleBtn");
const sidebar = document.getElementById("sidebar");

toggleBtn.onclick = () => {
  sidebar.classList.toggle("collapsed");
  toggleBtn.innerText = sidebar.classList.contains("collapsed") ? ">" : "<";
};
