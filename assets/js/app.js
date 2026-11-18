document.addEventListener('DOMContentLoaded', () => {
  const sidebar = document.querySelector('[data-sidebar]');
  const toggle = document.querySelector('[data-sidebar-toggle]');
  const backdrop = document.querySelector('[data-sidebar-backdrop]');
  const closeSidebar = () => {
    sidebar?.classList.remove('open');
    backdrop?.classList.remove('open');
    toggle?.setAttribute('aria-expanded', 'false');
  };
  toggle?.addEventListener('click', () => {
    const open = sidebar?.classList.toggle('open') ?? false;
    backdrop?.classList.toggle('open', open);
    toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
  });
  backdrop?.addEventListener('click', closeSidebar);
  sidebar?.querySelectorAll('a').forEach(link => link.addEventListener('click', closeSidebar));
  document.addEventListener('keydown', event => { if (event.key === 'Escape') closeSidebar(); });

  document.querySelectorAll('form[data-confirm]').forEach(form => {
    form.addEventListener('submit', event => {
      const target = event.submitter;
      const message = target?.getAttribute('data-confirm') || form.getAttribute('data-confirm') || 'Yakin melanjutkan?';
      if (!window.confirm(message)) event.preventDefault();
    });
  });

  document.querySelectorAll('form[data-prevent-double-submit]').forEach(form => {
    form.addEventListener('submit', () => {
      const button = form.querySelector('button[type="submit"]');
      if (!button || button.disabled) return;
      button.dataset.originalText = button.textContent || '';
      button.textContent = 'Menyimpan...';
      button.disabled = true;
      button.setAttribute('aria-busy', 'true');
    });
  });

  const categoryFilter = document.querySelector('#service-category');
  const serviceSearch = document.querySelector('#service-search');
  const serviceRows = [...document.querySelectorAll('[data-service-row]')];
  const checks = [...document.querySelectorAll('.service-check')];
  const totalEl = document.querySelector('#selected-total');
  const countEl = document.querySelector('#selected-count');
  const durationEl = document.querySelector('#selected-duration');
  const formatMoney = value => 'Rp ' + new Intl.NumberFormat('id-ID', { maximumFractionDigits: 0 }).format(Number(value || 0));

  const updateServiceFilter = () => {
    const category = categoryFilter?.value || 'Semua';
    const query = (serviceSearch?.value || '').trim().toLowerCase();
    serviceRows.forEach(row => {
      const categoryMatch = category === 'Semua' || row.dataset.category === category;
      const searchMatch = (row.dataset.search || '').toLowerCase().includes(query);
      row.hidden = !(categoryMatch && searchMatch);
    });
  };
  const updateTotal = () => {
    const selected = checks.filter(check => check.checked);
    checks.forEach(check => {
      const card = check.closest('.service-option');
      card?.classList.toggle('is-selected', check.checked);
      if (card) card.setAttribute('aria-selected', check.checked ? 'true' : 'false');
    });
    const total = selected.reduce((sum, check) => sum + Number(check.dataset.price || 0), 0);
    const duration = selected.reduce((sum, check) => sum + Number(check.dataset.duration || 0), 0);
    if (totalEl) totalEl.textContent = formatMoney(total);
    if (countEl) countEl.textContent = selected.length + ' layanan';
    if (durationEl) durationEl.textContent = duration + ' menit';
  };
  categoryFilter?.addEventListener('change', updateServiceFilter);
  serviceSearch?.addEventListener('input', updateServiceFilter);
  checks.forEach(check => check.addEventListener('change', updateTotal));
  document.querySelector('#transaction-form')?.addEventListener('reset', () => window.setTimeout(updateTotal, 0));
  updateServiceFilter();
  updateTotal();

  const period = document.querySelector('#periode');
  const start = document.querySelector('#tanggal_awal');
  const end = document.querySelector('#tanggal_akhir');
  const updateDateFields = () => {
    if (!period || !start || !end) return;
    const editable = period.value === 'custom';
    start.readOnly = !editable;
    end.readOnly = !editable;
    start.style.background = editable ? '#fff' : '#f5f6f7';
    end.style.background = editable ? '#fff' : '#f5f6f7';
  };
  period?.addEventListener('change', updateDateFields);
  updateDateFields();
});

// Indonesian date and live clock for the compact application top bar.
(() => {
  const dateNode = document.querySelector('[data-live-date]');
  const timeNode = document.querySelector('[data-live-time]');
  if (!dateNode && !timeNode) return;
  const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
  const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
  const tick = () => {
    const now = new Date();
    if (dateNode) dateNode.textContent = `${days[now.getDay()]}, ${now.getDate()} ${months[now.getMonth()]} ${now.getFullYear()}`;
    if (timeNode) timeNode.textContent = `${String(now.getHours()).padStart(2, '0')}.${String(now.getMinutes()).padStart(2, '0')}.${String(now.getSeconds()).padStart(2, '0')}`;
  };
  tick();
  window.setInterval(tick, 1000);
})();
