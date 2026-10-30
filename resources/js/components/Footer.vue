<template>
  <footer class="site-footer">
    <div class="w">
      <!-- FOOTER GRID -->
      <div class="fg">
        <div>
          <router-link class="logo" to="/" aria-label="Expertvence">
            <span class="lw">
              Expert
              <svg viewBox="0 0 34 28" aria-hidden="true">
                <defs>
                  <linearGradient id="lf" x1="0" y1="0" x2="1" y2="1">
                    <stop offset="0" stop-color="#5BE7FF" />
                    <stop offset="1" stop-color="#1A9FC0" />
                  </linearGradient>
                </defs>
                <path d="M1 3h13v3.5H5V11h8v3.5H5V19h9v3.5H1z" fill="url(#lf)" />
                <path d="M14 3h6.5l3.5 11 6-11h4L26 25h-5.5z" fill="url(#lf)" />
              </svg>
              Vence
            </span>
            <small>Software</small>
          </router-link>
          <p style="margin-top:14px;font-size:15px;color:#D3E4E8;max-width:32ch">
            Web applications, digital marketing, professional page management, and ready-made software for your business.
          </p>

          <!-- Social Media Icons under the description -->
          <div class="footer-social">
            <a href="https://www.facebook.com/profile.php?id=100079079156709" target="_blank" rel="noopener noreferrer" aria-label="Facebook">
              <svg viewBox="0 0 24 24" fill="currentColor" width="18" height="18"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
            </a>
            <a href="#" target="_blank" rel="noopener noreferrer" aria-label="X (Twitter)">
              <svg viewBox="0 0 24 24" fill="currentColor" width="18" height="18"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
            </a>
            <a href="#" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn">
              <svg viewBox="0 0 24 24" fill="currentColor" width="18" height="18"><path d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.28 1.3v-1.11h-2.79v8.37h2.79v-4.93c0-.77.62-1.4 1.39-1.4a1.4 1.4 0 0 1 1.4 1.4v4.93h2.75M6.46 8.76c-.97 0-1.75-.79-1.75-1.76s.78-1.75 1.75-1.75 1.75.78 1.75 1.75-.78 1.76-1.75 1.76m1.39 9.74v-8.37H5.07v8.37h2.78z"/></svg>
            </a>
          </div>
        </div>

        <div>
          <h4>Ready Solutions</h4>
          <ul>
            <li><a href="#solutions">Somiti Management</a></li>
            <li><a href="#solutions">School Management</a></li>
            <li><a href="#solutions">E-commerce</a></li>
          </ul>
        </div>

        <div>
          <h4>Our Services</h4>
          <ul>
            <li><a href="#services">Web Application</a></li>
            <li><a href="#services">Digital Marketing</a></li>
            <li><a href="#plans">Page Management</a></li>
            <li><a href="#services">Banner &amp; Design</a></li>
          </ul>
        </div>

        <div>
          <h4>Site Map</h4>
          <ul>
            <li><a href="#audit">Free Page Audit</a></li>
            <li><a href="#about">About Us</a></li>
            <li><a href="#process">Our Process</a></li>
            <li><a href="#reviews">Client Reviews</a></li>
            <li><a href="#contact">Contact Us</a></li>
          </ul>
        </div>
      </div>

      <!-- COPYRIGHT CENTERED -->
      <div class="copy">
        <span>© {{ currentYear }} Expertvence. All rights reserved.</span>
      </div>
    </div>
  </footer>
</template>

<script setup>
const currentYear = new Date().getFullYear()
</script>
