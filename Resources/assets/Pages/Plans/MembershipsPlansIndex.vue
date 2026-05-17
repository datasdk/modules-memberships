<template>
  <section>


    <div class="content-header">

      <h1>
        Planer
        <small>Her er en oversigt over alle dine planer</small>
      </h1>
      
      <v-btn color="primary" @click="goto('module.memberships.plans.create')">Opret plan</v-btn>  

    </div>


    <v-card>
       

      <Table
        :headers="headers" 
        :table="table"
        :route="route"
        :include="include"
      ></Table>


    </v-card>


  </section>
</template>


<script>

import TableIndex from "@/Mixins/TableIndex";

export default {

  mixins: [TableIndex],

  data(){

    return {

      table: "plans",
      route: "memberships.plans",

      headers: [
          { text: 'ID', value: 'id' },
          { text: 'Overskrift', value: 'title' }, 
          { text: 'Price', value: 'price' },
          { text: 'Billede', value: 'images' },  
          { text: 'Tags', value: 'tags' },          
          { text: 'Dato', value: 'created_at' },    
          { text: '', value: 'actions' },
      ],

    //  options: ["categories","memberships"]

      include: "images"

    }
    
  }

}

</script>

<style >


</style>