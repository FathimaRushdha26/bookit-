// Dynamic time-slot loader for the booking form
(function () {
  const form = document.getElementById('bookingForm');
  if (!form) return;
  const dateInput = document.getElementById('bookingDate');
  const slotsBox  = document.getElementById('slots');
  const timeInput = document.getElementById('bookingTime');
  const base = form.dataset.slotsUrl;

  function load() {
    if (!dateInput.value) return;
    slotsBox.innerHTML = '<span class="muted">Loading...</span>';
    fetch(base + '&date=' + encodeURIComponent(dateInput.value))
      .then(r => r.json())
      .then(list => {
        slotsBox.innerHTML = '';
        list.forEach(s => {
          const b = document.createElement('button');
          b.type = 'button';
          b.textContent = s.time;
          b.className = 'slot' + (s.available ? '' : ' disabled');
          b.disabled = !s.available;
          if (s.time === timeInput.value && s.available) b.classList.add('selected');
          b.addEventListener('click', () => {
            slotsBox.querySelectorAll('.slot').forEach(x => x.classList.remove('selected'));
            b.classList.add('selected');
            timeInput.value = s.time;
          });
          slotsBox.appendChild(b);
        });
      })
      .catch(() => { slotsBox.innerHTML = '<span class="muted">Could not load slots.</span>'; });
  }

  dateInput.addEventListener('change', () => { timeInput.value = ''; load(); });
  form.addEventListener('submit', e => {
    if (!timeInput.value) { e.preventDefault(); alert('Please select a time slot.'); }
  });
  load();
})();
