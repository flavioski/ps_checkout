<template>
  <button @click="handleClick">
    <router-link v-if="url && url.indexOf('http') == -1" :title="label" :to="url">{{ label }}</router-link>
    <a v-else-if="url" :href="url" target="_blank" :title="label" rel="noopener">{{ label }}</a>
    <span v-else-if="label">{{ label }}</span>
    <slot v-else/>
  </button>
</template>
<script>
export default {
  props: {
    label: String,
    url: String
  },
  methods: {
    handleClick(e) {
      this.$emit('click', e);
    }
  }
}
</script>
