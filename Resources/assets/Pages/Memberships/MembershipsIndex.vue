<template>
  <section>


    <div class="content-header">
      <h1>
        Memberships
        <small>Her kan du få en oversigt over dine medlemskaber</small>
      </h1>

      <v-btn color="primary" @click="goto('module.memberships.subscriptions.create')">
        Opret medlemskab
      </v-btn>
    </div>



    <!-- COMPONENT -->
    <Table 
      :headers="headers" 
      :sorting="sorting"
      :route="route" 
      :include="include"
      :table="table"
      :filters="filters"
      :move="false"
      :show_time="show_time"
    >

      <!-- Kunde-visning -->
      <template #item.subscribable="{ item }">
        <div v-if="item.subscribable">

          {{ item.subscribable.first_name }} {{ item.subscribable.last_name }}<br />
          <small>{{ item.subscribable.email }}</small>

        </div>
        <div v-else>

          <em>Ingen</em>

        </div>
      </template>


      <template #item.subscription_status="{ item }">
        <section>
          
          <SubscriptionStatusChip
            :status="item.status"
          />
  
        </section>
      </template>

      

      <template #item.payment="{ item }">
        <section>
        
          <div class="pa-3">
            
            <PaymentMethodChip :method="item.payment_method" class="pb-1"/>
                  
            <PaymentStatusChip :status="item.payment_status" :paid_at="item.paid_at"/> 

          </div>
            

        </section>
      </template>


      <template #item.paid_at="{ item }">
        <section>
        
          <span v-if="item.paid_at">{{item.paid_at}}</span>

          <span v-else>-</span>

        </section>
      </template>


      <template #item.auto_renew="{ item }">
        <section>
  
          <div v-if="item.auto_renew">
            Auto

          </div>
          <div v-else>
            Nej
          </div>

        </section>
      </template>


    </Table>

    

  </section>
</template>

<script>
import TableIndex from "@/Mixins/TableIndex";

import PaidAtDisplay      from "./../../js/Components/PaidAtDisplay.vue";
import ProductList        from "./../../js/Components/ProductList.vue";
import PaymentStatusChip  from "./../../js/Components/PaymentStatusChip.vue"
import PaymentMethodChip  from "./../../js/Components/PaymentMethodChip.vue"
import SubscriptionStatusChip  from "./../../js/Components/SubscriptionStatusChip.vue"

export default {

  mixins: [
    TableIndex,
  ],

  components:{
    PaidAtDisplay,
    ProductList,
    PaymentStatusChip,
    PaymentMethodChip,
    SubscriptionStatusChip
  },

  data() {
    return {
      table: "subscriptions",
      route: "memberships.subscriptions",
      headers: [
        { text: "Medlemskab", value: "plan.title" }, 
        { text: "Kunde", value: "subscribable" },
        
        { text: "Opstart", value: "starts_at" },
        { text: "Ophør", value: "ends_at" },
        
        { text: "Betalingsmetode", value: "payment" },
        { text: "Status", value: "subscription_status" },
        
        { text: "Fornyelse", value: "auto_renew" },
 
        { text: "", value: "actions" },
      ],
      include: "subscribable,plan",
      selected: [],
      sorting: null,
      send_invite_open_prompt: false,
      filters: [],
      show_time: false

     // filters: [{ field: "type", operator: "=", value: "membership" }]
    };
  },

  methods: {
    truncateContent(content) {
      if (!content) return "";
      return content.length > 200 ? content.slice(0, 200) + "..." : content;
    },
  },
};
</script>

<style scoped>
#userInvitationList {
  overflow: auto;
  height: auto;
  max-height: 150px;
}
</style>
