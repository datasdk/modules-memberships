<template>
  <section>

    <Dialog
    v-model="open"
    width="500"
    >
        
        <v-card >

            <v-card-title>Medlemskaber</v-card-title>

            <v-card-subtitle>Tildel medlemskaber</v-card-subtitle>

            <v-card-text>
                
                <PublishSelection
                    v-model="access"
                />


                <v-divider/>
                    

                    <div> 
                        <label>
                            <input type="checkbox" class="mr-2" v-model="sync"/> Synkroniser
                        </label> 
                </div>


                <i>Vælger du synkroniser vil alle medlemskaber blive nulstille og erstattet med ovenstående valgte</i>
                        

                 <v-card-actions>
                    
                    <v-btn
                    color="primary"
                    :loading="loading"
                    @click="submit"
                    >Tildel medlemskaber</v-btn>

                </v-card-actions>
                

            </v-card-text>

           

        </v-card>

    </Dialog>
    

  </section>
</template>

<script>

import collect from 'collect.js'
import { mdiClose } from '@mdi/js';

export default {
    props:{
        
        value: { required: true },
        model: { required: true },

    },

    data(){

        return {

            selected: this.value,
            open: false,
            loading: false,
            access: undefined,
            memberships: [],
            sync: false
        }

    },


    methods:{

        submit(){

            
            let selected = collect(this.selected).pluck("id")

            this.loading = true


            axios.post( route("api.options.memberships.set",this.model) ,{
                access: this.access,
                memberships: this.memberships,
                model_id: selected,
                sync: this.sync
            }).then((res)=>{

             //   console.log(res)
                //console.log(this.selected)
                //console.log(this.categories)

                this.$emit("submit")
  
                this.open = false

                this.selected = []

                this.$emit("input",this.selected)


            }).then(()=>{

                this.loading = false

            })


        }

    },

    computed:{

        is_limited(){

            return this.access === "limited"

        }

    },

    beforeMount(){

        this.open = this.selected.length > 0

    }

}
</script>

<style>

</style>