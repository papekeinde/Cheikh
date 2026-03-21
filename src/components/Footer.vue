<template>
  <footer class="footer">
    <div class="container">
      <div class="footer-content">
        <div class="footer-logo">
          <span class="logo-text">PORTFOLIO</span>
          <p class="footer-tagline">Créativité & Innovation</p>
        </div>
        
        <div class="footer-links">
          <a href="#hero" class="footer-link">Accueil</a>
          <a href="#about" class="footer-link">À propos</a>
          <a href="#projects" class="footer-link">Projets</a>
          <a href="#skills" class="footer-link">Compétences</a>
          <a href="#contact" class="footer-link">Contact</a>
        </div>
        
        <div class="footer-social">
          <a href="#" class="social-icon">GH</a>
          <a href="#" class="social-icon">LI</a>
          <a href="#" class="social-icon">TW</a>
          <a href="#" class="social-icon">DR</a>
        </div>
      </div>
      
      <div class="footer-bottom">
        <p class="footer-copyright">
          © {{ currentYear }} Portfolio Artistique. Créé avec passion.
        </p>
      </div>
    </div>
  </footer>
</template>

<script setup>
import { ref } from 'vue'

const currentYear = ref(new Date().getFullYear())
</script>

<style scoped>
.footer {
  background: rgba(255, 255, 255, 0.02);
  border-top: 1px solid rgba(255, 255, 255, 0.1);
  padding: 4rem 4rem 2rem;
}

.container {
  max-width: 1200px;
  margin: 0 auto;
}

.footer-content {
  display: grid;
  grid-template-columns: 1fr 1fr 1fr;
  gap: 3rem;
  margin-bottom: 3rem;
}

.footer-logo .logo-text {
  font-family: var(--font-display);
  font-size: 1.5rem;
  font-weight: 700;
  letter-spacing: 0.1em;
  display: block;
  margin-bottom: 0.5rem;
}

.footer-tagline {
  font-size: 0.875rem;
  color: rgba(255, 255, 255, 0.5);
}

.footer-links {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.footer-link {
  color: rgba(255, 255, 255, 0.7);
  text-decoration: none;
  font-size: 0.875rem;
  transition: color 0.3s ease;
}

.footer-link:hover {
  color: var(--color-accent);
}

.footer-social {
  display: flex;
  gap: 1rem;
  justify-content: flex-end;
}

.social-icon {
  width: 40px;
  height: 40px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--color-text);
  text-decoration: none;
  font-size: 0.75rem;
  font-weight: 600;
  border: 1px solid rgba(255, 255, 255, 0.2);
  transition: all 0.3s ease;
}

.social-icon:hover {
  background: var(--color-accent);
  border-color: var(--color-accent);
  transform: translateY(-3px);
}

.footer-bottom {
  padding-top: 2rem;
  border-top: 1px solid rgba(255, 255, 255, 0.05);
  text-align: center;
}

.footer-copyright {
  font-size: 0.875rem;
  color: rgba(255, 255, 255, 0.4);
}

@media (max-width: 768px) {
  .footer {
    padding: 3rem 1.5rem 2rem;
  }
  
  .footer-content {
    grid-template-columns: 1fr;
    gap: 2rem;
    text-align: center;
  }
  
  .footer-links {
    flex-direction: row;
    flex-wrap: wrap;
    justify-content: center;
    gap: 0.75rem;
  }
  
  .footer-social {
    justify-content: center;
  }
}

@media (max-width: 480px) {
  .footer {
    padding: 2rem 1rem 1.5rem;
  }
}
</style>
