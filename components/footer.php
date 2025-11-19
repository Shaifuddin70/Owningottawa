<!-- Footer Placeholder -->
<div id="footer-placeholder"></div>

<!-- Modern Footer -->
<footer class="modern-footer">
  <div class="footer-top">
    <div class="container">
      <div class="footer-grid">
        <!-- Brand Section -->
        <div class="footer-brand scroll-animate">
          <div class="footer-logo">
            <a href="/" class="footer-logo-link">
              <img src="images/owningottawa.jpg" alt="OwningOttawa" class="footer-logo-img">
              <span class="footer-logo-text">OwningOttawa</span>
            </a>
          </div>
          <p class="footer-description">Your trusted real estate partner in Ottawa. Helping first-time buyers, homeowners, and residential investors navigate the market with clarity and confidence.</p>

          <div class="footer-contact-info">
            <a href="tel:6133186478" class="footer-contact-item">
              <i class="fas fa-phone-alt"></i>
              <span>613-318-6478</span>
            </a>
            <a href="mailto:info@owningottawa.ca" class="footer-contact-item">
              <i class="fas fa-envelope"></i>
              <span>info@owningottawa.ca</span>
            </a>
          </div>

          <div class="footer-social">
            <a href="#" class="social-link" aria-label="Facebook">
              <i class="fab fa-facebook-f"></i>
            </a>
            <a href="#" class="social-link" aria-label="Instagram">
              <i class="fab fa-instagram"></i>
            </a>
            <a href="#" class="social-link" aria-label="LinkedIn">
              <i class="fab fa-linkedin-in"></i>
            </a>
            <a href="#" class="social-link" aria-label="Twitter">
              <i class="fab fa-twitter"></i>
            </a>
          </div>
        </div>

        <!-- Services Section -->
        <div class="footer-section scroll-animate delay-1">
          <h3 class="footer-title">
            <i class="fas fa-briefcase"></i>
            Our Services
          </h3>
          <ul class="footer-links">
            <li>
              <a href="/services#real-estate">
                <i class="fas fa-home-lg-alt"></i>
                <span>Real Estate Services</span>
              </a>
            </li>
            <li>
              <a href="/services#mortgage">
                <i class="fas fa-percent"></i>
                <span>Mortgage Solutions</span>
              </a>
            </li>
            <li>
              <a href="/services#property-management">
                <i class="fas fa-building"></i>
                <span>Property Management</span>
              </a>
            </li>
            <li>
              <a href="/services#bookkeeping">
                <i class="fas fa-calculator"></i>
                <span>Bookkeeping & Accounting</span>
              </a>
            </li>
            <li>
              <a href="/services#permits">
                <i class="fas fa-drafting-compass"></i>
                <span>Building Permits & Design</span>
              </a>
            </li>
          </ul>
        </div>

        <!-- Quick Links Section -->
        <div class="footer-section scroll-animate delay-2">
          <h3 class="footer-title">
            <i class="fas fa-link"></i>
            Quick Links
          </h3>
          <ul class="footer-links">
            <li>
              <a href="/">
                <i class="fas fa-home"></i>
                <span>Home</span>
              </a>
            </li>
            <li>
              <a href="/about">
                <i class="fas fa-users"></i>
                <span>About Us</span>
              </a>
            </li>
            <li>
              <a href="/services">
                <i class="fas fa-briefcase"></i>
                <span>Our Services</span>
              </a>
            </li>
            <li>
              <a href="/contact">
                <i class="fas fa-envelope"></i>
                <span>Contact Us</span>
              </a>
            </li>
          </ul>
        </div>

        <!-- Newsletter / CTA Section -->
        <div class="footer-section footer-cta scroll-animate delay-3">
          <h3 class="footer-title">
            <i class="fas fa-paper-plane"></i>
            Get In Touch
          </h3>
          <p class="footer-cta-text">Ready to start your real estate journey? Let's discuss how we can help you achieve your property goals.</p>
          <a href="/contact" class="footer-cta-button">
            <span>Book a Consultation</span>
            <i class="fas fa-arrow-right"></i>
          </a>

          <div class="footer-hours">
            <h4 class="footer-hours-title">
              <i class="fas fa-clock"></i>
              Business Hours
            </h4>
            <div class="footer-hours-list">
              <div class="footer-hour-item">
                <span>Monday - Friday</span>
                <span>9:00 AM - 5:00 PM</span>
              </div>
              <div class="footer-hour-item">
                <span>Saturday</span>
                <span>By Appointment</span>
              </div>
              <div class="footer-hour-item">
                <span>Sunday</span>
                <span>Closed</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer Bottom -->
  <div class="footer-bottom">
    <div class="container">
      <div class="footer-bottom-content">
        <div class="footer-copyright">
          <p>&copy; 2025 <span class="copyright-brand">OwningOttawa</span>. All rights reserved.</p>
          <p class="footer-tagline">All services are provided with professionalism, transparency, and local market expertise.</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Back to Top Button -->
  <button class="back-to-top" id="backToTop" aria-label="Back to top">
    <i class="fas fa-arrow-up"></i>
  </button>
