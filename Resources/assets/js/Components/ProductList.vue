<template>
  <div>
    <ul v-if="items && items.length">
      <li v-for="product in items" :key="product.id">
        {{ product.product_name }} (x{{ product.quantity }}) - {{ product.price }} kr
      </li>
    </ul>
    <div v-else>
      <em>Ingen produkter</em>
    </div>
  </div>
</template>

<script>
export default {
  name: "ProductList",
  props: {
    items: {
      type: Array,
      default: () => [],
    },
  },
};
</script>

<style scoped>
/* Tilføj styling efter behov */
</style>
