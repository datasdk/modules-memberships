<template>
  <section>



    <table class="table">
        <tr>
            <th>Medlemskab</th>
        </tr>
        <tr>
            <td width="150"></td>
            <td>
                

                <Loading v-if="loading"/>


                <div v-else-if="memberships" class="membership-overview pb-3">

                

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
                                    :key="item.name"
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

            </td>

        </tr>

    </table>



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
            input: [],                   
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
        

        if(!this.value || typeof this.value == undefined){

            this.input = []

        }


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