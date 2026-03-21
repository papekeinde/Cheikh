<template>
  <section id="about" class="about" ref="aboutRef">
    <div class="container">
      <div class="about-header">
        <h2 class="section-title" ref="titleRef">À PROPOS</h2>
        <div class="title-number">01</div>
      </div>
      
      <div class="about-content">
        <div class="about-text" ref="textRef">
          <p class="about-paragraph">
            Je suis un créatif passionné qui fusionne l'art et la technologie 
            pour créer des expériences numériques uniques et mémorables.
          </p>
          <p class="about-paragraph">
            Mon approche combine design innovant, animations fluides et 
            développement web moderne pour donner vie à des idées audacieuses.
          </p>
          <p class="about-paragraph">
            Chaque projet est une opportunité d'explorer de nouvelles possibilités 
            et de repousser les limites de la créativité digitale.
          </p>
        </div>
        
        <div class="about-stats" ref="statsRef">
          <div class="stat-item">
            <span class="stat-number">5+</span>
            <span class="stat-label">Années d'expérience</span>
          </div>
          <div class="stat-item">
            <span class="stat-number">50+</span>
            <span class="stat-label">Projets réalisés</span>
          </div>
          <div class="stat-item">
            <span class="stat-number">30+</span>
            <span class="stat-label">Clients satisfaits</span>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { gsap } from 'gsap'
import { ScrollTrigger } from 'gsap/ScrollTrigger'

gsap.registerPlugin(ScrollTrigger)

const aboutRef = ref(null)
const titleRef = ref(null)
const textRef = ref(null)
const statsRef = ref(null)

onMounted(() => {
  gsap.from(titleRef.value, {
    x: -100,
    opacity: 0,
    duration: 1,
    scrollTrigger: {
      trigger: aboutRef.value,
      start: 'top 80%',
      end: 'top 30%',
      toggleActions: 'play none none reverse'
    }
  })
  
  gsap.from('.about-paragraph', {
    y: 50,
    opacity: 0,
    duration: 0.8,
    stagger: 0.2,
    scrollTrigger: {
      trigger: textRef.value,
      start: 'top 80%',
      toggleActions: 'play none none reverse'
    }
  })
  
  gsap.from('.stat-item', {
    scale: 0,
    opacity: 0,
    duration: 0.6,
    stagger: 0.15,
    ease: 'back.out(1.7)',
    scrollTrigger: {
      trigger: statsRef.value,
      start: 'top 80%',
      toggleActions: 'play none none reverse'
    }
  })
})
</script>

<style scoped>
.about {
  min-height: 100vh;
  padding: 8rem 4rem;
  position: relative;
}

.container {
  max-width: 1200px;
  margin: 0 auto;
}

.about-header {
  position: relative;
  margin-bottom: 5rem;
}

.section-title {
  font-size: clamp(3rem, 8vw, 6rem);
  font-weight: 700;
  letter-spacing: 0.05em;
  position: relative;
  display: inline-block;
}

.title-number {
  position: absolute;
  top: -2rem;
  right: 0;
  font-size: 8rem;
  font-weight: 700;
  color: rgba(255, 255, 255, 0.03);
  font-family: var(--font-display);
  pointer-events: none;
}

.about-content {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 4rem;
  align-items: center;
}

.about-text {
  display: flex;
  flex-direction: column;
  gap: 2rem;
}

.about-paragraph {
  font-size: 1.125rem;
  line-height: 1.8;
  color: rgba(255, 255, 255, 0.8);
}

.about-stats {
  display: flex;
  flex-direction: column;
  gap: 3rem;
}

.stat-item {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
  padding: 2rem;
  background: rgba(255, 255, 255, 0.03);
  border: 1px solid rgba(255, 255, 255, 0.1);
  transition: all 0.3s ease;
}

.stat-item:hover {
  background: rgba(255, 107, 107, 0.1);
  border-color: var(--color-accent);
  transform: translateX(10px);
}

.stat-number {
  font-size: 3rem;
  font-weight: 700;
  color: var(--color-accent);
  font-family: var(--font-display);
}

.stat-label {
  font-size: 0.875rem;
  text-transform: uppercase;
  letter-spacing: 0.1em;
  color: rgba(255, 255, 255, 0.6);
}

@media (max-width: 1024px) {
  .about {
    padding: 6rem 3rem;
  }
  
  .about-content {
    gap: 3rem;
  }
  
  .stat-number {
    font-size: 2.5rem;
  }
}

@media (max-width: 768px) {
  .about {
    padding: 4rem 1.5rem;
  }
  
  .about-header {
    margin-bottom: 3rem;
  }
  
  .about-content {
    grid-template-columns: 1fr;
    gap: 2.5rem;
  }
  
  .about-paragraph {
    font-size: 1rem;
  }
  
  .about-stats {
    flex-direction: row;
    flex-wrap: wrap;
    gap: 1rem;
  }
  
  .stat-item {
    flex: 1 1 calc(50% - 0.5rem);
    padding: 1.5rem;
  }
  
  .stat-number {
    font-size: 2rem;
  }
  
  .title-number {
    font-size: 4rem;
  }
}

@media (max-width: 480px) {
  .about {
    padding: 3rem 1rem;
  }
  
  .stat-item {
    flex: 1 1 100%;
  }
}
</style>
