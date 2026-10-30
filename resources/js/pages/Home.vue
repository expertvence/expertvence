<template>
  <main class="home-page">
    <!-- ================= HERO ================= -->
    <section class="hero" id="home">
      <div class="w">
        <div>
          <span class="badge">
            <i></i>Web Applications · Digital Marketing · Page Management
          </span>

          <h1>Grow your business with <em>Web Apps &amp; Digital Marketing</em></h1>

          <p class="l">
            We build web applications, run professional social media page management, and deliver ready-made software for somiti, school, and e-commerce.
          </p>

          <div class="cta">
            <button class="btn pill" @click="openModal">
              <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="3" width="12" height="11" rx="2" />
                <path d="M2 7h12M5.5 1.5v3M10.5 1.5v3" />
              </svg>
              Free consultation
              <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M2 8h12M9 3l5 5-5 5" />
              </svg>
            </button>
            <a class="btn o" style="border-radius:99px;padding:16px 28px" href="#audit">
              Free page audit
            </a>
          </div>

          <div class="mini">
            <span>
              <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="8" cy="8" r="6.5" />
                <path d="M5.2 8.2l2 2 3.6-4" />
              </svg>
              Web &amp; Marketing Experts
            </span>
            <span>
              <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="8" cy="8" r="6.5" />
                <path d="M5.2 8.2l2 2 3.6-4" />
              </svg>
              Reply within 24 hours
            </span>
          </div>

          <div class="stats">
            <div>
              <b>50+</b>
              <span>Projects delivered</span>
            </div>
            <div>
              <b>100+</b>
              <span>Pages managed</span>
            </div>
            <div>
              <b>4.9/5 <small>★</small></b>
              <span>Client satisfaction</span>
            </div>
          </div>
        </div>

        <!-- HERO ILLUSTRATION -->
        <div class="art" aria-hidden="true">
          <div class="chip c1">
            <span class="ci">
              <svg viewBox="0 0 16 16" fill="currentColor">
                <path d="M9 1L3 9h4l-1 6 7-9H9z" />
              </svg>
            </span>
            <div>
              <small>Average delivery</small>
              <b>2–4 weeks</b>
            </div>
          </div>

          <svg class="s1" viewBox="0 0 170 140">
            <defs>
              <linearGradient id="b1" x1="0" y1="0" x2="1" y2="1">
                <stop offset="0" stop-color="#1C5C6E" />
                <stop offset="1" stop-color="#12404D" />
              </linearGradient>
            </defs>
            <path d="M20 10h120a18 18 0 0 1 18 18v62a18 18 0 0 1-18 18H70l-34 22 6-22H20A18 18 0 0 1 2 90V28A18 18 0 0 1 20 10z" fill="url(#b1)" />
            <text x="80" y="76" text-anchor="middle" font-family="Inter,sans-serif" font-size="38" font-weight="800" fill="#fff">&lt;/&gt;</text>
          </svg>

          <svg class="s2" viewBox="0 0 170 110">
            <defs>
              <linearGradient id="c1g" x1="0" y1="0" x2="0" y2="1">
                <stop offset="0" stop-color="#BAE6FD" />
                <stop offset="1" stop-color="#7DD3FC" />
              </linearGradient>
            </defs>
            <path d="M46 100a30 30 0 0 1-4-59.7A44 44 0 0 1 126 34a34 34 0 0 1 4 66z" fill="url(#c1g)" />
          </svg>

          <svg class="s3" viewBox="0 0 150 170">
            <defs>
              <linearGradient id="t1" x1="0" y1="0" x2="1" y2="1">
                <stop offset="0" stop-color="#1C5C6E" />
                <stop offset="1" stop-color="#12404D" />
              </linearGradient>
            </defs>
            <rect x="6" y="6" width="138" height="158" rx="18" fill="url(#t1)" />
            <rect x="30" y="80" width="18" height="52" rx="3" fill="#fff" />
            <rect x="58" y="62" width="18" height="70" rx="3" fill="#7DD3FC" />
            <rect x="86" y="46" width="18" height="86" rx="3" fill="#fff" />
            <rect x="114" y="30" width="14" height="102" rx="3" fill="#7DD3FC" />
          </svg>

          <svg class="s4" viewBox="0 0 110 110">
            <defs>
              <radialGradient id="sp" cx=".35" cy=".3">
                <stop offset="0" stop-color="#E0F2FE" />
                <stop offset="1" stop-color="#38BDF8" />
              </radialGradient>
            </defs>
            <g stroke="#94A3B8" stroke-width="1.5">
              <path d="M55 12L14 38M55 12l41 26M14 38v36M96 38v36M14 74l41 24M96 74L55 98M14 38l82 36M96 38L14 74" />
            </g>
            <circle cx="55" cy="55" r="26" fill="url(#sp)" />
            <g fill="#E2E8F0" stroke="#94A3B8">
              <circle cx="55" cy="12" r="6" />
              <circle cx="14" cy="38" r="6" />
              <circle cx="96" cy="38" r="6" />
              <circle cx="14" cy="74" r="6" />
              <circle cx="96" cy="74" r="6" />
              <circle cx="55" cy="98" r="6" />
            </g>
          </svg>

          <div class="chip c2">
            <span class="ci">
              <svg viewBox="0 0 16 16" fill="currentColor">
                <path d="M8 1l6 2v5c0 3.5-2.6 6-6 7-3.4-1-6-3.5-6-7V3z" />
              </svg>
            </span>
            <div>
              <small>Growth focused</small>
              <b>Marketing that converts</b>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ================= SERVICES ================= -->
    <section class="sec" id="services">
      <div class="w">
        <h2>Everything you need to grow online.</h2>
        <p class="sub">From a powerful web application to daily page management, one team handles it all.</p>

        <div class="grid g3">
          <div class="card" v-for="service in services" :key="service.title">
            <div class="ic">{{ service.icon }}</div>
            <h3>{{ service.title }}</h3>
            <p>{{ service.desc }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- ================= FREE FACEBOOK PAGE AUDIT ================= -->
    <section class="audit" id="audit">
      <div class="w ag">
        <div>
          <span class="free">100% FREE</span>
          <h2>Get your free Facebook page audit</h2>
          <p class="sub">
            Not sure why your page is not getting reach or customers? We review your page for free, find the problems, and tell you exactly what to fix.
          </p>

          <div class="chk6">
            <div><span>🖼️</span>Profile photo, cover &amp; branding</div>
            <div><span>ℹ️</span>Page info, category &amp; CTA button</div>
            <div><span>📅</span>Posting frequency &amp; consistency</div>
            <div><span>🎨</span>Content &amp; design quality</div>
            <div><span>💬</span>Engagement, reach &amp; inbox reply</div>
            <div><span>📣</span>Ads, boost &amp; audience targeting</div>
          </div>

          <div class="rep">
            <div class="ring"><b>62</b></div>
            <div style="flex:1">
              <ul>
                <li><span>Branding</span><i style="--w:80%"></i></li>
                <li class="bad"><span>Posting</span><i style="--w:40%"></i></li>
                <li class="bad"><span>Engagement</span><i style="--w:35%"></i></li>
                <li><span>Page setup</span><i style="--w:75%"></i></li>
              </ul>
              <small>Sample report: you get a page score, the problems found, and step-by-step suggestions.</small>
            </div>
          </div>
        </div>

        <div class="fcard wcard">
          <button
            class="wtrig"
            id="wtrig"
            type="button"
            @click="toggleWpop"
            aria-haspopup="dialog"
            aria-controls="wpop"
            aria-label="Click here to chat on WhatsApp"
          >
            <span class="wbig">
              <i class="rg r1"></i>
              <i class="rg r2"></i>
              <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                <path d="M12 2a10 10 0 0 0-8.6 15L2 22l5.1-1.3A10 10 0 1 0 12 2zm5.2 14.2c-.2.6-1.3 1.2-1.8 1.2-.5.1-1 .2-3.3-.7-2.8-1.2-4.6-4-4.7-4.2-.1-.2-1.1-1.5-1.1-2.8s.7-2 1-2.3c.2-.3.5-.3.7-.3h.5c.2 0 .4 0 .6.5l.8 2c.1.2.1.3 0 .5l-.4.6c-.1.2-.3.3-.1.6.2.3.8 1.3 1.7 2.1 1.2 1 2.1 1.4 2.4 1.5.3.1.5.1.6-.1l.9-1.1c.2-.3.4-.2.6-.1l1.9.9c.3.1.5.2.5.3.1.2.1.8-.1 1.4z"/>
              </svg>
            </span>
            <span class="clk">
              <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M8 13V3M3.5 7.5L8 3l4.5 4.5"/>
              </svg>
              Click here
            </span>
          </button>
          <h3>Get your free audit on WhatsApp</h3>
          <p>Send us your Facebook page link. We'll review it and reply with your audit report within 48 hours.</p>
          <p class="note">No payment. No obligation. Usually replies in a few minutes.</p>
        </div>
      </div>
    </section>

    <!-- ================= READY SOFTWARE SOLUTIONS ================= -->
    <section class="sec alt" id="solutions">
      <div class="w">
        <div class="eyebrow">Ready Software</div>
        <h2>Ready-made software, ready to launch</h2>
        <p class="sub">
          Start using proven software right away. We install it, customize it with your logo and rules, and train your team.
        </p>

        <div class="grid g3">
          <div class="card" v-for="sol in solutions" :key="sol.title">
            <div class="ic">{{ sol.icon }}</div>
            <span class="tag">{{ sol.tag }}</span>
            <h3>{{ sol.title }}</h3>
            <p>{{ sol.desc }}</p>
            <ul class="feat">
              <li v-for="(feat, fi) in sol.features" :key="fi">{{ feat }}</li>
            </ul>
            <a class="more" href="#contact" @click.prevent="openModal">
              View demo →
            </a>
          </div>
        </div>
      </div>
    </section>

    <!-- ================= PAGE MANAGEMENT PLANS ================= -->
    <section class="sec" id="plans">
      <div class="w">
        <div class="eyebrow">Page Management</div>
        <h2>Professional page management plans</h2>
        <p class="sub">
          Choose a plan for your Facebook and Instagram page. Every plan includes custom designs and a monthly report.
        </p>

        <div class="grid g3">
          <!-- Starter -->
          <div class="card plan">
            <h3>Starter</h3>
            <p>Best for new and small pages</p>
            <ul class="feat">
              <li>12 designed posts / month</li>
              <li>Page setup &amp; optimization</li>
              <li>Basic inbox support</li>
              <li>Monthly report</li>
            </ul>
            <button class="btn o" style="margin-top:20px" @click="openModal">
              Get a quote
            </button>
          </div>

          <!-- Growth (Hot) -->
          <div class="card plan hot">
            <span class="tag">Most popular</span>
            <h3>Growth</h3>
            <p>Best for growing businesses</p>
            <ul class="feat">
              <li>24 designed posts / month</li>
              <li>Boost &amp; ad campaign setup</li>
              <li>Daily inbox &amp; comment reply</li>
              <li>Content calendar + reel ideas</li>
              <li>Monthly report</li>
            </ul>
            <button class="btn" style="margin-top:20px" @click="openModal">
              Get a quote
            </button>
          </div>

          <!-- Professional -->
          <div class="card plan">
            <h3>Professional</h3>
            <p>Complete marketing management</p>
            <ul class="feat">
              <li>30+ posts &amp; reels / month</li>
              <li>Full ad management</li>
              <li>Google &amp; SEO support</li>
              <li>Brand banner &amp; cover design</li>
              <li>Weekly report &amp; meeting</li>
            </ul>
            <button class="btn o" style="margin-top:20px" @click="openModal">
              Get a quote
            </button>
          </div>
        </div>
      </div>
    </section>

    <!-- ================= ABOUT US ================= -->
    <section class="sec alt" id="about">
      <div class="w two">
        <div>
          <div class="eyebrow">Who We Are</div>
          <h2>A software firm that also grows your business.</h2>
          <p>
            We combine software development with digital marketing. Our team builds your web application, then helps you reach customers through professional page management and ads.
          </p>
          <button class="btn" @click="openModal">Talk to Our Team</button>
        </div>

        <div class="vis">
          <div>
            <b>50+</b>
            <p style="margin:8px 0 0">projects delivered for businesses and organizations</p>
          </div>
        </div>
      </div>
    </section>

    <!-- ================= HOW WE WORK ================= -->
    <section class="sec" id="process">
      <div class="w">
        <h2>How we work</h2>
        <p class="sub">A simple, clear process from first call to launch and support.</p>

        <div class="grid g4">
          <div class="card" v-for="step in processSteps" :key="step.num">
            <div class="num">{{ step.num }}</div>
            <h3>{{ step.title }}</h3>
            <p>{{ step.desc }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- ================= CLIENT REVIEWS CAROUSEL ================= -->
    <section class="sec alt" id="reviews">
      <div class="w">
        <div class="eyebrow">Testimonials</div>
        <h2>Trusted by growing businesses.</h2>
        <p class="sub">Real feedback from clients who use our software and page management services.</p>

        <div class="rvbar">
          <div class="rvsum">
            <div class="big">5.0</div>
            <div>
              <div class="stars" aria-hidden="true">★★★★★</div>
              <small>Based on {{ reviews.length }} client reviews</small>
            </div>
          </div>
        </div>

        <div
          class="rvwrap"
          @mouseenter="isPaused = true"
          @mouseleave="isPaused = false"
          @focusin="isPaused = true"
          @focusout="isPaused = false"
        >
          <button
            type="button"
            class="rvb l"
            @click="prevReview"
            aria-label="Previous reviews"
          >
            <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <path d="M10 3L5 8l5 5"/>
            </svg>
          </button>

          <div
            class="rvtrack"
            ref="reviewTrackRef"
            tabindex="0"
            role="region"
            aria-roledescription="carousel"
            aria-label="Client reviews"
            @scroll="onTrackScroll"
            @keydown.left.prevent="prevReview"
            @keydown.right.prevent="nextReview"
          >
            <article class="card rv" v-for="(r, idx) in reviews" :key="idx">
              <div class="rvtop">
                <div class="stars" role="img" :aria-label="r.rating + ' out of 5 stars'">
                  {{ '★'.repeat(r.rating) + '☆'.repeat(5 - r.rating) }}
                </div>
                <span class="svc">{{ r.service }}</span>
              </div>
              <blockquote>{{ r.text }}</blockquote>
              <div class="who">
                <span class="av" aria-hidden="true">{{ r.name.trim().charAt(0).toUpperCase() }}</span>
                <div>
                  <b>{{ r.name }}</b>
                  <small>{{ r.role }}</small>
                </div>
              </div>
            </article>
          </div>

          <button
            type="button"
            class="rvb r"
            @click="nextReview"
            aria-label="Next reviews"
          >
            <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <path d="M6 3l5 5-5 5"/>
            </svg>
          </button>
        </div>

        <div class="rvdots">
          <button
            v-for="i in totalPages"
            :key="i"
            type="button"
            :class="{ on: activePageIndex === (i - 1) }"
            :aria-label="'Go to review page ' + i"
            @click="goToPage(i - 1)"
          ></button>
        </div>

        <p style="margin-top:28px">
          <router-link class="btn" to="/portfolio">Read All the Reviews</router-link>
        </p>
      </div>
    </section>

    <!-- ================= WHY CHOOSE US ================= -->
    <section class="sec">
      <div class="w two">
        <div>
          <h2>Why choose us?</h2>
          <p>
            One reliable partner for software and marketing means less hassle, faster results, and a better return on your budget.
          </p>
          <button class="btn" @click="openModal">Get Started</button>
        </div>

        <div>
          <ul class="why">
            <li>Web application and marketing under one roof</li>
            <li>Affordable ready-made software with custom features</li>
            <li>Bangla-friendly systems made for local businesses</li>
            <li>Free support and training after launch</li>
          </ul>
        </div>
      </div>
    </section>

    <!-- ================= TECH MARQUEE ================= -->
    <section class="sec alt">
      <div class="w">
        <h2>Tools &amp; technologies we use</h2>
        <p class="sub">Modern development and marketing tools behind every project.</p>

        <div class="mq">
          <div class="mq-row row1">
            <span v-for="(item, i) in toolsRow1" :key="'r1-'+i">{{ item }}</span>
            <span v-for="(item, i) in toolsRow1" :key="'r1d-'+i">{{ item }}</span>
          </div>
          <div class="mq-row row2">
            <span v-for="(item, i) in toolsRow2" :key="'r2-'+i">{{ item }}</span>
            <span v-for="(item, i) in toolsRow2" :key="'r2d-'+i">{{ item }}</span>
          </div>
        </div>
      </div>
    </section>

    <!-- ================= NEWS & TIPS ================= -->
    <section class="sec" id="news">
      <div class="w">
        <h2>Latest news &amp; tips</h2>
        <p class="sub">Practical ideas on software, websites, and digital marketing.</p>

        <div class="grid g3 news">
          <div class="card" v-for="item in news" :key="item.title">
            <div class="img">{{ item.icon }}</div>
            <div class="b">
              <small>{{ item.date }}</small>
              <h3 style="margin:6px 0">{{ item.title }}</h3>
              <p>{{ item.desc }}</p>
              <router-link class="more" :to="item.link">Read More</router-link>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ================= STRATEGY CALL BANNER ================= -->
    <section style="padding:0 0 70px" id="contact">
      <div class="w">
        <div class="band">
          <small>FREE CONSULTATION · NO OBLIGATION</small>
          <h2>Let's grow your business online.</h2>
          <p>
            Tell us what you need: a web application, page management, or ready software. We'll suggest the best plan and price.
          </p>
          <button class="btn" @click="openModal">Book a free call</button>
        </div>
      </div>
    </section>

    <!-- ================= NEWSLETTER ================= -->
    <section style="padding:0 0 70px">
      <div class="w nl">
        <div>
          <h3 style="font-size:24px">Subscribe to our newsletter</h3>
          <p class="sub" style="margin-top:6px">Tips and offers, once a month.</p>
        </div>

        <div>
          <form v-if="!newsletterDone" @submit.prevent="handleNewsletter">
            <input
              type="email"
              required
              placeholder="Your email address"
              aria-label="Email"
              v-model="newsletterEmail"
            />
            <button class="btn" type="submit" :disabled="subscribing">
              {{ subscribing ? 'Subscribing...' : 'Subscribe' }}
            </button>
          </form>
          <p id="ok" v-else style="display:block">
            You've been successfully subscribed to our newsletter!
          </p>
        </div>
      </div>
    </section>

    <!-- ================= FLOATING WHATSAPP BUTTON ================= -->
    <button
      class="wa"
      id="wafab"
      type="button"
      @click.stop="toggleWpop"
      aria-haspopup="dialog"
      aria-controls="wpop"
      aria-label="Chat on WhatsApp"
    >
      <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
        <path d="M12 2a10 10 0 0 0-8.6 15L2 22l5.1-1.3A10 10 0 1 0 12 2zm5.2 14.2c-.2.6-1.3 1.2-1.8 1.2-.5.1-1 .2-3.3-.7-2.8-1.2-4.6-4-4.7-4.2-.1-.2-1.1-1.5-1.1-2.8s.7-2 1-2.3c.2-.3.5-.3.7-.3h.5c.2 0 .4 0 .6.5l.8 2c.1.2.1.3 0 .5l-.4.6c-.1.2-.3.3-.1.6.2.3.8 1.3 1.7 2.1 1.2 1 2.1 1.4 2.4 1.5.3.1.5.1.6-.1l.9-1.1c.2-.3.4-.2.6-.1l1.9.9c.3.1.5.2.5.3.1.2.1.8-.1 1.4z"/>
      </svg>
    </button>

    <!-- ================= SCROLL TO TOP PROGRESS BUTTON ================= -->
    <button
      class="up"
      id="up"
      type="button"
      @click="scrollToTop"
      aria-label="Scroll to top"
    >
      <svg class="rn" viewBox="0 0 56 56" aria-hidden="true">
        <defs>
          <linearGradient id="upg" x1="0" y1="0" x2="1" y2="1">
            <stop offset="0" stop-color="#22D3EE" />
            <stop offset="1" stop-color="#12404D" />
          </linearGradient>
        </defs>
        <circle class="tk" cx="28" cy="28" r="24" />
        <circle class="pg" id="upp" :style="{ strokeDashoffset: scrollDashoffset }" cx="28" cy="28" r="24" />
      </svg>
      <svg class="ar" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <path d="M10 16V4M4.5 9.5L10 4l5.5 5.5" />
      </svg>
    </button>

    <!-- ================= WHATSAPP POPUP DIALOG ================= -->
    <div
      class="wpop"
      id="wpop"
      :class="{ open: isWpopOpen }"
      role="dialog"
      aria-label="Start a conversation on WhatsApp"
      :aria-hidden="!isWpopOpen"
      @click.stop
    >
      <div class="wph">
        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
          <path d="M12 2a10 10 0 0 0-8.6 15L2 22l5.1-1.3A10 10 0 1 0 12 2zm5.2 14.2c-.2.6-1.3 1.2-1.8 1.2-.5.1-1 .2-3.3-.7-2.8-1.2-4.6-4-4.7-4.2-.1-.2-1.1-1.5-1.1-2.8s.7-2 1-2.3c.2-.3.5-.3.7-.3h.5c.2 0 .4 0 .6.5l.8 2c.1.2.1.3 0 .5l-.4.6c-.1.2-.3.3-.1.6.2.3.8 1.3 1.7 2.1 1.2 1 2.1 1.4 2.4 1.5.3.1.5.1.6-.1l.9-1.1c.2-.3.4-.2.6-.1l1.9.9c.3.1.5.2.5.3.1.2.1.8-.1 1.4z"/>
        </svg>
        <div>
          <b>Start a Conversation</b>
          <small>Select a team member to chat on WhatsApp</small>
        </div>
        <button class="wx" id="wx" type="button" @click="isWpopOpen = false" aria-label="Close">×</button>
      </div>

      <div class="wpb">
        <p>The team typically replies in a few minutes.</p>

        <a class="wm" :href="whatsappCompanyUrl" target="_blank" rel="noopener">
          <span class="wav co">
            <svg viewBox="0 0 34 28" aria-hidden="true">
              <defs>
                <linearGradient id="lp" x1="0" y1="0" x2="1" y2="1">
                  <stop offset="0" stop-color="#5BE7FF" />
                  <stop offset="1" stop-color="#1A9FC0" />
                </linearGradient>
              </defs>
              <path d="M1 3h13v3.5H5V11h8v3.5H5V19h9v3.5H1z" fill="url(#lp)" />
              <path d="M14 3h6.5l3.5 11 6-11h4L26 25h-5.5z" fill="url(#lp)" />
            </svg>
          </span>
          <span class="wmt">
            <b>Expertvence</b>
            <small>Company support · Online</small>
          </span>
          <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
            <path d="M12 2a10 10 0 0 0-8.6 15L2 22l5.1-1.3A10 10 0 1 0 12 2zm5.2 14.2c-.2.6-1.3 1.2-1.8 1.2-.5.1-1 .2-3.3-.7-2.8-1.2-4.6-4-4.7-4.2-.1-.2-1.1-1.5-1.1-2.8s.7-2 1-2.3c.2-.3.5-.3.7-.3h.5c.2 0 .4 0 .6.5l.8 2c.1.2.1.3 0 .5l-.4.6c-.1.2-.3.3-.1.6.2.3.8 1.3 1.7 2.1 1.2 1 2.1 1.4 2.4 1.5.3.1.5.1.6-.1l.9-1.1c.2-.3.4-.2.6-.1l1.9.9c.3.1.5.2.5.3.1.2.1.8-.1 1.4z"/>
          </svg>
        </a>

        <a class="wm" :href="whatsappConsultantUrl" target="_blank" rel="noopener">
          <span class="wav cn">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <path d="M4 14v-2a8 8 0 0 1 16 0v2"/>
              <rect x="3" y="14" width="4" height="6" rx="2" fill="currentColor"/>
              <rect x="17" y="14" width="4" height="6" rx="2" fill="currentColor"/>
              <path d="M19 20c0 1.5-2 2-5 2"/>
            </svg>
          </span>
          <span class="wmt">
            <b>Consultant</b>
            <small>Page consultant · Online</small>
          </span>
          <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
            <path d="M12 2a10 10 0 0 0-8.6 15L2 22l5.1-1.3A10 10 0 1 0 12 2zm5.2 14.2c-.2.6-1.3 1.2-1.8 1.2-.5.1-1 .2-3.3-.7-2.8-1.2-4.6-4-4.7-4.2-.1-.2-1.1-1.5-1.1-2.8s.7-2 1-2.3c.2-.3.5-.3.7-.3h.5c.2 0 .4 0 .6.5l.8 2c.1.2.1.3 0 .5l-.4.6c-.1.2-.3.3-.1.6.2.3.8 1.3 1.7 2.1 1.2 1 2.1 1.4 2.4 1.5.3.1.5.1.6-.1l.9-1.1c.2-.3.4-.2.6-.1l1.9.9c.3.1.5.2.5.3.1.2.1.8-.1 1.4z"/>
          </svg>
        </a>
      </div>
    </div>

    <!-- Contact Modal -->
    <ContactModal :show="showModal" @close="showModal = false" />
  </main>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import axios from 'axios'
import ContactModal from '@/components/ContactModal.vue'

const showModal = ref(false)
const newsletterEmail = ref('')
const subscribing = ref(false)
const newsletterDone = ref(false)

const openModal = () => {
  showModal.value = true
}

/* ================= WHATSAPP POPUP & AUDIT ================= */
const isWpopOpen = ref(false)
const WA_COMPANY = '8801797488350'
const WA_CONSULTANT = '8801797488350'
const waMsg = encodeURIComponent('Hello, I want a free Facebook page audit.')
const whatsappCompanyUrl = `https://wa.me/${WA_COMPANY}?text=${waMsg}`
const whatsappConsultantUrl = `https://wa.me/${WA_CONSULTANT}?text=${waMsg}`

const toggleWpop = () => {
  isWpopOpen.value = !isWpopOpen.value
}

const handleGlobalClick = (e) => {
  if (isWpopOpen.value) {
    const pop = document.getElementById('wpop')
    const triggerAudit = document.getElementById('wtrig')
    const triggerFab = document.getElementById('wafab')
    if (
      pop &&
      !pop.contains(e.target) &&
      (!triggerAudit || !triggerAudit.contains(e.target)) &&
      (!triggerFab || !triggerFab.contains(e.target))
    ) {
      isWpopOpen.value = false
    }
  }
}

const handleKeydown = (e) => {
  if (e.key === 'Escape' && isWpopOpen.value) {
    isWpopOpen.value = false
  }
}

/* ================= SCROLL TO TOP PROGRESS ================= */
const scrollDashoffset = ref(150.8)

const updateScrollProgress = () => {
  const scrollable = document.documentElement.scrollHeight - window.innerHeight
  const ratio = scrollable > 0 ? Math.min(1, Math.max(0, window.scrollY / scrollable)) : 0
  scrollDashoffset.value = 150.8 * (1 - ratio)
}

const scrollToTop = () => {
  window.scrollTo({
    top: 0,
    behavior: window.matchMedia('(prefers-reduced-motion: reduce)').matches ? 'auto' : 'smooth'
  })
}

/* ================= SERVICES DATA ================= */
const services = [
  {
    icon: '💻',
    title: 'Web Application Development',
    desc: 'Custom web apps, dashboards, admin panels, and business websites built with modern technology.'
  },
  {
    icon: '📈',
    title: 'Digital Marketing',
    desc: 'Facebook and Google ads, SEO, and campaigns planned to bring real leads and sales.'
  },
  {
    icon: '📱',
    title: 'Professional Page Management',
    desc: 'Daily posting, content calendar, inbox replies, and monthly performance reports for your Facebook and Instagram pages.'
  },
  {
    icon: '🎨',
    title: 'Banner & Graphic Design',
    desc: 'Eye-catching banners, post designs, cover photos, and brand identity that make your page look professional.'
  },
  {
    icon: '🔍',
    title: 'SEO & Google Ads',
    desc: 'Rank higher on Google and reach customers who are already searching for your service.'
  },
  {
    icon: '🛠️',
    title: 'Hosting, Domain & Support',
    desc: 'Domain, hosting, SSL, backup, and regular maintenance so your website never goes down.'
  }
]

/* ================= READY SOLUTIONS DATA ================= */
const solutions = [
  {
    icon: '🤝',
    tag: 'Somiti Management',
    title: 'Somiti Software',
    desc: 'Complete digital system for somiti, cooperatives, and associations.',
    features: [
      'Member registration & profile',
      'Monthly deposit & loan management',
      'Installment and fund ledger',
      'Reports and SMS notice'
    ]
  },
  {
    icon: '🎓',
    tag: 'School Management',
    title: 'School Management System',
    desc: 'Run admission, classes, and results from one dashboard for schools and coaching centers.',
    features: [
      'Student & teacher management',
      'Attendance, exam & result',
      'Fee collection and due list',
      'Parent portal and notice board'
    ]
  },
  {
    icon: '🛒',
    tag: 'E-commerce',
    title: 'E-commerce Website',
    desc: 'Launch your online shop with product catalog, payment, and order management.',
    features: [
      'Product, category & stock',
      'Cart, checkout & bKash/Nagad payment',
      'Order tracking and invoice',
      'Powerful admin panel'
    ]
  }
]

/* ================= HOW WE WORK PROCESS ================= */
const processSteps = [
  {
    num: '01',
    title: 'Discuss',
    desc: 'We understand your business, goals, and budget.'
  },
  {
    num: '02',
    title: 'Design',
    desc: 'We prepare the design, banners, and plan for your approval.'
  },
  {
    num: '03',
    title: 'Build & Launch',
    desc: 'We develop, test, and launch your software or campaign.'
  },
  {
    num: '04',
    title: 'Support & Grow',
    desc: 'We provide training, maintenance, and monthly growth reports.'
  }
]

/* ================= CLIENT REVIEWS ================= */
const reviews = [
  {
    name: 'Client Name',
    role: 'Somiti Chairman',
    service: 'Somiti Software',
    rating: 5,
    text: 'Our member records and monthly deposits are now fully digital. Reports that took days now take minutes, and the team was always ready to help.'
  },
  {
    name: 'Client Name',
    role: 'School Principal',
    service: 'School Management',
    rating: 5,
    text: 'Admission, attendance and results are all in one place. Parents get notices on time and our fee collection has become much easier.'
  },
  {
    name: 'Client Name',
    role: 'Online Shop Owner',
    service: 'E-commerce',
    rating: 5,
    text: 'They built our online store quickly and it looks professional. We started getting orders within the first week of launch.'
  },
  {
    name: 'Client Name',
    role: 'Restaurant Owner',
    service: 'Page Management',
    rating: 5,
    text: 'Our Facebook page now looks professional and gets real reach. Daily posts, fast inbox replies and a monthly report, exactly what we needed.'
  },
  {
    name: 'Client Name',
    role: 'Business Owner',
    service: 'Web Application',
    rating: 5,
    text: 'The web application matches our workflow perfectly. Delivery was on time and support after launch has been excellent.'
  },
  {
    name: 'Client Name',
    role: 'Coaching Center Owner',
    service: 'Digital Marketing',
    rating: 4,
    text: 'Our ad campaigns brought many new student inquiries. The team explains everything clearly and is easy to work with.'
  }
]

const reviewTrackRef = ref(null)
const activePageIndex = ref(0)
const totalPages = ref(1)
const isPaused = ref(false)
let autoPlayTimer = null

const calculateStep = () => {
  if (!reviewTrackRef.value) return 300
  const card = reviewTrackRef.value.querySelector('.rv')
  return card ? card.getBoundingClientRect().width + 22 : 300
}

const updateCarouselMetrics = () => {
  if (!reviewTrackRef.value) return
  const track = reviewTrackRef.value
  const step = calculateStep()
  const perPage = Math.max(1, Math.round(track.clientWidth / step))
  totalPages.value = Math.max(1, reviews.length - perPage + 1)
  activePageIndex.value = Math.min(totalPages.value - 1, Math.max(0, Math.round(track.scrollLeft / step)))
}

const goToPage = (pageIndex) => {
  if (!reviewTrackRef.value) return
  const step = calculateStep()
  const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches
  reviewTrackRef.value.scrollTo({
    left: pageIndex * step,
    behavior: reducedMotion ? 'auto' : 'smooth'
  })
  activePageIndex.value = pageIndex
}

const nextReview = () => {
  const next = activePageIndex.value >= totalPages.value - 1 ? 0 : activePageIndex.value + 1
  goToPage(next)
}

const prevReview = () => {
  const prev = activePageIndex.value <= 0 ? totalPages.value - 1 : activePageIndex.value - 1
  goToPage(prev)
}

const onTrackScroll = () => {
  requestAnimationFrame(updateCarouselMetrics)
}

const startAutoPlay = () => {
  stopAutoPlay()
  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return
  autoPlayTimer = setInterval(() => {
    if (!isPaused.value && !document.hidden) {
      nextReview()
    }
  }, 5000)
}

const stopAutoPlay = () => {
  if (autoPlayTimer) {
    clearInterval(autoPlayTimer)
    autoPlayTimer = null
  }
}

/* ================= TECH TOOLS MARQUEE ================= */
const allTools = [
  'Laravel', 'PHP', 'React', 'Next.js', 'Node.js', 'MySQL', 'WordPress', 'JavaScript',
  'Tailwind', 'REST API', 'Figma', 'Photoshop', 'Canva', 'Meta Ads', 'Google Ads',
  'Meta Business Suite', 'SEO', 'Analytics', 'bKash', 'Nagad', 'SSLCommerz', 'WhatsApp',
  'cPanel', 'Git', 'Cloudflare'
]

const toolsRow1 = allTools.slice(0, 12)
const toolsRow2 = allTools.slice(12)

/* ================= NEWS DATA ================= */
const news = [
  {
    icon: '📘',
    date: 'Oct 21, 2026',
    title: '10 Ways to Grow Your Facebook Business Page',
    desc: 'Simple, proven steps to get more reach and customers.',
    link: '/gallery'
  },
  {
    icon: '🤝',
    date: 'Oct 16, 2026',
    title: 'Somiti Software: Why Go Digital?',
    desc: 'How online records save time and build member trust.',
    link: '/gallery'
  },
  {
    icon: '🛒',
    date: 'Oct 15, 2026',
    title: 'Start Your E-commerce Business in Bangladesh',
    desc: 'What you need to launch and sell online.',
    link: '/gallery'
  }
]

/* ================= NEWSLETTER SUBMISSION ================= */
const handleNewsletter = async () => {
  if (!newsletterEmail.value) return
  subscribing.value = true

  try {
    await axios.post('/api/auth/newsletter/subscribe', {
      email: newsletterEmail.value
    })
    newsletterDone.value = true
  } catch (err) {
    newsletterDone.value = true
  } finally {
    subscribing.value = false
  }
}

/* ================= LIFECYCLE HOOKS ================= */
onMounted(() => {
  window.addEventListener('scroll', updateScrollProgress, { passive: true })
  window.addEventListener('resize', updateScrollProgress)
  window.addEventListener('resize', updateCarouselMetrics)
  document.addEventListener('click', handleGlobalClick)
  document.addEventListener('keydown', handleKeydown)

  updateScrollProgress()
  setTimeout(() => {
    updateCarouselMetrics()
    startAutoPlay()
  }, 200)
})

onUnmounted(() => {
  window.removeEventListener('scroll', updateScrollProgress)
  window.removeEventListener('resize', updateScrollProgress)
  window.removeEventListener('resize', updateCarouselMetrics)
  document.removeEventListener('click', handleGlobalClick)
  document.removeEventListener('keydown', handleKeydown)
  stopAutoPlay()
})
</script>
