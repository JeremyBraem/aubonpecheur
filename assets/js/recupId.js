document.addEventListener("DOMContentLoaded", function () {
  const modalToggles = document.querySelectorAll('[data-modal-toggle="updateCanneModal"]');
  const modalTarget = document.getElementById("updateCanneModal");

  modalToggles.forEach(function (toggle) {
    toggle.addEventListener("click", function () {
      const canneId = toggle.closest("tr").getAttribute("data-canne-id");
      const inputCanneId = modalTarget.querySelector('input[name="canne_id"]');

      if (modalTarget && inputCanneId) {
        inputCanneId.value = canneId;
        modalTarget.classList.add("active");
      }
    });
  });
});
