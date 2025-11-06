const toggleBtn = document.getElementById('theme-toggle');
  const root = document.documentElement;

  if (localStorage.getItem('theme') === 'dark') {
    root.classList.add('dark');
    toggleBtn.setAttribute('aria-pressed', 'true');
  }

  toggleBtn.addEventListener('click', () => {
    root.classList.toggle('dark');
    const dark = root.classList.contains('dark');
    localStorage.setItem('theme', dark ? 'dark' : 'light');
    toggleBtn.setAttribute('aria-pressed', dark);
  });