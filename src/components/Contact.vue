<template>
  <section id="contact" class="contact" ref="contactRef">
    <div class="container">
      <div class="contact-header">
        <h2 class="section-title">CONTACT</h2>
        <div class="title-number">04</div>
      </div>
      
      <div class="contact-content">
        <div class="contact-info" ref="infoRef">
          <p class="contact-intro">
            Vous avez un projet en tête ? Discutons-en ensemble et créons 
            quelque chose d'extraordinaire.
          </p>
          
          <div class="contact-details">
            <div class="contact-detail">
              <span class="detail-label">Email</span>
              <a href="mailto:contact@portfolio.com" class="detail-value">contact@portfolio.com</a>
            </div>
            <div class="contact-detail">
              <span class="detail-label">Téléphone</span>
              <a href="tel:+33123456789" class="detail-value">+33 1 23 45 67 89</a>
            </div>
            <div class="contact-detail">
              <span class="detail-label">Réseaux</span>
              <div class="social-links">
                <a href="#" class="social-link">GitHub</a>
                <a href="#" class="social-link">LinkedIn</a>
                <a href="#" class="social-link">Twitter</a>
                <a href="#" class="social-link">Dribbble</a>
              </div>
            </div>
          </div>
        </div>
        
        <form class="contact-form" ref="formRef" @submit.prevent="handleSubmit">
          <div class="form-group">
            <input 
              type="text" 
              placeholder="Votre nom" 
              class="form-input"
              required
            />
          </div>
          <div class="form-group">
            <input 
              type="email" 
              placeholder="Votre email" 
              class="form-input"
              required
            />
          </div>
          <div class="form-group">
            <input 
              type="text" 
              placeholder="Sujet" 
              class="form-input"
              required
            />
          </div>
          <div class="form-group">
            <textarea 
              placeholder="Votre message" 
              class="form-input form-textarea"
              rows="6"
              required
            ></textarea>
          </div>
          <button type="submit" class="form-submit">
            <span>Envoyer le message</span>
          </button>
        </form>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { gsap } from 'gsap'
import { ScrollTrigger } from 'gsap/ScrollTrigger'

gsap.registerPlugin(ScrollTrigger)

const contactRef = ref(null)
const infoRef = ref(null)
const formRef = ref(null)

onMounted(() => {
  gsap.from(infoRef.value, {
    x: -100,
    opacity: 0,
    duration: 1,
    scrollTrigger: {
      trigger: contactRef.value,
      start: 'top 80%',
      toggleActions: 'play none none reverse'
    }
  })
  
  gsap.from('.form-group', {
    y: 50,
    opacity: 0,
    duration: 0.8,
    stagger: 0.1,
    scrollTrigger: {
      trigger: formRef.value,
      start: 'top 80%',
      toggleActions: 'play none none reverse'
    }
  })
})

const handleSubmit = () => {
  gsap.to('.form-submit', {
    scale: 0.95,
    duration: 0.1,
    yoyo: true,
    repeat: 1
  })
  
  // Handle form submission
  alert('Message envoyé avec succès !')
}
</script>

<style scoped>
.contact {
  min-height: 100vh;
  padding: 8rem 4rem;
  position: relative;
}

.container {
  max-width: 1200px;
  margin: 0 auto;
}

.contact-header {
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

.contact-content {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 5rem;
}

.contact-intro {
  font-size: 1.25rem;
  line-height: 1.8;
  color: rgba(255, 255, 255, 0.8);
  margin-bottom: 3rem;
}

.contact-details {
  display: flex;
  flex-direction: column;
  gap: 2.5rem;
}

.contact-detail {
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
}

.detail-label {
  font-size: 0.75rem;
  text-transform: uppercase;
  letter-spacing: 0.2em;
  color: var(--color-accent);
  font-weight: 600;
}

.detail-value {
  font-size: 1.125rem;
  color: var(--color-text);
  text-decoration: none;
  transition: color 0.3s ease;
}

.detail-value:hover {
  color: var(--color-accent);
}

.social-links {
  display: flex;
  gap: 1.5rem;
  flex-wrap: wrap;
}

.social-link {
  font-size: 0.875rem;
  color: var(--color-text);
  text-decoration: none;
  padding: 0.5rem 1rem;
  border: 1px solid rgba(255, 255, 255, 0.2);
  transition: all 0.3s ease;
}

.social-link:hover {
  background: var(--color-accent);
  border-color: var(--color-accent);
}

.contact-form {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}

.form-group {
  display: flex;
  flex-direction: column;
}

.form-input {
  width: 100%;
  padding: 1rem 1.5rem;
  font-size: 1rem;
  font-family: var(--font-primary);
  color: var(--color-text);
  background: rgba(255, 255, 255, 0.03);
  border: 1px solid rgba(255, 255, 255, 0.1);
  outline: none;
  transition: all 0.3s ease;
}

.form-input:focus {
  background: rgba(255, 255, 255, 0.05);
  border-color: var(--color-accent);
}

.form-input::placeholder {
  color: rgba(255, 255, 255, 0.4);
}

.form-textarea {
  resize: vertical;
  min-height: 150px;
}

.form-submit {
  padding: 1.25rem 2.5rem;
  font-size: 0.875rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.1em;
  color: var(--color-text);
  background: var(--color-accent);
  border: none;
  cursor: pointer;
  transition: all 0.3s ease;
  position: relative;
  overflow: hidden;
  align-self: flex-start;
}

.form-submit::before {
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

.form-submit:hover::before {
  left: 0;
}

.form-submit:hover {
  transform: translateY(-2px);
  box-shadow: 0 10px 30px rgba(255, 107, 107, 0.3);
}

@media (max-width: 1024px) {
  .contact {
    padding: 6rem 3rem;
  }
  
  .contact-content {
    gap: 3rem;
  }
}

@media (max-width: 768px) {
  .contact {
    padding: 4rem 1.5rem;
  }
  
  .contact-header {
    margin-bottom: 3rem;
  }
  
  .contact-content {
    grid-template-columns: 1fr;
    gap: 2.5rem;
  }
  
  .contact-intro {
    font-size: 1.1rem;
    margin-bottom: 2rem;
  }
  
  .social-links {
    gap: 0.75rem;
  }
  
  .social-link {
    font-size: 0.8rem;
    padding: 0.4rem 0.8rem;
  }
  
  .form-input {
    padding: 0.9rem 1.2rem;
    font-size: 0.9rem;
  }
  
  .form-submit {
    width: 100%;
    text-align: center;
  }
}

@media (max-width: 480px) {
  .contact {
    padding: 3rem 1rem;
  }
  
  .contact-details {
    gap: 1.5rem;
  }
}
</style>
