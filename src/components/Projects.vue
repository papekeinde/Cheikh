<template>
  <section id="projects" class="projects" ref="projectsRef">
    <div class="container">
      <div class="projects-header">
        <h2 class="section-title">PROJETS</h2>
        <div class="title-number">02</div>
      </div>
      
      <div class="projects-grid">
        <div 
          v-for="(project, index) in projects" 
          :key="index"
          class="project-card"
          :ref="el => projectCards[index] = el"
          @mouseenter="onProjectHover(index)"
          @mouseleave="onProjectLeave(index)"
        >
          <div class="project-image">
            <div class="project-overlay">
              <span class="project-view">Voir le projet</span>
            </div>
          </div>
          <div class="project-info">
            <h3 class="project-title">{{ project.title }}</h3>
            <p class="project-description">{{ project.description }}</p>
            <div class="project-tags">
              <span v-for="tag in project.tags" :key="tag" class="project-tag">{{ tag }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue'
import { gsap } from 'gsap'
import { ScrollTrigger } from 'gsap/ScrollTrigger'

gsap.registerPlugin(ScrollTrigger)

const projectsRef = ref(null)
const projectCards = ref([])

const projects = reactive([
  {
    title: 'PROJET CRÉATIF 01',
    description: 'Une expérience immersive avec animations 3D et interactions avancées',
    tags: ['Vue.js', 'Three.js', 'GSAP']
  },
  {
    title: 'PROJET ARTISTIQUE 02',
    description: 'Portfolio interactif avec transitions fluides et design moderne',
    tags: ['React', 'WebGL', 'Framer']
  },
  {
    title: 'EXPÉRIENCE DIGITALE 03',
    description: 'Plateforme web innovante combinant art et technologie',
    tags: ['Next.js', 'Canvas', 'GSAP']
  },
  {
    title: 'INSTALLATION INTERACTIVE 04',
    description: 'Projet expérimental explorant les limites du web design',
    tags: ['Vue.js', 'Shader', 'Three.js']
  }
])

onMounted(() => {
  projectCards.value.forEach((card, index) => {
    if (card) {
      gsap.from(card, {
        y: 100,
        opacity: 0,
        duration: 0.8,
        delay: index * 0.1,
        scrollTrigger: {
          trigger: card,
          start: 'top 85%',
          toggleActions: 'play none none reverse'
        }
      })
    }
  })
})

const onProjectHover = (index) => {
  const card = projectCards.value[index]
  if (card) {
    gsap.to(card.querySelector('.project-image'), {
      scale: 1.05,
      duration: 0.5,
      ease: 'power2.out'
    })
    gsap.to(card.querySelector('.project-overlay'), {
      opacity: 1,
      duration: 0.3
    })
  }
}

const onProjectLeave = (index) => {
  const card = projectCards.value[index]
  if (card) {
    gsap.to(card.querySelector('.project-image'), {
      scale: 1,
      duration: 0.5,
      ease: 'power2.out'
    })
    gsap.to(card.querySelector('.project-overlay'), {
      opacity: 0,
      duration: 0.3
    })
  }
}
</script>

<style scoped>
.projects {
  min-height: 100vh;
  padding: 8rem 4rem;
  position: relative;
}

.container {
  max-width: 1400px;
  margin: 0 auto;
}

.projects-header {
  position: relative;
  margin-bottom: 5rem;
}

.section-title {
  font-size: clamp(3rem, 8vw, 6rem);
  font-weight: 700;
  letter-spacing: 0.05em;
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

.projects-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 3rem;
}

.project-card {
  cursor: pointer;
  transition: transform 0.3s ease;
}

.project-image {
  position: relative;
  width: 100%;
  aspect-ratio: 16/10;
  background: linear-gradient(135deg, rgba(255, 107, 107, 0.2), rgba(78, 205, 196, 0.2));
  overflow: hidden;
  margin-bottom: 1.5rem;
}

.project-overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(255, 107, 107, 0.9);
  display: flex;
  align-items: center;
  justify-content: center;
  opacity: 0;
  transition: opacity 0.3s ease;
}

.project-view {
  font-size: 1.25rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.1em;
  color: var(--color-text);
}

.project-info {
  padding: 0 0.5rem;
}

.project-title {
  font-size: 1.5rem;
  font-weight: 600;
  margin-bottom: 1rem;
  letter-spacing: 0.05em;
}

.project-description {
  font-size: 1rem;
  color: rgba(255, 255, 255, 0.7);
  margin-bottom: 1.5rem;
  line-height: 1.6;
}

.project-tags {
  display: flex;
  gap: 0.75rem;
  flex-wrap: wrap;
}

.project-tag {
  font-size: 0.75rem;
  padding: 0.5rem 1rem;
  background: rgba(255, 255, 255, 0.05);
  border: 1px solid rgba(255, 255, 255, 0.1);
  text-transform: uppercase;
  letter-spacing: 0.1em;
  transition: all 0.3s ease;
}

.project-tag:hover {
  background: rgba(255, 107, 107, 0.2);
  border-color: var(--color-accent);
}

@media (max-width: 1024px) {
  .projects {
    padding: 6rem 3rem;
  }
  
  .projects-grid {
    gap: 2rem;
  }
  
  .project-title {
    font-size: 1.25rem;
  }
}

@media (max-width: 768px) {
  .projects {
    padding: 4rem 1.5rem;
  }
  
  .projects-header {
    margin-bottom: 3rem;
  }
  
  .projects-grid {
    grid-template-columns: 1fr;
    gap: 2.5rem;
  }
  
  .project-title {
    font-size: 1.2rem;
  }
  
  .project-description {
    font-size: 0.9rem;
  }
  
  .project-tag {
    font-size: 0.7rem;
    padding: 0.4rem 0.75rem;
  }
}

@media (max-width: 480px) {
  .projects {
    padding: 3rem 1rem;
  }
  
  .project-image {
    aspect-ratio: 16/9;
  }
}
</style>
