<template>
  <section id="skills" class="skills" ref="skillsRef">
    <div class="container">
      <div class="skills-header">
        <h2 class="section-title">COMPÉTENCES</h2>
        <div class="title-number">03</div>
      </div>
      
      <div class="skills-content">
        <div class="skills-category" v-for="(category, index) in skillsData" :key="index" :ref="el => categoryRefs[index] = el">
          <h3 class="category-title">{{ category.title }}</h3>
          <div class="skills-list">
            <div v-for="skill in category.skills" :key="skill.name" class="skill-item">
              <div class="skill-header">
                <span class="skill-name">{{ skill.name }}</span>
                <span class="skill-percentage">{{ skill.level }}%</span>
              </div>
              <div class="skill-bar">
                <div class="skill-progress" :style="{ width: '0%' }" :data-level="skill.level"></div>
              </div>
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

const skillsRef = ref(null)
const categoryRefs = ref([])

const skillsData = reactive([
  {
    title: 'DÉVELOPPEMENT FRONTEND',
    skills: [
      { name: 'Vue.js / React', level: 95 },
      { name: 'JavaScript / TypeScript', level: 90 },
      { name: 'HTML5 / CSS3', level: 95 },
      { name: 'Three.js / WebGL', level: 85 }
    ]
  },
  {
    title: 'DESIGN & ANIMATION',
    skills: [
      { name: 'GSAP / Framer Motion', level: 90 },
      { name: 'UI/UX Design', level: 85 },
      { name: 'Adobe Creative Suite', level: 80 },
      { name: 'Figma / Sketch', level: 88 }
    ]
  },
  {
    title: 'DÉVELOPPEMENT BACKEND',
    skills: [
      { name: 'Node.js / Express', level: 85 },
      { name: 'PHP / Laravel', level: 80 },
      { name: 'MongoDB / MySQL', level: 82 },
      { name: 'API REST / GraphQL', level: 88 }
    ]
  }
])

onMounted(() => {
  categoryRefs.value.forEach((category, index) => {
    if (category) {
      gsap.from(category, {
        y: 80,
        opacity: 0,
        duration: 0.8,
        delay: index * 0.2,
        scrollTrigger: {
          trigger: category,
          start: 'top 85%',
          toggleActions: 'play none none reverse'
        }
      })
      
      // Animate skill bars
      const skillBars = category.querySelectorAll('.skill-progress')
      skillBars.forEach((bar, i) => {
        const level = bar.getAttribute('data-level')
        gsap.to(bar, {
          width: `${level}%`,
          duration: 1.5,
          delay: index * 0.2 + i * 0.1,
          ease: 'power3.out',
          scrollTrigger: {
            trigger: category,
            start: 'top 80%',
            toggleActions: 'play none none reverse'
          }
        })
      })
    }
  })
})
</script>

<style scoped>
.skills {
  min-height: 100vh;
  padding: 8rem 4rem;
  position: relative;
}

.container {
  max-width: 1200px;
  margin: 0 auto;
}

.skills-header {
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

.skills-content {
  display: flex;
  flex-direction: column;
  gap: 4rem;
}

.skills-category {
  background: rgba(255, 255, 255, 0.02);
  padding: 3rem;
  border: 1px solid rgba(255, 255, 255, 0.05);
  transition: all 0.3s ease;
}

.skills-category:hover {
  background: rgba(255, 255, 255, 0.03);
  border-color: rgba(255, 107, 107, 0.3);
  transform: translateY(-5px);
}

.category-title {
  font-size: 1.5rem;
  font-weight: 600;
  letter-spacing: 0.1em;
  margin-bottom: 2rem;
  color: var(--color-accent);
  text-transform: uppercase;
}

.skills-list {
  display: flex;
  flex-direction: column;
  gap: 2rem;
}

.skill-item {
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
}

.skill-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.skill-name {
  font-size: 1rem;
  font-weight: 500;
  color: rgba(255, 255, 255, 0.9);
}

.skill-percentage {
  font-size: 0.875rem;
  font-weight: 600;
  color: var(--color-secondary);
  font-family: monospace;
}

.skill-bar {
  width: 100%;
  height: 4px;
  background: rgba(255, 255, 255, 0.1);
  border-radius: 2px;
  overflow: hidden;
  position: relative;
}

.skill-progress {
  position: absolute;
  top: 0;
  left: 0;
  height: 100%;
  background: linear-gradient(90deg, var(--color-accent), var(--color-secondary));
  border-radius: 2px;
  transition: width 1s ease;
}

@media (max-width: 1024px) {
  .skills {
    padding: 6rem 3rem;
  }
}

@media (max-width: 768px) {
  .skills {
    padding: 4rem 1.5rem;
  }
  
  .skills-header {
    margin-bottom: 3rem;
  }
  
  .skills-content {
    gap: 2.5rem;
  }
  
  .skills-category {
    padding: 1.5rem;
  }
  
  .category-title {
    font-size: 1.1rem;
    margin-bottom: 1.5rem;
  }
  
  .skill-name {
    font-size: 0.875rem;
  }
}

@media (max-width: 480px) {
  .skills {
    padding: 3rem 1rem;
  }
  
  .skills-category {
    padding: 1.25rem;
  }
}
</style>