</footer>

<!-- Fixed Pop-up Button (Bottom Left) -->
<a href="/contact" class="popup-button" id="popupButton" aria-label="Contact Us">
  <i class="fas fa-comments"></i>
  <span class="popup-button-text">Get in Touch</span>
</a>

<script>
  // Back to top button
  const backToTop = document.getElementById('backToTop');

  window.addEventListener('scroll', () => {
    if (window.scrollY > 300) {
      backToTop.classList.add('show');
    } else {
      backToTop.classList.remove('show');
    }
  });

  backToTop.addEventListener('click', () => {
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  });

  // Scroll animations for footer
  const footerObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('animated');
      }
    });
  }, {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
  });

  document.addEventListener('DOMContentLoaded', () => {
    const footerAnimated = document.querySelectorAll('.footer-section, .footer-brand');
    footerAnimated.forEach(el => footerObserver.observe(el));
  });

  // Form handling (if form exists)
  var form = document.getElementById("my-form");
  if (form) {
    async function handleSubmit(event) {
      event.preventDefault();
      var status = document.getElementById("my-form-status");
      var data = new FormData(event.target);
      fetch(event.target.action, {
        method: form.method,
        body: data,
        headers: {
          'Accept': 'application/json'
        }
      }).then(response => {
        if (response.ok) {
          status.innerHTML = "Thanks for your submission!";
          form.reset()
        } else {
          response.json().then(data => {
            if (Object.hasOwn(data, 'errors')) {
              status.innerHTML = data["errors"].map(error => error["message"]).join(", ")
            } else {
              status.innerHTML = "Oops! There was a problem submitting your form"
            }
          })
        }
      }).catch(error => {
        status.innerHTML = "Oops! There was a problem submitting your form"
      });
    }
    form.addEventListener("submit", handleSubmit);
  }

  // FAQ Toggle (if exists on page)
  function toggleFAQ(button) {
    const faqItem = button.parentElement;
    const answer = faqItem.querySelector('.faq-answer');
    const icon = button.querySelector('i');

    // Close all other FAQ items
    document.querySelectorAll('.faq-item').forEach(item => {
      if (item !== faqItem) {
        item.classList.remove('active');
        if (item.querySelector('.faq-answer')) {
          item.querySelector('.faq-answer').style.maxHeight = '0';
        }
        const questionIcon = item.querySelector('.faq-question i');
        if (questionIcon) {
          questionIcon.style.transform = 'rotate(0deg)';
        }
      }
    });

    // Toggle current FAQ item
    faqItem.classList.toggle('active');

    if (faqItem.classList.contains('active')) {
      if (answer) {
        answer.style.maxHeight = answer.scrollHeight + 'px';
      }
      if (icon) {
        icon.style.transform = 'rotate(180deg)';
      }
    } else {
      if (answer) {
        answer.style.maxHeight = '0';
      }
      if (icon) {
        icon.style.transform = 'rotate(0deg)';
      }
    }
  }

  // Social FAB (if exists)
  (function() {
    const fab = document.getElementById('socialFab');
    const toggle = document.getElementById('socialFabToggle');
    const actions = document.getElementById('socialFabActions');
    if (!fab || !toggle || !actions) return;

    function openFab() {
      fab.classList.add('open');
      toggle.setAttribute('aria-expanded', 'true');
      actions.setAttribute('aria-hidden', 'false');
    }

    function closeFab() {
      fab.classList.remove('open');
      toggle.setAttribute('aria-expanded', 'false');
      actions.setAttribute('aria-hidden', 'true');
    }

    toggle.addEventListener('click', function(e) {
      e.stopPropagation();
      if (fab.classList.contains('open')) {
        closeFab();
      } else {
        openFab();
      }
    });

    document.addEventListener('click', function(e) {
      if (!fab.contains(e.target)) {
        closeFab();
      }
    });

    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') closeFab();
    });

    actions.querySelectorAll('.fab-action').forEach(function(a) {
      a.addEventListener('click', function() {
        closeFab();
      });
    });
  })();

  // Partner slider (if exists)
  let currentPartnerSlide = 1;
  const totalPartnerSlides = 6;
  let isManualControl = false;

  function currentSlide(n) {
    isManualControl = true;
    showPartnerSlide(currentPartnerSlide = n);
    setTimeout(() => {
      isManualControl = false;
    }, 3000);
  }

  function showPartnerSlide(n) {
    const track = document.getElementById('partnerTrack');
    const dots = document.querySelectorAll('.dot');

    if (!track || dots.length === 0) return;

    dots.forEach(dot => dot.classList.remove('active'));
    if (dots[n - 1]) {
      dots[n - 1].classList.add('active');
    }

    const slideWidth = 230;
    const translateX = -(n - 1) * slideWidth;
    track.style.transform = `translateX(${translateX}px)`;

    if (isManualControl) {
      track.style.animation = 'none';
    } else {
      track.style.animation = 'slideRightToLeft 20s linear infinite';
    }
  }

  if (document.getElementById('partnerTrack')) {
    setInterval(() => {
      if (!isManualControl) {
        currentPartnerSlide = currentPartnerSlide >= totalPartnerSlides ? 1 : currentPartnerSlide + 1;
        showPartnerSlide(currentPartnerSlide);
      }
    }, 3000);
  }

  // Hero slider (if exists)
  let currentSlideIndex = 0;
  const slides = document.querySelectorAll('.hero-slide');
  const heroDots = document.querySelectorAll('.hero-slider-dots .dot');
  let slideInterval;

  function showSlide(index) {
    if (slides.length === 0) return;

    slides.forEach(slide => slide.classList.remove('active'));
    heroDots.forEach(dot => dot.classList.remove('active'));

    if (slides[index]) {
      slides[index].classList.add('active');
    }
    if (heroDots[index]) {
      heroDots[index].classList.add('active');
    }

    currentSlideIndex = index;
  }

  function nextSlide() {
    if (slides.length === 0) return;
    const nextIndex = (currentSlideIndex + 1) % slides.length;
    showSlide(nextIndex);
  }

  function startSlideShow() {
    if (slides.length === 0) return;
    slideInterval = setInterval(nextSlide, 5000);
  }

  function stopSlideShow() {
    clearInterval(slideInterval);
  }

  window.currentSlide = function(index) {
    showSlide(index - 1);
    stopSlideShow();
    startSlideShow();
  };

  // Scroll Animation System
  if (typeof observerOptions === 'undefined') {
    var observerOptions = {
      threshold: 0.1,
      rootMargin: '0px 0px -50px 0px'
    };
  }

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('animate-in');
        observer.unobserve(entry.target);
      }
    });
  }, observerOptions);

  document.addEventListener('DOMContentLoaded', function() {
    const animatedElements = document.querySelectorAll('.scroll-animate, .scroll-animate-left, .scroll-animate-right, .scroll-animate-scale');
    animatedElements.forEach(el => {
      observer.observe(el);
    });

    if (slides.length > 0) {
      showSlide(0);
      startSlideShow();
    }

    const statNumbers = document.querySelectorAll('.stat-number');
    const statsObserver = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          const target = parseInt(entry.target.getAttribute('data-target'));
          if (target) {
            animateCounter(entry.target, target);
            statsObserver.unobserve(entry.target);
          }
        }
      });
    }, {
      threshold: 0.5
    });

    statNumbers.forEach(stat => {
      if (stat.getAttribute('data-target')) {
        statsObserver.observe(stat);
      }
    });
  });

  function animateCounter(element, target) {
    let current = 0;
    const increment = target / 100;
    const timer = setInterval(() => {
      current += increment;
      if (current >= target) {
        current = target;
        clearInterval(timer);
      }

      if (target >= 1000000) {
        element.textContent = formatNumber(Math.floor(current));
      } else {
        element.textContent = Math.floor(current);
      }
    }, 20);
  }

  function formatNumber(num) {
    if (num >= 1000000) {
      return (num / 1000000).toFixed(1) + 'M+';
    } else if (num >= 1000) {
      return (num / 1000).toFixed(1) + 'K+';
    }
    return num.toString();
  }

  // Typing animation (if exists)
  function initTypingAnimation() {
    const typingElement = document.getElementById('typing-text');
    if (!typingElement) return;

    const texts = [
      'Audits?',
      'Tax Planning?',
      'Bookkeeping?',
      'Payroll?',
      'Business Registration?',
      'Financial Consulting?'
    ];

    let textIndex = 0;
    let charIndex = 0;
    let isDeleting = false;
    let typeSpeed = 100;
    let deleteSpeed = 50;
    let pauseTime = 2000;

    function typeText() {
      const currentText = texts[textIndex];

      if (isDeleting) {
        typingElement.textContent = currentText.substring(0, charIndex - 1);
        charIndex--;
        typeSpeed = deleteSpeed;
      } else {
        typingElement.textContent = currentText.substring(0, charIndex + 1);
        charIndex++;
        typeSpeed = 100;
      }

      if (!isDeleting && charIndex === currentText.length) {
        typeSpeed = pauseTime;
        isDeleting = true;
      } else if (isDeleting && charIndex === 0) {
        isDeleting = false;
        textIndex = (textIndex + 1) % texts.length;
        typeSpeed = 500;
      }

      setTimeout(typeText, typeSpeed);
    }

    typeText();
  }

  document.addEventListener('DOMContentLoaded', function() {
    setTimeout(initTypingAnimation, 1000);
  });
</script>

<!-- Bootstrap JavaScript CDN -->
<script
  src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
  crossorigin="anonymous"></script>

<!-- JavaScript -->
<script src="components/js/navigation.js"></script>
<script src="https://elfsightcdn.com/platform.js" async></script>
</body>

</html>