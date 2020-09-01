import NotFound from "./components/NotFound";

window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
    require('admin-lte');
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import router from './router'

axios.interceptors.response.use(
    function(response) { return response;},
    function(error) {
        // handle error
            if (error.response.status === 401) {
                // router.push({path:'/login'}).then();
                Toast.fire({
                    icon: 'warning',
                    title: 'Session Expired, reload to login'
                })
            }else if (error.response.status === 403){
                // Router.push({name: 'dashboard'}).then(()=>{
                //
                // });
                Toast.fire({
                    icon: 'warning',
                    title: 'Not Authorized to access'
                })
            }else if (error.response.status === 404){
                // Router.push({path:'/dashboard'}).then(()=>{
                //
                // });
                Toast.fire({
                    icon: 'warning',
                    title: 'Page Not Found'
                })
            }
            return Promise.reject(error)
        });

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });
