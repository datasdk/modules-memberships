<template>
  <select
    class="form-control"
    :value="displayValue"
    @change="handleChange"
    required
  >
    <option v-for="num in range" :key="num" :value="num">{{ num }}</option>
  </select>
</template>

<script>
export default {
  name: 'NumberSelect',
  props: {
    value: {
      type: Number,
      default: 1
    },
    min: {
      type: Number,
      default: 1
    },
    max: {
      type: Number,
      default: 100
    }
  },
  computed: {
    range() {
      const arr = []
      for (let i = this.min; i <= this.max; i++) arr.push(i)
      return arr
    },
    displayValue() {
      return this.value <= 0 ? 1 : this.value
    }
  },
  watch: {
    value(val) {
      if (val <= 0) {
        this.$emit('input', 1)
      }
    }
  },
  methods: {
    handleChange(event) {
      const newValue = Number(event.target.value)
      this.$emit('input', newValue <= 0 ? 1 : newValue)
    }
  }
}
</script>
