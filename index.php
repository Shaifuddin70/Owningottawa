<?php include 'components/header.php'; ?>
<!-- Main Content -->
<main class="main-content modern-redesign">

  <!-- Hero Section with Video Background -->
  <section class="modern-hero" aria-label="Welcome to Owning Ottawa">
    <div class="hero-media">
      <iframe class="hero-video"
        src="https://www.youtube.com/embed/QwOMYBZwI3E?autoplay=1&mute=1&loop=1&playlist=QwOMYBZwI3E&controls=0&modestbranding=1&rel=0&playsinline=1"
        title="DESIGNER RESIDENCE | CINEMATIC REAL ESTATE VIDEO IN 4K | SONY FX6"
        frameborder="0"
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
        referrerpolicy="strict-origin-when-cross-origin"
        allowfullscreen>
      </iframe>
    </div>

    <div class="modern-hero-content">
      <div class="hero-badge fade-in-up">
        <i class="fas fa-crown"></i>
        <span>Premium Real Estate Portfolio</span>
      </div>
      <h1 class="modern-hero-title fade-in-up delay-1">
        Your Complete Property Partner in <span class="text-gold">Ottawa</span>
      </h1>
      <p class="modern-hero-subtitle fade-in-up delay-2">
        First home? New project? Investment opportunity?<br>
        Find it, finance it, and manage it—all with OwningOttawa.
      </p>
      <div class="hero-features fade-in-up delay-3">
        <a href="/services#real-estate" class="hero-feature-item">
          <i class="fas fa-home"></i>
          <span>Real Estate</span>
        </a>
        <a href="/services#mortgage" class="hero-feature-item">
          <i class="fas fa-coins"></i>
          <span>Mortgages</span>
        </a>
        <a href="/services#property-management" class="hero-feature-item">
          <i class="fas fa-building"></i>
          <span>Management</span>
        </a>
      </div>
      <div class="hero-cta-buttons fade-in-up delay-4">
        <a href="/services" class="btn-modern-primary">
          <span>Explore Services</span>
          <i class="fas fa-arrow-right"></i>
        </a>
        <a href="/contact" class="btn-modern-outline">
          <span>Get Started</span>
          <i class="fas fa-paper-plane"></i>
        </a>
      </div>

    </div>
  </section>

  <!-- Featured Listings iframe -->
  <section class="common-section" aria-label="Featured Property Listings">
    <div class="section-header text-center scroll-animate">
      <span class="section-tag"><i class="fas fa-star"></i> Featured</span>
      <h2 class="section-title-modern">Featured Listings</h2>
      <p class="section-subtitle-modern">Browse our exclusive property listings</p>
    </div>
    <div class=" scroll-animate px-lg-5">
      <iframe
        src="https://listing.owningottawa.com/featured-listings"
        title="Featured Property Listings"
        frameborder="0"
        allowfullscreen
        loading="lazy"
        class="featured-listings-frame">
      </iframe>
    </div>
  </section>

  <!-- Services Section -->
  <section class="common-section  " id="services">
    <div class="container">
      <div class="section-header text-center scroll-animate">
        <span class="section-tag"><i class="fas fa-sparkles"></i> What We Offer</span>
        <h2 class="section-title-modern">Complete Real Estate Solutions</h2>
        <p class="section-subtitle-modern">Everything you need under one roof for confident property decisions</p>
      </div>

      <div class="services-grid-modern">
        <article class="service-card-modern scroll-animate">
          <div class="service-icon-wrapper">
            <div class="service-icon">
              <i class="fas fa-home-lg-alt"></i>
            </div>
          </div>
          <div class="service-content">
            <h3 class="service-title">Real Estate Services</h3>
            <p class="service-description">Buy, sell, or invest with confidence. Expert guidance from your first home to your next opportunity with strategic insight and precision.</p>
            <a href="/services#real-estate" class="service-link">
              Learn More <i class="fas fa-arrow-right"></i>
            </a>
          </div>
          <div class="service-number">01</div>
        </article>

        <article class="service-card-modern scroll-animate delay-1">
          <div class="service-icon-wrapper">
            <div class="service-icon">
              <i class="fas fa-percent"></i>
            </div>
          </div>
          <div class="service-content">
            <h3 class="service-title">Mortgage Solutions</h3>
            <p class="service-description">Get the right mortgage for your budget and goals. We compare lenders, explain rates, and secure the most favorable terms available.</p>
            <a href="/services#mortgage" class="service-link">
              Learn More <i class="fas fa-arrow-right"></i>
            </a>
          </div>
          <div class="service-number">02</div>
        </article>

        <article class="service-card-modern scroll-animate delay-2">
          <div class="service-icon-wrapper">
            <div class="service-icon">
              <i class="fas fa-building"></i>
            </div>
          </div>
          <div class="service-content">
            <h3 class="service-title">Property Management</h3>
            <p class="service-description">Keep your investment running smoothly with tenant placement, rent collection, maintenance coordination, and proactive communication.</p>
            <a href="/services#property-management" class="service-link">
              Learn More <i class="fas fa-arrow-right"></i>
            </a>
          </div>
          <div class="service-number">03</div>
        </article>

        <article class="service-card-modern scroll-animate delay-3">
          <div class="service-icon-wrapper">
            <div class="service-icon">
              <i class="fas fa-calculator"></i>
            </div>
          </div>
          <div class="service-content">
            <h3 class="service-title">Bookkeeping & Accounting</h3>
            <p class="service-description">Stay financially organized. Keep property owners and investors compliant, accurate, and ready for sustainable growth.</p>
            <a href="/services#bookkeeping" class="service-link">
              Learn More <i class="fas fa-arrow-right"></i>
            </a>
          </div>
          <div class="service-number">04</div>
        </article>

        <article class="service-card-modern scroll-animate delay-4">
          <div class="service-icon-wrapper">
            <div class="service-icon">
              <i class="fas fa-drafting-compass"></i>
            </div>
          </div>
          <div class="service-content">
            <h3 class="service-title">Building Permits & Design</h3>
            <p class="service-description">Simplify your renovation or new project with expert permit applications, drawings, and design documentation.</p>
            <a href="/services#permits" class="service-link">
              Learn More <i class="fas fa-arrow-right"></i>
            </a>
          </div>
          <div class="service-number">05</div>
        </article>
      </div>
    </div>
  </section>



  <!-- Process Timeline -->
  <section class="process-timeline">
    <div class="container">
      <div class="section-header text-center scroll-animate">
        <span class="section-tag"><i class="fas fa-route"></i> Our Process</span>
        <h2 class="section-title-modern">How We Work</h2>
        <p class="section-subtitle-modern">A simple, guided journey from first consultation to long-term success</p>
      </div>

      <div class="timeline">
        <div class="timeline-item scroll-animate">
          <div class="timeline-icon">
            <i class="fas fa-comments"></i>
          </div>
          <div class="timeline-content">
            <div class="timeline-number">01</div>
            <h3 class="timeline-title">Consultation & Assessment</h3>
            <p class="timeline-text">We start by understanding your goals, budget, and timeline to create a personalized strategy.</p>
          </div>
        </div>

        <div class="timeline-item scroll-animate delay-1">
          <div class="timeline-icon">
            <i class="fas fa-map-marked-alt"></i>
          </div>
          <div class="timeline-content">
            <div class="timeline-number">02</div>
            <h3 class="timeline-title">Property Strategy & Planning</h3>
            <p class="timeline-text">We build a comprehensive roadmap connecting real estate, finance, and management.</p>
          </div>
        </div>

        <div class="timeline-item scroll-animate delay-2">
          <div class="timeline-icon">
            <i class="fas fa-tasks"></i>
          </div>
          <div class="timeline-content">
            <div class="timeline-number">03</div>
            <h3 class="timeline-title">Execution & Coordination</h3>
            <p class="timeline-text">From showings and negotiations to paperwork, we manage every step with precision.</p>
          </div>
        </div>

        <div class="timeline-item scroll-animate delay-3">
          <div class="timeline-icon">
            <i class="fas fa-heart"></i>
          </div>
          <div class="timeline-content">
            <div class="timeline-number">04</div>
            <h3 class="timeline-title">Ongoing Support</h3>
            <p class="timeline-text">We remain your long-term partner for accounting, management, and future investments.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Why Choose Us -->
  <section class="why-choose-us">
    <div class="container">
      <div class="why-choose-grid">
        <div class="why-content scroll-animate">
          <span class="section-tag"><i class="fas fa-medal"></i> Why Choose Us</span>
          <h2 class="section-title-modern">Excellence in Every Transaction</h2>
          <p class="section-description">Every client's goal is different, but our approach stays consistent: clear, accurate, and confident. We combine market expertise with a professional, data-driven process to deliver results.</p>

          <div class="why-features">
            <div class="why-feature-item">
              <div class="why-feature-icon">
                <i class="fas fa-check-circle"></i>
              </div>
              <div class="why-feature-content">
                <h4>Local Market Expertise</h4>
                <p>Deep knowledge of Ottawa's neighborhoods and market trends</p>
              </div>
            </div>

            <div class="why-feature-item">
              <div class="why-feature-icon">
                <i class="fas fa-check-circle"></i>
              </div>
              <div class="why-feature-content">
                <h4>Comprehensive Services</h4>
                <p>Everything from real estate to permits under one roof</p>
              </div>
            </div>

            <div class="why-feature-item">
              <div class="why-feature-icon">
                <i class="fas fa-check-circle"></i>
              </div>
              <div class="why-feature-content">
                <h4>Client-First Approach</h4>
                <p>Your goals drive our strategy and execution</p>
              </div>
            </div>
          </div>

          <a href="/about" class="btn-modern-outline">
            <span>Learn More About Us</span>
            <i class="fas fa-arrow-right"></i>
          </a>
        </div>

        <div class="why-image scroll-animate delay-1">
          <img src="/images/shubham-duggal-2.jpg" alt="Shubham Duggal - Real Estate & Business Strategy">
          <div class="image-decoration"></div>
        </div>
      </div>
    </div>
  </section>

  <!-- Testimonials -->
  <section class="testimonials-section">
    <div class="container">
      <div class="section-header text-center scroll-animate">
        <span class="section-tag"><i class="fas fa-quote-left"></i> Testimonials</span>
        <h2 class="section-title-modern">What Our Clients Say</h2>
        <p class="section-subtitle-modern">Real stories from satisfied property owners and investors</p>
      </div>

      <div class="testimonials-grid">
        <article class="testimonial-card scroll-animate">
          <div class="testimonial-stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
          </div>
          <p class="testimonial-text">"Working with OwningOttawa was the best decision we made. They guided us through our first home purchase with patience and expertise."</p>
          <div class="testimonial-author">
            <div class="author-avatar">
              <i class="fas fa-user"></i>
            </div>
            <div class="author-info">
              <h4 class="author-name">Sarah Johnson</h4>
              <p class="author-role">First-Time Buyer</p>
            </div>
          </div>
        </article>

        <article class="testimonial-card scroll-animate delay-1">
          <div class="testimonial-stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
          </div>
          <p class="testimonial-text">"Exceptional service! They helped me find the perfect investment property and now manage it seamlessly. Highly recommend!"</p>
          <div class="testimonial-author">
            <div class="author-avatar">
              <i class="fas fa-user"></i>
            </div>
            <div class="author-info">
              <h4 class="author-name">Michael Chen</h4>
              <p class="author-role">Property Investor</p>
            </div>
          </div>
        </article>

        <article class="testimonial-card scroll-animate delay-2">
          <div class="testimonial-stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
          </div>
          <p class="testimonial-text">"Professional, knowledgeable, and always available. They made selling our home stress-free and got us an amazing price!"</p>
          <div class="testimonial-author">
            <div class="author-avatar">
              <i class="fas fa-user"></i>
            </div>
            <div class="author-info">
              <h4 class="author-name">Emily Rodriguez</h4>
              <p class="author-role">Home Seller</p>
            </div>
          </div>
        </article>
      </div>
    </div>
  </section>

  <!-- FAQ Section -->
  <section class="faq-modern">
    <div class="container">
      <div class="section-header text-center scroll-animate">
        <span class="section-tag"><i class="fas fa-question-circle"></i> FAQ</span>
        <h2 class="section-title-modern">Frequently Asked Questions</h2>
        <p class="section-subtitle-modern">Find answers to common questions about our services</p>
      </div>

      <div class="faq-grid">
        <div class="faq-column">
          <div class="faq-item-modern scroll-animate">
            <button class="faq-question-modern" type="button" onclick="toggleModernFAQ(this)">
              <span class="faq-icon"><i class="fas fa-map-marked-alt"></i></span>
              <span class="faq-title">Do you only work in Ottawa?</span>
              <span class="faq-toggle"><i class="fas fa-plus"></i></span>
            </button>
            <div class="faq-answer-modern">
              <p>Our primary focus is Ottawa, but we assist clients relocating from across Canada and guide them to find the right property locally.</p>
            </div>
          </div>

          <div class="faq-item-modern scroll-animate delay-1">
            <button class="faq-question-modern" type="button" onclick="toggleModernFAQ(this)">
              <span class="faq-icon"><i class="fas fa-percentage"></i></span>
              <span class="faq-title">Can you help with mortgage approval?</span>
              <span class="faq-toggle"><i class="fas fa-plus"></i></span>
            </button>
            <div class="faq-answer-modern">
              <p>Yes. We connect clients with trusted lenders and help navigate each stage of the approval and refinancing process.</p>
            </div>
          </div>

          <div class="faq-item-modern scroll-animate delay-2">
            <button class="faq-question-modern" type="button" onclick="toggleModernFAQ(this)">
              <span class="faq-icon"><i class="fas fa-building"></i></span>
              <span class="faq-title">Do you manage rental properties?</span>
              <span class="faq-toggle"><i class="fas fa-plus"></i></span>
            </button>
            <div class="faq-answer-modern">
              <p>Yes. We offer complete management—from tenant placement to maintenance and financial reporting.</p>
            </div>
          </div>
        </div>

        <div class="faq-column">
          <div class="faq-item-modern scroll-animate delay-3">
            <button class="faq-question-modern" type="button" onclick="toggleModernFAQ(this)">
              <span class="faq-icon"><i class="fas fa-file-contract"></i></span>
              <span class="faq-title">Can you help with building permits?</span>
              <span class="faq-toggle"><i class="fas fa-plus"></i></span>
            </button>
            <div class="faq-answer-modern">
              <p>Absolutely. We handle drawings, documentation, and permit coordination to keep your project compliant and moving forward.</p>
            </div>
          </div>

          <div class="faq-item-modern scroll-animate delay-4">
            <button class="faq-question-modern" type="button" onclick="toggleModernFAQ(this)">
              <span class="faq-icon"><i class="fas fa-calculator"></i></span>
              <span class="faq-title">Do you provide bookkeeping for investors?</span>
              <span class="faq-toggle"><i class="fas fa-plus"></i></span>
            </button>
            <div class="faq-answer-modern">
              <p>Yes. Our accounting services keep your financials accurate, compliant, and ready for reporting or tax filing.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA Section -->
  <section class="cta-section">
    <div class="container">
      <div class="cta-content scroll-animate">
        <div class="cta-icon">
          <i class="fas fa-rocket"></i>
        </div>
        <h2 class="cta-title">Ready to Find Your Perfect Property?</h2>
        <p class="cta-text">Partner with OwningOttawa and move forward with confidence. Let's turn your real estate goals into reality.</p>
        <div class="cta-buttons">
          <a href="/contact" class="btn-modern-primary">
            <span>Get Started Today</span>
            <i class="fas fa-arrow-right"></i>
          </a>
          <a href="tel:6133328884" class="btn-modern-outline">
            <span><i class="fas fa-phone"></i> Call Now</span>
          </a>
        </div>
      </div>
    </div>
  </section>

