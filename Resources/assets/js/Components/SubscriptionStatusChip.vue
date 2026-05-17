<template>
  <div>
    <v-chip
      v-if="label"
      :color="color"
      dark
      small
      class="ma-1"
    >
      {{ label }}
    </v-chip>
  </div>
</template>

<script>
export default {
  name: "SubscriptionStatusChip",

  props: {
    // fx: "active", "on_trial", "on_grace", "canceled", "ended"
    status: {
      type: String,
      default: "unknown",
    },
  },

  computed: {
    color() {
      switch (this.status) {
        case 'active':
          return 'green';
        case 'on_trial':
          return 'blue';
        case 'on_grace':
          return 'orange';
        case 'canceled':
          return 'red';
        case 'ended':
          return 'grey';
        default:
          return 'grey lighten-1';
      }
    },

    label() {
      switch (this.status) {
        case 'active':
          return this.$t ? this.$t('Aktiv') : 'Aktiv';
        case 'on_trial':
          return this.$t ? this.$t('Prøveperiode') : 'Prøveperiode';
        case 'on_grace':
          return this.$t ? this.$t('Graceperiode') : 'Graceperiode';
        case 'canceled':
          return this.$t ? this.$t('Annulleret') : 'Annulleret';
        case 'ended':
          return this.$t ? this.$t('Udløbet') : 'Udløbet';
        default:
          return this.$t ? this.$t('Ukendt') : 'Ukendt';
      }
    },
  },
};
</script>
