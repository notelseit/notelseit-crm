import { createRouter, createWebHistory } from 'vue-router'
import Dashboard from '@/views/Dashboard.vue'
import ClientCrud from '@/views/ClientCrud.vue'
import LeadCrud from '@/views/LeadCrud.vue'
import OfferCrud from '@/views/OfferCrud.vue'
import ActivityCrud from '@/views/ActivityCrud.vue'
import ContactCrud from '@/views/ContactCrud.vue'
import Calendar from '@/views/Calendar.vue'

export default createRouter({
  history: createWebHistory(),
  routes: [
    { path: '/', component: Dashboard },
    { path: '/clients', component: ClientCrud },
    { path: '/leads', component: LeadCrud },
    { path: '/offers', component: OfferCrud },
    { path: '/activities', component: ActivityCrud },
    { path: '/contacts', component: ContactCrud },
    { path: '/calendar', component: Calendar },
  ]
})