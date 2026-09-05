// Legacy jQuery Sidebar Accordion retired in favor of pure Tailwind + Vanilla JS sliding drilldown
// (Retained for reference, inactive to prevent event conflicts)
/*
$(".menu > ul > li").click(function (e) {
  const activeLink = $(this).find("> a").attr("href");
  localStorage.setItem("activeSidebarLink", activeLink);
  $(this).siblings().removeClass("active");
  $(this).siblings().find("ul").slideUp();
  $(this).toggleClass("active");
  $(this).find("ul").slideToggle();
});
*/

//   ................................................
//   ................................................
//   ................................................
//   ................................................

// Counter Animation
function counterAnimation() {
  const counters = document.querySelectorAll(".counter-value");
  counters.forEach((counter) => {
    const target = +counter.getAttribute("data-target");
    const speed = target / 250;
    const updateCounter = () => {
      const current = +counter.innerText;
      if (current < target) {
        counter.innerText = Math.ceil(current + speed);
        setTimeout(updateCounter, 1);
      } else {
        counter.innerText = target;
      }
    };
    updateCounter();
  });
}

// Sidebar Close on Outside Click
document.addEventListener("click", function (event) {
  const sidebar = document.querySelector(".vertical-menu");
  const toggleButton = document.querySelector(".vertical-menu-btn");

  if (sidebar && toggleButton) {
    if (!sidebar.contains(event.target) && !toggleButton.contains(event.target)) {
      document.body.classList.remove("sidebar-enable");
    }
  }
});

// Responsive Sidebar Toggle
function toggleSidebar() {
  const currentSize = document.body.getAttribute("data-sidebar-size");

  document.body.classList.toggle("sidebar-enable");
  if (window.innerWidth >= 992) {
    document.body.setAttribute(
      "data-sidebar-size",
      currentSize === "sm" ? "lg" : "sm"
    );
  }
}
document.querySelectorAll(".vertical-menu-btn").forEach((button) => {
  button.addEventListener("click", toggleSidebar);
});

// Tooltip Initialization with safety check
if (window.bootstrap && typeof window.bootstrap.Tooltip === 'function') {
  document.querySelectorAll("[data-bs-toggle='tooltip']").forEach((tooltip) => {
    try { new bootstrap.Tooltip(tooltip); } catch(e) {}
  });
}

// Popover Initialization with safety check
if (window.bootstrap && typeof window.bootstrap.Popover === 'function') {
  document.querySelectorAll("[data-bs-toggle='popover']").forEach((popover) => {
    try { new bootstrap.Popover(popover); } catch(e) {}
  });
}

// Horizontal Layout Toggle
function toggleLayout() {
  const body = document.body;
  const layout = body.getAttribute("data-layout");

  if (layout === "horizontal") {
    body.setAttribute("data-layout", "vertical");
  } else {
    body.setAttribute("data-layout", "horizontal");
  }
}
document.querySelectorAll(".layout-toggle").forEach((button) => {
  button.addEventListener("click", toggleLayout);
});

// Initialize Animations on Page Load
document.addEventListener("DOMContentLoaded", function () {
  if (typeof counterAnimation === 'function') {
    counterAnimation();
  }
});

// Right sidebar toggle functionality
document.querySelectorAll(".right-bar-toggle").forEach(function (toggleBtn) {
  toggleBtn.addEventListener("click", function () {
    document.body.classList.toggle("right-bar-enabled");
  });
});

// Close the right sidebar when clicking outside of it
document.body.addEventListener("click", function (event) {
  const isClickInside = event.target.closest(".right-bar-toggle, .right-bar");
  if (!isClickInside) {
    document.body.classList.remove("right-bar-enabled");
  }
});

// Toggle light/dark mode based on radio button selection
document
  .querySelectorAll('input[name="layout-mode"]')
  .forEach(function (toggleBtn) {
    toggleBtn.addEventListener("change", function () {
      const selectedMode = document.querySelector(
        'input[name="layout-mode"]:checked'
      ).value;
      document.body.setAttribute("data-layout-mode", selectedMode);
    });
  });






//.........................................................................

// // Function to toggle light and dark mode
function toggleLightMode() {
  const body = document.body;
  const currentMode = body.getAttribute('light-mode');
  const newMode = currentMode === 'dark' ? 'light' : 'dark';

  // Update the mode attribute
  body.setAttribute('light-mode', newMode);

  // Save the preference to localStorage
  localStorage.setItem('lightMode', newMode);
}

// Set the mode on page load based on localStorage
window.onload = function () {
  const savedMode = localStorage.getItem('lightMode') || 'light'; // Default to light mode
  document.body.setAttribute('light-mode', savedMode);
};
// // //////


