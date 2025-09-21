<template>
  <div v-if="loading" class="row">
    <div
      v-for="n in count"
      :key="n"
      class="col-12 col-lg-3 col-sm-6 col-md-3 p-2"
    >
      <div class="card h-100">
        <div class="card-body">
          <div class="skeleton skeleton-heading mb-2"></div>
          <div
            v-for="i in lines"
            :key="i"
            class="skeleton skeleton-text mb-1"
          ></div>
        </div>
      </div>
    </div>
  </div>
  <slot v-else></slot>
</template>

<script setup>
defineProps({
  loading: Boolean,
  count: { type: Number, default: 4 },
  lines: { type: Number, default: 1 },
});
</script>

<style scoped>
.skeleton {
  background: linear-gradient(-90deg, #f0f0f0 0%, #e2e2e2 50%, #f0f0f0 100%);
  background-size: 200% 100%;
  animation: shimmer 1.5s infinite;
  border-radius: 6px;
}

@keyframes shimmer {
  0% {
    background-position: 200% 0;
  }
  100% {
    background-position: -200% 0;
  }
}

.skeleton-heading {
  width: 70%;
  height: 20px;
}

.skeleton-text {
  width: 100%;
  height: 14px;
  margin-top: 6px;
}
</style>
