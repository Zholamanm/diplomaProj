<template>
  <div v-if="meta">
    <button @click="changePage(meta.current_page - 1)" :disabled="meta.current_page <= 1" class="btn btn-sm btn-dark">Previous</button>
    <span>{{ meta.current_page }} / {{ meta.last_page }}</span>
    <button @click="changePage(meta.current_page + 1)" :disabled="meta.current_page >= meta.last_page" class="btn btn-sm btn-dark">Next</button>
  </div>
</template>

<script>
export default {
  props: {
    meta: {
      type: Object,
      default: () => ({})
    }
  },
  methods: {
    changePage(page) {
      if (page > 0 && page <= this.meta.last_page) {
        this.$emit('page-changed', page);
      }
    }
  }
};
</script>
