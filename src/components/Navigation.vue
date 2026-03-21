<template>
  <nav class="navigation" ref="navRef">
    <div class="nav-logo">
      <span class="logo-text">PORTFOLIO</span>
    </div>
    
    <button class="nav-burger" :class="{ active: menuOpen }" @click="toggleMenu" aria-label="Menu">
      <span></span>
      <span></span>
      <span></span>
    </button>
    
    <div class="nav-overlay" :class="{ active: menuOpen }" @click="closeMenu"></div>
    
    <ul class="nav-menu" :class="{ active: menuOpen }">
      <li><a href="#hero" class="nav-link" @click="closeMenu">Accueil</a></li>
      <li><a href="#about" class="nav-link" @click="closeMenu">À propos</a></li>
      <li><a href="#projects" class="nav-link" @click="closeMenu">Projets</a></li>
      <li><a href="#skills" class="nav-link" @click="closeMenu">Compétences</a></li>
      <li><a href="#contact" class="nav-link" @click="closeMenu">Contact</a></li>
    </ul>
    
    <div class="nav-social">
      <a href="#" class="social-link">GH</a>
      <a href="#" class="social-link">LI</a>
      <a href="#" class="social-link">TW</a>
    </div>
  </nav>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { gsap } from 'gsap'
import { ScrollTrigger } from 'gsap/ScrollTrigger'

gsap.registerPlugin(ScrollTrigger)

const navRef = ref(null)
const menuOpen = ref(false)

const toggleMenu = () => {
  menuOpen.value = !menuOpen.value
  document.body.style.overflow = menuOpen.value ? 'hidden' : ''
}

const closeMenu = () => {
  menuOpen.value = false
  document.body.style.overflow = ''
}

onMounted(() => {
  gsap.from('.nav-logo, .nav-menu li, .nav-social, .nav-burger', {
    y: -50,
    opacity: 0,
    duration: 0.8,
    stagger: 0.1,
    ease: 'power3.out',
    delay: 3
  })
  
  // Hide/show on scroll
  let lastScroll = 0
  ScrollTrigger.create({
    start: 'top top',
    end: 'max',
    onUpdate: (self) => {
      const currentScroll = self.scroll()
      if (currentScroll > lastScroll && currentScroll > 100) {
        gsap.to(navRef.value, { y: -100, duration: 0.3 })
      } else {
        gsap.to(navRef.value, { y: 0, duration: 0.3 })
      }
      lastScroll = currentScroll
    }
  })
})
</script>

<style scoped>
.navigation {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 2rem 4rem;
  z-index: 1000;
  background: rgba(10, 10, 10, 0.8);
  backdrop-filter: blur(10px);
  border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.nav-logo .logo-text {
  font-family: var(--font-display);
  font-size: 1.5rem;
  font-weight: 700;
  letter-spacing: 0.1em;
}

.nav-menu {
  display: flex;
  gap: 3rem;
  list-style: none;
}

.nav-link {
  color: var(--color-text);
  text-decoration: none;
  font-size: 0.875rem;
  font-weight: 500;
  text-transform: uppercase;
  letter-spacing: 0.1em;
  position: relative;
  transition: color 0.3s ease;
}

.nav-link::after {
  content: '';
  position: absolute;
  bottom: -5px;
  left: 0;
  width: 0;
  height: 2px;
  background: var(--color-accent);
  transition: width 0.3s ease;
}

.nav-link:hover {
  color: var(--color-accent);
}

.nav-link:hover::after {
  width: 100%;
}

.nav-social {
  display: flex;
  gap: 1.5rem;
}

.social-link {
  color: var(--color-text);
  text-decoration: none;
  font-size: 0.75rem;
  font-weight: 600;
  letter-spacing: 0.1em;
  transition: color 0.3s ease;
}

.social-link:hover {
  color: var(--color-accent);
}

.nav-burger {
  display: none;
  flex-direction: column;
  gap: 5px;
  background: none;
  border: none;
  cursor: pointer;
  padding: 5px;
  z-index: 1002;
}

.nav-burger span {
  display: block;
  width: 25px;
  height: 2px;
  background: var(--color-text);
  transition: all 0.3s ease;
}

.nav-burger.active span:nth-child(1) {
  transform: rotate(45deg) translate(5px, 5px);
}

.nav-burger.active span:nth-child(2) {
  opacity: 0;
}

.nav-burger.active span:nth-child(3) {
  transform: rotate(-45deg) translate(5px, -5px);
}

.nav-overlay {
  display: none;
}

@media (max-width: 768px) {
  .navigation {
    padding: 1rem 1.5rem;
  }
  
  .nav-burger {
    display: flex;
  }
  
  .nav-menu {
    display: flex;
    position: fixed;
    top: 0;
    right: -100%;
    width: 70%;
    max-width: 300px;
    height: 100vh;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    gap: 2rem;
    background: rgba(10, 10, 10, 0.97);
    backdrop-filter: blur(20px);
    border-left: 1px solid rgba(255, 255, 255, 0.1);
    transition: right 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    z-index: 1001;
  }
  
  .nav-menu.active {
    right: 0;
  }
  
  .nav-menu .nav-link {
    font-size: 1.25rem;
    letter-spacing: 0.15em;
  }
  
  .nav-overlay {
    display: block;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100vh;
    background: rgba(0, 0, 0, 0.5);
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.3s ease;
    z-index: 1000;
  }
  
  .nav-overlay.active {
    opacity: 1;
    pointer-events: auto;
  }
  
  .nav-social {
    display: none;
  }
}

@media (max-width: 1024px) and (min-width: 769px) {
  .navigation {
    padding: 1.5rem 2.5rem;
  }
  
  .nav-menu {
    gap: 1.5rem;
  }
  
  .nav-link {
    font-size: 0.75rem;
  }
}
</style>
