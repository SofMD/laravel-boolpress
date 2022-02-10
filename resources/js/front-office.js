
import Vue from 'vue';
import App from './views/App';

// App router
import router from './routes';

const root = new Vue({
    el: '#root',
    router,
    render: h => h(App),
})