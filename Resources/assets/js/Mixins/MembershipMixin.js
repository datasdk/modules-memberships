// src/Mixins/SubscriptionForm.js
export default {
  data() {
    return {
      table: "plans",
      loading: true,
      loadingPlans: true,
      new_user: "0",

      plans: [],
      selectedPlan: null,

      input: {
        plan_id: undefined,
        subscribable_id: undefined,
        starts_at: undefined,
        ends_at: undefined,        
        permanent_membership: 0,
        has_trial: 0,
        trial_period: 7,
        trial_interval: "days",
        trial_ends_at: undefined,
        active: true,
        payment_method: "credit_card",
        payment_status: "pending",
        status: "confirmed",
        customer: null,
        new_user: false,
        auto_upgrade: 0,
        invoice_period: 1,
        invoice_interval: "months",
        auto_renew: 1,
        paid_at: undefined,
      },

      user: {
        first_name: undefined,
        middle_name: undefined,
        last_name: undefined,
        email: undefined,
        contact: { phone: undefined },
        invite: false,
        password: undefined,
      },
    };
  },

  computed: {
    orderIsPaid() {
      return this.input.payment_status === "paid";
    },

    trialEndDay() {
      return this.getEndDate("trial");
    },

    mainEndDay() {
      return this.getEndDate("main");
    },
  },

  methods: {


    // Når en plan vælges fra SelectPlan
    changePlan(plan) {
      this.selectedPlan = plan;

      if (!plan) return;

      Object.assign(this.input, {
        invoice_period: plan.invoice_period,
        invoice_interval: plan.invoice_interval,
        has_trial: plan.has_trial,
        trial_period: plan.trial_period,
        trial_interval: plan.trial_interval,
      });
    },

    // Beregn slutdato
    getEndDate(type = "main") {
      if (!this.input.starts_at || !this.selectedPlan) return null;

      const start = this.$moment(this.input.starts_at);
      let period, interval;

      if (type === "main") {
        period = this.input.invoice_period;
        interval = this.input.invoice_interval;
      } else if (type === "trial") {
        period = this.input.trial_period;
        interval = this.input.trial_interval;
      }

      const unitMap = {
        days: "day",
        weeks: "week",
        months: "month",
        years: "year",
      };

      const unit = unitMap[interval] || "month";

      return start.clone().add(period, unit);
    },

    // Formatter dato
    dateformat(str) {
      return this.$moment(str).format("DD-MM-YYYY");
    },
  },


  watch: {
    // Overvåg startdatoen
    "input.starts_at"(newVal) {

      if (!newVal) return;

      const start = new Date(newVal);
      const trialEnd = this.input.trial_ends_at ? new Date(this.input.trial_ends_at) : null;

      // Hvis prøveperiodens slutdato er før startdatoen → ret det
      if (trialEnd && trialEnd < start) {
        this.input.trial_ends_at = newVal;
      }

    }

    

  },

};
