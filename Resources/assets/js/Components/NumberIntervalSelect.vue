<template>
  <v-row>
    <!-- Talvælger fra min til max -->
    <v-col cols="4">
      <select class="form-control" v-model.number="localNumber" required>
        <option v-for="num in range" :key="num" :value="num">{{ num }}</option>
      </select>
    </v-col>

    <!-- Intervalvælger -->
    <v-col cols="8">
      <select class="form-control" v-model="localInterval" required>
        <option disabled value="">Vælg interval</option>
        <option value="day">Dag</option>
        <option value="week">Uge</option>
        <option value="month">Måned</option>
        <option value="year">År</option>
      </select>
    </v-col>
  </v-row>
</template>

<script>
export default {
  name: 'NumberIntervalSelect',
  props: {
    modelNumber: {
      type: Number,
      default: 1
    },
    modelInterval: {
      type: String,
      default: ''
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
  emits: ['update:modelNumber', 'update:modelInterval'],
  computed: {
    range() {
      const arr = []
      for (let i = this.min; i <= this.max; i++) arr.push(i)
      return arr
    },
    localNumber: {
      get() { return this.modelNumber },
      set(value) { this.$emit('update:modelNumber', value) }
    },
    localInterval: {
      get() { return this.modelInterval },
      set(value) { this.$emit('update:modelInterval', value) }
    }
  }
}
</script>