</main>

<script>
  // Animated Counter
  function animateCounter(element) {
    const target = parseInt(element.getAttribute('data-target'));
    const duration = 2000;
    const step = target / (duration / 16);
    let current = 0;

    const timer = setInterval(() => {
      current += step;
      if (current >= target) {
        element.textContent = target + (element.nextElementSibling.textContent.includes('%') ? '%' : '+');
        clearInterval(timer);
      } else {
        element.textContent = Math.floor(current);
      }
    }, 16);
  }

  // Intersection Observer for scroll animations
  if (typeof observerOptions === 'undefined') {
    var observerOptions = {
      threshold: 0.1,
      rootMargin: '0px 0px -50px 0px'
    };
  }

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('animated');

        // Trigger counter animation for stat numbers
        if (entry.target.querySelector('.stat-number')) {
          const statNumber = entry.target.querySelector('.stat-number');
          if (!statNumber.classList.contains('counted')) {
            statNumber.classList.add('counted');
            animateCounter(statNumber);
          }
        }
      }
    });
  }, observerOptions);

  // Observe all scroll-animate elements
  document.addEventListener('DOMContentLoaded', () => {
    const animatedElements = document.querySelectorAll('.scroll-animate, .fade-in-up, .fade-in');
    animatedElements.forEach(el => observer.observe(el));
  });

  // Modern FAQ Toggle
  function toggleModernFAQ(button) {
    const item = button.parentElement;
    const answer = item.querySelector('.faq-answer-modern');
    const icon = button.querySelector('.faq-toggle i');
    const isOpen = item.classList.contains('active');

    // Close all other FAQs
    document.querySelectorAll('.faq-item-modern').forEach(faq => {
      if (faq !== item) {
        faq.classList.remove('active');
        faq.querySelector('.faq-answer-modern').style.maxHeight = null;
        faq.querySelector('.faq-toggle i').classList.remove('fa-minus');
        faq.querySelector('.faq-toggle i').classList.add('fa-plus');
      }
    });

    // Toggle current FAQ
    if (isOpen) {
      item.classList.remove('active');
      answer.style.maxHeight = null;
      icon.classList.remove('fa-minus');
      icon.classList.add('fa-plus');
    } else {
      item.classList.add('active');
      answer.style.maxHeight = answer.scrollHeight + 'px';
      icon.classList.remove('fa-plus');
      icon.classList.add('fa-minus');
    }
  }

  // Smooth scroll for anchor links
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
      e.preventDefault();
      const target = document.querySelector(this.getAttribute('href'));
      if (target) {
        target.scrollIntoView({
          behavior: 'smooth',
          block: 'start'
        });
      }
    });
  });
</script>

<?php include 'components/footer.php'; ?>