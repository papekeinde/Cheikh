<template>
  <section id="hero" class="hero" ref="heroRef">
    <div class="hero-content">
      <div class="hero-subtitle" ref="subtitleRef">Créatif & Développeur</div>
      <h1 class="hero-title" ref="titleRef">
        <span class="title-line">PORTFOLIO</span>
        <span class="title-line">ARTISTIQUE</span>
      </h1>
      <p class="hero-description" ref="descRef">
        Une expérience immersive qui fusionne créativité et technologie
      </p>
      <div class="hero-cta" ref="ctaRef">
        <a href="#projects" class="cta-button">Découvrir mes projets</a>
        <a href="#contact" class="cta-button cta-button-outline">Me contacter</a>
      </div>
    </div>
    
    <div class="scroll-indicator" ref="scrollRef">
      <span class="scroll-text">Scroll</span>
      <div class="scroll-line"></div>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { gsap } from 'gsap'
import { ScrollTrigger } from 'gsap/ScrollTrigger'

gsap.registerPlugin(ScrollTrigger)

const heroRef = ref(null)
const titleRef = ref(null)
const subtitleRef = ref(null)
const descRef = ref(null)
const ctaRef = ref(null)
const scrollRef = ref(null)

onMounted(() => {
  const tl = gsap.timeline({ delay: 3.5 })
  
  tl.from(subtitleRef.value, {
    y: 50,
    opacity: 0,
    duration: 1,
    ease: 'power3.out'
  })
  
  tl.from('.title-line', {
    y: 100,
    opacity: 0,
    duration: 1.2,
    stagger: 0.2,
    ease: 'power4.out'
  }, '-=0.5')
  
  tl.from(descRef.value, {
    y: 30,
    opacity: 0,
    duration: 0.8,
    ease: 'power2.out'
  }, '-=0.5')
  
  tl.from('.cta-button', {
    y: 30,
    opacity: 0,
    duration: 0.8,
    stagger: 0.2,
    ease: 'power2.out'
  }, '-=0.3')
  
  tl.from(scrollRef.value, {
    opacity: 0,
    duration: 1,
    ease: 'power2.out'
  }, '-=0.5')
  
  // Parallax effect
  gsap.to('.hero-content', {
    y: 200,
    opacity: 0,
    scrollTrigger: {
      trigger: heroRef.value,
      start: 'top top',
      end: 'bottom top',
      scrub: 1
    }
  })
  
  // Scroll indicator animation
  gsap.to('.scroll-line', {
    scaleY: 0,
    transformOrigin: 'top',
    scrollTrigger: {
      trigger: heroRef.value,
      start: 'top top',
      end: 'bottom top',
      scrub: 1
    }
  })
})
</script>

<style scoped>
.hero {
  position: relative;
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 0 4rem;
  overflow: hidden;
}

.hero-content {
  text-align: center;
  max-width: 1200px;
  margin: 0 auto;
}

.hero-subtitle {
  font-size: 1rem;
  font-weight: 500;
  letter-spacing: 0.3em;
  text-transform: uppercase;
  color: var(--color-accent);
  margin-bottom: 2rem;
}

.hero-title {
  font-size: clamp(4rem, 10vw, 8rem);
  font-weight: 700;
  line-height: 1;
  margin-bottom: 2rem;
  overflow: hidden;
}

.title-line {
  display: block;
  background: linear-gradient(90deg, var(--color-text), var(--color-accent), var(--color-secondary));
  background-size: 200% auto;
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  animation: gradient 3s ease infinite;
}

@keyframes gradient {
  0%, 100% {
    background-position: 0% center;
  }
  50% {
    background-position: 100% center;
  }
}

.hero-description {
  font-size: 1.25rem;
  color: rgba(255, 255, 255, 0.7);
  margin-bottom: 3rem;
  max-width: 600px;
  margin-left: auto;
  margin-right: auto;
}

.hero-cta {
  display: flex;
  gap: 1.5rem;
  justify-content: center;
  align-items: center;
}

.cta-button {
  padding: 1rem 2.5rem;
  font-size: 0.875rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.1em;
  text-decoration: none;
  color: var(--color-text);
  background: var(--color-accent);
  border: 2px solid var(--color-accent);
  border-radius: 0;
  transition: all 0.3s ease;
  position: relative;
  overflow: hidden;
}

.cta-button::before {
  content: '';
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: var(--color-secondary);
  transition: left 0.3s ease;
  z-index: -1;
}

.cta-button:hover::before {
  left: 0;
}

.cta-button-outline {
  background: transparent;
  border-color: var(--color-text);
}

.cta-button-outline::before {
  background: var(--color-text);
}

.cta-button-outline:hover {
  color: var(--color-bg);
}

.scroll-indicator {
  position: absolute;
  bottom: 3rem;
  left: 50%;
  transform: translateX(-50%);
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 1rem;
}

.scroll-text {
  font-size: 0.75rem;
  font-weight: 500;
  letter-spacing: 0.2em;
  text-transform: uppercase;
  writing-mode: vertical-rl;
}

.scroll-line {
  width: 1px;
  height: 60px;
  background: var(--color-accent);
  transform-origin: top;
}

@media (max-width: 768px) {
  .hero {
    padding: 0 1.5rem;
  }
  
  .hero-subtitle {
    font-size: 0.8rem;
    letter-spacing: 0.2em;
    margin-bottom: 1.5rem;
  }
  
  .hero-description {
    font-size: 1rem;
    margin-bottom: 2rem;
  }
  
  .hero-cta {
    flex-direction: column;
    gap: 1rem;
  }
  
  .cta-button {
    width: 100%;
    text-align: center;
    padding: 0.9rem 2rem;
  }
  
  .scroll-indicator {
    bottom: 2rem;
  }
}

@media (max-width: 480px) {
  .hero {
    padding: 0 1rem;
  }
  
  .hero-title {
    font-size: clamp(2.5rem, 12vw, 4rem);
  }
}
</style>
