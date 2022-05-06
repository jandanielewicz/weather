routes = function (Vue) {

    return [
        {
            path: '/',
            redirect: '/weather'
        },
        {
            path: '/weather',
            component: Vue.component('weather-view'),
        },
        {
            path: '/profile',
            component: Vue.component('profile')
        },
    ]
}
