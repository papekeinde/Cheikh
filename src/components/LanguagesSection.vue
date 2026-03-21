<template>
  <section class="languages-section" ref="sectionEl">
    <div class="languages-container">
      <!-- SECTION HEADER -->
      <div class="section-intro">
        <h2 class="section-heading">
          <span class="text-gradient">Tech Stack</span>
          <span class="text-secondary">& Languages</span>
        </h2>
        <p class="section-desc">
          Mastering the tools that shape modern web experiences
        </p>
      </div>

      <!-- 3D CANVAS -->
      <div class="canvas-wrapper">
        <canvas ref="canvasEl" class="three-canvas"></canvas>

        <!-- OVERLAY CONTENT -->
        <div class="languages-overlay">
          <div v-for="lang in languages" :key="lang.id" class="language-card" :style="{ '--lang-index': lang.id }">
            <div class="lang-icon" v-html="lang.icon"></div>
            <h4 class="lang-name">{{ lang.name }}</h4>
            <p class="lang-desc">{{ lang.description }}</p>
            <div class="lang-proficiency">
              <div class="proficiency-bar">
                <div class="proficiency-fill" :style="{ width: lang.proficiency + '%' }"></div>
              </div>
              <span class="proficiency-text">{{ lang.proficiency }}%</span>
            </div>
          </div>
        </div>
      </div>

      <!-- STATS -->
      <div class="languages-stats">
        <div v-for="stat in stats" :key="stat.label" class="stat-item">
          <h3 class="stat-number" ref="statNumbers">{{ stat.value }}</h3>
          <p class="stat-label">{{ stat.label }}</p>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import * as THREE from 'three'
import gsap from 'gsap'
import { ScrollTrigger } from 'gsap/ScrollTrigger'

gsap.registerPlugin(ScrollTrigger)

const sectionEl = ref(null)
const canvasEl = ref(null)
const statNumbers = ref([])

let scene, camera, renderer, particles, animationId

const languages = [
  {
    id: 0,
    name: 'Vue.js',
    description: 'Progressive JavaScript framework',
    icon: '<svg viewBox="0 0 256 221" xmlns="http://www.w3.org/2000/svg"><path d="M204.8 0H256L128 220.8L0 0h50.57L128 133.12L204.8 0Z" fill="#4FC08D"/><path d="M0 0L128 220.8L256 0h-50.6L128 133.12L50.57 0Z" fill="#4FC08D" opacity="0.5"/></svg>',
    proficiency: 95
  },
  {
    id: 1,
    name: 'Three.js',
    description: '3D JavaScript library',
    icon: '<svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"><circle cx="50" cy="50" r="45" fill="none" stroke="#00ff88" stroke-width="2"/><path d="M30 40 L50 60 L70 40 M50 60 L50 80" stroke="#00ff88" stroke-width="2" fill="none"/></svg>',
    proficiency: 85
  },
  {
    id: 2,
    name: 'GSAP',
    description: 'Animation & interactions',
    icon: '<svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"><rect x="20" y="30" width="60" height="40" fill="none" stroke="#00ccff" stroke-width="2" rx="5"/><circle cx="50" cy="50" r="8" fill="#00ccff"/><path d="M20 50 L30 50 M70 50 L80 50" stroke="#00ccff" stroke-width="2"/></svg>',
    proficiency: 90
  },
  {
    id: 3,
    name: 'JavaScript',
    description: 'Modern ES6+ development',
    icon: '<svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"><rect x="10" y="10" width="80" height="80" fill="#f7df1e" rx="10"/><text x="50" y="65" font-size="40" font-weight="bold" fill="#000" text-anchor="middle">JS</text></svg>',
    proficiency: 92
  },
  {
    id: 4,
    name: 'React',
    description: 'UI library with hooks',
    icon: '<svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"><circle cx="50" cy="50" r="15" fill="none" stroke="#61dafb" stroke-width="2"/><ellipse cx="50" cy="50" rx="40" ry="20" fill="none" stroke="#61dafb" stroke-width="2"/><ellipse cx="50" cy="50" rx="40" ry="20" fill="none" stroke="#61dafb" stroke-width="2" transform="rotate(60 50 50)"/><ellipse cx="50" cy="50" rx="40" ry="20" fill="none" stroke="#61dafb" stroke-width="2" transform="rotate(120 50 50)"/></svg>',
    proficiency: 88
  },
  {
    id: 5,
    name: 'WebGL',
    description: 'GPU-accelerated graphics',
    icon: '<svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"><path d="M30 20 L70 20 L85 50 L70 80 L30 80 L15 50 Z" fill="none" stroke="#ff6b6b" stroke-width="2"/><circle cx="50" cy="50" r="5" fill="#ff6b6b"/></svg>',
    proficiency: 80
  },
  {
    id: 6,
    name: 'CSS3',
    description: 'Advanced styling & animations',
    icon: '<svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"><rect x="15" y="15" width="70" height="70" fill="none" stroke="#1572b6" stroke-width="2"/><path d="M35 35 Q50 50 35 65 M50 35 Q65 50 50 65 M65 35 Q50 50 65 65" fill="none" stroke="#1572b6" stroke-width="2"/></svg>',
    proficiency: 93
  },
  {
    id: 7,
    name: 'TypeScript',
    description: 'Type-safe JavaScript',
    icon: '<svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"><rect x="10" y="10" width="80" height="80" fill="#3178c6" rx="5"/><text x="50" y="62" font-size="35" font-weight="bold" fill="#fff" text-anchor="middle">TS</text></svg>',
    proficiency: 87
  },
  {
    id: 8,
    name: 'Node.js',
    description: 'Backend JavaScript runtime',
    icon: '<svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"><path d="M50 15 L75 30 L75 60 L50 75 L25 60 L25 30 Z" fill="none" stroke="#68a063" stroke-width="2"/><circle cx="50" cy="45" r="8" fill="none" stroke="#68a063" stroke-width="2"/></svg>',
    proficiency: 85
  }
]

