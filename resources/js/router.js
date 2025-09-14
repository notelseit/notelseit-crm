import Vue from 'vue';
import Router from 'vue-router';

import AdminDashboard from './components/AdminDashboard.vue';
import SettingsPage from './components/SettingsPage.vue';
import UsersPage from './components/UsersPage.vue';
import SendEmailPage from './components/SendEmailPage.vue';
import EmailsHistoryPage from './components/EmailsHistoryPage.vue';
import ProfilePage from './components/ProfilePage.vue';
import LoginPage from './components/LoginPage.vue';

Vue.use(Router);

export default new Router({
  routes: [
    { path: '/', component: AdminDashboard },
    { path: '/settings', component: SettingsPage },
    { path: '/users', component: UsersPage },
    { path: '/send-email', component: SendEmailPage },
    { path: '/emails-history', component: EmailsHistoryPage },
    { path: '/profile', component: ProfilePage },
    { path: '/login', component: LoginPage },
  ]
});