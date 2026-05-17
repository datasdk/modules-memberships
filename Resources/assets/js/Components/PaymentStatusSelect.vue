<template>
  <div>
    <v-select
      v-if="useVuetify"
      v-model="localValue"
      :items="options"
      item-text="label"
      item-value="value"
      :label="label"
      outlined
      dense
      hide-details
    ></v-select>

    <select
      v-else
      class="form-control"
      v-model="localValue"
    >
      <option disabled value="">{{ placeholder }}</option>
      <option
        v-for="opt in options"
        :key="opt.value"
        :value="opt.value"
      >
        {{ opt.label }}
      </option>
    </select>
  </div>
</template>

<script>
export default {
  name: "PaymentStatusSelect",

  props: {
    value: {
      type: String,
      default: "",
    },
    label: {
      type: String,
      default: "Betalingsstatus",
    },
    placeholder: {
      type: String,
      default: "Vælg status",
    },
    useVuetify: {
      type: Boolean,
      default: false, // Skift til true hvis du bruger Vuetify <v-select>
    },
  },

  data() {
    return {
      options: [
        { value: "paid", label: "Betalt" },
        { value: "pending", label: "Afventer betaling" },
        { value: "failed", label: "Betaling fejlet" },
        { value: "refunded", label: "Refunderet" },
      ],
    };
  },

  computed: {
    localValue: {
      get() {
        return this.value;
      },
      set(val) {
        this.$emit("input", val);
      },
    },
  },
};
</script>
