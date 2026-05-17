<template>
  <section>


    <Loading v-if="loading"/>

    
    <table>

        <tr>
            <td>

            <div v-if="memberships" class="membership-overview pb-3">

            

                <div class="alert alert-info" 
                v-if="!memberships.length">Der er ingen medlemskaber tilgængelige</div>


                <div 
                v-for="item in memberships" :key="item.name"  
                >

    
                    <ul>

                        <li>
                                                    
                            <label>

                                <input 
                                type="checkbox" 
                                name="memberships[]"
                                :value="item.id"
                                v-model="input"              
                                >
                                            
                                <strong>{{ item.title  }}</strong>   
                                
                                <!--<i>{{ item.description }}</i>-->

                            </label>
                                            
                            <div class="id">id: {{item.id}}</div>

                        </li>

                    </ul>
                        
                </div>

            </div>


    <!--
        

            <v-dialog 
                v-model="open"
                width="500"
            >

            


                    <v-card>

                        <v-card-title class="pb-3">
                                

                            <div class="pb-2 float-left"><strong>Tilføj nyt medlemskab</strong></div>
                        
                        </v-card-title>

            

                        <div class="pa-4 pt-0 pb-4">

                            <v-alert v-if="error" v-text="error"/>

                            <form @submit.prevent="create">


                                <div class="alert alert-danger" v-if="error">{{error}}</div>
                                

                                

                                <div class="text-right"><SelectLang /></div>


                                <div class="form-group">


                                    <TextField 
                                    name="new_category" 
                                    autocomplete="off"
                                    placeholder="Angiv navn på medlemskab"
                                    v-model="name"
                                    />


                                </div>
                                
                        

                                <button class="btn btn-primary">Opret medlemskab</button>

                                <button class="btn btn-default" @click="close_window">Annuller</button>
                        
                        
                            </form>



                        </div>
                                
                    </v-card>


            

            </v-dialog>

    -->


            <div 
                class="form-group new_category_prompt" 
                v-if="open">   

                    <div class="p-1">
            
                    </div>
                        
            </div>


            <div class="text-right">


                <div class="link"
                v-if="!open"
                @click="open_new_role" 
                color="primary"
                outlined   
                ><i class="fas fa-plus mr-2"></i>Opret nyt medlemskab
                </div>


            </div>



  </section>
</template>

<script>


export default {

    name: "UserRoleSelector",

    props:{

        value: { default: ()=>{ return [] } },
        show: { default: true },
  
    },

    data(){

        return {
            loading: true,
            memberships: null,
            input: this.value,                   
            open: false,
            error: null,
            name: window.languagesDefaultValues,
            defaultName: this.name
            
        }
          
    },


    watch:{

        input:{

            handler(){

                this.$emit('input', this.input)

            },
            immediate: true,

        }

    },

    methods:{


        get_name(item){

            if(item.nickname)
            if(item.nickname.length){ return item.nickname }
            
            return item.name

        },

   
        close_window(){

            this.open = false

        },
        open_new_role(){

            this.open = true

        },

        async get(){


            return axios.get(route("api.memberships.plans.index")).then((res)=>{

              
                this.memberships = res.data.data

                this.loading = false

            })

   

        },

        create(){


            this.error = null



            axios.post(route('api.roles.store'),{
                type: this.type,
                name: this.name,
                lang: this.$i18n.locale
            }).then((res) => {

                
                let membership = res.data

                this.memberships.push(membership)

                this.input.push(membership.id)

                this.name = this.defaultName

                this.close_window()
               

            })

        },

    },

    computed:{

        is_limited(){

            return this.value === "limited"

        }

    },

    beforeMount(){
        
        
        this.get()
        
      //  this.input = collect(this.value).pluck('id').toArray()      
        

    }

}
</script>

<style scoped>

    .link{
        cursor: pointer;
    }

    h4{
        font-size: 20px;
        margin: 0;
    }

    ul{
        list-style-type: none;
        margin: 0;
        padding: 0;

    }

    ul li{
        padding:5px 0px 5px 0px;
        border-bottom: 1px solid #eee;
        width: 100%;
        overflow: auto;
    }

    li.item{
        list-style-type: none;
        padding: 5px 0px 5px 0px;
        border-bottom: 1px solid #eee;
        width: 100%;
        overflow: auto;
    }



    .membership-overview{
        overflow: auto;
        width: 100%;
        min-height: 100px;
        max-height: 300px;
        /* border-top: #eee solid 1px; */
        /* margin-top: 10px; */
        padding-top: 15px;
    }

    div.id{
        float: right;
        color:#ddd;
        text-align: right;
    }

    li label{
        cursor: pointer;
        width: 80%;
        margin: 0;
    }

</style>