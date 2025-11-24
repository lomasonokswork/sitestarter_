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

  document.addEventListener('click', (e) => {
  if (e.target.closest('.copy-btn')) {
    const btn = e.target.closest('.copy-btn');
    const url = btn.getAttribute('data-url');
    const font = btn.getAttribute('data-font');
    const textToCopy = url || font;
    
    navigator.clipboard.writeText(textToCopy)
      .then(() => {
        toast.textContent = 'Copied!';
        toast.classList.add('show');
        setTimeout(() => {
          toast.classList.remove('show');
        }, 2000);
      })
      .catch(err => {
        console.error('Failed to copy:', err);
      });
  }
});