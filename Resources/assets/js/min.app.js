//require("@/bootstrap");


import MembershipsIndex from "./../../views/MembershipsIndex.vue"

import MembershipsEdit from "./../../views/MembershipsEdit.vue"


import MembershipsPlansIndex from "./../../views/MembershipsPlansIndex.vue"

import MembershipsPlansEdit from "./../../views/MembershipsPlansEdit.vue"



window.router.addRoute({ path: '/memberships', component: MembershipsIndex, name: "module.memberships.subscriptions.index"})

window.router.addRoute({ path: '/memberships/create', component: MembershipsEdit, name: "module.memberships.subscriptions.create" })

window.router.addRoute({ path: '/memberships/:id/edit', component: MembershipsEdit, name: "module.memberships.subscriptions.edit", props: true })


window.router.addRoute({ path: '/memberships/plans', component: MembershipsPlansIndex, name: "module.memberships.plans.index"})

window.router.addRoute({ path: '/memberships/plans/create', component: MembershipsPlansEdit, name: "module.memberships.plans.create" })

window.router.addRoute({ path: '/memberships/plans/:id/edit', component: MembershipsPlansEdit, name: "module.memberships.plans.edit", props: true })


Vue.component('Memberships', require('./Components/Memberships.vue').default);

