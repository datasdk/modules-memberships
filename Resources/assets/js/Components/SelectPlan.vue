<template>
  <div>
    <Loading v-if="loading" :type="2" />

    <div v-else-if="!plans.length">
      <div><strong>Ingen planer fundet</strong></div>
      <div>
        Der blev ikke fundet nogen medlemskaber<br />
        <router-link :to="{ path: '/memberships/plans/create' }">Klik her</router-link>
        for at oprette en ny plan
      </div>
    </div>

    <div v-else>
      <select v-model="selected" class="form-control">
        <option :value="undefined" disabled>Vælg abonnement</option>

        <option
          v-for="item in plans"
          :key="item.id"
          :value="item.id"
        >
          {{ getPlanLabel(item) }}
        </option>
      </select>
    </div>
  </div>
</template>

<script>
export default {
  name: "SelectPlan",

  props: {
    value: [String, Number], // v-model i Vue2
  },

  data() {
    return {
      plans: [],
      loading: true,
      selected: this.value,
    };
  },

  watch: {
    selected: "emitChange",
    value(newVal) {
      this.selected = newVal;
    },
  },

  methods: {
    getPlanLabel(item) {
      return `${item.title} - ${item.price} DKK - ${item.invoice_period} x ${item.invoice_interval}` + 
             (item.sku ? ` - sku: ${item.sku}` : "");
    },

    emitChange(id) {
      this.$emit("input", id);
      const plan = this.plans.find(p => p.id === id) || null;
      this.$emit("change", plan);
    },

    initializeSelection() {
      if (this.value != null) {
        this.selected = this.value;
        this.emitChange(this.value);
      }
    },
  },

  mounted() {
    axios.get(route("api.memberships.plans.index"), { params: { lang: this.$i18n.locale } })
      .then((res) => {
        this.plans = res.data.data;
        this.loading = false;
        this.$emit("loaded", this.plans);
        this.initializeSelection();
      })
      .catch(() => {
        this.loading = false;
      });
  },
};
</script>
