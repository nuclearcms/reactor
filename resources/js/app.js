// Modernizr
import {Modernizr} from 'umomega-foundation';
window.Modernizr = Modernizr;

// Import Vue and configure
import Vue from "vue";
Vue.config.productionTip = false;

// lang.js
import Lang from "lang.js";
Vue.prototype.trans = new Lang({ messages, locale: locale, fallback: 'en' });
Vue.prototype.locale = locale;
Vue.prototype.appLocale = app_locale;
Vue.prototype.appLocales = app_locales;

// Axios & Configuration
import axios from 'axios';
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let csrf_token = document.head.querySelector('meta[name="csrf-token"]');
if (csrf_token) {
	window.axios.defaults.headers.common['X-CSRF-TOKEN'] = csrf_token.content;
}

let api_token = window.token;
if(api_token) {
	window.axios.defaults.headers.common['Authorization'] = `Bearer ${api_token}`;
}

// API URL Handles
import {api_url_with_token, api_url} from 'umomega-foundation';
window.api_url_with_token = api_url_with_token;
window.api_url = api_url;

// Event Bus
window.Event = new Vue();

import {store} from 'umomega-foundation';
Vue.prototype.store = store;
store.nuclear_version = window.nuclear_version;
store.allowed_extensions = window.allowed_extensions;
store.allowed_mimetypes = window.allowed_mimetypes;
store.allowed_size = window.allowed_size;

// Page Titles
import VuePageTitle from 'vue-page-title'
Vue.use(VuePageTitle, { suffix: ' — Nuclear' });

// Notifications
import Notifications from 'vue-notification'
Vue.use(Notifications);
Vue.prototype.notifier = {
	success(text) { this.notify(text, 'success') },
	danger(text) { this.notify(text, 'danger') },
	warning(text) { this.notify(text, 'warning') },
	info(text) { this.notify(text, 'info') },
	notify(text, type) { Vue.notify({ text, type }) }
};

// Routing
import VueRouter from "vue-router";
import routes from './routes';
Vue.use(VueRouter);
window.router = new VueRouter(routes);

// Main Template
import App from './App.vue';

// Register the Vue Instance
new Vue({
	router: router,
	render: h => h(App),
	data: {
		shared: store
	}
}).$mount('#app');