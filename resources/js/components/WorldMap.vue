<template>
  <section class="world-map-section">
    <h2>We Serve Worldwide 🌍</h2>
    <p class="subtitle">Proudly based in Bangladesh</p>

    <div id="world-map"></div>
  </section>
</template>

<script setup>
import { onMounted } from 'vue'
import $ from 'jquery'

// REQUIRED imports
import 'jvectormap-next'
import 'jvectormap-next/jquery-jvectormap.css'
import 'jvectormap-next/jquery-jvectormap-world-mill'

onMounted(() => {
  $('#world-map').vectorMap({
    map: 'world_mill',
    backgroundColor: 'transparent',

    regionStyle: {
      initial: {
        fill: '#1e293b',
        'fill-opacity': 1,
        stroke: 'none'
      },
      hover: {
        fill: '#38bdf8'
      }
    },

    series: {
      regions: [{
        values: {
          BD: '#22c55e'   // Bangladesh
        }
      }]
    },

    onRegionTipShow: function (e, el, code) {
      if (code === 'BD') {
        el.html('🇧🇩 Bangladesh<br/>ExpertVence Software')
      }
    }
  })
})
</script>

<style scoped>
.world-map-section {
  padding: 90px 20px;
  background: #020617;
  text-align: center;
  color: #e5e7eb;
}

.world-map-section h2 {
  font-size: 32px;
  margin-bottom: 6px;
}

.subtitle {
  color: #94a3b8;
  margin-bottom: 40px;
}

#world-map {
  width: 100%;
  max-width: 1100px;
  height: 520px;
  margin: auto;
}
</style>
