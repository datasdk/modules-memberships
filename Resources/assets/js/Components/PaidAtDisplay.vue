<template>
  <section>
    <v-chip
      v-if="paid_at"
      color="green lighten-4"
      text-color="green darken-3"
      small
      class="ma-1"
    >
      {{ paid_at }}
    </v-chip>

    <v-chip
      v-else
      color="red lighten-4"
      text-color="red darken-2"
      small
      class="ma-1"
    >
      Ikke betalt
    </v-chip>
  </section>
</template>

<script>
export default {
  name: "PaidAtDisplay",
  props: {
    paid_at: {
      type: [String, Date, null],
      default: null,
    },
  },
};
</script>

<style scoped>
/* Valgfri ekstra styling */
</style>
