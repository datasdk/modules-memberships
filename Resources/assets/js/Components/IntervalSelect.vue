<template>
  <select
    class="form-control"
    v-model="selected"
    required
  >
    <option disabled value="">Vælg interval</option>
    <option value="days">{{ plural ? 'Dage' : 'Dag' }}</option>
    <option value="weeks">{{ plural ? 'Uger' : 'Uge' }}</option>
    <option value="months">{{ plural ? 'Måneder' : 'Måned' }}</option>
    <option value="years">{{ plural ? 'År' : 'År' }}</option>
  </select>
</template>

<script>
export default {
  name: 'IntervalSelect',
  props: {
    value: {
      type: String,
      default: ''
    },
    plural: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      selected: this.value
    }
  },
  watch: {
    selected(newVal) {
      this.$emit('input', newVal)
    },
    value(newVal) {
      // Sync hvis value ændres udefra
      this.selected = newVal
    }
  }
}
</script>

<style scoped>
.form-control {
  min-width: 140px;
}
</style>
