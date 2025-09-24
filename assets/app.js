document.addEventListener("DOMContentLoaded", () => {
  const toggle = document.querySelector(".nav-toggle");
  const list = document.getElementById("nav-list");
  if (toggle && list) {
    toggle.addEventListener("click", () => {
      const open = list.classList.toggle("open");
      toggle.setAttribute("aria-expanded", open ? "true" : "false");
    });
  }

  // Menu description toggle
  const menuItems = document.querySelectorAll(".menu-item");
  menuItems.forEach((item) => {
    const clickable = item.querySelector(".menu-item-name, .menu-item-content");
    const desc = item.querySelector(".menu-item-description");
    if (!clickable || !desc) return;

    clickable.addEventListener("click", () => {
      item.classList.toggle("is-open");
    });
  });
});
