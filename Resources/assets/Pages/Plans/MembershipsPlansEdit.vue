<template>
  <section>
    <Loading v-if="loading" />

    <div v-else>
      <form @submit.prevent="submit">
        <!-- PLAN -->
        <table class="table">
          <tr><th colspan="2">Plan</th></tr>

          <tr>
            <td width="200">Overskrift</td>
            <td>
              <TextField name="name" v-model="input.title" />
            </td>
          </tr>

          <tr>
            <td>Indhold</td>
            <td>
              <TextEditor name="content" v-model="input.description" />
            </td>
          </tr>

          <tr>
            <td>Aktiv</td>
            <td>
              <label>
                <input type="checkbox" v-model="input.active" />
                Medlemskabesplanen er aktiv
              </label>
            </td>
          </tr>
        </table>

        <!-- PRIS -->
        <table class="table">
          <tr><th colspan="2">Pris</th></tr>

          <tr>
            <td width="200">Pris (DKK)</td>
            <td>
              <input
                type="number"
                class="form-control"
                v-model="input.price"
                min="0"
                step="0.01"
              />
            </td>
          </tr>
        </table>



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
        </table>



        <!-- PRØVE-PERIODE -->
        <table class="table" v-if="!hasPermanentMembership">
          <tr><th colspan="2">Prøve-periode</th></tr>

          <tr>
            <td width="200">Gratis prøveperiode</td>
            <td>
              <div class="pt-2">
                <label>
                  <input type="radio" v-model="input.has_trial" :value="0" />
                  Uden gratis prøveperiode
                  <p>Start medlemskabet uden prøveperiode.</p>
                </label>
              </div>

              <div>
                <label>
                  <input type="radio" v-model="input.has_trial" :value="1" />
                  Med gratis prøveperiode
                  <p>
                    Giv kunden en gratis prøveperiode, hvor medlemsfordele er
                    tilgængelige indtil slutdato.
                  </p>
                </label>
              </div>
            </td>
          </tr>

          <tbody v-if="input.has_trial">
            <tr>
              <td width="200">Varighed</td>
              <td>
                <v-row>
                  <v-col cols="4">
                    <NumberSelect v-model="input.trial_period" />
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
          </tbody>
        </table>

       

        <!-- INDSTILLINGER -->
        <table class="table">
          <tr><th colspan="2">Indstillinger</th></tr>

          <tr>
            <td width="200">Billede</td>
            <td>

              <ImageSelect 
                v-model="input.image" 
              />

            </td>
          </tr>
        </table>

        <!-- FAKTURERING -->
        <table class="table">
          <tr><th colspan="2">Fakturering & Periode</th></tr>

          <tr>
            <td width="200">Ophørstid efter udløb (grace period)</td>
            <td>
              <v-row>
                <v-col cols="4">

                  <NumberSelect 
                    v-model="input.grace_period" 
                    :min="0" 
                  />

                </v-col>

                <v-col cols="8">

                  <IntervalSelect
                    v-model="input.grace_interval"
                    :plural="input.grace_period != 1"
                  />

                </v-col>
              </v-row>
              <small class="text-muted"
                >Hvor mange dage/uger brugeren stadig har adgang efter
                udløb.</small
              >
            </td>
          </tr>
        </table>

        

     

        <!-- HANDLINGER -->
        <v-btn color="primary" type="submit" :loading="submitLoading">
          {{ submitText }}
        </v-btn>

        <v-btn color="default" @click="goto('module.memberships.plans.index')">
          Tilbage
        </v-btn>
      </form>
    </div>
  </section>
</template>

<script>
import TableEdit from "@/Mixins/TableEdit";

export default {
  mixins: [TableEdit],

  data() {
    return {
      table: "plans",
      lang: this.$i18n.locale,

      input: {
        name: undefined,
        description: undefined,
        sku: undefined,
        image: undefined,
        features: [],
        tags: [],
        active: 1,
        price: 0,
        invoice_period: 1,
        invoice_interval: "months",
        grace_period: 7,
        grace_interval: "days",
        permanent_membership: 0,
        has_trial: 0,
        trial_period: 7,
        trial_interval: "days",
      },

      features: {
        categoryTypes: ["features"],
        categories: [],
        loading: false,
      },
    };
  },

  methods: {

    async create() {

      return axios
        .post(route("api.memberships.plans.store"), this.input)
        .then(() => {

          this.$router.push({ name: "module.memberships.plans.index" });

        });

    },

    async update() {

      return axios
        .patch(route("api.memberships.plans.update", { id: this.id }), this.input)
        .then(() => {

          this.$router.push({ name: "module.memberships.plans.index" });

        });

    },

    get(params) {

      return axios
        .get(route("api.memberships.plans.show", params), {
          params: { include: "images,features" },
        })
        .then((res) => {

          let data = res.data.data;
          data.features = data.features.map((f) => f.code);
          this.input = data;

        });

    },
  },

  watch: {

    "input.permanent_membership": function(val){

      if(val){ this.input.has_trial = 0 }

    }
    

  },

  computed:{

    hasPermanentMembership(){

      return this.input.permanent_membership == 1

    }

  },

  beforeMount() {

    this.features.loading = true;

    axios
      .post(route("api.categories.tree", { type: this.features.categoryTypes }), {
        lang: this.lang,
      })
      .then((res) => {

        this.features.loading = false;
        this.features.categories = res.data.data;

      });

  },
};
</script>

<style scoped>
label {
  cursor: pointer;
}
p {
  font-weight: normal;
}
</style>