const stats = [
  { value: '9+', label: 'Languages/Frameworks' },
  { value: '60+', label: 'Completed Projects' },
  { value: '5+', label: 'Years Experience' }
]

const initThreeScene = () => {
  const canvas = canvasEl.value
  if (!canvas) return

  // Scene setup
  scene = new THREE.Scene()
  camera = new THREE.PerspectiveCamera(75, canvas.clientWidth / canvas.clientHeight, 0.1, 1000)
  camera.position.z = 8

  renderer = new THREE.WebGLRenderer({ canvas, antialias: true, alpha: true })
  renderer.setSize(canvas.clientWidth, canvas.clientHeight)
  renderer.setClearColor(0x000000, 0.1)
  renderer.setPixelRatio(window.devicePixelRatio)

  // Create particles
  const particleGeometry = new THREE.BufferGeometry()
  const particleCount = 300
  const positions = new Float32Array(particleCount * 3)

  for (let i = 0; i < particleCount * 3; i += 3) {
    positions[i] = (Math.random() - 0.5) * 30
    positions[i + 1] = (Math.random() - 0.5) * 30
    positions[i + 2] = (Math.random() - 0.5) * 30
  }

  particleGeometry.setAttribute('position', new THREE.BufferAttribute(positions, 3))

  const particleMaterial = new THREE.PointsMaterial({
    color: 0x00ff88,
    size: 0.1,
    transparent: true,
    opacity: 0.6,
    sizeAttenuation: true
  })

  particles = new THREE.Points(particleGeometry, particleMaterial)
  scene.add(particles)

  // Add lights
  const ambientLight = new THREE.AmbientLight(0xffffff, 0.5)
  scene.add(ambientLight)

  const pointLight = new THREE.PointLight(0x00ff88, 1)
  pointLight.position.set(10, 10, 10)
  scene.add(pointLight)

  // Handle resize
  const onWindowResize = () => {
    const width = canvas.clientWidth
    const height = canvas.clientHeight
    camera.aspect = width / height
    camera.updateProjectionMatrix()
    renderer.setSize(width, height)
  }

  window.addEventListener('resize', onWindowResize)

  // Animation loop with scroll integration
  const animate = () => {
    animationId = requestAnimationFrame(animate)

    // Rotate particles based on scroll
    particles.rotation.x += 0.0001
    particles.rotation.y += 0.0002

    // Update particle positions with wave effect
    const positionAttribute = particleGeometry.getAttribute('position')
    const positions = positionAttribute.array
    const time = Date.now() * 0.0001

    for (let i = 0; i < positions.length; i += 3) {
      positions[i + 1] += Math.sin(time + i) * 0.01
    }
    positionAttribute.needsUpdate = true

    // Glow effect
    particleMaterial.opacity = 0.3 + Math.sin(time) * 0.3

    renderer.render(scene, camera)
  }

  animate()

  return () => {
    window.removeEventListener('resize', onWindowResize)
    if (animationId) cancelAnimationFrame(animationId)
    renderer.dispose()
  }
}

