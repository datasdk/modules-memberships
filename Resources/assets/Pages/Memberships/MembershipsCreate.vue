<template>
  <section>


    <Loading v-if="loading" />

    <div v-else>


      <form @submit.prevent="submit">


        <table class="table">
            <tr>
              <th colspan="2">Medlemskab</th>
            </tr>

            <tr>
              <td>Abonnement</td>
              <td>

   
                <SelectPlan 
                  v-model="input.plan_id"
                  @change="changePlan"
                />

              </td>
            </tr>

            <tr>
              <td width="200">Kunde</td>
              <td>
                
                <SelectUser 
                  v-model="input.subscribable_id" 
                />
                
              </td>
          </tr>
        </table>



        <div v-if="selectedPlan" class="animate__animated animate__fadeIn">


          <table class="table">   
              <tr>
                <th colspan="2">Abonnement periode</th>
              </tr>

              <!-- Begrænset medlemskab -->
              <tr>
                <td width="200">Varighed</td>
                <td >

                  <div class="pt-2">

                    <label >
                      <input type="radio" v-model="input.permanent_membership" :value="0" /> Begrænset medlemskab
                      <p>
                        Opret medlemskab med opstarts dato og udløbsdato. Brugeren kan ikke tilgå samme fordele efter endt dato.
                      </p>
                    </label>

                  </div> 

                  <div>

                    <label>
                      <input type="radio" v-model="input.permanent_membership" :value="1" /> Permanent medlemskab
                      <p>Giv kunden permanent adgang til medlemskabets fordele.</p>
                    </label>

                  </div>
                
                </td>

              </tr>

              <tr> 

                <td width="200">Opstartsdato</td>

                <td>

                  <Datepicker 
                    :monday-first="true" 
                    v-model="input.starts_at" 
                  />

                </td>
              </tr>


              <tr v-if="!input.permanent_membership">
                <td width="200">Varighed</td>
                <td>
                  
                  <v-row>

                    <v-col cols="4">
                      
                
                      <NumberSelect 
                        v-model="input.invoice_period"
                      />


                    </v-col>

                    <v-col cols="8">

                      <IntervalSelect 
                        v-model="input.invoice_interval" 
                        :plural="input.invoice_period != 1"
                      />

                    </v-col>

                  </v-row>

                </td>
              </tr>

              <tr>
                <td></td>
                <td>
                  <label>

                    <v-row>

                      <v-col cols="1">

                        <input type="checkbox" v-model="input.auto_renew"  :value="1"/>

                      </v-col>

                      <v-col cols="11">

                        <strong>Automatisk fornyelse</strong>
                        <p>Forny automatisk medlemskab efter endt periode.<br>
                        Er der ikke tilknyttet et kort, vil medlemskabet midlertidigt blive sat i dvale.</p>

                      </v-col>

                    </v-row>

                  </label>
                </td>
              </tr>
              
          </table>


          <div  class="animate__animated animate__fadeIn">


            <table class="table" v-if="input.permanent_membership == 0">
              <tr>
                <th colspan="2">
                  Prøve-periode 
                </th>
              </tr>

              <!-- Prøveperiode -->
              <tr>
                <td width="200">Gratis prøveperiode</td>
                <td>

                    <div class="pt-2">
                      <label >
                        <input type="radio" name="has_trial" v-model="input.has_trial" :value="0" /> Uden gratis prøveperiode
                        <p>Start medlemskabet fra den angivne dato uden gratis prøveperiode.</p>
                      </label>
                    </div>
                    
                    <div>

                      <label>
                        <input type="radio" name="has_trial" v-model="input.has_trial" :value="1" /> Med gratis prøveperiode
                        <p>Giv kunden en gratis prøveperiode, hvor alle medlemsfordelene bliver tilgængelig for kunden ind til prøveperioden er slut.</p>
                      </label>

                    </div>
                    
                </td>
              </tr>

              <tbody v-if="input.has_trial">

                <tr >
                  <td>Varighed</td>
                  <td height="50">
                      
                      
                      <v-row>

                        <v-col cols="4">
                       
                          <NumberSelect 
                            v-model="input.trial_period"
                          />

                        </v-col>

                        <v-col cols="8">

                          <IntervalSelect 
                            v-model="input.trial_interval" 
                            :plural="input.trial_period != 1"
                          />

                        </v-col>

                      </v-row>

                    
                    </td>
                  </tr>


                  <tr>
                    <td></td>
                    <td>
                      <label>
              
                        <v-row>

                          <v-col cols="1">

                            <input type="checkbox" v-model="input.trial_auto_upgrade"  :value="1"/>

                          </v-col>

                          <v-col cols="11">

                            Opgrader automatisk til betalende medlemskab
                            <p>Opgrader automatisk medlemskab efter endt prøveperiode.<br>
                            Er der ikke tilknyttet et kort, vil medlemskabet midlertidigt blive sat i dvale.</p>

                          </v-col>

                        </v-row>
                      

                      </label>

                    </td>
                  </tr>

                </tbody>
                
            </table>


          

            

          <table class="table">

            <tr>
              <th colspan="2">Ordreindstillinger</th>
            </tr>

            <tr>
              <td width="200">Betalingsmetode</td>
              <td>

                <PaymentMethodSelect 
                  v-model="input.payment_method"
                />

        
              </td>
            </tr>

        
            <tr>
              <td>Betalingsstatus</td>
              <td>

                      
                <select class="form-control" v-model="input.payment_status">
                  <option disabled value="">Vælg status</option>
                  <option value="paid">Betalt</option>
                  <option value="pending">Afventer betaling</option>
                  <option value="failed">Betaling fejlet</option>
                  <option value="refunded">Refunderet</option>
                </select>

              </td>
            </tr>

            <tr v-if="orderIsPaid">
              <td>Betalingsdato</td>
              <td>

                <Datepicker 
                  v-model="input.paid_at" 
                />

              </td>
            </tr>

          </table>



          <table class="table">
            <tr>
              <th colspan="2">Overblik</th>
            </tr>
            <tr>
              <td colspan="2">Alle datoer er til og med slutdata</td>
            </tr>
         
            <tr >
                <td>Prøve-periode</td>
                  <td height="50">
                    
                    <div v-if="input.has_trial">
                      <strong>{{ dateformat(input.starts_at) }}</strong> - {{ dateformat(trialEndDay) }}
                    </div>
                    <div v-else>
                      Ingen prøveperiode
                    </div>
                    
 
              </td>
            </tr>
            <tr>
                <td width="200">Periode</td>
                <td>
                
                  <strong>{{ dateformat(input.starts_at) }}</strong> - {{ dateformat(mainEndDay) }}

                </td>
            </tr>
          </table>


            <v-btn color="primary" type="submit" :loading="submitLoading">{{ submitText }}</v-btn>

            <v-btn color="default" @click="goto('module.memberships.subscriptions.index')">Tilbage</v-btn>



          </div>


        </div>


      </form>


    </div>
  </section>
</template>

<script>
import TableEdit from "@/Mixins/TableEdit";
import Datepicker from "@/Components/input/Datepicker.vue";
import MembershipMixin from "./../../js/Mixins/MembershipMixin.js"
import PaymentMethodSelect from "./../../js/Components/PaymentMethodSelect.vue"



export default {

  components: { 
    Datepicker,
    PaymentMethodSelect
  },

  mixins: [TableEdit, MembershipMixin],




  methods: {


    async create() {


      const payload = {
        ...this.input,
        trial_ends_at: this.input.has_trial ? this.input.trial_ends_at : null,
        ends_at: this.input.permanent_membership ? this.input.ends_at : null,
        customer: this.new_user === "1" ? this.user : this.input.customer,
      };


      return axios.post(route("api.memberships.subscriptions.store"), payload).then(() => {

        this.$router.push({ name: "module.memberships.subscriptions.index" });

      });


    },


  }


};
</script>

<style scoped>
label{
  cursor: pointer;
}
p{
  font-weight: normal;
}
</style>