onMounted(() => {
  initThreeScene()

  // LANGUAGE CARDS ANIMATION
  gsap.from('.language-card', {
    scrollTrigger: {
      trigger: '.languages-section',
      start: 'top 60%',
      end: 'top 20%',
      scrub: 1
    },
    opacity: 0,
    y: 100,
    rotation: 10,
    stagger: 0.1,
    ease: 'power2.out'
  })

  // PROFICIENCY BAR ANIMATION
  gsap.from('.proficiency-fill', {
    scrollTrigger: {
      trigger: '.languages-section',
      start: 'top 60%'
    },
    width: 0,
    duration: 2,
    stagger: 0.15,
    ease: 'power2.inOut'
  })

  // STATS COUNTER ANIMATION
  statNumbers.value.forEach((el, idx) => {
    const stat = stats[idx]
    const numValue = parseInt(stat.value)

    gsap.to({ value: 0 }, {
      scrollTrigger: {
        trigger: '.languages-stats',
        start: 'top 70%'
      },
      value: numValue,
      duration: 2.5,
      ease: 'power2.out',
      onUpdate: function() {
        el.textContent = Math.floor(this.targets()[0].value) + (stat.value.includes('+') ? '+' : '')
      }
    })
  })

  // SECTION HEADER ANIMATION
  gsap.from('.section-heading, .section-desc', {
    scrollTrigger: {
      trigger: '.languages-section',
      start: 'top 80%'
    },
    opacity: 0,
    y: 30,
    duration: 0.8,
    stagger: 0.2,
    ease: 'power2.out'
  })
})

onUnmounted(() => {
  ScrollTrigger.getAll().forEach(trigger => trigger.kill())
  if (animationId) cancelAnimationFrame(animationId)
})
</script>

<style scoped>
.languages-section {
  position: relative;
  min-height: 200vh;
  background: linear-gradient(135deg, #0a0a0a 0%, #1a1a1a 50%, #0a0a0a 100%);
  padding: 6rem 2rem;
  overflow: hidden;
}

.languages-section::before {
  content: '';
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: radial-gradient(circle at 20% 50%, rgba(0, 255, 136, 0.05), transparent 40%),
              radial-gradient(circle at 80% 50%, rgba(0, 200, 255, 0.03), transparent 40%);
  pointer-events: none;
  z-index: 1;
}

.languages-container {
  max-width: 1400px;
  margin: 0 auto;
  position: relative;
  z-index: 2;
}

.section-intro {
  text-align: center;
  margin-bottom: 6rem;
}

.section-heading {
  font-size: clamp(2.5rem, 6vw, 4rem);
  font-weight: 800;
  margin: 0 0 1rem;
  letter-spacing: -0.02em;
  line-height: 1.1;
}

.text-gradient {
  background: linear-gradient(135deg, #00ff88 0%, #00ccff 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

.text-secondary {
  display: block;
  color: #aaa;
  font-weight: 400;
  font-size: 1.5rem;
  margin-top: 0.5rem;
}

.section-desc {
  font-size: 1.1rem;
  color: #888;
  max-width: 500px;
  margin: 1.5rem auto 0;
  letter-spacing: 0.02em;
  font-weight: 300;
}

.canvas-wrapper {
  position: relative;
  height: 600px;
  margin: 4rem 0;
  background: rgba(0, 0, 0, 0.3);
  border: 1px solid rgba(0, 255, 136, 0.1);
  border-radius: 20px;
  overflow: hidden;
}

.three-canvas {
  width: 100%;
  height: 100%;
  display: block;
}

.languages-overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 2rem;
  padding: 2rem;
  align-content: center;
  pointer-events: none;
}

.language-card {
  background: linear-gradient(135deg, rgba(0, 255, 136, 0.08), rgba(0, 200, 255, 0.03));
  border: 1px solid rgba(0, 255, 136, 0.2);
  border-radius: 12px;
  padding: 1.5rem;
  text-align: center;
  backdrop-filter: blur(10px);
  transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
  cursor: pointer;
  pointer-events: auto;
}

.language-card:hover {
  background: linear-gradient(135deg, rgba(0, 255, 136, 0.15), rgba(0, 200, 255, 0.08));
  border-color: #00ff88;
  transform: translateY(-8px);
  box-shadow: 0 20px 40px rgba(0, 255, 136, 0.2);
}

.lang-icon {
  width: 50px;
  height: 50px;
  margin: 0 auto 1rem;
  display: flex;
  align-items: center;
  justify-content: center;
  filter: drop-shadow(0 0 10px rgba(0, 255, 136, 0.3));
}

.lang-icon svg {
  width: 100%;
  height: 100%;
}

.lang-name {
  font-size: 1.1rem;
  font-weight: 700;
  color: #fff;
  margin: 0 0 0.5rem;
  text-transform: uppercase;
  letter-spacing: 0.05em;
}

.lang-desc {
  font-size: 0.85rem;
  color: #aaa;
  margin: 0 0 1rem;
  font-weight: 300;
  min-height: 40px;
}

.lang-proficiency {
  display: flex;
  align-items: center;
  gap: 0.8rem;
}

.proficiency-bar {
  flex: 1;
  height: 4px;
  background: rgba(0, 255, 136, 0.1);
  border-radius: 2px;
  overflow: hidden;
}

.proficiency-fill {
  height: 100%;
  background: linear-gradient(90deg, #00ff88, #00ccff);
  width: 0;
  border-radius: 2px;
}

.proficiency-text {
  font-size: 0.75rem;
  font-weight: 600;
  color: #00ff88;
  min-width: 35px;
  text-align: right;
}

.languages-stats {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 2rem;
  margin-top: 6rem;
  padding: 3rem;
  background: rgba(0, 255, 136, 0.05);
  border: 1px solid rgba(0, 255, 136, 0.1);
  border-radius: 20px;
}

.stat-item {
  text-align: center;
}

.stat-number {
  font-size: clamp(2.5rem, 6vw, 3.5rem);
  font-weight: 800;
  background: linear-gradient(135deg, #00ff88, #00ccff);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  margin: 0 0 0.5rem;
}

.stat-label {
  font-size: 0.95rem;
  color: #888;
  letter-spacing: 0.05em;
  text-transform: uppercase;
  margin: 0;
  font-weight: 500;
}

@media (max-width: 1024px) {
  .languages-section {
    min-height: auto;
    padding: 5rem 1.5rem;
  }
  
  .canvas-wrapper {
    height: 500px;
  }
  
  .languages-overlay {
    grid-template-columns: repeat(3, 1fr);
  }
}

@media (max-width: 768px) {
  .languages-section {
    min-height: auto;
    padding: 4rem 1rem;
  }

  .section-heading {
    font-size: clamp(1.8rem, 5vw, 2.5rem);
  }

  .text-secondary {
    font-size: 1.1rem;
  }

  .section-intro {
    margin-bottom: 3rem;
  }

  .canvas-wrapper {
    height: auto;
    min-height: 500px;
  }

  .languages-overlay {
    position: relative;
    grid-template-columns: repeat(2, 1fr);
    gap: 0.75rem;
    padding: 1rem;
  }

  .three-canvas {
    position: absolute;
    top: 0;
    left: 0;
  }

  .language-card {
    padding: 1rem;
  }

  .lang-icon {
    width: 35px;
    height: 35px;
    margin-bottom: 0.5rem;
  }

  .lang-name {
    font-size: 0.85rem;
  }

  .lang-desc {
    font-size: 0.7rem;
    min-height: auto;
    margin-bottom: 0.5rem;
  }

  .languages-stats {
    margin-top: 3rem;
    padding: 2rem 1.5rem;
    gap: 1.5rem;
    grid-template-columns: repeat(3, 1fr);
  }

  .stat-number {
    font-size: clamp(1.8rem, 5vw, 2.5rem);
  }

  .stat-label {
    font-size: 0.75rem;
  }
}

@media (max-width: 480px) {
  .languages-section {
    padding: 3rem 0.75rem;
  }

  .languages-overlay {
    grid-template-columns: 1fr 1fr;
    gap: 0.5rem;
    padding: 0.5rem;
  }

  .language-card {
    padding: 0.75rem;
  }

  .lang-desc {
    display: none;
  }

  .languages-stats {
    grid-template-columns: 1fr;
    padding: 1.5rem;
  }
}
</style>
